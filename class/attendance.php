<?php
class Hrm_Attendance {
    private static $_instance;

    public static function getInstance() {
        if ( ! self::$_instance ) {
            self::$_instance = new Hrm_Attendance();
        }

        return self::$_instance;
    }

    function __construct() {

    }

    public static function attendance_init() {
        check_ajax_referer('hrm_nonce');
        
        $punch_in = self::getInstance()->punch_in_status();
        
        wp_send_json_success(array(
            'punch_in' => $punch_in
        ));
    }

    function punch_in_status( $user_id = false ) {
        $current_time    = date( 'Y-m-d 00:00:00', strtotime( current_time( 'mysql' ) ) );
        $user_id         = $user_id ? absint( $user_id ) : get_current_user_id();
        $punch_in_status = 'enable';

        global $wpdb;
        $table = $wpdb->prefix . 'hrm_attendance';

        $punch     = $wpdb->get_row( "SELECT * FROM $table WHERE date >= '$current_time' AND user_id = $user_id ORDER BY id DESC LIMIT 1" );
        $punch_in  = isset( $punch->punch_in ) ? $punch->punch_in : 0;
        $punch_out = isset( $punch->punch_out ) ? $punch->punch_out : 0;
        
        if ( $punch_in > $punch_out ) {
            $punch_in_status = 'disable';
        }

        // if multi attendance is enable
        if ( $punch_in_status == 'enable' && !empty( $punch ) ) {
            $is_multi_attendance = $this->is_multi_attendance();
            $punch_in_status = $is_multi_attendance ? 'enable' : 'disable';
        }

        return $punch_in_status;
    }

    function is_multi_attendance() {
        $is_multi_attendance = get_option( 'hrm_is_multi_attendance', false );
        return $is_multi_attendance;
    }

    public static function ajax_punch_in() {
        check_ajax_referer('hrm_nonce');
        
        $punch_id = self::getInstance()->punch_in();

        if ( ! $punch_id ) {
            wp_send_json_error( array( 'error' => array( __( 'Something is wrong!', 'hrm' ) ) ) );
        }
        
        wp_send_json_success( array(
            'success'         => __( 'Attendance has been save successfully', 'hrm' ),
            'punch_id'        => $punch_id,
            'punch_in_status' => self::getInstance()->punch_in_status()
        ) );
    }


    function punch_in( $user_id = false ) {
        $punch_in_status = $this->punch_in_status();
        
        if ( $punch_in_status == 'disable' ) {
            return false;
        }

        global $wpdb;

        $user_id = $user_id ? absint( $user_id ) : get_current_user_id();
        $table    = $wpdb->prefix . 'hrm_attendance';
        $data    = array(
            'user_id'  => $user_id,
            'date'     => current_time( 'mysql' ),
            'punch_in' => current_time( 'mysql' ),
        );
        $format = array( '%d', '%s', '%s' );

        $insert = $wpdb->insert( $table, $data, $format );

        if ( $insert ) {
            return $wpdb->insert_id;
        }

        return false;

    }

    public static function ajax_punch_out() {
        check_ajax_referer('hrm_nonce');

        $update = self::getInstance()->punch_out();

        if ( ! $update ) {
            wp_send_json_error( array( 'error' => array( __( 'Something is wrong!', 'hrm' ) ) ) );
        }
        
        wp_send_json_success( array(
            'success'         => __( 'Attendance has been updated successfully', 'hrm' ),
            'punch_in_status' => self::getInstance()->punch_in_status()
        ) );
    }

    function punch_out( $punch_id = false, $user_id = false ) {
        global $wpdb;
        
        $user_id    = $user_id ? absint( $user_id ) : get_current_user_id();
        $punch_out  = current_time( 'mysql' );
        $today_date = date( 'Y-m-d 00:00:00', strtotime( current_time( 'mysql' ) ) );
        $table      = $wpdb->prefix . 'hrm_attendance';

        //Get last row for current date according with user id
        $punch_in_row = $wpdb->get_row( "SELECT * FROM $table WHERE date >= '$today_date' AND user_id = $user_id ORDER BY id DESC LIMIT 1" );

        if ( ! $punch_in_row ) {
            return false;
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

        return false;
    }


}