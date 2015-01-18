<?php
class Hrm_Time {
    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new Hrm_Time();
        }

        return self::$_instance;
    }

    function __construct() {

        add_action( 'admin_init', array($this, 'admin_init_action') );
        add_filter( 'hrm_search_parm', array( $this, 'project_search_parm' ), 10, 1 );
        add_action( 'text_field_before_input', array($this, 'task_budget_crrency_symbol'), 10, 2 );
    }

    function generate_edit_form( $post ) {
        $post_id = $post['post_id'];
        $post = get_post( $post_id );
        $punch_out_time = get_post_meta( $post_id, '_puch_out_time', true );
        $puch_out_note = get_post_meta( $post_id, '_puch_out_note', true );

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        $form['post_id'] = array(
            'type' => 'hidden',
            'value' => isset( $post_id ) ? $post_id : '',
        );

        $form['punch_in_date'] = array(
            'type' => 'text',
            'label'=> __( 'Punch In Date', 'hrm' ),
            'class' => 'hrm-datepicker',
            'value' => date( 'Y-m-d', strtotime( $post->post_date ) )
        );
        $form['punch_in_time'] = array(
            'type' => 'text',
            'class' => 'hrm-timepicker',
            'label'=> __( 'Punch In Time', 'hrm' ),
            'value' => date( 'h:i:s a', strtotime( $post->post_date ) )
        );


        $form['punch_in_note'] = array(
            'label' => __( 'Punch In Note', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $post->post_content ) ? $post->post_content : '',
        );

        $form['punch_out_date'] = array(
            'type' => 'text',
            'label'=> __( 'Punch Out Date', 'hrm' ),
            'class' => 'hrm-datepicker',
            'value' => !empty( $punch_out_time ) ? date( 'Y-m-d', $punch_out_time ) : '',
        );
        $form['punch_out_time'] = array(
            'type' => 'text',
            'class' => 'hrm-timepicker',
            'label'=> __( 'Punch Out Time', 'hrm' ),
            'value' => !empty( $punch_out_time ) ? date( 'h:i:s a', $punch_out_time ) : ''
        );


        $form['punch_out_note'] = array(
            'label' => __( 'Punch Out Note', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $puch_out_note ) ? $puch_out_note : '',
        );

        $form['header'] = __( 'Attendance', 'hrm' );
        $form['action'] = 'edit_attendance_save';
        $form['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $form );
        return ob_get_clean();
    }

    function edit_attendance_save($post) {
        $post_date = $post['punch_in_date'] .' '. $post['punch_in_time'];

        $arg = array(
            'ID' => $post['post_id'],
            'post_date' => date( 'Y-m-d H:i:s', strtotime( $post_date ) ),
            'post_content' => $post['punch_in_note']
        );

        $post_id = wp_update_post($arg);

        $punch_out = $post['punch_out_date'] .' '. $post['punch_out_time'];
        $punch_out_date_time = strtotime( $punch_out );

        update_post_meta( $post['post_id'], '_puch_out_time', $punch_out_date_time );
        update_post_meta( $post['post_id'], '_puch_out_note', $post['punch_out_note'] );

        return true;
    }

    function new_punch_in($post) {
        $user_id = ( isset( $_POST['user_id'] ) && $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : get_current_user_id();

        $post_arg = array(
            'post_type' => 'hrm_punch',
            'post_status' => 'publish',
            'post_content' => $post['note'],
            'post_author' => $user_id
        );

        $arg = array(
            'post_type' => 'hrm_punch',
            'post_status'=> 'publish',
            'author' => $user_id,
            'meta_query' => array(
                array(
                    'key' => '_puch_in_status',
                    'value' => '1',
                    'compear' => '='
                ),
            )
        );
        $query = new WP_Query( $arg );

        if ( isset( $query->posts[0] ) ) {
            return false;
        }

        $post_id = wp_insert_post( $post_arg );

        if ( $post_id ) {
            update_post_meta( $post_id, '_puch_user', $user_id );
            update_post_meta( $post_id, '_puch_in_status', '1' );
            update_user_meta( $user_id, '_puch_in_status', '1' );
        }

        return true;
    }

    function new_punch_out($post) {
        $post_id = isset( $post['post_id'] ) ? intval( $post['post_id'] ) : false;
        $user_id = ( isset( $_POST['user_id'] ) && $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : get_current_user_id();
        $punch_out_time = strtotime( current_time('mysql') );
        if ( $post_id ) {
            update_post_meta( $post_id, '_puch_out_time', $punch_out_time );
            update_post_meta( $post_id, '_puch_out_note', $post['note'] );
            update_post_meta( $post_id, '_puch_in_status', '0' );
            update_user_meta( $user_id, '_puch_in_status', '0' );

            return true;
        } else {
            return false;
        }
    }

    function punch_in_out_form() {
        return $this->punch_out_form();
    }

    function punch_in_form() {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        $form['user_id'] = array(
            'type' => 'hidden',
            'value' => ( isset( $_POST['user_id'] ) && $_POST['user_id'] ) ? intval( $_POST['hrm_dataAttr']['user_id'] ) : '0',
        );
        $form[] = array(
            'type' => 'descriptive',
            'label'=> __( 'Date', 'hrm' ),
            'value' => get_date2mysql( current_time('mysql') )
        );
        $form[] = array(
            'type' => 'descriptive',
            'label'=> __( 'Time', 'hrm' ),
            'value' => hrm_get_time( current_time('mysql'), true )
        );


        $form['note'] = array(
            'label' => __( 'Note', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $project->post_content ) ? $project->post_content : '',
        );


        $form['action'] = 'create_punch_in';
        $form['header'] = __('Punch In', 'hrm');
        $form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function punch_out_form() {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        $user_id = ( isset( $_POST['user_id'] ) && $_POST['user_id'] ) ? intval( $_POST['hrm_dataAttr']['user_id'] ) : false;
        $form['user_id'] = array(
            'type' => 'hidden',
            'value' => $user_id,
        );
        $arg = array(
            'post_type' => 'hrm_punch',
            'post_status'=> 'publish',
            'author' => $user_id ? $user_id : get_current_user_id(),
            'meta_query' => array(
                array(
                    'key' => '_puch_in_status',
                    'value' => '1',
                    'compear' => '='
                ),
            )
        );
        $query = new WP_Query( $arg );

        if ( !isset( $query->posts[0] ) ) {
            return $this->punch_in_form();
        }

        $post = $query->posts[0];

         $form['post_id'] = array(
            'type' => 'hidden',
            'value' => $post->ID
        );

        $form[] = array(
            'type' => 'descriptive',
            'label'=> __( 'Punch in Time', 'hrm' ),
            'value' => isset( $post->post_date ) ? hrm_get_punch_in_time( $post->post_date ) : ''
        );

        $form[] = array(
            'type' => 'descriptive',
            'label'=> __( 'Punch in Note', 'hrm' ),
            'value' => isset( $post->post_content ) ? $post->post_content : ''
        );

        $form[] = array(
            'type' => 'descriptive',
            'label'=> __( 'Date', 'hrm' ),
            'value' => get_date2mysql( current_time('mysql') )
        );
        $form[] = array(
            'type' => 'descriptive',
            'label'=> __( 'Time', 'hrm' ),
            'value' => hrm_get_time( current_time('mysql'), true )
        );


        $form['note'] = array(
            'label' => __( 'Note', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $project->post_content ) ? $project->post_content : '',
        );


        $form['action'] = 'create_punch_out';
        $form['header'] = __('Punch Out', 'hrm');
        $form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function role_permission ( $role_name = false, $display_name = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        $get_tab = isset( $_POST['hrm_dataAttr']['tab'] ) ? $_POST['hrm_dataAttr']['tab'] : '';
        if ( $role_name !== false ) {
            $roles =  get_role( $role_name );
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => 'edit'
            );
        }

        $page = hrm_page();

        //hidden form
        $hidden_form['role_name'] = array(
            'label' =>  __( 'Role', 'hrm' ),
            'type' => ( $role_name === false ) ? 'text' : 'hidden',
            'required' => 'required',
            'value' => ( $role_name === false ) ? '' : esc_attr( $role_name ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );
        $hidden_form['display_name'] = array(
            'label' =>  __( 'Display Name', 'hrm' ),
            'type' => ( $display_name === null ) ? 'text' : 'hidden',
            'value' => ( $display_name === null ) ? '' : esc_attr( $display_name ),
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        foreach( $page as $tab => $tab_item )  {

            foreach ($tab_item as $tab_name => $tab_name_itme) {
                if ( $get_tab != $tab_name ) {
                    continue;
                }
                $view = isset( $roles->capabilities[$tab_name.'_view'] ) ? 'view' : '';
                $add = isset( $roles->capabilities[$tab_name.'_add'] ) ? 'add' : '';
                $delete = isset( $roles->capabilities[$tab_name.'_delete'] ) ? 'delete' : '';
                $tab_role[] = array(
                    'label' => __( 'View', 'hrm' ),
                    'value' => 'view',
                    'class' => 'hrm-cap-'.$tab_name.'_view',
                    'checked' => ( $role_name === false ) ? 'view' : $view,
                );

                $tab_role[] = array(
                    'label' => __( 'Add', 'hrm' ),
                    'value' => 'add',
                    'class' => 'hrm-cap-'.$tab_name.'_add',
                    'checked' => ( $role_name === false ) ? 'add' : $add,
                );

                $tab_role[] = array(
                    'label' => __( 'Delete', 'hrm' ),
                    'value' => 'delete',
                    'class' => 'hrm-cap-'.$tab_name.'_delete',
                    'checked' => ( $role_name === false ) ? 'delete' : $delete,
                );

                if ( isset( $tab_name_itme['role'] ) && is_array( $tab_name_itme['role'] ) && count( $tab_name_itme['role'] ) ) {
                    foreach ( $tab_name_itme['role'] as $role_value => $label ) {
                        $checked = isset( $roles->capabilities[$tab_name.'_'.$role_value] ) ? $role_value : '';
                        $tab_role[] = array(
                            'label' => $label,
                            'value' => $role_value,
                            'class' => 'hrm-cap-'.$tab_name.'_'.$role_value,
                            'checked' => ( $role_name === false ) ? $role_value : $checked,
                        );
                    }
                }

                $hidden_form['cap['.$tab_name.'][]'] = array(
                    'label'      => $tab_name_itme['title'],
                    'type'       => 'checkbox',
                    'desc'       => 'Choose access permission',
                    'wrap_class' => 'hrm-parent-field',
                    'fields'     => $tab_role,
                );

                $tab_role = '';

                $tab_name_itme['submenu'] = isset( $tab_name_itme['submenu'] ) ? $tab_name_itme['submenu'] : array();
                foreach ($tab_name_itme['submenu'] as $submenu => $submenu_item ) {

                    $view = isset( $roles->capabilities[$submenu.'_view'] ) ? 'view' : '';
                    $add = isset( $roles->capabilities[$submenu.'_add'] ) ? 'add' : '';
                    $delete = isset( $roles->capabilities[$submenu.'_delete'] ) ? 'delete' : '';

                    $submenu_role[] = array(
                        'label' => __( 'View', 'hrm' ),
                        'value' => 'view',
                        'class' => 'hrm-cap-'.$submenu.'_view' . ' hrm-cap-'.$tab_name.'-view-child' . ' hrm-cap-'.$tab_name,
                        'checked' => ( $role_name === false ) ? 'view' : $view,
                    );

                    $submenu_role[] = array(
                        'label' => __( 'Add', 'hrm' ),
                        'value' => 'add',
                        'class' => 'hrm-cap-'.$submenu.'_add' . ' hrm-cap-'.$tab_name.'-add-child' . ' hrm-cap-'.$tab_name,
                        'checked' => ( $role_name === false ) ? 'add' : $add,
                    );

                    $submenu_role[] = array(
                        'label' => __( 'Delete', 'hrm' ),
                        'value' => 'delete',
                        'class' => 'hrm-cap-'.$submenu.'_delete' . ' hrm-cap-'.$tab_name.'-delete-child' . ' hrm-cap-'.$tab_name,
                        'checked' => ( $role_name === false ) ? 'delete' : $delete,
                    );

                    if ( isset( $submenu_item['role'] ) && is_array( $submenu_item['role'] ) && count( $submenu_item['role'] ) ) {
                        foreach ( $submenu_item['role'] as $role_value => $label ) {
                            $checked = isset( $roles->capabilities[$submenu.'_'.$role_value] ) ? $role_value : '';
                            $submenu_role[] = array(
                                'label' => $label,
                                'value' => $role_value,
                                'class' => 'hrm-cap-'.$submenu.'_'.$role_value . ' hrm-cap-'.$tab_name.'-delete-child' . ' hrm-cap-'.$tab_name,
                                'checked' => ( $role_name === false ) ? $role_value : $checked,
                            );
                        }
                    }

                    $hidden_form['cap['.$submenu.'][]'] = array(
                        'label'      => $submenu_item['title'],
                        'type'       => 'checkbox',
                        'desc'       => 'Choose access permission',
                        'wrap_class' => 'hrm-child-field',
                        'fields'     => $submenu_role,
                    );
                    $submenu_role = '';
                }
            }
        }

        $hidden_form['header'] = 'User Role';
        $hidden_form['action'] = 'user_role';
        $hidden_form['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }
}