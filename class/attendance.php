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



    function get_attendance( $table_name, $args = array() ) {
        
        global $wpdb;

        $table_name = $wpdb->prefix . $table_name;

        $args = array(
                    'relation' => 'OR',
                    array(
                        'field'     => 'toma',
                        'value'     => 6,
                        'condition' => '='
                    ),
                    array(
                        'field'     => 'kuenai',
                        'value'     => 6,
                        'condition' => '='
                    ),

                    array(
                        'relation' => 'AND',
                        array(
                            'field'     => 'shipon',
                            'value'     => 6,
                            'condition' => '='
                        ),
                        // array(
                        //     'field'     => 'kharuj',
                        //     'value'     => 6,
                        //     'condition' => '='
                        // ),

                        array(
                            'relation' => 'OR',
                            array(
                                'field'     => 'rode',
                                'value'     => 6,
                                'condition' => '='
                            ),
                            // array(
                            //     'field'     => 'brider',
                            //     'value'     => 6,
                            //     'condition' => '='
                            // ),


                            array(
                                'relation' => 'AND',
                                array(
                                    'field'     => 'radio',
                                    'value'     => 6,
                                    'condition' => '='
                                ),
                                // array(
                                //     'field'     => 'brider',
                                //     'value'     => 6,
                                //     'condition' => '='
                                // )
                            )
                        )
                    ),

                    array(
                        'relation' => 'AND',
                        array(
                            'field'     => 'kjhkjhkj',
                            'value'     => 6,
                            'condition' => '='
                        ),
                        array(
                            'field'     => 'hkjhjh',
                            'value'     => 6,
                            'condition' => '='
                        )
                    )
                );
            
            
        $ll = $this->generate_query( $args );
        
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

            if ( empty( $element['parent_id'] ) && !empty( $query ) ) {
                $query .= $this->relation;
            }

            if ( $this->has_children( $element, $key ) ) {
                $query .= '(';
            }
            
            $query .= $element['query'];

            if ( $element['parent_id'] && !$this->has_children( $element, $key ) ) {
                $query .= ')';
            }

            $parent_relation  = isset( $element['relation'] ) ? $element['relation'] : 'AND';

            if ( $this->has_children( $element, $key ) ) { 
                $query .= $parent_relation;

                $query =  $this->build_query( $element, $query );
            } 
                       
        }

        return $query;
    }


    function generate_query( $args ) {
        $this->relation = empty( $args['relation'] ) ? $this->relation : $args['relation'];
        $args = $this->data_formating( $args );
        //echo '<pre>'; print_r( $args ); echo '</pre>';
        $parent_id = empty( $args['id'] ) ? false : $args['id'];
        $args = $this->condition_make_micro_query( $args, $parent_id );
        //echo '<pre>'; print_r( $args ); echo '</pre>'; 
        $args = $this->condition_make_micro_query2( $args );
        //echo '<pre>'; print_r( $args ); echo '</pre>'; 
        $args = $this->condition_make_micro_query3( $args, $parent_id );
        //echo '<pre>'; print_r( $args ); echo '</pre>'; 

        $args = $this->build_query( $args );

        //echo $args;

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


    function condition_make_micro_query3( $args ) {
        $root_el = array();
        $relation = $this->relation;
        foreach ( $args as $key => $element ) {
            if ( is_int( $key ) && !is_array( $element ) ) {
                $root_el[] = $element;
            }
        }
        $condition['parent_id'] = false;
        $condition['relation'] = $relation;
        $condition['query'] = '( '. implode( ' '. $relation .' ', $root_el ) .' )';
        array_unshift( $args, $condition );
        return $args;
    }

    function condition_make_micro_query2( $array ) {

        foreach ( $array as $key => $element ) {

            if ( ! is_array( $element ) ) {
                continue;
            }

            if ( $this->has_children( $element, $key ) ) { 

                $array[$key] = $this->condition_make_micro_query2( $element );
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


    function condition_make_micro_query( $args, $parent_id = false  ) {

        
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

