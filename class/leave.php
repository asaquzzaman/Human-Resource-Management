<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as Collection;
use HRM\Core\Transformer_Manager;
use HRM\Core\Leave\Leave_Transformer;
use HRM\Models\Leave;
use HRM\Models\User;
use HRM\Models\Leave_Type;
use HRM\Core\Leave\Leave_Type_Transform as Leave_Type_Transform;
use HRM\Models\Meta;
use HRM\Core\Crud\Crud;

class Hrm_Leave {

	private static $_instance;

	public static function getInstance() {
		if( ! self::$_instance ) {
			self::$_instance = new hrm_Leave();
		}

		return self::$_instance;
	}

    function __construct() {
        add_filter( 'hrm_change_data', array( $this, 'update_holiday_data' ), 10, 5 );
    }

    public static function search_emp_leave_records() {
        check_ajax_referer('hrm_nonce');
        $send = [];
        $users = get_users( array(
            'search' => '*' . $_POST['user'] . '*',
            'search_columns' => array( 'user_login', 'user_email', 'nicename' ),
        ));

        $args = [
            'start_time' => date( 'Y-m-d', strtotime( $_POST['start'] ) ),
            'end_time'   => date( 'Y-m-d', strtotime( $_POST['end'] ) ),
            'per_page'   => 50, 
        ];
        
        foreach( $users as $user ) {
            $args['emp_id'] = $user->ID;
            $user->leave_records = Hrm_Leave::getInstance()->get_leaves( $args );
            $send[] = $user->data;
        }

        wp_send_json_success( $send );
    }

    public function get_leaves( $args = array() ) {

        global $wpdb;
        $transformer = new Transformer_Manager();
        

        $defaults = array(
            'start_time' => hrm_financial_start_date(),
            'end_time'   => hrm_financial_end_date(),
            'per_page'   => 50,  
            'page'       => 1    
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'hrm-leave' . md5( serialize( $args ) ) . get_current_user_id();
        $items     = wp_cache_get( $cache_key, 'hrm' );
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

            if ( !empty( $args['id'] ) ) {
                $leaves = $leaves->where( 'id', $args['id'] );
            }
                
            $leaves = $leaves->paginate( $args['per_page'], ['*'], $args['page'] );

            $leave_collection = $leaves->getCollection();
            
            $resource = new Collection( $leave_collection, new Leave_Transformer );
            $resource->setPaginator( new IlluminatePaginatorAdapter( $leaves ) );

            if ( !empty( $args['emp_id'] ) ) {
                $leave_type_count = $this->employee_leave_count( $args['emp_id'] );
                $resource->setMeta(['types' => $leave_type_count]);
            }
            
            $items = $transformer->get_response( $resource );

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
        $from = !empty( $post['from'] ) ? date( 'Y-m-d', strtotime( $post['from'] ) ) : date( 'Y-m-d', time() );
        $to = empty( $post['to'] ) ? $from : date( 'Y-m-d', strtotime( $post['to'] ) );

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

    function employee_to_employer_leave_message( $post, $get_duration, $current_user ) {
        $post_from    = hrm_get_date2mysql( $post['from'] );
        $post_to      = hrm_get_date2mysql( $post['to'] );
        ob_start();
        ?>
            <div style="width: 600px; background: #eee; padding: 5px;">
                <table width="600" style="background: #fff; padding: 10px;">
                    <tr>
                        <td style="padding: 10px;"><?php _e( 'Hello', 'hrm' ); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;"><?php _e( 'You have a leave notification', 'hrm' ); ?></td>
                    </tr>
                </table>
                <table  width="600" style="border-collapse: collapse; background: #fff; padding: 10px;">
                <thead>
                    <tr>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Employee ID', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Name', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Leave Type', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Duration', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Comment', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Status', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Leave Total', 'hrm' ); ?></th>
                    <tr>
                </thead>

                <tr>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $current_user->ID; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $current_user->display_name; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $get_duration['leave_type_name']; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $post_from;  _e( ' to ', 'hrm' ); echo $post_to; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $post['comment']; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $this->status( $post['status'] );; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $post['apply_leave_total'];  _e( ' days', 'hrm' ); ?></td>
                <tr>
                </table>
            </div>
            <?php
        return ob_get_clean();
    }

    function employer_to_employee_leave_message( $send_to_user, $post, $get_duration, $current_user ) {
        $post_from    = hrm_get_date2mysql( $post['from'] );
        $post_to      = hrm_get_date2mysql( $post['to'] );
        ob_start();
        ?>
            <div style="width: 600px; background: #eee; padding: 5px;">
                <table width="600" style="background: #fff; padding: 10px;">
                <tr>
                    <td style="padding: 10px;"><?php _e( 'Hello, ', 'hrm' ); ?> <?php echo $send_to_user->display_name; ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><?php _e( 'You have leave request notification', 'hrm' ); ?></td>
                </tr>
                </table>
                <table  width="600" style="border-collapse: collapse; background: #fff; padding: 10px;">
                <thead>
                    <tr>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Employer', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Leave Type', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Duration', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Comment', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Status', 'hrm' ); ?></th>
                        <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Leave Total', 'hrm' ); ?></th>
                    </tr>
                </thead>

                <tr>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $current_user->display_name; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $get_duration['leave_type_name']; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $post_from; _e( ' to ', 'hrm' ); echo $post_to; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $post['comment']; ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $this->status( $post['status'] ); ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $post['apply_leave_total']; _e( ' days', 'hrm' ); ?></td>
                </tr>
                </table>
            </div>
        <?php
        return ob_get_clean();
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
        $get_apply_leave = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', '*', array( 'id' => $postdata['leave_id'] ), true );

        $leave_owner = get_user_by( 'id', $get_apply_leave->emp_id );

        $to = $leave_owner->user_email;
        $subject = __( 'Human Resource Management - Leave status changes', 'hrm' );
        $sender_id = get_current_user_id();
        $message = $this->status_update_message_body( $get_apply_leave, $leave_owner, $postdata['status'], $prev_leave_row );

        Hrm_Settings::getInstance()->send( $to, $subject, $message, $sender_id );
    }

    function status_update_message_body( $get_apply_leave, $leave_owner, $status, $prev_leave_row ) {
        $prev_leave_satus = $this->status( $prev_leave_row->status );
        $present_leave_satatus = $this->status( $status );
        $post_from     = hrm_get_date2mysql( $get_apply_leave->start_time );
        $post_to       = hrm_get_date2mysql( $get_apply_leave->end_time );
        $leave_type    = Hrm_Settings::getInstance()->edit_query( 'hrm_leave_type', $get_apply_leave->type );
        $work_in_week  = get_option( 'hrm_work_week' );
        $holidays      = Hrm_Settings::getInstance()->hrm_query('hrm_holiday');
        $holiday_index = array();
        unset( $holidays['total_row'] );

        foreach ( $holidays as $key => $holiday ) {
            $holiday_index = array_merge( $holiday_index, maybe_unserialize( $holiday->index_holiday ) );
        }

        $leave_count = $this->count_leave_exclude_holiday_weekend( $post_from, $post_to, $work_in_week, $holiday_index );
        ob_start();
        ?>

            <div style="width: 600px; background: #eee; padding: 5px;">
            <table width="600" style="background: #fff; padding: 10px;">
                <tr>
                    <td style="padding: 10px;"><?php _e( 'Hello', 'hrm' ); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><?php _e( 'You leave status is changes ', 'hrm' ); echo $prev_leave_satus; _e( ' to ' ); echo $present_leave_satatus; ?></td>
                </tr>
            </table>
            <table  width="600" style="border-collapse: collapse; background: #fff; padding: 10px;">
            <thead>
                <tr>
                    <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Employee ID', 'hrm' ); ?></th>
                    <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Name', 'hrm' ); ?></th>
                    <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Leave Type', 'hrm' ); ?></th>
                    <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Duration', 'hrm' ); ?></th>
                    <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Comment', 'hrm' ); ?></th>
                    <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Status', 'hrm' ); ?></th>
                    <th style="background: #f7f5f5; border: 1px solid #e1e1e1;"><?php _e( 'Leave Total', 'hrm' ); ?></th>
                <tr>
            </thead>

            <tr>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $leave_owner->ID; ?></td>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $leave_owner->display_name; ?></td>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $leave_type['leave_type_name']; ?></td>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $post_from; _e( ' to ', 'hrm' ); echo $post_to; ?></td>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $get_apply_leave->comments; ?></td>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $present_leave_satatus; ?></td>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $leave_count;  _e( ' days', 'hrm' ); ?></td>
            <tr>
            </table>
        <?php
        return ob_get_clean();
    }

    public static function ajax_leave_header() {
        $menu = hrm_page();
        $leave = $menu[hrm_leave_page()];
        
        wp_send_json_success( array( 'header' => $leave ) );
    }

    public function new_leave_type( $postdata ) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'hrm_leave_type';
        $id = empty( $postdata['id'] ) ? false : absint( $postdata['id'] );

        $data = array(
            'leave_type_name' => $postdata['leave_type'],
            'entitlement'     => $postdata['entitlement'],
            'entitle_from'    => hrm_financial_start_date(),
            'entitle_to'      => hrm_financial_end_date(),
            'carry'           => $postdata['nextYear'] ? 1 : 0,
            'f_year'          => $postdata['nextYear']
                                ? hrm_get_current_financial_id()
                                : 0
        );

        $format = array( '%s', '%d', '%s', '%s', '%d' );

        if ( $id ) {
            $result     = $wpdb->update( $table, $data, array( 'id' => $id ), $format, array( '%d' ) );
            $date['id'] = $id;

        } else {
            $result     = $wpdb->insert( $table, $data, $format );
            $date['id'] = $wpdb->insert_id;
        }

        if ( $result ) {
            return array( 'type' => $date['id'], 'leave_type' => $data );
        }

        return new WP_Error( 'unknoen', __( 'Something went wrong!', 'hrm' ), array(501) );

    }

    public static function ajax_create_new_leave_type() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;

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

    public static function ajax_get_leave_type() {
        check_ajax_referer('hrm_nonce');
        
        $leave_types = self::getInstance()->get_leave_types();

        wp_send_json_success(array( 
            'leave_types'  => $leave_types, 
        ));
    }

    function get_leave_types( $args = array() ) {
        $defaults = array(
            'start_time' => hrm_financial_start_date(),
            'end_time'   => hrm_financial_end_date(),
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'hrm-leave-types' . md5( serialize( $args ) ) . get_current_user_id();
        $send     = wp_cache_get( $cache_key, 'hrm' );
        
        if ( false === $send ) { 

            $leave_types = new Leave_Type();

            $leave_types = $leave_types->where(function($q) use($args) {
                if ( !empty( $args['id'] ) ) {
                    $q->where( 'id', $args['id'] );
                }

                if ( !empty( $args['start_time'] ) ) {
                    $q->where( 'entitle_from', '>=', $args['start_time'] );
                }

                if ( !empty( $args['end_time'] ) ) {
                    $q->where( 'entitle_to', '<=', $args['end_time'] );
                }
            });

            $leave_types = $leave_types->orWhere( 'carry', 1 );

            $leave_types = $leave_types->get();

            $leave_types = new Collection( $leave_types, new Leave_Type_Transform );
            $transform = new Transformer_Manager();

            $send = $transform->get_response( $leave_types );

            wp_cache_set( $cache_key, $send, 'hrm' );

        }

        return $send;
    }

    public static function ajax_create_new_holidays() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;

        $holidays = self::getInstance()->create_new_holidays( $postdata );

        if ( is_wp_error( $holidays ) ) {
            wp_send_json_error( array( 'error' => $holidays->get_error_messages() ) ); 
        } else {
            wp_send_json_success( array( 
                'holidays'  => $holidays, 
                'success'     => __( 'Leave type has been created successfully', 'hrm' ) 
            ) );
        }
    }

    function create_new_holidays( $postdata ) {
        global $wpdb;

        $table = $wpdb->prefix . 'hrm_holiday';
        $id = empty( $postdata['id'] ) ? false : absint( $postdata['id'] );

        $data = array(
            'name'        => $postdata['name'],
            'from'        => $postdata['from'],
            'to'          => $postdata['to'],
            'description' => $postdata['description']
        );

        $format = array( '%s', '%s', '%s', '%s' );

        if ( $id ) {
            $result     = $wpdb->update( $table, $data, array( 'id' => $id ), $format, array( '%d' ) );
            $date['id'] = $id;

        } else {
            $result     = $wpdb->insert( $table, $data, $format );
            $date['id'] = $wpdb->insert_id;
        }

        if ( $result ) {
            return array( 'type' => $date['id'], 'leave_type' => $data );
        }

        return new WP_Error( 'unknoen', __( 'Something went wrong!', 'hrm' ), array(501) );

    }

    function ajax_get_holidays() {
        check_ajax_referer('hrm_nonce');
        
        $holidays = self::getInstance()->get_holidays();

        wp_send_json_success(array( 
            'holidays'  => $holidays, 
        ));
    }

    function get_holidays( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'from' => date( 'Y-01-01 00:00:00' ),
            'to'   => date( 'Y-12-31 24:59:59' )
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
                }

            }

            $query = Hrm_Attendance::getInstance()->generate_query( $query_args );

            $table = $wpdb->prefix . 'hrm_holiday';

            $items = $wpdb->get_results( "SELECT * FROM {$table} WHERE 1=1 AND $query" );
            
            wp_cache_set( $cache_key, $items, 'hrm' );
        }
        
        return $items;
    }

    public static function ajax_save_work_week() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $work_week = self::getInstance()->save_work_week( $postdata );

        wp_send_json_success(array( 
            'work_week'  => $work_week, 
        ));
    }

    public function save_work_week( $postdata ) {
        $prev_work_week = get_option( 'hrm_work_week' );
        
        if ( empty( $prev_work_week ) ) {
            $prev_work_week['saturday']  = empty( $postdata['saturday'] ) ? 'full' : $postdata['saturday'];
            $prev_work_week['sunday']    = empty( $postdata['sunday'] ) ? 'full' : $postdata['sunday'];
            $prev_work_week['monday']    = empty( $postdata['monday'] ) ? 'full' : $postdata['monday'];
            $prev_work_week['tuesday']   = empty( $postdata['tuesday'] ) ? 'full' : $postdata['tuesday'];
            $prev_work_week['wednesday'] = empty( $postdata['wednesday'] ) ? 'full' : $postdata['wednesday'];
            $prev_work_week['thursday']  = empty( $postdata['thursday'] ) ? 'full' : $postdata['thursday'];
            $prev_work_week['friday']    = empty( $postdata['friday'] ) ? 'full' : $postdata['friday'];
        
        } else {
            $prev_work_week['saturday']  = empty( $postdata['saturday'] ) ? $prev_work_week['saturday'] : $postdata['saturday'];
            $prev_work_week['sunday']    = empty( $postdata['sunday'] ) ? $prev_work_week['sunday'] : $postdata['sunday'];
            $prev_work_week['monday']    = empty( $postdata['monday'] ) ? $prev_work_week['monday'] : $postdata['monday'];
            $prev_work_week['tuesday']   = empty( $postdata['tuesday'] ) ? $prev_work_week['tuesday'] : $postdata['tuesday'];
            $prev_work_week['wednesday'] = empty( $postdata['wednesday'] ) ? $prev_work_week['wednesday'] : $postdata['wednesday'];
            $prev_work_week['thursday']  = empty( $postdata['thursday'] ) ? $prev_work_week['thursday'] : $postdata['thursday'];
            $prev_work_week['friday']    = empty( $postdata['friday'] ) ? $prev_work_week['friday'] : $postdata['friday'];
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
        
        $leave_types = self::getInstance()->get_leave_types();
        $holidays = self::getInstance()->get_holidays();
        $work_week = self::getInstance()->get_work_week();
        $apply_to    = new WP_User_Query( array(
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
        $start = date( 'Y-m-d', strtotime( $_POST['start'] ) );
        $end = date( 'Y-m-d', strtotime( $_POST['end'] ) );
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
        
        $postdata    = $_POST;
        $times       = empty( $postdata['time'] ) ? array() : $postdata['time'];
        $leave       = array();
        
        foreach ( $times as $key => $time ) {

            $postdata['start_time'] = date( 'Y-m-d', strtotime( $time ) );
            $postdata['end_time']   = date( 'Y-m-d', strtotime( $time ) );
            
            $leave  = Crud::data_process( $postdata );
        }
        
        if ( is_wp_error( $leave ) ) {
            wp_send_json_error( array(
                'error' => $leave->get_error_messages()
            ));
        }

        wp_send_json_success(array(
            'success' => __( 'Successfully updated', 'hrm' )
        ));
    }

    public static function ajax_get_leaves() {
        check_ajax_referer('hrm_nonce');
        wp_send_json_success( self::getInstance()->get_leaves( $_POST ) );
    }

    // public function get_leave_records() {
    //     $leave_model = new HRM\Models\leave();
    //     $transformer = new Transformer_Manager();

    //     $leaves           = $leave_model::paginate();
    //     $leave_collection = $leaves->getCollection();
    //     $resource         = new Collection( $leave_collection, new Leave_Transformer );
        
    //     $resource->setPaginator( new IlluminatePaginatorAdapter( $leaves ) );
 
    //     $response = $transformer->get_response( $resource );

    //     return $response;
    // }

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
            'others_employee_leave' => wp_list_pluck( $_POST['others_employee_leave'], 'id' ),
            'leave_types'           => wp_list_pluck( $_POST['leave_types'], 'id' ),
            'apply_to'         => wp_list_pluck( $_POST['apply_to'], 'id' )
        ];
        
        self::getInstance()->save_leave_form_settings( $settings );

        wp_send_json_success();
    }

    public function save_leave_form_settings( $settings ) {
        update_option('hrm_leave_form_settings', $settings);
    }

    public static function ajax_update_leave() {
        check_ajax_referer('hrm_nonce');

        $postdata = $_POST;

        $update = self::getInstance()->update_leave( $postdata );

        if ( $update ) {
           $update = self::getInstance()->get_leaves(['id' => $postdata['id']]); 
           wp_send_json_success($update);
        }
        
        wp_send_json_error();
    }

    public function update_leave( $postdata ) {
        return Crud::data_process( $postdata );
    }

    public static function ajax_delete_leave() {
        check_ajax_referer('hrm_nonce');
        $leave_id = intval( $_POST['leave_id'] );
        self::getInstance()->delete_leave($leave_id);
        wp_send_json_success();
    }

    public function delete_leave($leave_id) {
        if ( $leave_id ) {
            Leave::find( $leave_id )->delete();
        }
    }
}

