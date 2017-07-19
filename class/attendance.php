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
        $current_time = date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) );
        $user_id      = $user_id ? absint( $user_id ) : get_current_user_id();
        $punch_id     = 'enable';

        global $wpdb;
        $table = $wpdb->prefix . 'hrm_attendance';

        $punch     = $wpdb->get_row( "SELECT * FROM $table WHERE date = '$current_time' AND user_id = $user_id" );
        $punch_in  = isset( $punch->punch_in ) ? $punch->punch_in : 0;
        $punch_out = isset( $punch->punch_out ) ? $punch->punch_out : 0;

        if ( $punch_in > $punch_out ) {
            $punch_in = 'disable';
        }

        return $punch_in;
    }

    public static function ajax_punch_in() {
        check_ajax_referer('hrm_nonce');
        
        self::getInstance()->punch_in();
        
        wp_send_json_success( array(
            'success' => __( 'Attendance has been save successfully', 'hrm' )
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

    function punch_out() {

    }


}