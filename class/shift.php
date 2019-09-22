<?php
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Item as Item;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Models\Shift;
use HRM\Transformers\Shift_Transformer;
use Illuminate\Pagination\Paginator;
use HRM\Models\Relation;
use HRM\Models\Department;


class HRM_Shift {
	use Transformer_Manager;
	
	private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

	function __construct() {
		add_action( 'wp_ajax_hrm_shift_filter', array( $this, 'ajax_get_shift' ) );
        add_action( 'wp_ajax_hrm_insert_shift', array( $this, 'ajax_add_shift' ) );
        add_action( 'wp_ajax_hrm_update_shift', array( $this, 'ajax_update_shift' ) );
        add_action( 'wp_ajax_hrm_delete_shift', array( $this, 'ajax_delete_shift' ) );
        //$this->migrate();
	}

    function migrate() {
        global $wpdb;

        $table = $wpdb->prefix . 'hrm_office_time';
        $shift_tb = $wpdb->prefix . 'hrm_time_shift';
        $attendance = $wpdb->prefix . 'hrm_attendance'; 

        $office_times = $wpdb->get_results("Select * From " . $wpdb->prefix . "hrm_office_time");

        if ( $office_times ) {
            $active = end( $office_times );
            $data = $this->shift_data_formating( $active, 1,  'Office Time');

            $shift_id = $wpdb->insert( $shift_tb, $data );
            $wpdb->update( $attendance, ['config_id' => $wpdb->insert_id], ['config_id' => $active->id] );

            array_pop( $office_times );
        }

        foreach ( $office_times as $time ) {
            $data = $this->shift_data_formating( $active, 0,  'Office Time');

            $shift_id = $wpdb->insert( $shift_tb, $data );
            $wpdb->update( $attendance, ['config_id' => $wpdb->insert_id], ['config_id' => $time->id] );
        }

        $wpdb->query( "alter table " . $wpdb->prefix . "hrm_attendance change config_id shift_id BIGINT" ) ;
    }

    function shift_data_formating( $shift, $status, $name ) {
        return [
            'name'        => $name,
            'status'      => $status,
            'punch_start' => $shift->start,
            'created_at'  => date( 'Y-m-d H:i:s', strtotime( current_time( 'mysql' ) ) ),
            'updated_at'  => date( 'Y-m-d H:i:s', strtotime( current_time( 'mysql' ) ) ),
            'times' => maybe_serialize(
                [
                    [
                        'begin'       => date( 'H:i', strtotime( $shift->start ) ),
                        'end'         => date( 'H:i', strtotime( $shift->end ) ),
                        'workHours'   => $this->get_hours( $shift->start, $shift->end ),
                        'workMinutes' => $this->get_minutes( $shift->start, $shift->end ),
                        'breakStatus' => false,
                        'breaks' => [
                            [
                                'breakBegin'   => '',
                                'breakEnd'     => '',
                                'breakHours'   => '',
                                'breakMinutes' => ''
                            ]
                        ]
                    ]
                ]
            )
        ];
    }

    function get_hours( $start, $end ) {
        // Create two new DateTime-objects...
        $date1 = new DateTime( $end );
        $date2 = new DateTime( $start );

        // The diff-methods returns a new DateInterval-object...
        $diff = $date2->diff($date1);

        return $diff->format('%h'); 
    }
    
    function get_minutes( $start, $end ) {
        // Create two new DateTime-objects...
        $date1 = new DateTime( $end );
        $date2 = new DateTime( $start );

        // The diff-methods returns a new DateInterval-object...
        $diff = $date2->diff($date1);

        return $diff->format('%m'); 
    }

    function ajax_delete_shift() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'delete' => isset( $_POST['delete'] ) ? hrm_clean( $_POST['delete'] ) : []
        ];

        $shift = self::getInstance()->delete_shift( $postdata );
        
        wp_send_json_success( $shift );
    }

    function delete_shift( $postData ) {
        
        foreach ( $postData['delete'] as $key => $id ) {
            $shift = Shift::find($id);
            $shift->update(array(
                'status' => 0,
            ));
        }

        return true;
    }   

    function ajax_add_shift() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'departments' => isset( $_POST['departments'] ) ? hrm_clean( $_POST['departments'] ) : '',
            'times' => isset( $_POST['times'] ) ? hrm_clean( $_POST['times'] ) : '',
            'punch_start' => isset( $_POST['punch_start'] ) ? hrm_clean( $_POST['punch_start'] ) : '',
        ];

        $shift = self::getInstance()->add_shift( $postdata );
        
        if (  isset( $shift['success'] ) &&  $shift['success'] === false ) {
            wp_send_json_error( $shift );
        }

        wp_send_json_success( $shift );
    }

    function add_shift( $postData ) {
        $validation = $this->validation( $postData );

        $postData['departments'] = $_POST['departments'] = $this->filter_departments( hrm_clean( $postData['times'] ) );
        
        if ( ! is_wp_error( $validation ) ) {
            $current_date            = date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) );
            $postData['punch_start'] = $_POST['punch_start'] = $current_date .' '. trim( hrm_clean( $postData['punch_start'] ) );
            $postData['punch_start'] = $_POST['punch_start'] = date( 'Y-m-d H:i:s', strtotime( hrm_clean( $postData['punch_start'] ) ) );
            $postData['times']       = $_POST['times'] = maybe_serialize( $postData['times'] ); 

            $store = hrm_insert_records();
            
            foreach ( $postData['departments'] as $key => $department_id) {
                Relation::create(array(
                    'type' => 'time_shift_department',
                    'from' => $store['data']['id'],
                    'to'   => $department_id
                ));
            }

            return $store;
            
        } else {
            return [
                'success' => false,
                'error'   => [$validation->get_error_message()]
            ];
        }
    }

    function ajax_update_shift() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'id' => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'departments' => isset( $_POST['departments'] ) ? hrm_clean( $_POST['departments'] ) : '',
            'times' => isset( $_POST['times'] ) ? hrm_clean( $_POST['times'] ) : '',
            'punch_start' => isset( $_POST['punch_start'] ) ? hrm_clean( $_POST['punch_start'] ) : '',
        ];

        $shift = self::getInstance()->update_shift( $postdata );

        
        if (  isset( $shift['success'] ) &&  $shift['success'] === false ) {
            wp_send_json_error( $shift );
        }

        wp_send_json_success( $shift );
    }

    function filter_departments( $times ) {
        $departments = [];
        
        foreach ( $times as $key => $time ) {
            foreach ( $time['departments'] as $key2 => $department ) {
                $departments[] = $department['id'];
            }
        }

        $departments = array_unique( $departments );
        
        return $departments;
    }

    function filter_shift_data( $postData ) {
        
        foreach ( $_POST['times'] as $key => $time ) {

            if( empty( $time['breakStatus'] ) || $time['breakStatus'] == 'false' ) {
                $_POST['times'][$key]['breaks'][0] = [
                    'breakBegin'   => '',
                    'breakEnd'     => '',
                    'breakHours'   => '',
                    'breakMinutes' => ''
                ];
            }
        }

        foreach ( $postData['times'] as $key => $time ) {

            if( empty( $time['breakStatus'] ) || $time['breakStatus'] == 'false' ) {
                $postData['times'][$key]['breaks'][0] = [
                    'breakBegin'   => '',
                    'breakEnd'     => '',
                    'breakHours'   => '',
                    'breakMinutes' => ''
                ];
            }
        }
        
        return $postData;
    }

    function update_shift( $postData ) {
        global $wpdb;
        $validation = $this->validation( $postData );

        $postData['departments'] = $_POST['departments'] = $this->filter_departments( $postData['times'] );
        
        if ( ! is_wp_error( $validation ) ) {
            $postData                = $this->filter_shift_data( $postData );
            $current_date            = date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) );
            $postData['punch_start'] = $_POST['punch_start'] = $current_date .' '. trim( hrm_clean( $postData['punch_start'] ) );
            $postData['punch_start'] = $_POST['punch_start'] = date( 'Y-m-d H:i:s', strtotime( hrm_clean( $postData['punch_start'] ) ) );
            $postData['times']       = $_POST['times'] = maybe_serialize( $postData['times'] ); 


            $hasRelations = Relation::where('from', $postData['id'])
                ->where('type', 'time_shift_department')
                ->get()
                ->toArray();

            $hasRelations = wp_list_pluck( $hasRelations, 'to' );
            
            $insert = array_diff( $postData['departments'], $hasRelations );
            $delete = array_diff( $hasRelations, $postData['departments'] );
            
            foreach ( $insert as $key => $department_id) {
                Relation::create(array(
                    'type' => 'time_shift_department',
                    'from' => $postData['id'],
                    'to'   => $department_id
                ));
            }

            if ( $delete ) {
                Relation::whereIn('to', $delete)
                    ->where('type', 'time_shift_department')
                    ->where('from', intval( $postData['id'] ) )
                    ->delete();
            }
            
            $store = hrm_update_records();

            return $store;
            
        } else {
            return [
                'success' => false,
                'error' => [$validation->get_error_message()]
            ];
        }
    }

    function validation( $postData ) {
        global $wpdb;
        $departments = $this->filter_departments( $postData['times'] );
        $shift_id = isset( $postData['id'] ) ? intval( $postData['id'] ) : false;

        $time_shift = hrm_tb_prefix() . 'hrm_time_shift';
        $relation_tb = hrm_tb_prefix() . 'hrm_relation';

        $hasDepts = Shift::with([
                'departments'=> function($q) use( $relation_tb, $departments )  {
                        $q->whereIn($relation_tb.'.to', $departments)
                          ->where($relation_tb.'.type', 'time_shift_department');
                    }
            ])
            ->where('status', '1')
            ->get()
            ->toArray();
        
        foreach ( $hasDepts as $key => $hasDept ) {
            if ( $shift_id == $hasDept['id'] ) {
                continue;
            }

            if ( count( $hasDept['departments'] ) ) {
                $message = $hasDept['departments'][0]['name'] . ' department already exist in ' . $hasDept['name'] . ' time shift.';
                return new WP_Error('time', $message );
            }
        }
        
        return true;
    }

    function get_shift_by_department( $departments ) {
        global $wpdb;
        
        $time_shift = hrm_tb_prefix() . 'hrm_time_shift';
        $relation_tb = hrm_tb_prefix() . 'hrm_relation';

        $department_ids = is_array( $departments ) ? $departments : [$departments];
        
        $collection = Shift::with([
                'departments'=> function($q) use( $relation_tb, $department_ids )  {
                        $q->whereIn( $relation_tb.'.to', $department_ids )
                          ->where( $relation_tb.'.type', 'time_shift_department' );
                    }
            ])
            ->where('status', '1');

        $resource = new Collection( $collection->get(), new Shift_Transformer );

        $shift = $this->get_response( $resource );

        if ( is_array( $departments ) ) {
            return $shift;
        }

        if ( ! empty( $shift ) ) {
            return $shift['data'][0];
        }

        return [];
    }

	function ajax_get_shift() {

		check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'id' => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'status' => isset( $_POST['departments'] ) ? hrm_clean( $_POST['departments'] ) : '',
            'per_page' => isset( $_POST['per_page'] ) ? intval( $_POST['per_page'] ) : '',
            'page' => isset( $_POST['page'] ) ? intval( $_POST['page'] ) : '',
        ];

        $shift = self::getInstance()->get_shift( $postdata );

        wp_send_json_success( $shift );
	}

	function get_shift( $postData ) {
        
        $status   = empty( $postData['status'] ) ? 1 : hrm_clean( $postData['status'] );
        $per_page = empty( $postData['per_page'] ) ? hrm_per_page() : intval( $postData['per_page'] );
        $id       = empty( $postData['id'] ) ? false : intval( $postData['id'] );
        $page     = empty( $postData['page'] ) ? 1 : intval( $postData['page'] );

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
      
        if ( $id ) {

            if ( is_array( $id ) ) {
                $shift = Shift::where( function($q) use( $id ) {

                    $q->whereIn( 'id', $id );

                })
                ->orderBy( 'id', 'DESC' )
                ->paginate( $per_page );
                
                $collection = $shift->getCollection();
                $resource = new Collection( $collection, new Shift_Transformer );
                $resource->setPaginator( new IlluminatePaginatorAdapter( $shift ) );

            } else {

                $shift_collection = Shift::find( $id );
                $resource = new Item( $shift_collection, new Shift_Transformer );
            }
        
        } else {
            $shift = Shift::where( function($q) use( $status ) {
                if ( ! empty(  $status ) ) {
                    $q->where( 'status', intval($status) );
                }
            })
            ->orderBy( 'id', 'DESC' )
            ->paginate( $per_page );

            $collection = $shift->getCollection();
            $resource = new Collection( $collection, new Shift_Transformer );
            $resource->setPaginator( new IlluminatePaginatorAdapter( $shift ) );
        }

        return $this->get_response( $resource );
	}
}

