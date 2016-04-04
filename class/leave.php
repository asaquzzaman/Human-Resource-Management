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

        $leave_hidden_form['entitlement'] = array(
            'label' =>  __( 'Entitlement ', 'hrm' ),
            'type' => 'text',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_integer' => true,
                'data-hrm_integer_error_msg'=> __( 'Your inserted value is not integer', 'hrm' ),
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'value' => isset( $field_value['entitlement'] ) ? $field_value['entitlement'] : '',
        );

        $leave_hidden_form['entitle_from'] = array(
            'label' =>  __( 'Entitle from', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-datepicker-from',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'value' => isset( $field_value['entitle_from'] ) ? hrm_get_date2mysql( $field_value['entitle_from'] ) : '',
        );

        $leave_hidden_form['entitle_to'] = array(
            'label' =>  __( 'Entitle to', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-datepicker-to',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'value' => isset( $field_value['entitle_to'] ) ? hrm_get_date2mysql( $field_value['entitle_to'] ) : '',
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
            'class' => 'hrm-leave-discription',
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

    function is_leave_take_prev( $emp_id, $post_from, $post_to ) {
        global $wpdb;
        $table = $wpdb->prefix . 'hrm_leave';
        $result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table}
            WHERE
            emp_id = $emp_id
            AND
            ( ( start_time <= '%s' AND end_time >= '%s' )
            OR
            ( start_time <= '%s' AND end_time >= '%s' ) )
            ", $post_from, $post_from, $post_to, $post_to
        ) );

        return $result;
    }

    function count_leave_between_two_date( $start_time, $end_time ) {
        $start = strtotime( $start_time );
        $end = strtotime( $end_time );
        $days_between = intval( ($end - $start) / 86400 );
        return $days_between + 1;
    }

    function count_leave_exclude_holiday_weekend( $start, $end, $work_in_week, $holiday ) {
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

    function new_leave( $post = null ) {

        global $wpdb;
        $update       = false;
        $table_name   = $wpdb->prefix. 'hrm_leave';
        $get_duration = Hrm_Settings::getInstance()->edit_query( 'hrm_leave_type', $post['type_id'] );
        $post_from    = date( 'Y-m-d H:i:s', strtotime( $post['from'] ) );
        $post_to      = date( 'Y-m-d H:i:s', strtotime( $post['to'] ) );
        $get_from     = $get_duration['entitle_from'];
        $get_to       = $get_duration['entitle_to'];
        $user_id      = isset( $post['name'] ) ? $post['name'] : array();

        $work_in_week = get_option( 'hrm_work_week' );
        $holidays = Hrm_Settings::getInstance()->hrm_query('hrm_holiday');
        unset( $holidays['total_row'] );
        $holiday_index = array();

        foreach ( $holidays as $key => $holiday ) {
            $holiday_index = array_merge( $holiday_index, maybe_unserialize( $holiday->index_holiday ) );
        }

        if ( $get_from <= $post_from && $get_to >= $post_to ) {

            $get_apply_leave = Hrm_Settings::getInstance()->hrm_query( 'hrm_leave', $user_id );
            $leave_take_prev = $this->is_leave_take_prev( $user_id, $post_from, $post_to );

            if ( $leave_take_prev ) {
                $prev_start = $leave_take_prev->start_time;
                $prev_end = $leave_take_prev->end_time;
                return array( 'error_msg'=> __( 'Leave record found '. $prev_start . ' to ' . $prev_end . ' so please apply leave out side this range', 'hrm' ) );
            }

            $leave_take = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', '*', array( 'leave_type_id' => $post['type_id'], 'emp_id' => $user_id ) );
            $leave_count = 0;

            if ( $leave_take['total_row'] ) {
                unset( $leave_take['total_row'] );
                foreach ( $leave_take as $key => $leave ) {
                    $leave_count = $this->count_leave_exclude_holiday_weekend( $leave->start_time, $leave->end_time, $work_in_week, $holiday_index ) + $leave_count;
                }
                $apply_leave_count = $this->count_leave_exclude_holiday_weekend( $post_from, $post_to, $work_in_week, $holiday_index );

                $post['apply_leave_total'] = $apply_leave_count;
                $apply_leave_count = $apply_leave_count +  $leave_count;

                if ( $get_duration['entitlement'] < $apply_leave_count ) {
                    return array( 'error_msg'=> __( 'Unbalanced leave apply', 'hrm' ) );
                }
            } else {
                $apply_leave_count = $this->count_leave_exclude_holiday_weekend( $post_from, $post_to, $work_in_week, $holiday_index );
                $post['apply_leave_total'] = $apply_leave_count;
                if ( $get_duration['entitlement'] < $apply_leave_count ) {
                    return array( 'error_msg'=> __( 'Unbalanced leave apply', 'hrm' ) );
                }
            }
        } else {

            return array( 'error_msg'=> __( 'Please chose date form '. $get_from . ' to ' . $get_to, 'hrm' ) );
        }

        $args = array(
            'emp_id'         => $user_id,
            'leave_type_id'  => $post['type_id'],
            'start_time'     => hrm_date2mysql( $post_from ),
            'end_time'       => hrm_date2mysql( $post_to ),
            'leave_comments' => $post['comment'],
            'leave_status'   => isset( $post['leave_status'] ) ? $post['leave_status'] : 1,
        );

        $format = array( '%d', '%d', '%s', '%s', '%s' );

        if( isset( $post['id'] ) && !empty( $post['id']  ) ) {
            $where = array( 'id' => $post['id'] );
            $update = $wpdb->update( $table_name, $args, $where, $format );
        } else {
            $update = $wpdb->insert( $table_name, $args, $format );
        }

        if ( $update ) {
            $this->send_new_leave_email( $user_id, $post, $get_duration );
            return true;
        } else {
            return false;
        }
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
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $this->leave_status( $post['leave_status'] );; ?></td>
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
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $this->leave_status( $post['leave_status'] ); ?></td>
                    <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $post['apply_leave_total']; _e( ' days', 'hrm' ); ?></td>
                </tr>
                </table>
            </div>
        <?php
        return ob_get_clean();
    }

    function individula_apply_leave( $field_value = null ) {

        $from_pim = isset( $_POST['hrm_dataAttr']['user_id'] ) && !empty( $_POST['hrm_dataAttr']['user_id'] ) ? trim( $_POST['hrm_dataAttr']['user_id'] ) : false;

        if ( $from_pim ) {
            $field['name'] = array(
                'type'   => 'hidden',
                'value'  =>  $from_pim
            );
        }

        $users = get_users();
        $apply_to_users = array();
        foreach ( $users as $key => $user ) {
            if ( reset( $user->roles ) != 'hrm_employee' ) {
                $apply_to_users[$user->ID] = $user->display_name;
            }
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

        $field['apply_to[]'] = array(
            'label'    => __( 'Apply To', 'hrm' ),
            'type'     => 'multiple',
            'class'    => 'hrm-chosen',
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'option'   => $apply_to_users
        );


        $field['from'] = array(
            'label' => __( 'From Date', 'hrm' ),
            'class' => 'hrm-datepicker-from',
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
            'class' => 'hrm-datepicker-to',
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

        $field['header']       = __( 'Apply Leave', 'hrm' );
        $field['action']       = 'insert_leave';
        $field['table_option'] = 'hrm_leave';

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $field );

        $return_value = array(
            'append_data' => ob_get_clean()
        );

        return $return_value;
    }


    function assign( $field_value = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        $user_id = isset( $_POST['hrm_dataAttr']['employee_id'] ) && !empty( $_POST['hrm_dataAttr']['employee_id'] ) ? trim( $_POST['hrm_dataAttr']['employee_id'] ) : false;
        $users = get_users();
        $apply_to_users = array();
        foreach ( $users as $key => $user ) {
            //if ( reset( $user->roles ) != 'hrm_employee' ) {
                $apply_to_users[$user->ID] = $user->display_name;
            //}
        }
        if ( $user_id ) {

            unset( $apply_to_users[$user_id] );
            $field['name'] = array(
                'type'   => 'hidden',
                'value'  => $user_id
            );
            $field['employee_id'] = array(
                'type'   => 'hidden',
                'value'  => $user_id
            );
        } else {
            $field['name'] = array(
                'label'  => __( 'Employee Name', 'hrm' ),
                'required' => 'required',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                ),
                'class'  => 'hrm-chosen',
                'type'   => 'select',
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

        $field['apply_to[]'] = array(
            'label'    => __( 'Apply To', 'hrm' ),
            'type'     => 'multiple',
            'class'    => 'hrm-chosen',
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'option'   => $apply_to_users
        );

        if ( $user_id ) {
            $field['leave_status'] = array(
                'type'  => 'hidden',
                'value' => '1'
            );

        } else {
            $field['leave_status'] = array(
                'label'    => __( 'Status', 'hrm' ),
                'type'     => 'select',
                'required' => 'required',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                ),
                'option'   => $this->leave_status(),
                'selected' => isset( $field_value['leave_status'] ) ? $field_value['leave_status'] : '2',
            );
        }

        $field['from'] = array(
            'label' => __( 'From Date', 'hrm' ),
            'class' => 'hrm-datepicker-from',
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
            'class' => 'hrm-datepicker-to',
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

        $field['header']       = __( 'Apply Leave', 'hrm' );
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

        if ( $status === null ) {
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
        $prev_leave_row = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', '*', array( 'id' => $postdata['leave_id'] ), true );

        $update = $wpdb->update( $table, $data, $where, $format, $where_format = null );

        if ( $update ) {
            $this->leave_status_update_message( $postdata, $prev_leave_row );
            return $update;
        }
        return false;
    }

    function leave_status_update_message( $postdata, $prev_leave_row ) {
        global $wpdb;
        $table  = $wpdb->prefix . 'hrm_leave';
        $get_apply_leave = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', '*', array( 'id' => $postdata['leave_id'] ), true );

        $leave_owner = get_user_by( 'id', $get_apply_leave->emp_id );

        $to = $leave_owner->user_email;
        $subject = __( 'Human Resource Management - Leave status changes', 'hrm' );
        $sender_id = get_current_user_id();
        $message = $this->leave_status_update_message_body( $get_apply_leave, $leave_owner, $postdata['status'], $prev_leave_row );

        Hrm_Settings::getInstance()->send( $to, $subject, $message, $sender_id );
    }

    function leave_status_update_message_body( $get_apply_leave, $leave_owner, $status, $prev_leave_row ) {
        $prev_leave_satus = $this->leave_status( $prev_leave_row->leave_status );
        $present_leave_satatus = $this->leave_status( $status );
        $post_from     = hrm_get_date2mysql( $get_apply_leave->start_time );
        $post_to       = hrm_get_date2mysql( $get_apply_leave->end_time );
        $leave_type    = Hrm_Settings::getInstance()->edit_query( 'hrm_leave_type', $get_apply_leave->leave_type_id );
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
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $get_apply_leave->leave_comments; ?></td>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $present_leave_satatus; ?></td>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $leave_count;  _e( ' days', 'hrm' ); ?></td>
            <tr>
            </table>
        <?php
        return ob_get_clean();
    }

    function leave_emp_search_query( $post, $limit, $pagenum ) {

        $search_arg = array();
        $type_id    = ( isset( $post['type_id'] ) && $post['type_id'] != '-1' ) ? $post['type_id'] : 0;
        $emp_id     = ( isset( $post['emp_id'] ) && $post['emp_id'] != '-1' ) ? $post['emp_id'] : '';
        $start_time = isset( $post['start_time'] ) && $post['start_time'] ? $post['start_time'] : '';
        $end_time   = isset( $post['end_time'] ) && $post['end_time'] ? $post['end_time'] : '';

        $where = array();

        if ( $type_id ) {
            $where[] = "leave_type_id = '$type_id'";
        }

        if ( $emp_id ) {
            $where[] = "emp_id = '$emp_id'";
        }

        if ( $start_time ) {
            $where[] = "start_time >= '$start_time'";
        }

        if ( $end_time ) {
            $where[] = "end_time <= '$end_time'";
        }

        $where = implode( ' AND ', $where );

        if ( ! $where ) {
            $get_leave_users = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', array( 'DISTINCT emp_id' ), array(), false, $limit, $pagenum );
            return $get_leave_users;
        }

        global $wpdb;
        $table = $wpdb->prefix . 'hrm_leave';
        $offset = ( $pagenum - 1 ) * $limit;
       // echo "SELECT SQL_CALC_FOUND_ROWS DISTINCT emp_id FROM $table WHERE $where ORDER BY id desc LIMIT $offset,$limit"; die();
        $results = $wpdb->get_results( "SELECT SQL_CALC_FOUND_ROWS DISTINCT emp_id FROM $table WHERE $where ORDER BY id desc LIMIT $offset,$limit" );
        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );
        return $results;
    }

    function leave_search_query( $post, $users_id ) {
        $search_arg = array();
        $type_id    = ( isset( $post['type_id'] ) && $post['type_id'] != '-1' ) ? $post['type_id'] : '';
        $emp_id     = ( isset( $post['emp_id'] ) && $post['emp_id'] != '-1' ) ? $post['emp_id'] : '';
        $start_time = isset( $post['start_time'] ) && $post['start_time'] ? $post['start_time'] : '';
        $end_time   = isset( $post['end_time'] ) && $post['end_time'] ? $post['end_time'] : '';

        $where = array();
        $in = $users_id ? implode( ',' , $users_id ) : false;

        if ( $emp_id && $in ) {
            $where[] = "emp_id IN ( $in )";
        }

        if ( $type_id ) {
            $where[] = "leave_type_id = '$type_id'";
        }


        if ( $start_time ) {
            $where[] = "start_time >= '$start_time'";
        }

        if ( $end_time ) {
            $where[] = "end_time <= '$end_time'";
        }

        $where = implode( ' AND ', $where );

        if ( ! $where ) {
            $results  = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', '*', array( 'emp_id' => $users_id ) );
            return $results;
        }

        global $wpdb;
        $table = $wpdb->prefix . 'hrm_leave';

        $results = $wpdb->get_results( "SELECT SQL_CALC_FOUND_ROWS * FROM $table WHERE $where ORDER BY id desc " );

        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );
        return $results;
    }
}

