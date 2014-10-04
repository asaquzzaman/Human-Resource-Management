<?php

class Hrm_Employeelist {
    private static $_instance;

    public static function getInstance() {
        if( ! self::$_instance ) {
            self::$_instance = new hrm_Employeelist();
        }

        return self::$_instance;
    }

    function add_new_employer( $postdata ) {
        if ( isset( $postdata['employer_id'] ) && !empty( $postdata['employer_id'] ) ) {
            $user_id = $postdata['employer_id'];
            $this->update_empoyer( $user_id, $postdata );
            return $user_id;
        }
        $validate = $this->new_admin_form_validate( $postdata );

        if ( is_wp_error( $validate ) ) {
            return $validate;
        }

        $random_password = wp_generate_password( 8, false );
        $first_name = sanitize_text_field( $postdata['first_name'] );
        $last_name = sanitize_text_field( $postdata['last_name'] );
        $display_name = $first_name .' '. $last_name;

        $userdata = array(
            'user_login' => $postdata['user_name'],
            'user_pass' =>  $random_password,
            'user_email' => $postdata['email'],
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $display_name,
            'role'  => 'hrm_employer'
        );

        $user_id = wp_insert_user( $userdata );

        if( $user_id ) {
            update_user_meta( $user_id, '_hrm_user_role', 'hrm_employer' );
            $this->update_empoyer( $user_id, $postdata );

            wp_new_user_notification( $user_id, $random_password );

            return $user_id;

        } else {
            return false;
        }

    }

    function update_empoyer( $user_id, $postdata ) {
        $display_name = $postdata['first_name'] . ' ' . $postdata['last_name'];
        update_user_meta( $user_id, 'first_name', $postdata['first_name'] );
        update_user_meta( $user_id, 'last_name', $postdata['last_name'] );

        wp_update_user(array( 'ID' =>  $user_id, 'display_name' => $display_name));
        update_user_meta( $user_id, '_job_title', $postdata['job_title'] );
        update_user_meta( $user_id, '_job_category', $postdata['job_category'] );
        update_user_meta( $user_id, '_location', $postdata['location'] );
        update_user_meta( $user_id, '_job_desc', $postdata['job_desc'] );
        update_user_meta( $user_id, '_status', $postdata['status'] );
        update_user_meta( $user_id, '_mob_number', $postdata['mobile'] );
        update_user_meta( $user_id, '_joined_date', hrm_date2mysql( $postdata['joined_date'] ) );

    }

    function new_admin_form_validate( $postdata ) {

        if( empty($postdata['user_name']) ) {
            return new WP_Error( 'error', __('Username required ', 'cpm' ) );
        }

        if( empty($postdata['email']) ) {
            return new WP_Error( 'error', __('Eamil required', 'cpm' ) );
        }

        if ( ! is_email($postdata['email'] ) ) {
            return new WP_Error( 'error', __('Invalid email', 'cpm' ) );
        }

        if( username_exists( $postdata['user_name'] ) ) {
            return new WP_Error( 'error', __('Username already exist', 'cpm' ) );
        }

        if( email_exists( $postdata['email']) ) {
            return new WP_Error( 'error', __('Email already exist', 'cpm' ) );
        }

        return true;
    }

    function new_employee_form( $employer = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';


        $job_title = json_decode( stripcslashes( $_POST['hrm_dataAttr']['job_title'] ) );
        $job_category = json_decode( stripcslashes( $_POST['hrm_dataAttr']['job_category'] ) );
        $location = json_decode( stripcslashes( $_POST['hrm_dataAttr']['location'] ) );

        $employer_id = isset( $employer->ID ) ? $employer->ID : '';
        if ( $employer === null ) {
            $hidden_form['user_name'] = array(
                'label' =>  __( 'User Name', 'hrm' ),
                'type'  => 'text',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                ),
            );

            $hidden_form['email'] = array(
                'label' =>  __( 'E-mail', 'hrm' ),
                'type'  => 'text',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_email' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                    'data-hrm_email_error_msg'=> __( 'Please enter a valid email', 'hrm' ),
                ),
            );
        } else {
            $hidden_form['employer_id'] = array(
                'value' => $employer_id,
                'type'  => 'hidden',
            );
        }

        $hidden_form['first_name'] = array(
            'label' =>  __( 'First Name', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $employer_id, 'first_name', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );
        $hidden_form['last_name'] = array(
            'label' =>  __( 'Last Name', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $employer_id, 'last_name', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['job_title'] = array(
            'label' => __( 'Job Title', 'hrm' ),
            'type' => 'select',
            'option' => $job_title,
            'selected' => get_user_meta( $employer_id, '_job_title', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['job_category'] = array(
            'label' => __( 'Job Category', 'hrm' ),
            'type' => 'select',
            'option' => $job_category,
            'selected' => get_user_meta( $employer_id, '_job_category', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['location'] = array(
            'label' => __( 'Location', 'hrm' ),
            'type' => 'select',
            'option' => $location,
            'selected' => get_user_meta( $employer_id, '_location', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['status'] = array(
            'label' =>  __( 'status', 'hrm' ),
            'type'  => 'select',
            'option' => array(
                'yes' => 'Enable',
                'no' => 'Disable'
            ),
            'selected' => get_user_meta( $employer_id, '_status', true )
        );
        $hidden_form['mobile'] = array(
            'label' =>  __( 'Mobile Number', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $employer_id, '_mob_number', true )
        );
        $hidden_form['joined_date'] = array(
            'label' =>  __( 'Joined Date', 'hrm' ),
            'type'  => 'text',
            'class' => 'hrm-datepicker',
            'value' => get_user_meta( $employer_id, '_joined_date', true )
        );

        $hidden_form['job_desc'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'type'  => 'textarea',
            'value' => get_user_meta( $employer_id, '_job_desc', true )
        );


        $hidden_form['action'] = 'new_employer';
        $hidden_form['header'] = 'Employee Information';
        $hidden_form['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;

    }

    function employeer_search_query( $get, $limit ) {
        if ( !empty( $get['first_name'] ) ) {
            $meta[] =   array(
                'key'     => 'first_name',
                'value'   =>  trim( $get['first_name'] ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $get['last_name'] ) ) {
            $meta[] = array(
                'key'     => 'last_name',
                'value'   =>  trim( $get['last_name'] ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $get['status'] ) ) {
            $meta[] = array(
                'key'     => '_status',
                'value'   =>  trim( $get['status'] ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $get['mobile'] ) ) {
            $meta[] = array(
                'key'     => '_mob_number',
                'value'   =>  trim( $get['mobile'] ),
                'compare' => 'LIKE'
            );
        }

        if ( isset( $meta ) ) {
            $meta['relation'] = 'AND';
        } else {
            $meta = '';
        }

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;

        $args = array(
            'search'         => !empty( $get['user'] ) ? trim( $get['user'] ) : '',
            'search_columns' => array( 'user_login', 'user_email' ),
            'meta_query' => $meta,
            'number' => $limit,
            'offset' => $offset
        );


        $user_query = new WP_User_Query( $args );

        return $user_query;
    }

    function get_employee( $limit = 0 ) {
        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;

        $employers = new WP_User_Query( array( 'role' => 'hrm_employer', 'number' => $limit, 'offset' => $offset ) );
        return $employers;
    }
}