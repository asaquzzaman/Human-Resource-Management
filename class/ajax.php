<?php
class Hrm_Ajax {
    private static $instance;

    public static function getInstance() {
        if( ! self::$instance ) {
            self::$instance = new hrm_Ajax();
        }

        return self::$instance;
    }

    function __construct() {
        add_action( 'wp_ajax_ajax_referer_insert', array( $this, 'add_new_data' ) );
        add_action( 'wp_ajax_hrm_form_edit', array( $this, 'edit' ) );
        add_action( 'wp_ajax_single_form', array( $this, 'singel_form_add' ) );
        add_action( 'wp_ajax_hrm_delete', array( $this, 'delete' ) );
        add_action( 'wp_ajax_user_role', array( $this, 'create_user_role' ) );
        add_action( 'wp_ajax_role_delete', array( $this, 'user_role_remove' ) );
        add_action( 'wp_ajax_hrm_autocomplete', array( $this, 'hrm_autocomplete_action' ) );
        add_action( 'wp_ajax_user_create', array( $this, 'create_user' ) );
        add_action( 'wp_ajax_admin_autocomplete', array( $this, 'search_admin' ) );
        add_action( 'wp_ajax_get_role', array( $this, 'get_user_role' ) );
        add_action( 'wp_ajax_hrm_user_delete', array( $this, 'user_delete' ) );
        add_action( 'wp_ajax_update_user_role', array( $this, 'user_role_update' ) );
        add_action( 'wp_ajax_user-role-edit-form-appear', array( $this, 'user_role_edit_form_prepare' ) );
        add_action( 'wp_ajax_add_form', array( $this, 'add_form_generator' ) );
        add_action( 'wp_ajax_skills', array( $this, 'skill' ) );
        add_action( 'wp_ajax_skills_insert', array( $this, 'skill_add' ) );
        add_action( 'wp_ajax_add_project', array( $this, 'insert_project' ) );
        add_action( 'wp_ajax_project_edit', array( $this, 'edit_project' ) );
        add_action( 'wp_ajax_task_edit', array( $this, 'edit_task' ) );
        add_action( 'wp_ajax_sub_task_edit', array( $this, 'edit_sub_task' ) );
        add_action( 'wp_ajax_add_task', array( $this, 'insert_task' ) );
        add_action( 'wp_ajax_add_sub_task', array( $this, 'insert_sub_task' ) );
        add_action( 'wp_ajax_insert_leave', array( $this, 'new_leave' ) );
        add_action( 'wp_ajax_change_leave_status', array( $this, 'update_leave_status' ) );
        add_action( 'wp_ajax_new_employer', array( $this, 'add_employer' ) );
        add_action( 'wp_ajax_employer_edit', array( $this, 'edit_employer' ) );
        add_action( 'wp_ajax_update_my_info', array( $this, 'edit_my_info' ) );

        add_action( 'wp_ajax_project_worker', array( $this, 'find_project_worker' ) );
        add_action( 'wp_ajax_tast_complete', array( $this, 'complete_task' ) );
        add_action( 'wp_ajax_tast_incomplete', array( $this, 'incomplete_task' ) );
        add_action( 'wp_ajax_employee_delete', array( $this, 'delete_employee' ) );
        add_action( 'wp_ajax_delete_project', array( $this, 'project_delete' ) );
        add_action( 'wp_ajax_change_admin_status', array( $this, 'change_admin_status' ) );
        add_action( 'wp_ajax_create_punch_in', array( $this, 'new_punch_in' ) );
        add_action( 'wp_ajax_create_punch_out', array( $this, 'new_punch_out' ) );
        add_action( 'wp_ajax_edit_attendance', array( $this, 'time_editable' ) );
        add_action( 'wp_ajax_edit_attendance_save', array( $this, 'edit_attendance_save' ) );
        add_action( 'wp_ajax_single_tab_user_role', array( $this, 'single_tab_user_role' ) );
        add_action( 'wp_ajax_hrm_post_delete', array( $this, 'hrm_post_delete' ) );

        add_action( 'wp_ajax_rating_task', array( $this, 'rating_task' ) );
        add_action( 'wp_ajax_user_task_rating_content', array( $this, 'user_task_rating_content' ) );
        add_action( 'wp_ajax_task_rating', array( $this, 'task_rating' ) );
        add_action( 'wp_ajax_delete_task', array( $this, 'task_delete' ) );


    }

    function task_delete() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;
        //always before delete task
        Hrm_Evaluation::getInstance()->reduce_task_rating( $_POST['project_id'], $_POST['assing_to'] );
        wp_delete_post( $_POST['task_id'], true );
        wp_send_json_success();
    }

    function task_rating() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;
        $post_id = Hrm_Evaluation::getInstance()->new_task_rating( $post );
        wp_send_json_success( array( 'post_id' => $post_id, 'btn_text' => __( 'Edit', 'hrm' ) ) );
    }

    function user_task_rating_content() {
        check_ajax_referer('hrm_nonce');
        $project_id = intval( $_POST['project_id'] );
        $user_id = intval( $_POST['user_id'] );
        $content = Hrm_Evaluation::getInstance()->user_task_content( $project_id, $user_id );

        wp_send_json_success( array( 'slider_value' => $content['slider_value'], 'max' => $content['max'], 'append_data' => $content['content'], 'tasks_id' => $content['tasks_id'] ) );
    }

    function rating_task() {
        check_ajax_referer('hrm_nonce');
        $project_id = intval( $_POST['project_id'] );
        ob_start();
        Hrm_Evaluation::getInstance()->get_user_by_project_id( $project_id );
        wp_send_json_success( array( 'append_data' => ob_get_clean() ) );
    }

    function hrm_post_delete() {
        check_ajax_referer('hrm_nonce');

        $posts_id = isset( $_POST['hrm_check'] ) ? $_POST['hrm_check'] : array();
        foreach ( $posts_id as $post_id => $value ) {
            wp_delete_post( $post_id, true );
        }

        $tab = isset( $_POST['tab'] ) ? $_POST['tab'] : '';
        $subtab = isset( $_POST['sub_tab'] ) ? $_POST['sub_tab'] : '';

        if ( count( $posts_id ) ) {
            wp_send_json_success( array( 'msg' => __( 'delete successfull', 'hrm' ) ) );
        } else {
            wp_send_json_error( array( 'msg' => __( 'Faild to deleted', 'hrm' ) ) );
        }

    }

    function single_tab_user_role() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;
        hrm_single_tab_user_role_change( $post );
    }

    function edit_attendance_save() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;
        $edit_form = Hrm_Time::getInstance()->edit_attendance_save( $post );
        $url = $post['url'];
        if ( $edit_form ) {
            wp_send_json_success( array(
                'success_msg' => __( 'Successfully update punch', 'hrm' ),
            ));
        }
    }

    function time_editable() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;

        $edit_form = Hrm_Time::getInstance()->generate_edit_form( $post );
        wp_send_json_success( array( 'content' => $edit_form ) );
    }

    function new_punch_out() {
        check_ajax_referer('hrm_nonce');
        $post = array();
        $post = $_POST;
        $punch = Hrm_Time::getInstance()->new_punch_out($post);
        $url = $post['url'];
        if ( $punch ) {
             wp_send_json_success( array(
                'success_msg' => __( 'Successfully update punch', 'hrm' ),
                'redirect' => $url
            ));
        }
    }

    function new_punch_in() {
        check_ajax_referer('hrm_nonce');
        $post = array();
        $post = $_POST;
        $punch = Hrm_Time::getInstance()->new_punch_in($post);
        $url = $post['url'];

        if ( $punch ) {
             wp_send_json_success( array(
                'success_msg' => __( 'Successfully update puch', 'hrm' ),
                'redirect' => $url
            ));
        }
    }

    function change_admin_status() {
        check_ajax_referer('hrm_nonce');
        $user_id = $_POST['user_id'];
        $status = $_POST['status'];
        $changed = Hrm_Admin::getInstance()->change_admin_status( $user_id, $status );

        if ( $changed ) {
            wp_send_json_success();
        } else {
            wp_send_json_error();
        }
    }

    function project_delete() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        foreach ( $postdata['hrm_check'] as $key => $porject_id ) {
            $project_delete = Hrm_Admin::getInstance()->project_delete( $porject_id );
            Hrm_Evaluation::getInstance()->parent_rating_delete( $porject_id );
        }

        if ( $project_delete ) {
            wp_send_json_success( array(
                'msg' => __( 'Successfully deletet Project', 'hrm' )
            ));
        } else {
            wp_send_json_error( array(
                'msg' => __( 'Failed to deletet employee', 'hrm' ),
            ));
        }

    }

    function delete_employee() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        if ( !isset( $postdata['hrm_check'] ) || !is_array( $postdata['hrm_check'] ) ) {
            wp_send_json_error( array(
                'msg' => __( 'Failed to deletet employee', 'hrm' ),
            ));
        }
        $delete_user = false;
        if ( hrm_user_can_access( $postdata['tab'], null, 'delete' ) ) {
            $delete_user = hrm_Employee::getInstance()->delete_employee( $postdata['hrm_check'] );
        } else {
           wp_send_json_error( array(
                'msg' => __( 'You do not have permission deletet employee', 'hrm' ),
            ));
        }

        if ( $delete_user ) {
            wp_send_json_success( array(
                'msg' => __( 'Successfully deletet employee', 'hrm' ),
            ) );
        } else {
            wp_send_json_error( array(
                'msg' => __( 'Failed to deletet employee', 'hrm' ),
            ));
        }
    }

    function complete_task() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $update = Hrm_Admin::getInstance()->task_complete( $postdata['task_id'] );
        if ( $update ) {
            wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ) ) );
        } else {
            wp_send_json_error();
        }
    }

    function incomplete_task() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $update = Hrm_Admin::getInstance()->task_incomplete( $postdata['task_id'] );
        if ( $update ) {
            wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ) ) );
        } else {
            wp_send_json_error();
        }
    }

    function edit_my_info() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $table_option = get_option( $postdata['table_option'] );
        $user_id = hrm_employee::getInstance()->edit_my_info( $postdata, $table_option );
        if ( $user_id ) {
            wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ) ) );
        } else {
            wp_send_json_error();
        }
    }

    function edit_employer() {
        check_ajax_referer('hrm_nonce');
        $id = $_POST['id'];
        $user = get_user_by( 'id', $id );
        $data = hrm_Employeelist::getInstance()->new_employee_form( $user );
        wp_send_json_success( array( 'append_data' => $data ) );
    }

    function add_employer() {
        check_ajax_referer('hrm_nonce');

        $post = $_POST;
        $url = $_POST['url'];
        $user_id = hrm_Employeelist::getInstance()->add_new_employer( $post );

        if ( isset( $user_id->errors ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'User name or E-mail already exist', 'hrm' ), 'redirect' => $url ) );
        } else {
            wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ), 'redirect' => $url ) );
        }
    }

    function update_leave_status() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $update = hrm_Leave::getInstance()->update_leave_status( $postdata );
        if ( $update ) {
            wp_send_json_success( array( 'msg' => __( 'Successfully update leave status', 'hrm' ) ) );
        } else {
           wp_send_json_error( array( 'msg' => __( 'Failed to update leave status', 'hrm' ) ) );
        }
    }

    function new_leave() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $update = hrm_Leave::getInstance()->new_leave( $postdata );
        if( $update ) {
            wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' )  ) );
        } else {
            wp_send_json_error( __( 'Update Failed', 'hrm' ) );
        }
    }

    function find_project_worker() {
        $users = get_users( array(
            'search' => '*' . $_POST['search_admin'] . '*',
            'search_columns' => array( 'user_login', 'user_email', 'nicename' ),
        ) );
        $data = array();
        foreach( $users as $user) {
            $data[] = array(
                'label' => $user->display_name,
                '_user_meta' => Hrm_Admin::getInstance()->project_user_meta( $user->display_name, $user->ID, $user ),
            );
        }
        if( count($data) ) {
            $user_info = json_encode( $data );
        } else {
            $data[] = array(
                'label' => __( 'No user found!', 'hrm'),//'<div class="no-user-wrap"><p>' . __( 'No user found!', 'cpm' ) . '</p> <span class="button-primary">' . __( 'Create a new user?', 'cpm' ) . '</span></div>',
                'value' => 'hrm_create_user',
                '_user_meta' =>'',
            );
            $user_info = json_encode( $data );
        }

        wp_send_json_success( $user_info );
    }

    function insert_sub_task() {
        check_ajax_referer('hrm_nonce');
        $is_update = isset( $_POST['id'] ) ? true : false;
        $url = isset( $_POST['url'] ) ? $_POST['url'] : '';
        $start_date = !empty( $_POST['start_date'] ) ? hrm_date2mysql( $_POST['start_date'] ) : '';
        $end_date = !empty( $_POST['end_date'] ) ? hrm_date2mysql( $_POST['end_date'] ) : '';

        $data = array(
            'post_title' => $_POST['title'],
            'post_content' => $_POST['description'],
            'post_type' => 'hrm_sub_task',
            'post_status' => 'publish'
        );

        if ( $is_update ) {
            $data['ID'] = $_POST['id'];
            $task_id = wp_update_post( $data );
            $status = false;
        } else {
            $data['post_parent'] = $_POST['task_id'];
            $task_id = wp_insert_post( $data );
            $status = true;
        }

        if( $task_id ) {
            update_post_meta( $task_id, '_start_date', $start_date );
            update_post_meta( $task_id, '_end_date', $end_date );
            update_post_meta( $task_id, '_assigned', $_POST['assigned'] );
            update_post_meta( $task_id, '_completed', $_POST['status'] );

            wp_send_json_success( array( 'sub_task_id' => $task_id, 'sub_task' => $status, 'success_msg' => __( 'Update successfull', 'hrm' ), 'redirect' => $url ) );
        } else {
            wp_send_json_error( __( 'Update Failed', 'hrm' ) );
        }
    }

    function insert_task() {
        check_ajax_referer('hrm_nonce');
        $is_update  = isset( $_POST['id'] ) ? true : false;
        $url        = isset( $_POST['url'] ) ? $_POST['url'] : '';
        $start_date = !empty( $_POST['start_date'] ) ? hrm_date2mysql( $_POST['start_date'] ) : '';
        $end_date   = !empty( $_POST['end_date'] ) ? hrm_date2mysql( $_POST['end_date'] ) : '';

        $data = array(
            'post_title'   => $_POST['title'],
            'post_content' => $_POST['description'],
            'post_type'    => 'hrm_task',
            'post_status'  => 'publish'
        );

        if ( $is_update ) {
            $data['ID'] = $_POST['id'];
            $task_id = wp_update_post( $data );
            Hrm_Evaluation::getInstance()->update_task_rating( $_POST );
            $status = false;
        } else {
            $data['post_parent'] = $_POST['project_id'];
            $task_id = wp_insert_post( $data );
            Hrm_Evaluation::getInstance()->new_inserted_task_rating( $_POST['project_id'], $_POST['assigned'] );
            $status = false;
        }

        if( $task_id ) {
            $post = get_post($task_id);
            $project_id = $post->post_parent;
            if ( !isset($_POST['assigned']) ) {
                $assign_to = $post->post_author;
            } else {
                $assign_to = $_POST['assigned'];
            }
            update_post_meta( $task_id, '_start_date', $start_date );
            update_post_meta( $task_id, '_end_date', $end_date );
            update_post_meta( $task_id, '_assigned', $assign_to );
            update_post_meta( $task_id, '_completed', $_POST['status'] );

            $project_budget = get_post_meta( $project_id, '_budget', true );

            if ( $project_budget ) {

                $project_budget_utilize = get_post_meta( $project_id, '_project_budget_utilize', true );
                $task_budget = floatval( $_POST['task_budget'] );
                $new_budget_utilize = $project_budget_utilize + $task_budget;

                if ( floatval( $project_budget ) >= $new_budget_utilize ) {
                    update_post_meta( $project_id, '_project_budget_utilize', $new_budget_utilize );
                    update_post_meta( $task_id, '_task_budget', $task_budget );
                }
            }

            wp_send_json_success( array( 'task_id' => $task_id, 'sub_task_create_status' => $status, 'success_msg' => __( 'Update successfull', 'hrm' ), 'redirect' => $url ) );
        } else {
            wp_send_json_error( __( 'Update Failed', 'hrm' ) );
        }
    }

    function edit_project() {
        check_ajax_referer('hrm_nonce');
        $post_id = $_POST['id'];
        $post = get_post( $post_id );
        $data = Hrm_Admin::getInstance()->project_insert_form( $post );
        wp_send_json_success( array( 'append_data' => $data ) );

    }

    function edit_task() {
        check_ajax_referer('hrm_nonce');
        $post_id = $_POST['id'];
        $post = get_post( $post_id );
        $data = Hrm_Admin::getInstance()->task_form( $post );
        wp_send_json_success( array( 'append_data' => $data ) );

    }

    function edit_sub_task() {
        check_ajax_referer('hrm_nonce');
        $post_id = $_POST['id'];
        $post = get_post( $post_id );
        $data = Hrm_Admin::getInstance()->sub_task_form( $post );
        wp_send_json_success( array( 'append_data' => $data ) );

    }


    function insert_project() {
        check_ajax_referer('hrm_nonce');
        $is_update = ( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ) ? true : false;
        $url = isset( $_POST['url'] ) ? $_POST['url'] : '';
        $data = array(
            'post_title' => $_POST['title'],
            'post_content' => $_POST['description'],
            'post_type' => 'hrm_project',
            'post_status' => 'publish'
        );

        if ( $is_update ) {
            $data['ID'] = $_POST['id'];
            $project_id = wp_update_post( $data );
            $status = false;
        } else {
            $project_id = wp_insert_post( $data );
            $status = true;
        }

        if( $project_id ) {
            $this->insert_project_user_role( $_POST, $project_id  );
            Hrm_Admin::getInstance()->update_project_meta( $project_id, $_POST );
            wp_send_json_success( array( 'project_id' => $project_id, 'task_create_status' => $status, 'success_msg' => __( 'Update successfull', 'hrm' ) ) );
        } else {
            wp_send_json_error( __( 'Update Failed', 'hrm' ) );
        }
    }

    function insert_project_user_role( $posted, $project_id  ) {

        global $wpdb;
        $table = $wpdb->prefix . 'hrm_user_role';
        $wpdb->delete( $table, array( 'project_id' => $project_id ), array('%d') );
        $project_author = get_post_field( 'post_author', $project_id );
        $this->insert_user( $project_id, $project_author, 'manager' );
        //update_post_meta( $project_id, $project_author, 'manager');

        if( isset( $posted['role'] ) && count( $posted['role'] ) ) {

            foreach( $posted['role'] as $user_id => $role ) {
                if( $user_id == $project_author) {
                    continue;
                }
                $this->insert_user( $project_id, $user_id, $role );
                //update_post_meta( $project_id, $user_id, $role );
            }
        }
    }

    function insert_user( $project_id, $user_id, $role ) {
        global $wpdb;
        $table = $wpdb->prefix . 'hrm_user_role';
        $data = array(
            'project_id' => $project_id,
            'user_id' => $user_id,
            'role' => $role,
        );
        $format = array( '%d', '%d', '%s' );
        $wpdb->insert( $table, $data, $format );
    }

    function skill_add() {
        check_ajax_referer('hrm_nonce');
        $id = isset( $_POST['id'] ) ? $_POST['id'] : '';
        global $wpdb;
        $table = $wpdb->prefix . 'skill';

        $user_name = isset( $_POST['user_name'] ) ? $_POST['user_name'] : '';

        $url = $_POST['url'];

        if( ! empty( $id ) ) {
            $data = array(
                'description' => $_POST['skill_desc'],
            );
            $format = array( '%s');
            $update = $wpdb->update( $table, $data, array( 'id' => $id ), $format );
        } else {
            $results = $wpdb->get_results("SELECT id FROM $table", ARRAY_A );
            $results = wp_list_pluck( $results, 'id' );

            foreach ( $_POST['user_id'] as $key => $id ) {

                if ( in_array( $id, $results ) ) {
                    $update = true;
                    continue;
                }

                $data = array(
                    'id' => $id,
                    'name' => $user_name[$key],
                    'description' => $_POST['skill_desc'],
                );
                $format = array( '%d', '%s', '%s');

                $update = $wpdb->insert( $table, $data, $format );
            }

        }

        if( $update ) {
            wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ), 'redirect' => $url ) );
        } else {
            wp_send_json_error( __( 'Update Failed', 'hrm' ) );
        }
    }

    function skill() {
        check_ajax_referer('hrm_nonce');

        $search_field = 'emp_firstname';
        $search_value = trim( $_POST['search_value'] );
        $where = $search_field .' LIKE ' ."'%".$search_value."%'";

        global $wpdb;
        $tabledb = $wpdb->prefix . 'employee';

        $results = $wpdb->get_results("SELECT id, emp_lastname, emp_firstname $search_field FROM $tabledb WHERE $where ORDER BY id DESC");

        if( $results ) {
            foreach ($results as $key => $value) {

                $data[] = array(
                    'label' => $value->$search_field,
                    'value' => $value->$search_field,
                    'id' => $value->id,
                    '_user_meta'=> Hrm_Admin::getInstance()->skill_user_meta( $value->id, $value->emp_firstname, $value->emp_lastname  ),
                );
            }
        } else {
            $data[] = array(
                'label' => 'No user found !',
            );
        }

        $user_info = json_encode( $data );
        wp_send_json_success( $user_info );

    }

    function add_form_generator() {
        check_ajax_referer('hrm_nonce');
        $class_nam = isset( $_POST['class_name'] ) ? $_POST['class_name'] : '';
        $function_nam = isset( $_POST['function_name'] ) ? $_POST['function_name'] : '';

        if ( method_exists( $class_nam, 'getInstance' ) ) {
            $data = $class_nam::getInstance()->$function_nam ();

        } else if ( class_exists( $class_nam ) ) {
            $new_instance = new $class_nam ();
            $data = $new_instance->$function_nam();

        } else if ( function_exists( $function_nam ) ) {
            $data = $function_nam ();
        }

        wp_send_json_success( array( 'append_data' => $data ) );
    }

    function user_role_edit_form_prepare() {
        check_ajax_referer('hrm_nonce');
        $data = $_POST['class_name']::getInstance()->$_POST['function_name'] ( $_POST['id'] );

        wp_send_json_success( array( 'append_data' => $data ) );
    }

    function user_role_update() {
        check_ajax_referer('hrm_nonce');
        $admin = isset( $_POST['admin'] ) ? $_POST['admin'] : array();
        foreach ($_POST['admin'] as $key => $user_id) {
            wp_update_user( array( 'ID' => $user_id, 'role' => $_POST['admin_role'][$key] ) );
            update_user_meta( $user_id, 'hrm_admin_level', 'admin' );
        }
        wp_send_json_success( array( 'success_msg' => __( 'Update successful', 'hrm' ) ) );
    }

    function user_delete() {
        check_ajax_referer('hrm_nonce');

        if ( isset( $_POST['hrm_check'] ) && is_array( $_POST['hrm_check'] ) && count( $_POST['hrm_check'] ) ) {

            foreach( $_POST['hrm_check'] as $user_id => $value ) {

                $delete_user = wp_delete_user( $user_id );
            }
        }
        if( $delete_user ) {
            wp_send_json_success( array( 'msg' => __( 'Delete user successfully', 'hrm' ) ) );
        } else {
            wp_send_json_error( __( 'Delete Failed', 'hrm' ) );
        }

    }

    function get_user_role() {

        $data = $_POST['class_name']::getInstance()->$_POST['function_name'] ( $_POST['role_name'], $_POST['display_name'] );

        wp_send_json_success( array( 'append_data' => $data ) );
    }

    function search_admin() {
        $users = get_users( array(
            'search' => '*' . $_POST['search_admin'] . '*',
            'search_columns' => array( 'user_login', 'user_email', 'nicename' ),
        ) );

        $data = array();
        $super_admin = get_option( 'hrm_admin');
        foreach( $users as $user) {
            if ( $user->ID == $super_admin ) continue;
            $data[] = array(
                'label' => $user->display_name,
                '_user_meta' => Hrm_Admin::getInstance()->create_user_meta( $user->display_name, $user->ID ),
            );
        }
        if( count($data) ) {
            $user_info = json_encode( $data );
        } else {
            $data[] = array(
                'label' => '<div class="no-user-wrap"><p>' . __( 'No user found!', 'cpm' ) . '</p> <span class="button-primary">' . __( 'Create a new user?', 'cpm' ) . '</span></div>',
                'value' => 'hrm_create_user',
                '_user_meta' =>'',
            );
            $user_info = json_encode( $data );
        }

        wp_send_json_success( $user_info );
    }



    function create_user() {

        parse_str( $_POST['data'], $postdata );

        $validate = $this->new_admin_form_validate( $postdata );

        if ( is_wp_error( $validate ) ) {
            wp_send_json_error( $validate->errors['error'][0] );
        }

        $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
        $first_name = sanitize_text_field( $postdata['first_name'] );
        $last_name = sanitize_text_field( $postdata['last_name'] );
        $display_name = $first_name .' '. $last_name;

        $userdata = array(
            'user_login'   => $postdata['admin_name'],
            'user_pass'    =>  $random_password,
            'user_email'   => $postdata['admin_email'],
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => $display_name,
        );

        $user_id = wp_insert_user( $userdata );

        if( $user_id ) {
            update_user_meta( $user_id, '_user_flag', 1 );
            update_user_meta( $user_id, 'first_name', $first_name );
            update_user_meta( $user_id, 'last_name', $last_name );
            update_user_meta( $user_id, 'hrm_admin_level', 'admin' );

            wp_new_user_notification( $user_id, $random_password );

            $user_meta = Hrm_Admin::getInstance()->create_user_meta( $display_name, $user_id );
            wp_send_json_success( array(
                'success_msg' => __('Create admin successfull', 'hrm'),
                 '_user_meta' => $user_meta,
            ));
        } else {
            wp_send_json_error( __('Unknown Error!', 'hrm') );
        }
    }

    function new_admin_form_validate( $postdata ) {

        if( empty($postdata['admin_name']) ) {
            return new WP_Error( 'error', __('Username required ', 'cpm' ) );
        }

        if( empty($postdata['admin_email']) ) {
            return new WP_Error( 'error', __('Eamil required', 'cpm' ) );
        }

        if ( ! is_email($postdata['admin_email'] ) ) {
            return new WP_Error( 'error', __('Invalid email', 'cpm' ) );
        }

        if( username_exists( $postdata['admin_name'] ) ) {
            return new WP_Error( 'error', __('Username already exist', 'cpm' ) );
        }

        if( email_exists( $postdata['admin_email']) ) {
            return new WP_Error( 'error', __('Email already exist', 'cpm' ) );
        }

        return true;
    }

    function hrm_autocomplete_action() {

        if( ! isset( $_POST['table_option'] ) && empty( $_POST['table_option'] ) ) {
            wp_send_json_error( __( 'Error occured', 'hrm' ) );
        }
        $table_option['table_option'] = array();
        $table_option = get_option( $_POST['table_option'] );

        $search_field = $_POST['search_field'];
        $search_value = trim( $_POST['search_value'] );
        $where = $search_field .' LIKE ' ."'%".$search_value."%'";

        global $wpdb;
        $tabledb = $wpdb->prefix . $table_option['table_name'];

        $results = $wpdb->get_results("SELECT id, $search_field FROM $tabledb WHERE $where ORDER BY id DESC");

        if( $results ) {
            foreach ($results as $key => $value) {
                $data[] = array(
                    'label' => $value->$search_field,
                    'value' => $value->$search_field,
                    'id' => $value->id
                );
            }
        } else {
            wp_send_json_error( __( 'Error occured', 'hrm' ) );
        }

        $user_info = json_encode( $data );
        wp_send_json_success( $user_info );
    }

    function user_role_remove() {
        check_ajax_referer('hrm_nonce');
        if( isset( $_POST['hrm_check'] ) && is_array( $_POST['hrm_check'] ) && count( $_POST['hrm_check'] ) ) {
            foreach( $_POST['hrm_check'] as $role_name => $empty ) {
               remove_role( $role_name );
            }
        }
        wp_send_json_success(array('msg' => __('Delete successfull') ) );
    }

    function create_user_role() {

        check_ajax_referer('hrm_nonce');

        if ( isset( $_POST['id'] ) && $_POST['id'] == 'edit' && isset( $_POST['role_name'] ) && ! empty( $_POST['role_name'] ) ) {
            $capabilities = isset( $_POST['cap'] ) ? $_POST['cap'] : array();
            $edit_role = $this->edit_capabilities( $_POST['role_name'], $capabilities );

            if ( $edit_role ) {
                wp_send_json_success( array( 'success_msg' => __('User role update successfull', 'hrm') ) );
            } else {
                wp_send_json_error( __('Unknown Error!', 'hrm') );
            }
        } else if ( ! empty( $_POST['role_name'] ) && ! empty( $_POST['display_name'] ) ) {

            $capabilities = isset( $_POST['cap'] ) ? $_POST['cap'] : array();

            foreach ( $capabilities as $menu => $access_status ) {
                foreach ($access_status as $key => $can ) {
                    $cap[$menu.'_'.$can] = true;
                }
            }
            $cap = isset( $cap ) ? $cap : array();

            $add_role = $this->add_capabilities( $_POST['role_name'], $_POST['display_name'], $cap );

            if ( $add_role == null ) {
                wp_send_json_error( __( 'User role already exists', 'hrm' ) );
            } else if ( is_object( $add_role ) ) {
                $url = isset( $_POST['url'] ) ? $_POST['url'] : '';
                wp_send_json_success( array( 'success_msg' => __( 'User role add successfull', 'hrm' ), 'redirect' => $url ) );
            }

        } else {
            wp_send_json_error( __( 'Unknown Error!', 'hrm' ) );
        }

    }

    function add_capabilities ( $role_name, $display_name, $capabilities = array() ) {
        $capabilities['read'] = true;
        return add_role( $role_name, $display_name, $capabilities );
    }

    /**
     * $cap array and its capability name combine with key and value
     */
    function edit_capabilities( $exist_role, $cap = array() ) {

        if( ! is_array( $cap ) ) {
            return false;
        }

        $role = new wp_roles();
        $exist = $role->is_role( $exist_role );

        if( $exist ) {
            $cxist_cap = get_role( $exist_role );

            foreach ( $cxist_cap->capabilities as $role_name => $display_name ) {
                $role->remove_cap( $exist_role, $role_name );
            }

            foreach ( $cap as $menu => $access_status ) {
                foreach ( $access_status as $key => $can ) {
                    $capabilitie = $menu.'_'.$can;
                    $role->add_cap( $exist_role, $capabilitie );
                }
            }

            $role->add_cap( $exist_role, 'read' );

            return true;
        }

        return false;
    }

    function singel_form_add() {
        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['table_option'] ) && empty( $_POST['table_option'] ) ) {
            wp_send_json_error(__('Unknown Error!', 'hrm') );
        }

        $data = array();

        $field = get_option( $_POST['table_option'] );

        if( count( $field['field_dif'] ) ) {
            foreach( $field['field_dif'] as $key => $name ) {
                $data[$name] = isset( $_POST[$name] ) ? esc_attr( $_POST[$name] ) : '';
            }
        }

        $field['data'] = $data;
        $update = false;

        if( count( $field['field_dif'] ) ) {
            $update = update_option( $_POST['table_option'], $field );
        }

        if( $update ) {
            wp_send_json_success( array( 'success_msg' => __( 'Update Successfull', 'hrm' ) ) );
        } else {
            wp_send_json_error( __( 'Update Failed', 'hrm' ) );
        }
    }

    function delete() {
        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['hrm_check'] ) && ! count( $_POST['hrm_check'] ) ) {
            wp_send_json_error( array( 'msg' => __( 'Faild to deleted', 'hrm' ) ) );
        }

        if( ! isset( $_POST['table_option'] ) && empty( $_POST['table_option'] ) ) {
            wp_send_json_error( array( 'msg' => __( 'Faild to deleted', 'hrm' ) ) );
        }
        $table_option['table_option'] = array();
        $table_option = get_option( $_POST['table_option'] );

        global $wpdb;
        $table = $wpdb->prefix . $table_option['table_name'];

        $users_id = isset( $_POST['hrm_check'] ) ? $_POST['hrm_check'] : array();

        foreach( $users_id as $id => $value ) {
            $delete = $wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
        }

        if ( count( $users_id ) ) {
            $tab = isset( $_POST['tab'] ) ? $_POST['tab'] : '';
            $subtab = isset( $_POST['sub_tab'] ) ? $_POST['sub_tab'] : '';
            wp_send_json_success( array( 'msg' => __( 'delete successfull', 'hrm' ) ) );
        } else {
            wp_send_json_error( array( 'msg' => __( 'Faild to deleted', 'hrm' ) ) );
        }

    }

    function edit() {
        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['table_option'] ) && empty( $_POST['table_option'] ) ) {
            wp_send_json_error();
        }
        $id = isset( $_POST['id'] ) ? $_POST['id'] : '';
        $table_option['table_option'] = array();
        $table_option = get_option( $_POST['table_option'] );

        $table = isset( $table_option['table_name'] ) ? $table_option['table_name'] : '';
        $query_val = $this->edit_query( $table, $id );

        foreach ( $query_val  as $dbfield => $value ) {
            if( ! isset( $table_option['table_option'][$dbfield] ) || empty( $table_option['table_option'][$dbfield] ) ) {
                continue;
            }
            $set_form_field[$table_option['table_option'][$dbfield]] = $value;
        }
        $set_form_field['id'] = $id;

        $class_nam = isset( $_POST['class_name'] ) ? $_POST['class_name'] : '';
        $function_nam = isset( $_POST['function_name'] ) ? $_POST['function_name'] : '';

        if ( method_exists( $class_nam, 'getInstance' ) ) {
            $data = $class_nam::getInstance()->$function_nam ( $set_form_field );

        } else if ( class_exists( $class_nam ) ) {
            $new_instance = new $class_nam ();
            $data = $new_instance->$function_nam( $set_form_field );

        } else if ( function_exists( $function_nam ) ) {
            $data = $function_nam ( $set_form_field );
        }

        //$data = $_POST['class_name']::getInstance()->$_POST['function_name'] ( $set_form_field );
        wp_send_json_success( array( 'append_data' => $data ) );

    }

    function edit_query( $table, $id ) {
        global $wpdb;
        $table = $wpdb->prefix . $table;
        return $wpdb->get_row("SELECT * FROM $table WHERE id = $id", ARRAY_A );
    }

    function add_new_data() {
        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['table_option'] ) && empty( $_POST['table_option'] ) ) {
            wp_send_json_error( __( 'Unknown Error!', 'hrm' ) );
        }

        $table_option = get_option( $_POST['table_option'] );

        if( ! is_array( $table_option ) || ! count( $table_option ) ) {
            wp_send_json_error( __( 'Table option required!', 'hrm' ) );
        }

        $url = $_POST['url'];
        $id = ( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ) ? $_POST['id'] : '';

        if( ! isset( $table_option['table_name'] ) || empty( $table_option['table_name'] ) ) {
            wp_send_json_error( __( 'Table name required!', 'hrm' ) );
        }

        $format = ( isset( $table_option['table_format'] ) && is_array( $table_option['table_format'] ) ) ? $table_option['table_format'] : array();
        $table_option['table_option'] = ( isset( $table_option['table_option'] ) && is_array( $table_option['table_option'] ) ) ? $table_option['table_option'] : array();

        foreach( $table_option['table_option'] as $field => $name ) {
            $fiel_val = isset( $_POST[$name] ) ? $_POST[$name] : '';

            $data[$field] = is_array( $fiel_val ) ? maybe_serialize( $fiel_val ) : $fiel_val;
        }

        $data = ( isset( $data ) && is_array( $data ) ) ? $data : array();

        if ( empty( $id ) ) {
            $update_status = false;
        } else {
            $update_status = true;
        }


        $table_name  = apply_filters( 'hrm_change_table', $table_option['table_name'], $data, $format, $update_status, $_POST );
        global $wpdb;
        $table = $wpdb->prefix . $table_name;

        $data   = apply_filters( 'hrm_change_data', $data, $table_name, $format, $update_status, $_POST );
        $format = apply_filters( 'hrm_change_table', $format, $table_name, $data, $update_status, $_POST );

        if( $update_status ) {
            $where  = array( 'id' => $id );
            $where  = apply_filters( 'hrm_change_where', $where, $data, $table_name,  $format, $update_status );

            $update = $wpdb->update( $table, $data, $where, $format );

        } else {

            $update = $wpdb->insert( $table, $data, $format );
        }

        if( $update ) {
            do_action( 'hrm_after_save_data', $update, $update_status, $table_option['table_name'], $_POST );
            wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ), 'redirect' => $url ) );
        } else {
            wp_send_json_error( __( 'Update Failed', 'hrm' ) );
        }
    }
}