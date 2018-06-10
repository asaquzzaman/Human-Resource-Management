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
	}

    function ajax_delete_shift() {
        check_ajax_referer('hrm_nonce');
        $shift = self::getInstance()->delete_shift( $_POST );
        
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
        $shift = self::getInstance()->add_shift( $_POST );
        
        if (  isset( $shift['success'] ) &&  $shift['success'] === false ) {
            wp_send_json_error( $shift );
        }

        wp_send_json_success( $shift );
    }

    function add_shift( $postData ) {
        $validation = $this->validation( $postData );
        
        if ( ! is_wp_error( $validation ) ) {
            $current_date = date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) );
            $postData['puch_start'] = $current_date .' '. trim($postData['puch_start']);
            $postData['times'] = maybe_serialize( $postData['times'] ); 

            $store = hrm_insert_records( $postData );
            
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
                'error' => [$validation->get_error_message()]
            ];
        }

    }

    function ajax_update_shift() {
        check_ajax_referer('hrm_nonce');
        $shift = self::getInstance()->update_shift( $_POST );
        
        if (  isset( $shift['success'] ) &&  $shift['success'] === false ) {
            wp_send_json_error( $shift );
        }

        wp_send_json_success( $shift );
    }

    function update_shift( $postData ) {
        $validation = $this->validation( $postData );
        
        if ( ! is_wp_error( $validation ) ) {
            $current_date = date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) );
            $postData['puch_start'] = $current_date .' '. trim($postData['puch_start']);
            $postData['times'] = maybe_serialize( $postData['times'] ); 


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
                    ->where('from', $postData['id'])
                    ->delete();
            }

            $store = hrm_update_records( $postData );

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
        $departments = $postData['departments'];
        $shift_id = isset( $postData['id'] ) ? $postData['id'] : false;

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
                $message = $hasDept['departments'][0]['name'] . ' department already exist in ' . $hasDept['name'];
                return new WP_Error('time', $message );
            }
        }
        
        return true;
    }

	function ajax_get_shift() {

		check_ajax_referer('hrm_nonce');
        $shift = self::getInstance()->get_shift( $_POST );

        wp_send_json_success( $shift );
	}

	function get_shift( $postData ) {
        
        $status      = empty( $postData['status'] ) ? 1 : $postData['status'];
        $per_page    = hrm_per_page();

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
		$shift = Shift::where( function($q) use( $status ) {
            if ( ! empty(  $status ) ) {
                $q->where( 'status', $status );
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );

        $collection = $shift->getCollection();

        $resource = new Collection( $collection, new Shift_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $shift ) );

        return $this->get_response( $resource );
	}
}

