<?php

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


    function total_leave( $start, $end, $work_in_week, $holiday ) {
        $start = date( 'Y-m-d', strtotime( $start) );
        $end = date( 'Y-m-d', strtotime( $end) );
        if( $start > $end ) {
            return 0;
        }

        $holiday_status = count( $holiday ) ? true : false;
        $total = 0;
        while( $start <= $end ) {
            $day = strtolower( date('l', strtotime( $start ) ) );
            $start = date( 'Y-m-d', strtotime( $start ) );
            $weekend = isset( $work_in_week['data'][$day] ) ? $work_in_week['data'][$day] : '';
            if ( !in_array( $start, $holiday ) && $weekend != 'non' ) {
                $total++;
            }

            $start = date( 'Y-m-d', strtotime( $start . '+1 days') );
        }

        return $total;
    }

    function leave_take( $start, $end, $work_in_week, $holiday ) {
        $today = date( 'Y-m-d', time() );
        $start = date( 'Y-m-d', strtotime( $start) );
        $end_day = date( 'Y-m-d', strtotime( $end) );

        $holiday_status = count( $holiday ) ? true : false;

        $total = 0;
        while( $start < $today ) {

            $day = strtolower( date('l', strtotime( $start ) ) );

            $weekend = isset( $work_in_week['data'][$day] ) ? $work_in_week['data'][$day] : '';
            if ( $start <= $end_day && !in_array( $start, $holiday ) && $weekend != 'non' ) {

                $total++;
            }
            $start = date( 'Y-m-d', strtotime( $start . '+1 days') );
        }

        return $total;
    }

    function leave_remain( $start, $end, $work_in_week, $holiday ) {
        $start = date( 'Y-m-d', strtotime( $start) );
        $today = date( 'Y-m-d', time());
        $end = date( 'Y-m-d', strtotime($end) );

        if( $today > $end ) {
            return 0;
        }

        $holiday_status = count( $holiday ) ? true : false;
        $total = 0;
        if ( $start < $today ) {
            $start = $today;
        }

        while( $start <= $end ) {
            $day = strtolower( date('l', strtotime( $start ) ) );
            $start = date( 'Y-m-d', strtotime( $start ) );
            $weekend = isset( $work_in_week['data'][$day] ) ? $work_in_week['data'][$day] : '';

            if ( !in_array( $start, $holiday ) && $weekend != 'non' ) {
                $total++;
            }
            $start = date( 'Y-m-d', strtotime( $start . '+1 days') );
        }

        return $total;
    }

    function leave_type_form( $field_value = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_value !== null ) {
            $leave_hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }
        //hidden form
        $leave_hidden_form['leave_type'] = array(
            'label' =>  __( 'Leave Type', 'hrm' ),
            'type' => 'text',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'value' => isset( $field_value['leave_type'] ) ? $field_value['leave_type'] : '',
        );

        $leave_hidden_form['action'] = 'ajax_referer_insert';
        $leave_hidden_form['table_option'] = 'hrm_leave_type';
        $leave_hidden_form['header'] = 'Leave Type';
        $leave_hidden_form['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $leave_hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function holiday( $field_value = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_value !== null ) {
            $holiday['id'] = array(
                'type'  => 'hidden',
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }


        $holiday['name'] = array(
            'label' =>  __( 'Name', 'hrm' ),
            'type'  => 'text',
            'value' => isset( $field_value['name'] ) ? $field_value['name'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $holiday['from'] = array(
            'label' =>  __( 'From', 'hrm' ),
            'class' => 'hrm-datepicker-from',
            'type'  => 'text',
            'value' => isset( $field_value['from'] ) ? hrm_get_date2mysql( $field_value['from'] ) : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $holiday['to'] = array(
            'label' =>  __( 'To', 'hrm' ),
            'class' => 'hrm-datepicker-to',
            'type'  => 'text',
            'value' => isset( $field_value['to'] ) ? hrm_get_date2mysql( $field_value['to'] ) : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $holiday['description'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'type'  => 'textarea',
            'value' => isset( $field_value['description'] ) ? $field_value['description'] : '',
        );

        $holiday['length'] = array(
            'label' =>  __( 'Full Day/Half Day', 'hrm' ),
            'type'  => 'select',
            'option' => array(
                'full' => 'Full Day',
                'half' => 'Half Day'
            ),
            'selected' => isset( $field_value['length'] ) ? $field_value['length'] : '',
        );

        $holiday['action']       = 'ajax_referer_insert';
        $holiday['table_option'] = 'hrm_holiday';
        $holiday['header']       = 'Add Holiday';
        $holiday['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $holiday );
        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function new_leave( $post = null ) {

        global $wpdb;
        $update = false;
        $table_name = $wpdb->prefix. 'hrm_leave';
        $post_name = isset( $post['name'] ) ? $post['name'] : array();
        foreach ( $post_name as $key => $user_id ) {
            $args = array(
                'emp_id'         => $user_id,
                'leave_type_id'  => $post['type_id'],
                'start_time'     => hrm_date2mysql( $post['from'] ),
                'end_time'       => hrm_date2mysql( $post['to'] ),
                'leave_comments' => $post['comment'],
                'leave_status'   => 1
            );

            $format = array( '%d', '%d', '%s', '%s', '%s' );

            if( isset( $post['id'] ) && !empty( $post['id']  ) ) {
                $where = array( 'id' => $post['id'] );
                $update = $wpdb->update( $table_name, $args, $where, $format );
            } else {
                $update = $wpdb->insert( $table_name, $args, $format );
            }

        }

        if ( $update ) {
            return true;
        } else {
            return false;
        }
    }

    function assign( $field_value = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        $user_id = isset( $_POST['selfData']['user_id'] ) && !empty( $_POST['selfData']['user_id'] ) ? trim( $_POST['selfData']['user_id'] ) : false;
        $from_pim = isset( $_POST['hrm_dataAttr']['user_id'] ) && !empty( $_POST['hrm_dataAttr']['user_id'] ) ? trim( $_POST['hrm_dataAttr']['user_id'] ) : false;

        if ( $user_id || $from_pim ) {
            $field['name[]'] = array(
                'type'   => 'hidden',
                'value'  => $user_id ? $user_id : $from_pim

            );
        } else {
            $field['name[]'] = array(
                'label'  => __( 'Employee Name', 'hrm' ),
                'required' => 'required',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                ),
                'class'  => 'hrm-chosen',
                'type'   => 'multiple',
                'option' => json_decode( stripcslashes( $_POST['hrm_dataAttr']['user_info'] ) ),

            );
        }

        if ( $field_value !== null ) {

            $field['id'] = array(
                'type'  => 'hidden',
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }

        $field['type_id'] = array(
            'label'    => __( 'Leave Type', 'hrm' ),
            'type'     => 'select',
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'option'   => json_decode( stripcslashes( $_POST['hrm_dataAttr']['leave_cat'] ) ),
            'selected' => isset( $field_value['type_id'] ) ? $field_value['type_id'] : ''

        );
        $field['from'] = array(
            'label' => __( 'From Date', 'hrm' ),
            'class' => 'hrm-datepicker-leave-from',
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'type'  => 'text',
            'value' => isset( $field_value['from'] ) ? hrm_get_date2mysql( $field_value['from'] ) : ''
        );

        $field['to'] = array(
            'label' => __( 'To Date', 'hrm' ),
            'class' => 'hrm-datepicker-leave-to',
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'type'  => 'text',
            'value' => isset( $field_value['to'] ) ? hrm_get_date2mysql( $field_value['to'] ) : ''
        );

        $field['comment'] = array(
            'label' => __( 'Comment', 'hrm' ),
            'type'  => 'textarea',
            'value' => isset( $field_value['comment'] ) ? $field_value['comment'] : ''
        );

        $field['header']       = __( 'Assign Leave', 'hrm' );
        $field['action']       = 'insert_leave';
        $field['table_option'] = 'hrm_leave';
        $field['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $field );

        $return_value = array(
            'append_data' => ob_get_clean()
        );

        return $return_value;
    }

    function leave_status( $status = null ) {
        $leave = array(
            ''  => __( '- Select -', 'hrm'),
            '1' => __( 'Pending', 'hrm' ),
            '2' => __( 'Approve', 'hrm' ),
            '3' => __( 'Cancel', 'hrm' ),
        );

        if ( $status == null ) {
            return $leave;
        } else {
            return $leave[$status];
        }
    }

    function leave_employer_status( $status = null ) {
        $leave = array(
            ''  => __( '- Select -', 'hrm'),
            '2' => __( 'Cancel', 'hrm' ),
        );

        if ( $status == null ) {
            return $leave;
        } else {
            return $leave[$status];
        }
    }

    function update_leave_status( $postdata ) {
        global $wpdb;

        $table  = $wpdb->prefix . 'hrm_leave';
        $data   = array( 'leave_status' => $postdata['status'] );
        $where  = array( 'id' => $postdata['leave_id'] );
        $format = array( '%d' );

        $update = $wpdb->update( $table, $data, $where, $format, $where_format = null );
        if ( $update ) {
            return $update;
        }
        return false;
    }
}

