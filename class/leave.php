<?php

use Illuminate\Database\Capsule\Manager as DB;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Resource\Item;
use HRM\Core\Transformer_Manager;
use HRM\Transformers\Leave_Transformer;
use HRM\Models\Leave;
use HRM\Models\User;
use HRM\Models\Leave_Type;
use HRM\Transformers\Leave_Type_Transform as Leave_Type_Transform;
use HRM\Models\Meta;
use HRM\Core\Crud\Crud;
use HRM\Models\Relation;
use HRM\Models\Holiday;
use Illuminate\Pagination\Paginator;


class Hrm_Leave {
    use Transformer_Manager;

	private static $_instance;

	public static function getInstance() {
		if( ! self::$_instance ) {
			self::$_instance = new hrm_Leave();
		}

		return self::$_instance;
	}

    function __construct() {
        add_filter( 'hrm_change_data', array( $this, 'update_holiday_data' ), 10, 5 );
        add_action( 'wp_ajax_hrm_get_dashboard_leaves', array( $this, 'get_dasboard_leaves' ) );
        add_action( 'wp_ajax_leave_init', array( $this, 'ajax_leave_init' ) );
        add_action( 'wp_ajax_get_leaves', array( $this, 'ajax_get_leaves' ) );
    }


    function ajax_leave_init() {
        check_ajax_referer('hrm_nonce');
        wp_send_json_success([
            'employee_role' => Hrm_Employee::getInstance()->get_current_user_hr_role()
        ]);
    }

    function get_dasboard_leaves() {
        check_ajax_referer('hrm_nonce');
 
        $leaves = Hrm_Leave::getInstance()->get_leaves(
            array(
                'start_time' => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
                'end_time'   => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
                'per_page'   =>  1000,
                'status'     => 1
            )
        );

        wp_send_json_success( $leaves['data'] );
    }

    public static function ajax_get_employee_dropdown() {
        check_ajax_referer('hrm_nonce');

        $employees = Hrm_Employeelist::getInstance()->get_employee_drop_down();
        $dropdown = array();

        foreach ( $employees as $employee_id => $employee ) {
            $dropdown[] = array(
                'id' => $employee_id,
                'name' => $employee
            );
        }

        wp_send_json_success( $dropdown );
    }

    public static function search_emp_leave_records() {
        check_ajax_referer('hrm_nonce');
        
        $send = [];
        $users = get_users( array(
            'search' => '*' . hrm_clean( $_POST['user'] ) . '*',
            'search_columns' => array( 'user_login', 'user_email', 'nicename' ),
        ));

        $args = [
            'start_time' => date( 'Y-m-d', strtotime( hrm_clean( $_POST['start'] ) ) ),
            'end_time'   => date( 'Y-m-d', strtotime( hrm_clean( $_POST['end'] ) ) ),
            'per_page'   => 50, 
        ];
        
        foreach( $users as $user ) {
            $args['emp_id'] = $user->ID;
            $user->leave_records = Hrm_Leave::getInstance()->get_leaves( $args );
            $send[] = [
                'ID'            => $user->ID,
                'display_name'  => $user->display_name,
                'user_email'    => $user->user_email,
                'leave_records' => $user->leave_records,
                'avatar_url'    => get_avatar_url( $user->user_email )
            ];
        }

        wp_send_json_success( $send );
    }

    public static function ajax_get_leaves() {
        check_ajax_referer('hrm_nonce');
        
        $_POST['query'] = empty( $_POST['query'] ) ? [] : hrm_clean( $_POST['query'] );
        $_POST['emp_id'] = empty( $_POST['emp_id'] ) ? '' : hrm_clean( $_POST['emp_id'] );
        
        $args = array (
            'start_time' => empty( $_POST['query']['start_time'] ) ? false : hrm_clean( $_POST['query']['start_time'] ),

            'end_time' =>  empty( $_POST['query']['end_time'] ) ? false : hrm_clean( $_POST['query']['end_time'] ),

            'emp_id' => empty( $_POST['query']['emp_id'] ) 
                ? hrm_clean( $_POST['emp_id'] )
                : hrm_clean( $_POST['query']['emp_id'] ),

        );

        if ( !empty( $_POST['status'] ) ) {
            $args['status'] = intval( $_POST['status'] );
        }
        
        if ( ! hrm_user_can( 'manage_leave' ) ) {
            $args['emp_id'] = hrm_clean( $_POST['emp_id'] );
        }

        wp_send_json_success( self::getInstance()->get_leaves( $args ) );
    }

    function get_leaves_array( $args = array() ) {
        $leaves = $this->get_leaves( $args );
        $array = [];

        foreach ( $leaves['data'] as $key => $leave ) {
            
            $begin = new DateTime( $leave['start_time'] );
            $end   = new DateTime( $leave['end_time'] );

            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $date = $i->format("Y-m-d");

                $array[$date] = $date;
            }
        }
        
        return $array;
    }

    public function get_leaves( $args = array() ) {

        global $wpdb;
        
        $defaults = array(
            //'start_time' => hrm_financial_start_date(),
            //'end_time'   => hrm_financial_end_date(),
            'per_page'   => 50,  
            'page'       => 1    
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'hrm-leave' . md5( serialize( $args ) ) . get_current_user_id();
        $items     = wp_cache_get( $cache_key, 'hrm' );
        $page = $args['page'];

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
         if ( false === $items ) { 

            $leaves = Leave::with('leaveType');

            if ( !empty( $args['emp_id'] ) ) {
                $leaves = $leaves->where( 'emp_id', $args['emp_id'] );
            }
            

            if ( !empty( $args['start_time'] ) ) {
                $leaves = $leaves->where( 'start_time', '>=', $args['start_time'] );
            }

            if ( !empty( $args['end_time'] ) ) {
                $leaves = $leaves->where( 'end_time', '<=', $args['end_time'] );
            }

            if ( !empty( $args['status'] ) ) {
                $leaves = $leaves->where( 'status', $args['status'] );
            }
            
            if ( empty( $args['id'] ) ) {
                $leaves           = $leaves->paginate( $args['per_page'] );
                $leave_collection = $leaves->getCollection();

                $resource = new Collection( $leave_collection, new Leave_Transformer );
                $resource->setPaginator( new IlluminatePaginatorAdapter( $leaves ) );
            
            } else {
                $leave_collection = Leave::find( $args['id'] );
                $resource = new Item( $leave_collection, new Leave_Transformer );
            }

            if ( !empty( $args['emp_id'] ) ) {
                $leave_type_count = $this->employee_leave_count( $args['emp_id'] );
                $resource->setMeta(['types' => $leave_type_count]);
            }
            
            $items = $this->get_response( $resource );

            wp_cache_set( $cache_key, $items, 'hrm' );
        }
        
        return $items;
    }

    function employee_leave_count($emp_id = false) {
        $emp_id = $emp_id ? absint( $emp_id ) : get_current_user_id();
        $user  = User::find( $emp_id );
        $types = Leave_Type::all();
    
        foreach( $types as $type ) {
            $type->count = $user->leave_types->where('id', $type->id)->count();
        }

        $meta = $types->toArray();

        $count_extra_leave = $this->employee_extra_leave( $emp_id );

        $meta[] = array(
            'id'              => 0,
            'leave_type_name' => 'Extra',
            'entitle_from'    => '',
            'entitle_to'      => '',
            'entitlement'     => 0,
            'count'           => $count_extra_leave
        );

        return $meta;
    }

    public static function ajax_get_employee_leave_summery() {
        check_ajax_referer('hrm_nonce');
        
        $employee_id = hrm_clean( $_POST['employee_id'] );

        wp_send_json_success(
            self::getInstance()->employee_leave_count( $employee_id )
        );
    }

    function employee_extra_leave($emp_id = false) {
        $emp_id = $emp_id ? $emp_id : get_current_user_id();
        
        return Leave::where('type', '0')
                ->where('emp_id', $emp_id)
                ->count();
    }

    function update_holiday_data( $data, $table, $format, $update_status, $post ) {

        if ( $table != 'hrm_holiday' ) {
            return $data;
        }
        $from = !empty( $post['from'] ) ? date( 'Y-m-d', strtotime( hrm_clean( $post['from'] ) ) ) : date( 'Y-m-d', time() );
        $to = empty( $post['to'] ) ? $from : date( 'Y-m-d', strtotime( hrm_clean( $post['to'] ) ) );

        if ( $from >= $to  ) {
            $data['to'] = $from;
            $date[] = $from;
            $data['index_holiday'] = maybe_serialize( $date );
            return $data;
        }
        while ( $from <= $to) {
            $date[] = $from;
            $from = date( 'Y-m-d', strtotime( $from . '+1 days' ) );
        }

        $data['index_holiday'] = maybe_serialize( $date );

        return $data;
    }


    function send_new_leave_email( $user_id, $post, $get_duration ) {

        $current_user = wp_get_current_user();
        $subject = __( 'HRM-Leave' );

        $email = array();
        foreach ( $post['apply_to'] as $key => $user_id ) {
            $user = get_user_by( 'id', $user_id );
            $email[] = $user->user_email;
        }
        $message = $this->employee_to_employer_leave_message( $post, $get_duration, $current_user );
        Hrm_Settings::getInstance()->send( $email, $subject, $message, $current_user->ID );

        $send_to_user = get_user_by( 'id', $user_id );
        $email = $send_to_user->user_email;

        $message = $this->employer_to_employee_leave_message( $send_to_user, $post, $get_duration, $current_user );
        Hrm_Settings::getInstance()->send( $email, $subject, $message, $current_user->ID );
    }

    function status( $status = null ) {
        $leave = array(
            ''  => __( '- Select -', 'hrm'),
            '1' => __( 'Pending', 'hrm' ),
            '2' => __( 'Approve', 'hrm' ),
            '3' => __( 'Cancel', 'hrm' ),
        );

        if ( $status === null ) {
            return $leave;
        } else {
            return $leave[$status];
        }
    }


    function status_update_message( $postdata, $prev_leave_row ) {
        global $wpdb;
        $table  = $wpdb->prefix . 'hrm_leave';
        $get_apply_leave = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', '*', array( 'id' => intval( $postdata['leave_id'] ) ), true );

        $leave_owner = get_user_by( 'id', $get_apply_leave->emp_id );

        $to = $leave_owner->user_email;
        $subject = __( 'Human Resource Management - Leave status changes', 'hrm' );
        $sender_id = get_current_user_id();
        $message = $this->status_update_message_body( $get_apply_leave, $leave_owner, hrm_clean( $postdata['status'] ), $prev_leave_row );

        Hrm_Settings::getInstance()->send( $to, $subject, $message, $sender_id );
    }

    public static function ajax_leave_header() {
        $menu = hrm_page();
        $leave = $menu[hrm_leave_page()];
        
        wp_send_json_success( array( 'header' => $leave ) );
    }

    function add_relation( $type, $relations, $is_update ) {
       
        if ( $is_update ) {
            $hasRelations = Relation::where('from', $is_update )
                ->where('type', 'leave_type')
                ->get()
                ->toArray();

            $hasRelations = wp_list_pluck( $hasRelations, 'to' );
            
            $insert = array_diff( $relations, $hasRelations );
            $delete = array_diff( $hasRelations, $relations );
            
            foreach ( $insert as $key => $department_id) {
                Relation::create(array(
                    'type' => 'leave_type',
                    'from' => $is_update,
                    'to'   => $department_id
                ));
            }

            if ( $delete ) {
                Relation::whereIn('to', $delete)
                    ->where('type', 'leave_type')
                    ->where('from', $is_update)
                    ->delete();
            }        
        } 
    }

    function create_relation( $type, $relations, $from ) {
        foreach( $relations as $key => $to ) {

            Relation::create(array(
                'type' => $type,
                'from' => $from,
                'to'   => $to
            ));
        }
    }


    public static function ajax_create_new_leave_type() {
        check_ajax_referer('hrm_nonce');

        $postdata = [
            'id'          => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'nextYear'    => isset( $_POST['nextYear'] ) ? hrm_clean( $_POST['nextYear'] ) : '',
            'departments' => isset( $_POST['departments'] ) ? hrm_clean( $_POST['departments'] ) : '',
            'leave_type'  => isset( $_POST['leave_type'] ) ? hrm_clean( $_POST['leave_type'] ) : '',
            'leave_type'  => isset( $_POST['leave_type'] ) ? hrm_clean( $_POST['leave_type'] ) : '',
            'entitlement' => isset( $_POST['entitlement'] ) ? hrm_clean( $_POST['entitlement'] ) : '',
        ];

        $leave_type = self::getInstance()->new_leave_type( $postdata );

        if ( is_wp_error( $leave_type ) ) {
            wp_send_json_error( array( 'error' => $leave_type->get_error_messages() ) ); 
        } else {
            wp_send_json_success( array( 
                'leave_type'  => $leave_type, 
                'success'     => __( 'Leave type has been created successfully', 'hrm' ) 
            ) );
        }
    }

    public function new_leave_type( $postdata ) {
        global $wpdb;
     
        $table     = $wpdb->prefix . 'hrm_leave_type';
        $id        = empty( $postdata['id'] ) ? false : absint( $postdata['id'] );
        $next_year = filter_var( $postdata['nextYear'], FILTER_VALIDATE_BOOLEAN);
        $departments = wp_list_pluck( $postdata['departments'], 'id' );


        if ( $id ) {
            $format = array( '%s', '%d' );
            $data = array(
                'leave_type_name' => hrm_clean( $postdata['leave_type'] ),
                'carry'           => $next_year ? 1 : 0,
            );

            $result     = $wpdb->update( $table, $data, array( 'id' => $id ), $format, array( '%d' ) );
            $data['id'] = $id;

        } else {

            $data = array(
                'leave_type_name' => hrm_clean( $postdata['leave_type'] ),
                'entitlement'     => hrm_clean( $postdata['entitlement'] ),
                'entitle_from'    => hrm_financial_start_date(),
                'entitle_to'      => hrm_financial_end_date(),
                'f_year'          => $next_year
                                    ? hrm_get_current_financial_id()
                                    : 0,
                'carry'           => $next_year ? 1 : 0
                
            );

            $format = array( '%s', '%d', '%s', '%s', '%d' );

            $result     = $wpdb->insert( $table, $data, $format );
            $data['id'] = $wpdb->insert_id;
            
            $this->create_relation( 'leave_type', $departments, $wpdb->insert_id );
        }
        
        $this->add_relation( 'leave_type', $departments, $id );

        $leave_type = Leave_Type::find( intval( $data['id'] ) );

        $resource = new Item( $leave_type, new Leave_Type_Transform ); 

        $send = $this->get_response( $resource );

       // if ( $result ) {
            return $send;
       // }

        return new WP_Error( 'unknoen', __( 'Something went wrong!', 'hrm' ), array(501) );

    }

    public static function ajax_get_leave_type() {
        check_ajax_referer('hrm_nonce');
        
        $leave_types = self::getInstance()->get_leave_types();

        wp_send_json_success( $leave_types );
    }

    function get_leave_types( $args = array() ) {
        global $wpdb;
        $defaults = array(
            //'start_time' => hrm_financial_start_date(),
            //'end_time'   => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'hrm-leave-types' . md5( serialize( $args ) ) . get_current_user_id();
        $send     = wp_cache_get( $cache_key, 'hrm' );
        //var_dump( $args );
        if ( false === $send ) { 

            $leave_types = new Leave_Type();

            $leave_types = $leave_types->where(function($q) use($args) {
                if ( !empty( $args['id'] ) ) {
                    $q->where( 'id', $args['id'] );
                }

                // if ( !empty( $args['start_time'] ) ) {
                //     $q->where( 'entitle_from', '>=', $args['start_time'] );
                // }

                if ( !empty( $args['end_time'] ) ) {
                    $q->where( 'entitle_to', '>=', $args['end_time'] );
                }

                if ( !empty( $args['carry'] ) ) {
                    $q->orWhere( 'carry', 1 );
                }
            });

            $leave_types = $leave_types->get();
            //pr($wpdb->last_query); die();
            $leave_types = new Collection( $leave_types, new Leave_Type_Transform );
            $send = $this->get_response( $leave_types );

            wp_cache_set( $cache_key, $send, 'hrm' );

        }

        return $send;
    }

    public static function ajax_create_new_holidays() {
        check_ajax_referer('hrm_nonce');

        $postdata = [
            'id'          => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'name'        => isset( $_POST['name'] ) ? hrm_clean( $_POST['name'] ) : '',
            'description' => isset( $_POST['description'] ) ? hrm_clean( $_POST['description'] ) : '',
            'name'        => isset( $_POST['name'] ) ? hrm_clean( $_POST['name'] ) : '',
            'from'        => isset( $_POST['from'] ) ? hrm_clean( $_POST['from'] ) : '',
            'to'          => isset( $_POST['to'] ) ? hrm_clean( $_POST['to'] ) : '',
            'description' => isset( $_POST['description'] ) ? hrm_clean( $_POST['description'] ) : '',
        ];
        
        $holiday = self::getInstance()->create_new_holidays( $postdata );

        if ( is_wp_error( $holiday ) ) {
            wp_send_json_error( array( 'error' => $holiday->get_error_messages() ) ); 
        } else {
            wp_send_json_success( array( 
                'holiday'  => $holiday, 
                'success'     => __( 'Holiday has been created successfully', 'hrm' ) 
            ) );
        }
    }

    function create_new_holidays( $postdata ) {
        global $wpdb;

        $table = $wpdb->prefix . 'hrm_holiday';
        $id = empty( $postdata['id'] ) ? false : absint( $postdata['id'] );

        if ( $id ) {
            $data = array(
                'name'        => hrm_clean( $postdata['name'] ),
                'description' => hrm_clean( $postdata['description'] )
            );
            $format = array( '%s', '%s' );
            
            $result     = $wpdb->update( $table, $data, array( 'id' => $id ), $format, array( '%d' ) );
            $data['id'] = $id;
            $data = $this->get_holidays(array('id' => $data['id']));

            $data = $data ? $data[0] : array();

        } else {
            $data = array(
                'name'        => hrm_clean( $postdata['name'] ),
                'from'        => hrm_clean( $postdata['from'] ),
                'to'          => hrm_clean( $postdata['to'] ),
                'description' => hrm_clean( $postdata['description'] ),
                'f_year'      => hrm_get_current_financial_id()
            );
            $format = array( '%s', '%s', '%s', '%s' );
            $result     = $wpdb->insert( $table, $data, $format );
            $data['id'] = $wpdb->insert_id;
        }
        
       
        return $data;
        

        return new WP_Error( 'unknoen', __( 'Something went wrong!', 'hrm' ), array(501) );

    }

    public static function ajax_get_holidays() {
        check_ajax_referer('hrm_nonce');
        
        $holidays = self::getInstance()->get_holidays();

        wp_send_json_success(array( 
            'holidays'  => $holidays, 
        ));
    }

    function get_holidays_array( $args = array() ) {
        $holidays = $this->get_holidays( $args );

        $array = [];

        foreach ( $holidays as $key => $holiday ) {

            $begin = new DateTime( $holiday->from );
            $end   = new DateTime( $holiday->to );

            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $date = $i->format("Y-m-d");

                $array[$date] = $date;
            }
        }

        return $array;
    }

    function get_holidays( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'from' => hrm_financial_start_date(),
            'to'   => hrm_financial_end_date()
        );

        $args = wp_parse_args( $args, $defaults );

        $cache_key  = 'hrm-get-holidays' . md5( serialize( $args ) );
        $items      = wp_cache_get( $cache_key, 'hrm' );
        $query_args = array( 'relation' => 'AND' );

        if ( false === $items ) { 
            foreach ( $args as $key => $arg ) {
                switch ( $key ) {

                    case 'from':
                        $query_args[] = array(
                            'field'     => 'from',
                            'value'     => $arg,
                            'condition' => '>='
                        );
                        break;

                    case 'to':
                        $query_args[] = array(
                            'field'     => 'to',
                            'value'     => $arg,
                            'condition' => '<='
                        );
                        break;
                    case 'id':
                        $query_args[] = array(
                            'field'     => 'id',
                            'value'     => $arg,
                            'condition' => '='
                        );
                        break;

                }

            }

            $query = Hrm_Attendance::getInstance()->generate_query( $query_args );

            $table = $wpdb->prefix . 'hrm_holiday';

            $items = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "hrm_holiday WHERE 1=1 AND $query" );
            
            wp_cache_set( $cache_key, $items, 'hrm' );
        }
        
        return $items;
    }

    public static function ajax_save_work_week() {
        check_ajax_referer('hrm_nonce');


        $work_week = self::getInstance()->save_work_week();

        wp_send_json_success(array( 
            'work_week'  => $work_week, 
            'message' => 'Update weekend successfully'
        ));
    }

    public function save_work_week( $postdata ) {
        $prev_work_week = $this->get_work_week();
        
        if ( empty( $prev_work_week ) ) {
            $prev_work_week['saturday']  = empty( $_POST['saturday'] ) ? 'full' : hrm_clean( $_POST['saturday'] );
            $prev_work_week['sunday']    = empty( $_POST['sunday'] ) ? 'full' : hrm_clean( $_POST['sunday'] );
            $prev_work_week['monday']    = empty( $_POST['monday'] ) ? 'full' : hrm_clean( $_POST['monday'] );
            $prev_work_week['tuesday']   = empty( $_POST['tuesday'] ) ? 'full' : hrm_clean( $_POST['tuesday'] );
            $prev_work_week['wednesday'] = empty( $_POST['wednesday'] ) ? 'full' : hrm_clean( $_POST['wednesday'] );
            $prev_work_week['thursday']  = empty( $_POST['thursday'] ) ? 'full' : hrm_clean( $_POST['thursday'] );
            $prev_work_week['friday']    = empty( $_POST['friday'] ) ? 'full' : hrm_clean( $_POST['friday'] );
        
        } else {
            $prev_work_week['saturday']  = empty( $_POST['saturday'] ) ? $prev_work_week['saturday'] : hrm_clean( $_POST['saturday'] );
            $prev_work_week['sunday']    = empty( $_POST['sunday'] ) ? $prev_work_week['sunday'] : hrm_clean( $_POST['sunday'] );
            $prev_work_week['monday']    = empty( $_POST['monday'] ) ? $prev_work_week['monday'] : hrm_clean( $_POST['monday'] );
            $prev_work_week['tuesday']   = empty( $_POST['tuesday'] ) ? $prev_work_week['tuesday'] : hrm_clean( $_POST['tuesday'] );
            $prev_work_week['wednesday'] = empty( $_POST['wednesday'] ) ? $prev_work_week['wednesday'] : hrm_clean( $_POST['wednesday'] );
            $prev_work_week['thursday']  = empty( $_POST['thursday'] ) ? $prev_work_week['thursday'] : hrm_clean( $_POST['thursday'] );
            $prev_work_week['friday']    = empty( $_POST['friday'] ) ? $prev_work_week['friday'] : hrm_clean( $_POST['friday'] );
        }

        update_option( 'hrm_work_week', $prev_work_week );

        return $prev_work_week;
    }

    public static function ajax_get_work_week() {
        check_ajax_referer('hrm_nonce');
        
        $work_week = self::get_work_week();

        wp_send_json_success(array( 
            'work_week'  => $work_week, 
        ));
    }

    public static function get_work_week() {
       return get_option( 'hrm_work_week' );
    }

    function work_week_array( $start, $end ) {
        $work_weeks = Hrm_Leave::getInstance()->get_work_week();
        $weekend = [];

        foreach ( $work_weeks as $key => $work_week ) {
            if( $key == 'field_dif' ) {
                continue;
            }

            if( $work_week == 'non' ) {
                $weekend[$key] = date( 'N', strtotime( $key ) );
            }
        }

        $start  = new DateTime( $start );
        $end    = new DateTime( $end );
        $oneday = new DateInterval("P1D");

        $weekends = array();

        /* Iterate from $start up to $end+1 day, one day in each iteration.
           We add one day to the $end date, because the DatePeriod only iterates up to,
           not including, the end date. */
        foreach( new DatePeriod( $start, $oneday, $end->add($oneday) ) as $day ) {
            $lday = strtolower( $day->format('l') );
            
            if( array_key_exists( $lday, $weekend) ) {
                $date = $day->format('Y-m-d');
                $weekends[$date] = $date;
            }
            
        } 
        
        return $weekends;
    }


    public static function holiday_get_by_index() {
        $holidays_from = date('Y-m-01 00:00:00');
        $holidays_to   = date('Y-m-31 24:59:59');
        $holidays      = self::getInstance()->get_holidays(array( 'from' => $holidays_from, 'to' => $holidays_to ));
        $index         = array();
        $index_by_name = array();

        foreach ( $holidays as $key => $holiday ) {
            $start = date( 'Y-m-d', strtotime( $holiday->from ) );
            $end   = date( 'Y-m-d', strtotime( $holiday->to ) );

            while( $start <= $end ) {
                $index[$start] = $start;
                $index_by_name[$holiday->name][] = $start;
                $start   = date('Y-m-d', strtotime( $start . ' +1 day') );
            }
        }

        return array(
            'date_index' => $index,
            'name_index' => $index_by_name
        );
    }
 
    public static function get_leave_records_init_data() {
        check_ajax_referer('hrm_nonce');
        
        $leave_types = self::getInstance()->get_leave_types([
            'end_time' => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
            'carry' => 1
        ]);
        $holidays = self::getInstance()->get_holidays();
        $work_week = self::getInstance()->get_work_week();
        $apply_to  = new WP_User_Query( array(
            'role'   => 'administrator',
        ));

        $send_administrators = array();

        foreach ( $apply_to->results as $key => $apply ) {
            $apply->avatar     = get_avatar( $apply->ID, 96, 'mm' );
            $apply->avatar_url = get_avatar_url( $apply->ID, ['default' => 'mm'] );

            $send_administrators[] = $apply->data;
        }

        wp_send_json_success( array(
            'apply_to'    => $send_administrators,
            'leave_types' => $leave_types,
            'holidays'    => $holidays,
            'work_week'   => $work_week
        ));
    }

    public static function ajax_get_leave_record_events() {
        check_ajax_referer('hrm_nonce');
        
        $start = date( 'Y-m-d', strtotime( hrm_clean( $_POST['start'] ) ) );
        $end = date( 'Y-m-d', strtotime( hrm_clean( $_POST['end'] ) ) );
        $emp_id = empty( $_POST['emp_id'] ) ? get_current_user_id() : intval( $_POST['emp_id'] );

        $records = self::getInstance()->get_leaves( array(
            'start_time' => $start,
            'end_time'   => $end,
            'emp_id'     => $emp_id
        ) );

        wp_send_json_success(array(
            'records' => $records,
            'work_week' => self::get_work_week(),
            'holidays'  => self::getInstance()->get_holidays()
        ));
    }

    public static function ajax_create_new_leave() {
        check_ajax_referer('hrm_nonce');

        $postdata = [
            'comments'           => isset( $_POST['comments'] ) ? $_POST['comments'] : '', 
            'type'               => isset( $_POST['type'] ) ? $_POST['type'] : '', 
            'emp_id'             => isset( $_POST['emp_id'] ) ? $_POST['emp_id'] : '', 
            'time'               => isset( $_POST['time'] ) ? $_POST['time'] : '', 
            'disable_leave_type' => isset( $_POST['disable_leave_type'] ) ? $_POST['disable_leave_type'] : '', 
            'status'             => isset( $_POST['status'] ) ? $_POST['status'] : '', 
            'class'              => isset( $_POST['class'] ) ? $_POST['class'] : '', 
            'method'             => isset( $_POST['method'] ) ? $_POST['method'] : '', 
        ];

        $times       = empty( $postdata['time'] ) ? array() : hrm_clean( $postdata['time'] );
        $leave       = array();
        $return_data = array();
        $_POST['transformers'] = 'Leave_Transformer';
        
        
        foreach ( $times as $key => $time ) {

            $_POST['start_time'] = date( 'Y-m-d', strtotime( $time ) );
            $_POST['end_time']   = date( 'Y-m-d', strtotime( $time ) );
            
            $return_data[]  = Crud::data_process();
        }

        if ( is_wp_error( $leave ) ) {
            wp_send_json_error( array(
                'error' => $leave->get_error_messages()
            ));
        }

        wp_send_json_success(array(
            'success' => __( 'Successfully updated', 'hrm' ),
            'resource' => $return_data
        ));
    }

    public function get_leave_form_settings() {
        return get_option( 'hrm_leave_form_settings', false );
    }

    public static function ajax_get_leave_form_settings() {
        check_ajax_referer('hrm_nonce');

        $settings = [
            'roles'   => hrm_get_roles(),
            'settings' => self::getInstance()->get_leave_form_settings()
        ];
        
        wp_send_json_success( $settings );
    }

    public static function ajax_save_leave_form_settings() {
        check_ajax_referer('hrm_nonce');
        
        $settings = [
            'others_employee_leave' => wp_list_pluck( hrm_clean( $_POST['others_employee_leave'] ), 'id' ),
            'leave_types'           => wp_list_pluck( hrm_clean( $_POST['leave_types'] ), 'id' ),
            'apply_to'         => wp_list_pluck( hrm_clean( $_POST['apply_to'] ), 'id' )
        ];
        
        self::getInstance()->save_leave_form_settings( $settings );

        wp_send_json_success();
    }

    public function save_leave_form_settings( $settings ) {
        update_option('hrm_leave_form_settings', $settings);
    }

    public static function ajax_update_leave() {
        check_ajax_referer('hrm_nonce');

        $update = self::getInstance()->update_leave();

        if ( $update ) {
            $update = self::getInstance()->get_leaves(['id' => intval( $_POST['id'] ) ]);

            wp_send_json_success($update);
        }
        wp_send_json_error();
    }

    public function update_leave() {
        $_POST['transformers'] = 'Leave_Transformer';
        return Crud::data_process();
    }

    public static function ajax_delete_leave() {
        check_ajax_referer('hrm_nonce');
        
        $leave_id = intval( $_POST['leave_id'] );
        self::getInstance()->delete_leave($leave_id);
        wp_send_json_success();
    }

    public function delete_leave($leave_id) {
        $leave = Leave::find( $leave_id );

        if ( $leave ) {
            $leave->delete();
        } 
    }

    public static function ajax_delete_leave_type() {
        check_ajax_referer('hrm_nonce');
        
        $id = absint( $_POST['id'] );
        
        $delete = self::getInstance()->delete_leave_type( $id );
        
        if ( is_wp_error( $delete ) ) {
            wp_send_json_error( array( 'error' => $delete->get_error_messages() ) );
        } else {
            wp_send_json_success();
        }
    }

    public function delete_leave_type( $leave_type_id ) {

        $has_leave = Leave::where( 'type', $leave_type_id )->get()->toArray();

        if ( $has_leave ) {
            return new WP_Error( 'error', __( 'Some employee are taken leave from this leave type', 'hrm' ) );
        }

        $leave_type = Leave_Type::find($leave_type_id);

        if ( $leave_type ) {
            return $leave_type->delete();
        }

        return false;
    }

    public static function ajax_delete_holiday() {
        check_ajax_referer('hrm_nonce');
        
        $holiday_id = intval( $_POST['id'] );
        self::getInstance()->delete_holiday($holiday_id);
        wp_send_json_success();
    }

    public function delete_holiday( $holiday_id ) {
        
        $holiday = Holiday::find($holiday_id);

        if ( $holiday ) {
            return $holiday->delete();
        }

        return false;
    }
}

