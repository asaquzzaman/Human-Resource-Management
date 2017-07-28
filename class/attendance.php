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
        
    }

    public static function attendance_init() {
        check_ajax_referer('hrm_nonce');
        
        $punch_in = self::getInstance()->punch_in_status();
        
        wp_send_json_success(array(
            'punch_in'                => $punch_in,
            'punch_in_date'           => date( 'Y-m-d', strtotime( date( 'Y-m-01' ) ) ),
            'punch_out_date'          => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
            'punch_in_formated_date'  => hrm_get_date( date( 'Y-m-d', strtotime( date( 'Y-m-01' ) ) ) ),
            'punch_out_formated_date' => hrm_get_date( date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ) ),
            'search_user_id'          => get_current_user_id()
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
        return true; //$is_multi_attendance;
    }

    public static function ajax_punch_in() {
        check_ajax_referer('hrm_nonce');
        
        $punch_id = self::getInstance()->punch_in();

        if ( ! $punch_id ) {
            wp_send_json_error( array( 'error' => array( __( 'Something is wrong!', 'hrm' ) ) ) );
        }
        
        wp_send_json_success( array(
            'success'         => __( 'Attendance has been save successfully', 'hrm' ),
            'attendance'      => self::getInstance()->get_attendance(),
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
            'attendance'      => self::getInstance()->get_attendance(),
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

    public static function ajax_get_attendance() {
        check_ajax_referer('hrm_nonce');

        $args = array();
        
        if ( ! empty( $_POST['search'] ) ) {
            $postdata = $_POST['search'];

            if ( ! empty( $postdata['punch_in'] ) && validateDate( $postdata['punch_in'], 'Y-m-d' ) ) {
                $args['punch_in'] = $postdata['punch_in'] .' '. '00:00:00'; 
            }

            if ( ! empty( $postdata['punch_out'] ) && validateDate( $postdata['punch_out'], 'Y-m-d' ) ) {
                $args['punch_out'] = $postdata['punch_out'] .' '. '24:59:59'; 
            }

            if ( ! empty( $postdata['user_id'] ) && intval( $postdata['user_id'] ) > 0 ) {
                $args['user_id'] = $postdata['user_id']; 
            }
        }

        $attendance = self::getInstance()->get_attendance( $args );
        
        if ( ! $attendance ) {
            //wp_send_json_error( array( 'error' => array( __( 'Something is wrong!', 'hrm' ) ) ) );
        }
        
        if ( ! empty( $_POST['search'] ) ) {
            wp_send_json_success( array(
                'attendance' => $attendance,
                'punch_in_formated_date' => hrm_get_date( $args['punch_in'] ),
                'punch_out_formated_date' => hrm_get_date( $postdata['punch_out'] ),
                'punch_in_date' => $postdata['punch_in'],
                'punch_out_date' => $postdata['punch_out'] 
            ) );
        }

        wp_send_json_success( array(
            'attendance' => $attendance
        ) );
    }

    function get_attendance_meta( $attendance ) {
        foreach ( $attendance as $key => $attend ) {
            $attend->date      = hrm_get_date_time( $attend->date, false, true );
            $attend->punch_in  = hrm_get_date_time( $attend->punch_in, false, true );
            $attend->punch_out = ( strtotime( $attend->punch_out ) > 0 )  ? hrm_get_date_time( $attend->punch_out, false, true ) : '&#8211 &#8211';
            
            if ( strtotime( $attend->punch_out ) > 0 ) {
                $total = hrm_second_to_time( $attend->total );
                $attend->total = $total['hour'] .':'. $total['minute'] .':'. $total['second'];
            } else {
                $attend->total = '&#8211 &#8211';
            }
                
        }

        return $attendance;
    }   



    function get_attendance( $args = array() ) {
        
        global $wpdb;

        $defaults = array(
            'user_id'   => get_current_user_id(),
            'punch_in'  => date( 'Y-m-d', strtotime( date( 'Y-m-01' ) ) ),
            'punch_out' => date( 'Y-m-d 24:59:59', strtotime( current_time( 'mysql' ) ) )
        );

        $args       = wp_parse_args( $args, $defaults );

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

            $items = $wpdb->get_results( "SELECT * FROM {$table} WHERE 1=1 AND $query" );
            
            if ( $items ) {
                $items = $this->get_attendance_meta( $items );
            }
            
            wp_cache_set( $cache_key, $items, 'erp' );
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

    // function test($args, $depth = 0) {
    //     foreach ( $args as $key => $value) {
            
    //         if ( ! is_array( $value ) ) {
    //             continue;
    //         }
            
    //         $args['depth'] = $depth;
            
    //         if ( $this->has_children($value, $key) ) {
    //             $depth = $depth + 1;
    //             $args[$key] = $this->test( $value, $depth );
    //             $args[$key]['depth'] = $depth;
    //             $depth = 0;
    //         } else {
    //             $args[$key]['depth'] = $depth+1;
    //         }
    //     }

    //     return $args;
    // }


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
                $args[$key] =  $element['field'] ." ". $element['condition'] ." '". $element['value'] ."'";
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


}

