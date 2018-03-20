<?php

class Hrm_Attendance {
    private static $_instance;

    public $unique_ids = array();
    private $relation = 'AND';

    public static function getInstance() {
        if ( ! self::$_instance ) {
            self::$_instance = new Hrm_Attendance();
        }

        return self::$_instance;
    }

    function __construct() {
        add_action('wp_ajax_hrm_get_dashboard_attendance', array( $this, 'get_dashboard_attendance' ) );
    }

    public function get_dashboard_attendance() {
        check_ajax_referer('hrm_nonce');

        $employees = Hrm_Employeelist::getInstance()->get_employee(true);

        $attendances = $this->get_attendance(
            array (
                'user_id'  => 'all',
                'punch_in' => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
            )
        );

        $leaves = Hrm_Leave::getInstance()->get_leaves(
            array(
                'start_time' => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
                'end_time'   => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
                'per_page'   =>  1000,
                'status'     => 1
            )
        );

        $office_time = self::getInstance()->get_office_time();

        $presents    = $this->get_presents( $employees, $attendances, $leaves['data'] );
        $absents     = $this->get_absents( $employees, $attendances, $leaves['data'] );
        $early_enter = $this->get_early_enter( $employees, $attendances, $leaves['data'], $office_time );
        $early_leave = $this->get_early_leave( $employees, $attendances, $leaves['data'], $office_time );
        $late_leave  = $this->get_late_leave( $employees, $attendances, $leaves['data'], $office_time );

        wp_send_json_success(array(
            'present'    => $presents,
            'absent'     => $absents,
            'early_enter' => $early_enter,
            'early_leave' => $early_leave,
            'late_leave'  => $late_leave
        ));
        
    }

    public function get_early_enter( $employees, $attendances, $leaves, $office_time ) {
        

        $start  = date( 'Y-m-d 10:00', strtotime( current_time('mysql') ) );
        $closed = date( 'Y-m-d 18:00', strtotime( current_time('mysql') ) );

        $start  = empty( $office_time->start ) ? $start : date( 'Y-m-d h:i a', strtotime( $office_time->start ) );
        $closed = empty( $office_time->end ) ? $closed : date( 'Y-m-d h:i a', strtotime( $office_time->end ) );

        $start = strtotime( $start );
        $closed = strtotime( $closed );


        $get_presents = $this->get_presents( $employees, $attendances, $leaves );

        foreach ( $get_presents as $key => $get_present ) {
            $punch_in = strtotime( $get_present->punch_in_date_time );

            if ( $punch_in >= $start ) {
                unset( $get_presents[$key] );
            }
        }

        return $get_presents;
        
    }

    public function get_early_leave( $employees, $attendances, $leaves, $office_time ) {
        $data = [];

        $start  = date( 'Y-m-d 10:00', strtotime( current_time('mysql') ) );
        $closed = date( 'Y-m-d 18:00', strtotime( current_time('mysql') ) );

        $start  = empty( $office_time->start ) ? $start : date( 'Y-m-d h:i a', strtotime( $office_time->start ) );
        $closed = empty( $office_time->end ) ? $closed : date( 'Y-m-d h:i a', strtotime( $office_time->end ) );

        $start = strtotime( $start );
        $closed = strtotime( $closed );


        $get_presents = $this->get_presents( $employees, $attendances, $leaves );

        foreach ( $get_presents as $key => $get_present ) {
            if ( ! empty( $get_present->punch_out_date_time ) ) {
                if ( strtotime( $get_present->punch_out_date_time ) < $closed ) {
                    $data[] = $get_present;
                }
            }
        }
        
        return $data;
        
    }

    public function get_late_leave( $employees, $attendances, $leaves, $office_time ) {

        $data = [];

        $start  = date( 'Y-m-d 10:00', strtotime( current_time('mysql') ) );
        $closed = date( 'Y-m-d 18:00', strtotime( current_time('mysql') ) );

        $start  = empty( $office_time->start ) ? $start : date( 'Y-m-d h:i a', strtotime( $office_time->start ) );
        $closed = empty( $office_time->end ) ? $closed : date( 'Y-m-d h:i a', strtotime( $office_time->end ) );

        $start = strtotime( $start );
        $closed = strtotime( $closed );


        $get_presents = $this->get_presents( $employees, $attendances, $leaves );

        foreach ( $get_presents as $key => $get_present ) {
            if ( ! empty( $get_present->punch_out_date_time ) ) {
                if ( strtotime( $get_present->punch_out_date_time ) > $closed ) {
                    $data[] = $get_present;
                }
            }
        }
        
        return $data;
        
    }

    public function get_presents( $employees, $attendances, $leaves ) {
        $filter_attendances = [];
        $fileter_leaves = [];
        $filter_punch_outs = [];
        $data = [];
        $today = date('Y-m-d', strtotime( current_time( 'mysql' ) ) );
        
        foreach ( $leaves as $key => $leave ) {
            $fileter_leaves[$leave['emp_id']] = $leave;
        }

        //filter punch in
        foreach ( $attendances as $key => $attendance ) {
            $filter_attendances[$attendance->user_id][] = strtotime( $attendance->punch_in );
        }
        //filter punch in
        foreach ( $filter_attendances as $user_id => $filter_attendance ) {
            $filter_attendances[$user_id] = min($filter_attendance);
        }
        
        //filter punch out
        foreach ( $attendances as $key => $attendance ) {
            $punch_out = date( 'Y-m-d', strtotime( $attendance->punch_out ) );
            if ( $punch_out == $today ) {
                $filter_punch_outs[$attendance->user_id][] = strtotime( $attendance->punch_out );
            }
        }

        //filter punch out
        foreach ( $filter_punch_outs as $user_id => $filter_punch_out ) {
            $filter_punch_outs[$user_id] = max($filter_punch_out);
        }

        foreach ( $employees as $key => $emp ) {

            $emp->data->avatar_url = get_avatar_url( $emp->ID );

            if ( array_key_exists( $emp->ID, $fileter_leaves )  ) {
                $emp->data->leave = $fileter_leaves[$emp->ID];
            }

            if ( array_key_exists( $emp->ID, $filter_attendances ) ) {
                $emp->data->punch_in_time = date( 'h:i:s a', $filter_attendances[$emp->ID] );
                $emp->data->punch_in_date_time = date( 'Y-m-d h:i:s a', $filter_attendances[$emp->ID] );
            }

            if ( array_key_exists( $emp->ID, $filter_punch_outs ) ) {
                $emp->data->punch_out_time = date( 'h:i:s a', $filter_punch_outs[$emp->ID] );
                $emp->data->punch_out_date_time = date( 'Y-m-d h:i:s a', $filter_punch_outs[$emp->ID] );
            }

            if ( $emp->data->punch_in_time ) {
                $data[] = $emp->data;
            }
        }

        return $data;
    }

    public function get_absents( $employees, $attendances, $leaves ) {
        $filter_attendances = [];
        $fileter_leaves = [];
        $data = [];
        
        foreach ( $leaves as $key => $leave ) {
            $fileter_leaves[$leave['emp_id']] = $leave;
        }

        foreach ( $attendances as $key => $attendance ) {
            $filter_attendances[$attendance->user_id][] = strtotime( $attendance->punch_in );
        }

        foreach ( $filter_attendances as $user_id => $filter_attendance ) {
            $filter_attendances[$user_id] = date( 'h:i:s a', min($filter_attendance) );
        }

        foreach ( $employees as $key => $emp ) {
            if ( array_key_exists( $emp->ID, $fileter_leaves )  ) {
                $emp->data->leave = $fileter_leaves[$emp->ID];
            }

            if ( ! array_key_exists( $emp->ID, $filter_attendances ) ) {
                $data[] = $emp->data;
            }
        }
        
        return $data;
    }

    public static function attendance_init() {
        check_ajax_referer('hrm_nonce');
        
        $punch_in    = self::getInstance()->punch_in_status();
        $office_time = self::getInstance()->get_office_time();
        
        $office_start_with_date  = date( 'Y-m-d 10:00', strtotime( current_time('mysql') ) );
        $office_closed_with_date = date( 'Y-m-d 18:00', strtotime( current_time('mysql') ) );

        // Attendance default configuration saved
        if ( empty( $office_time ) ) {
            $args = array(
                'hrm_is_multi_attendance' => false,
                'office_start'            => $office_start_with_date,
                'office_closed'           => $office_closed_with_date
            );

            self::getInstance()->update_attendance_configuration( $args );
        }

        $multi_attend            = empty( $office_time->is_multi ) ? 0 : $office_time->is_multi;
        $office_start            = empty( $office_time->start ) ? '10:00 am' : hrm_get_time( $office_time->start );
        $office_closed           = empty( $office_time->end ) ? '06:00 pm' : hrm_get_time( $office_time->end );
        $office_start_with_date  = empty( $office_time->start ) ? $office_start_with_date : date( 'Y-m-d h:i a', strtotime( $office_time->start ) );
        $office_closed_with_date = empty( $office_time->end ) ? $office_closed_with_date : date( 'Y-m-d h:i a', strtotime( $office_time->end ) );


        wp_send_json_success(array(
            'punch_in'                     => $punch_in,
            'punch_in_date'                => date( 'Y-m-d', strtotime( date( 'Y-m-01' ) ) ),
            'punch_out_date'               => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
            'punch_in_formated_date'       => hrm_get_date( date( 'Y-m-d', strtotime( date( 'Y-m-01' ) ) ) ),
            'punch_out_formated_date'      => hrm_get_date( date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ) ),
            'search_user_id'               => get_current_user_id(),
            'hrm_is_multi_attendance'      => $multi_attend,
            'office_start'                 => $office_start,
            'office_closed'                => $office_closed,
            'office_start_with_date_time'  => $office_start_with_date,
            'office_closed_with_date_time' => $office_closed_with_date,
            'allow_ip'                     => self::getInstance()->process_ip( $office_time->ip ),
            'employees_dropdown'           => Hrm_Employeelist::getInstance()->get_employee_drop_down()
        ));
    }

    function process_ip( $ip ) {
        $ip = maybe_unserialize( $ip );
        $ip = implode( '|', $ip );

        return $ip;
    }

    function get_office_time() {
        global $wpdb;
        $table    = $wpdb->prefix . 'hrm_office_time';
        $office_time = $wpdb->get_row( "SELECT * FROM {$table} WHERE 1=1 ORDER BY id DESC LIMIT 1" );
        
        return $office_time;
    }

    function punch_in_status( $user_id = false ) {
        $current_time    = date( 'Y-m-d 00:00:00', strtotime( current_time( 'mysql' ) ) );
        $user_id         = $user_id ? absint( $user_id ) : get_current_user_id();
        $punch_in_status = 'enable';

        global $wpdb;
        $table = $wpdb->prefix . 'hrm_attendance';

        $punch = $wpdb->get_row( "SELECT * FROM $table WHERE `date` >= '$current_time' AND `user_id` = $user_id ORDER BY id DESC LIMIT 1" );
        
        $punch_in  = isset( $punch->punch_in ) ? $punch->punch_in : 0;
        $punch_out = isset( $punch->punch_out ) ? $punch->punch_out : 0;
        
        if ( $punch_in > $punch_out ) {
            $punch_in_status = 'disable';
        }

        // if multi attendance is enable
        if ( $punch_in_status == 'enable' && !empty( $punch ) ) {
            $is_multi_attendance = $this->is_multi_attendance();
            $punch_in_status     = $is_multi_attendance ? 'enable' : 'disable';
        }

        return $punch_in_status;
    }

    function office_start() {
        global $wpdb;
        $table    = $wpdb->prefix . 'hrm_office_time';
        $start = $wpdb->get_var( "SELECT `start` FROM {$table} WHERE 1=1 ORDER BY id DESC LIMIT 1" );
        
        return $start;
    }

    function office_closed() {
        global $wpdb;
        $table    = $wpdb->prefix . 'hrm_office_time';
        $end = $wpdb->get_var( "SELECT `end` FROM {$table} WHERE 1=1 ORDER BY id DESC LIMIT 1" );
        
        return $end;
    }

    function get_config_last_id() {
        global $wpdb;
        $table  = $wpdb->prefix . 'hrm_office_time';
        $id = $wpdb->get_var( "SELECT `id` FROM {$table} WHERE 1=1 ORDER BY id DESC LIMIT 1" );
        
        return $id;
    }

    function is_multi_attendance() {
        global $wpdb;
        $table    = $wpdb->prefix . 'hrm_office_time';
        $is_multi = $wpdb->get_var( "SELECT `is_multi` FROM {$table} WHERE 1=1 ORDER BY id DESC LIMIT 1" );
        
        return $is_multi;
    }

    public static function ajax_punch_in() {
        check_ajax_referer('hrm_nonce');
        
        $punch_id = self::getInstance()->punch_in();

        if ( is_wp_error( $punch_id ) ) {
            wp_send_json_error( array( 'error' => $punch_id->get_error_messages() ) );
        }

        $attendance = self::getInstance()->get_attendance();
        
        wp_send_json_success( array(
            'success'         => __( 'Attendance has been save successfully', 'hrm' ),
            'attendance'      => $attendance,
            'punch_id'        => $punch_id,
            'punch_in_status' => self::getInstance()->punch_in_status(),
            'total_time'      => self::getInstance()->count_office_time( $attendance )
        ) );
    }

    function punch_validator() {
        $office_time = $this->get_office_time();
        $ip          = maybe_unserialize( $office_time->ip );
        $client_ip   = hrm_get_client_ip();

        if ( empty( $ip ) ) {
            return true;
        }

        if ( in_array( $client_ip, $ip ) ) {
            return true;
        }

        return new WP_Error('ip_not_match', __( 'Your ip is not allowed', 'hrm' ) );
    }


    function punch_in( $user_id = false ) {
        $validator = $this->punch_validator();

        if ( is_wp_error( $validator ) ) {
            return $validator;
        }

        $punch_in_status = $this->punch_in_status();
        
        if ( $punch_in_status == 'disable' ) {
            return new WP_Error('punch_in_disabled', __( 'You have punch in before punch out', 'hrm' ) );
        }

        global $wpdb;

        $user_id = $user_id ? absint( $user_id ) : get_current_user_id();
        $table    = $wpdb->prefix . 'hrm_attendance';
        $data    = array(
            'user_id'   => $user_id,
            'date'      => current_time( 'mysql' ),
            'punch_in'  => current_time( 'mysql' ),
            'config_id' => $this->get_config_last_id()
        );
        $format = array( '%d', '%s', '%s' );

        $insert = $wpdb->insert( $table, $data, $format );

        if ( $insert ) {
            return $wpdb->insert_id;
        }

        return new WP_Error('punch_in_disabled', __( 'Unknonw error', 'hrm' ) );

    }

    public static function ajax_punch_out() {
        check_ajax_referer('hrm_nonce');

        $update = self::getInstance()->punch_out();

        if ( is_wp_error( $update ) ) {
            wp_send_json_error( array( 'error' => $update->get_error_messages() ) );
        }
        
        $attendance = self::getInstance()->get_attendance();

        wp_send_json_success( array(
            'success'         => __( 'Attendance has been updated successfully', 'hrm' ),
            'attendance'      => $attendance,
            'punch_in_status' => self::getInstance()->punch_in_status(),
            'total_time'      => self::getInstance()->count_office_time( $attendance )
        ) );
    }

    function punch_out( $punch_id = false, $user_id = false ) {
        $validator = $this->punch_validator();

        if ( is_wp_error( $validator ) ) {
            return $validator;
        }

        global $wpdb;
        
        $user_id    = $user_id ? absint( $user_id ) : get_current_user_id();
        $punch_out  = current_time( 'mysql' );
        $today_date = date( 'Y-m-d 00:00:00', strtotime( current_time( 'mysql' ) ) );
        $table      = $wpdb->prefix . 'hrm_attendance';

        //Get last row for current date according with user id
        $punch_in_row = $wpdb->get_row( "SELECT * FROM $table WHERE date >= '$today_date' AND user_id = $user_id ORDER BY id DESC LIMIT 1" );

        if ( ! $punch_in_row ) {
            return new WP_Error( 'error', __( 'Error occured', 'hrm' ) );
        }

        $punch_in   = $punch_in_row->punch_in;
        $punch_id   = absint( $punch_id ) ? $punch_id : $punch_in_row->id;
        $total_time = strtotime( $punch_out ) - strtotime( $punch_in );
        $total_time = ( $total_time <= 0 ) ? 0 : $total_time;

        $data = array(
            'punch_out' => current_time( 'mysql' ),
            'total'     => $total_time,
        );

        $where = array(
            'id' => $punch_id
        );

        $data_format  = array( '%s', '%d' );
        $where_format = array( '%d' );

        $update = $wpdb->update( $table, $data, $where, $data_format, $where_format );

        if ( $update ) {
            return true;
        }

        return new WP_Error( 'error', __( 'Error occured', 'hrm' ) );
    }

    public static function ajax_get_attendance() {
        check_ajax_referer('hrm_nonce');

        $args = array();
        
        if ( ! empty( $_POST['search'] ) ) {
            $postdata = $_POST['search'];

            if ( ! empty( $postdata['punch_in'] ) && hrm_validateDate( $postdata['punch_in'], 'Y-m-d' ) ) {
                $args['punch_in'] = $postdata['punch_in'] .' '. '00:00:00'; 
            }

            if ( ! empty( $postdata['punch_out'] ) && hrm_validateDate( $postdata['punch_out'], 'Y-m-d' ) ) {
                $args['punch_out'] = $postdata['punch_out'] .' '. '24:59:59'; 
            }

            if ( ! empty( $postdata['user_id'] ) && intval( $postdata['user_id'] ) > 0 ) {
                $args['user_id'] = $postdata['user_id']; 
            }
        }

        $attendance = self::getInstance()->get_attendance( $args );
        
        if ( ! empty( $_POST['search'] ) ) {
            wp_send_json_success( array(
                'attendance'              => $attendance,
                'punch_in_formated_date'  => hrm_get_date( $args['punch_in'] ),
                'punch_out_formated_date' => hrm_get_date( $postdata['punch_out'] ),
                'punch_in_date'           => $postdata['punch_in'],
                'punch_out_date'          => $postdata['punch_out'],
                'total_time'              => self::getInstance()->count_office_time( $attendance )
            ) );
        }

        wp_send_json_success( array(
            'attendance' => $attendance,
            'total_time' => self::getInstance()->count_office_time($attendance)
        ) );
    }

    function get_attendance_total( $args = array() ) {
        
        global $wpdb;

        $defaults = array(
            'user_id'   => get_current_user_id(),
            'punch_in'  => date( 'Y-m-d', strtotime( date( 'Y-m-01' ) ) ),
            'punch_out' => date( 'Y-m-d 24:59:59', strtotime( current_time( 'mysql' ) ) )
        );

        $args = wp_parse_args( $args, $defaults );

        $cache_key  = 'hrm-get-attendance-total' . md5( serialize( $args ) );
        $items      = wp_cache_get( $cache_key, 'erp' );
        $query_args = array( 'relation' => 'AND' );
     
        if ( false === $items ) {
            $items = $this->generate_query( $args );

            foreach ( $args as $key => $arg ) {
                switch ( $key ) {
                    case 'user_id':
                        $query_args[] = array(
                            'field'     => 'user_id',
                            'value'     => $arg,
                            'condition' => '='
                        );
                        break;

                    case 'punch_in':
                        $query_args[] = array(
                            'field'     => 'date',
                            'value'     => $arg,
                            'condition' => '>='
                        );
                        break;

                    case 'punch_out':
                        $query_args[] = array(
                            'field'     => 'date',
                            'value'     => $arg,
                            'condition' => '<='
                        );
                        break;
                }
            }

            $query = $this->generate_query( $query_args );
            $table = $wpdb->prefix . 'hrm_attendance';

            $items = $wpdb->get_var( "SELECT SUM(total) FROM {$table} WHERE 1=1 AND $query" );
            
            if ( $items ) {
                $items = $this->get_attendance_meta( $items );
                wp_cache_set( $cache_key, $items, 'hrm' );
            }
        }        
        
        return $items;
    }

    function count_office_time( $attendance ) {
        $total_time = 0;
        foreach ( $attendance as $key => $value ) {
            $total_time = $value->row_total + $total_time;
        }

        $total  = hrm_second_to_time( $total_time );
        $time   = $total['hour'] .':'. $total['minute'] .':'. $total['second'];

        return $time;
    }

    function get_attendance_meta( $attendance ) {

        foreach ( $attendance as $key => $attend ) {
            $attend->date      = hrm_get_date( $attend->date );
            $attend->punch_in  = hrm_get_date_time( $attend->punch_in, 'Y-m-d h:i:s a' );
            $attend->punch_out = ( strtotime( $attend->punch_out ) > 0 )  ? hrm_get_date_time( $attend->punch_out, 'Y-m-d h:i:s a' ) : '&#8211 &#8211';
            
            
            if ( strtotime( $attend->punch_out ) > 0 ) {
                $attend->row_total = $attend->total;
                $total             = hrm_second_to_time( $attend->total );
                $attend->total     = $total['hour'] .':'. $total['minute'] .':'. $total['second'];
                
            } else {
                $attend->total = '&#8211 &#8211';
            }
                
        }

        return $attendance;
    }   

    function get_attendance_summery( $args = array() ) {
        $defaults = array(
            'user_id'   => empty( $args['user_id'] ) 
                ? get_current_user_id() 
                : $args['user_id'],
            
            'punch_in'  => empty( $args['start_date'] ) 
                ? date( 'Y-m-d', strtotime( date( 'Y-m-01' ) ) ) 
                : $args['start_date'],

            'punch_out' => empty( $args['end_date'] ) 
                ? date( 'Y-m-d 24:59:59', strtotime( current_time( 'mysql' ) ) ) 
                : $args['end_date']
        );

        $attendance = $this->get_attendance( $defaults );
    }

    function get_attendance( $args = array() ) {
        
        global $wpdb;

        $defaults = array(
            'user_id'   => get_current_user_id(),
            'punch_in'  => date( 'Y-m-d', strtotime( date( 'Y-m-01' ) ) ),
            'punch_out' => date( 'Y-m-d 24:59:59', strtotime( current_time( 'mysql' ) ) )
        );

        if ( 
            ! empty( $args['user_id'] ) 
                &&
            $args['user_id'] === 'all'
        ) {
            unset( $defaults['user_id'] );
            unset( $args['user_id'] );
        }

        $args = wp_parse_args( $args, $defaults );

        if ( $args['punch_in'] > $args['punch_out'] ) {
            return false;
        }

        $cache_key  = 'hrm-get-attendance' . md5( serialize( $args ) );
        $items      = wp_cache_get( $cache_key, 'erp' );
        $query_args = array( 'relation' => 'AND' );
     
        if ( false === $items ) {
            $items = $this->generate_query( $args );

            foreach ( $args as $key => $arg ) {
                switch ( $key ) {
                    case 'user_id':
                        $query_args[] = array(
                            'field'     => 'user_id',
                            'value'     => $arg,
                            'condition' => '='
                        );
                        break;

                    case 'punch_in':
                        $query_args[] = array(
                            'field'     => 'punch_in',
                            'value'     => $arg,
                            'condition' => '>='
                        );
                        break;

                    case 'punch_out':
                        $query_args[] = array(
                            'field'     => 'punch_out',
                            'value'     => $arg,
                            'condition' => '<='
                        );
                        break;
                }
            }

            $query = $this->generate_query( $query_args );
            $table = $wpdb->prefix . 'hrm_attendance';

            $items = $wpdb->get_results( "SELECT * FROM {$table} WHERE 1=1 AND $query" );
            
            if ( $items ) {
                $items = $this->get_attendance_meta( $items );
                wp_cache_set( $cache_key, $items, 'hrm' );
            }
        }        
        
        return $items;
    }


    function data_formating( $args ) {
        if ( !empty( $args['field'] ) && !empty( $args['value'] ) && !empty( $args['condition'] ) ) {
            $args[] = array(
                'field'     => $args['field'],
                'value'     => $args['value'],
                'condition' => $args['condition']
            );

            $args['id'] = $this->generate_unique_id();
            unset( $args['field'], $args['value'], $args['condition'] );
        }

        return $args;
    }

    function data_formating2( $args ) {
        $format_data = array();

        foreach ( $args as $key => $value) {
            if ( is_array( $value ) ) {
                continue;
            }

            $format_data[$key] = $value;

            unset( $args[$key] );
        }

        if ( $format_data ) {
            $args[] = $format_data;
        }

        return $args;
    }

    function build_query( $args, $query = '' ) {
        foreach ( $args as $key => $element ) {

            if ( ! is_array( $element ) || empty( $element['query'] ) ) {
                continue;
            }

            if ( empty ( $element['parent_id'] ) && ! empty( $query ) ) {
                $query .= ' ' . $this->relation .' ';
            }

            if ( $this->has_children( $element, $key ) ) {
                $query .= '(';
            }
            
            $query .= $element['query'];

            if ( $element['parent_id'] && !$this->has_children( $element, $key ) ) {
                $depth = $element['depth'] - 1;
                $query .= str_repeat( ')', $depth );
            }

            $parent_relation  = isset( $element['relation'] ) ? $element['relation'] : 'AND';

            if ( $this->has_children( $element, $key ) ) { 
                $query .= ' ' . $parent_relation .' ';

                $query =  $this->build_query( $element, $query );
            } 
                       
        }

        return $query;
    }

    function generate_query( $args ) {
    
        $this->relation = empty( $args['relation'] ) ? $this->relation : $args['relation'];
        $args           = $this->data_formating( $args );
        $parent_id      = empty( $args['id'] ) ? false : $args['id'];
        $args           = $this->condition_make_micro_query( $args, $parent_id );
        $args           = $this->condition_make_micro_query2( $args );
        $args           = $this->condition_make_micro_query3( $args, $parent_id );
        $args           = $this->build_query( $args );

        return '( ' . $args . ')';

    }

    function get_without_array_ele( $ele, $key ) {
        
        if ( ! is_array( $ele ) ) {
            return $ele;
        }
    }

    function get_integer_array( $ele, $key ) {
        
        if ( is_int( $key ) && ! is_array( $ele ) ) {
            return $ele;
        }
    }


    //Only root query filter
    function condition_make_micro_query3( $args ) {
        $root_el = array();
        $relation = $this->relation;
        foreach ( $args as $key => $element ) {
            if ( is_int( $key ) && !is_array( $element ) ) {
                $root_el[] = $element;
            }
        }

        if ( ! $root_el ) {
            return $args;
        }

        $condition['parent_id'] = false;
        $condition['relation']  = $relation;

        if ( count( $root_el ) > 1 ) {
            $condition['query']     = '( '. implode( ' '. $relation .' ', $root_el ) .' )';
        } else {
            $condition['query']     = implode( '', $root_el );
        }

        array_unshift( $args, $condition );
        return $args;
    }

    function condition_make_micro_query2( $array, $depth = 0 ) {

        foreach ( $array as $key => $element ) {

            if ( ! is_array( $element ) ) {
                continue;
            }
            
            $array['depth'] = $depth;
            
            if ( $this->has_children( $element, $key ) ) { 

                $depth               = $depth + 1;
                $array[$key]         = $this->condition_make_micro_query2( $element, $depth );
                $array[$key]['depth'] = $depth;
                $depth               = 0;
                
            } else {
                $array[$key]['depth'] = $depth+1;
            }
                
            $relation  = isset( $element['relation'] ) ? $element['relation'] : 'AND';
            $condition = array_filter( $element, array( $this, 'get_integer_array' ), ARRAY_FILTER_USE_BOTH );
            
            if ( count( $condition ) > 1 ) {
                $query = '( ' . implode( ' '. $relation .' ',  $condition ) . ' )';
                $array[$key]['query'] = $query;
            } else {
                $query = implode( '',  $condition );
                $array[$key]['query'] = $query;
            }
            
        }

        return $array;
        
    }


    function condition_make_micro_query( $args, $parent_id = false ) {

        foreach ( $args as $key => $element ) {
            if ( ! is_array( $element )  ) {
                continue;
            }

            $has_childer = $this->has_children( $element, $key );
            
            if ( $has_childer ) {
                
                $id                      = $this->generate_unique_id();
                $args[$key]              = $this->condition_make_micro_query( $element, $id );
                $args[$key]['id']        = $id;
                $args[$key]['parent_id'] = $parent_id;

            } else  {
                $args[$key] =  "`". $element['field'] ."` ". $element['condition'] ." '". $element['value'] ."'";
                $depth = 0;

            }
        }

        return $args;
    }

    function has_children( $elements, $array_key ) {
        $has_childer = false;

        if ( ! is_int( $array_key ) ) {
            return $has_childer;
        }

        foreach ( $elements as $key => $element ) {
            if (  is_array( $element ) ) {
                $has_childer = true;
            }
        }

        return $has_childer;
    }

    function generate_unique_id() {
        $id = $this->unique_id( 6 );

        if ( in_array( $id, $this->unique_ids ) ) {
            $this->generate_unique_id();
        }

        $this->unique_ids[] = $id;

        return $id;
    }

    function unique_id( $length ) {
        $token = "";
        //$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet = "0123456789";
        $max = strlen( $codeAlphabet ); // edited

        for ( $i=0; $i < $length; $i++ ) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }

        return $token;
    }

    function update_attendance_configuration( $postdata ) {
        
        global $wpdb;

        $table  = $wpdb->prefix . 'hrm_office_time';
        $closed = $postdata['office_closed'];

        if ( empty( $postdata['office_start'] ) ) {
            return new WP_Error( 'office_start', __( 'Required office start time', 'hrm' ) );
        }

        if ( ! hrm_validateDate( $postdata['office_start'], 'Y-m-d H:i' ) ) {
            return new WP_Error( 'office_start', __( 'Invalid office start time', 'hrm' ) );
        }

        if ( empty( $closed ) ) {
            $closed = current_time( 'mysql' );
        }

        if ( ! hrm_validateDate( $closed, 'Y-m-d H:i' ) ) {
            $closed = current_time( 'mysql' );
        }

        if ( 
            isset( $postdata['hrm_is_multi_attendance'] ) 
            &&
            ( 
                $postdata['hrm_is_multi_attendance'] == 'true' 
                || 
                $postdata['hrm_is_multi_attendance'] == 1 
            )
        ) {
            
            $is_multi = 1;
        } else {
            $is_multi = 0;
        }

        $ip       = $postdata['allow_ip'];
        $string   = str_replace(' ', '', $ip);
        $allow_ip = explode('|', $string);
        $allow_ip = array_filter( $allow_ip, function( $ip ) {
            return filter_var($ip, FILTER_VALIDATE_IP);
        } );

        $data = array(
            'start'    => date( 'Y-m-d H:i:s', strtotime( $postdata['office_start'] ) ),
            'end'      => date( 'Y-m-d H:i:s', strtotime( $closed ) ),
            'is_multi' => $is_multi,
            'ip'       => maybe_serialize( $allow_ip )
        );


        $format = array( '%s', '%s', '%d', '%s' );
        $update = $wpdb->insert( $table, $data, $format );

        if ( $update ) {
            return $wpdb->insert_id;
        }

        return new WP_Error( 'office_start', __( 'Unknown error!', 'hrm' ) );

    }

    public static function ajax_attendance_configuration() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $configuration = Hrm_Attendance::getInstance()->update_attendance_configuration( $postdata );
        
        if ( is_wp_error( $configuration ) ) {
            wp_send_json_error( array( 'error' => $configuration->get_error_messages() ) );
        }

        wp_send_json_success(array(
            'success'  => __( 'Successfully update attendance configuration', 'hrm' ),
            'start'    => $postdata['office_start'],
            'end'      => $postdata['closed'],
            'is_multi' => $postdata['closed'],
        ));
    }
}

