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

        add_action( 'wp_ajax_hrm_ajax_upload', array( $this, 'ajax_upload' ) );
        add_action( 'wp_ajax_hrm_delete_file', array( $this, 'hrm_delete_file' ) );
        add_action( 'wp_ajax_file_upload', array( $this, 'file_upload' ) );
        add_action( 'wp_ajax_edit_file', array( $this, 'edit_file' ) );
        add_action( 'wp_ajax_file_search', array( $this, 'file_search' ) );
        add_action( 'wp_ajax_file_delete', array( $this, 'file_delete' ) );
        add_action( 'wp_ajax_delete_inbox_file', array( $this, 'delete_inbox_file' ) );

        add_action( 'wp_ajax_pagination', array( $this, 'pagination' ) );
        add_action( 'wp_ajax_view_pagination', array( $this, 'view_pagination' ) );

        add_action( 'wp_ajax_project_search', array( $this, 'project_search' ) );
        add_action( 'wp_ajax_hrm_search', array( $this, 'hrm_search' ) );
        add_action( 'wp_ajax_hrm_profile_pic_del', array( $this, 'hrm_profile_pic_del' ) );
        add_action( 'wp_ajax_punch_form_status', array( $this, 'punch_form_status' ) );

        add_action( 'wp_ajax_new_client', array( $this, 'new_client' ) );
        add_action( 'wp_ajax_client_edit', array( $this, 'client_edit' ) );
        add_action( 'wp_ajax_client_delete', array( $this, 'client_delete' ) );
        add_action( 'wp_ajax_get_clients_project', array( $this, 'get_clients_project' ) );
        add_action( 'wp_ajax_partial_payment_update', array( $this, 'partial_payment_update' ) );
        add_action( 'wp_ajax_partial_payment_cancel', array( $this, 'partial_payment_cancel' ) );
        add_action( 'wp_ajax_partial_payment_delete', array( $this, 'partial_payment_delete' ) );
    }

    function partial_payment_delete() {
        check_ajax_referer('hrm_nonce');
        $data  = $this->edit_query( $_POST['table'], $_POST['id'] );
        $table = HRM_Client::getInstance()->cancel_partial_payment_delete( $data, $_POST );
        wp_send_json_success( array( 'content' => $table['table'], 'project_id' => $data['project_id'], 'summary' => $table['summary'] ) );
    }

    function partial_payment_cancel() {
        check_ajax_referer('hrm_nonce');
        $data  = $this->edit_query( $_POST['table'], $_POST['id'] );
        $table = HRM_Client::getInstance()->cancel_partial_payment_update( $data, $_POST );
        wp_send_json_success( array( 'content' => $table ) );
    }

    function partial_payment_update() {
        check_ajax_referer('hrm_nonce');
        $data  = $this->edit_query( $_POST['table'], $_POST['id'] );
        $table = HRM_Client::getInstance()->update_partial_payment( $data, $_POST );
        wp_send_json_success( array( 'content' => $table['table'], 'project_id' => $data['project_id'], 'summary' => $table['summary'] ) );
    }

    function get_clients_project() {
        check_ajax_referer('hrm_nonce');
        $client_id = intval( $_POST['client_id'] );
        $projects = HRM_Client::getInstance()->get_projects_by_client( $client_id );

        $projects_id[null] = __( '-Select-', 'hrm' );
        foreach ( $projects->posts as $key => $project ) {
            $projects_id[$project->ID] = $project->post_title;
        }

        $field_obj = array(
            'label'      => __( 'Project', 'hrm' ),
            'type'       => 'select',
            'option'     => $projects_id,
            'selected'   => '',
            'wrap_class' => 'hrm-client-project-dropdown',
            'desc'       => __( 'Chose Project', 'hrm' ),
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field = Hrm_Settings::getInstance()->select_field( 'project_id', $field_obj );

        wp_send_json_success( array( 'field' => $field ) );
    }

    function client_delete() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        if ( !isset( $postdata['hrm_check'] ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'You does not select any item!', 'hrm' ) ) );
        }
        foreach ( $postdata['hrm_check'] as $key => $client_id ) {
            $client_delete = HRM_Client::getInstance()->client_delete( $client_id );
        }

        $page    = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );

        if ( $client_delete ) {
            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'success_msg' => __( 'Deleted successfull', 'hrm' ), 'content' => ob_get_clean() ) );
        } else {
            wp_send_json_error( array(
                'error_msg' => __( 'Failed to deletet client!', 'hrm' ),
            ));
        }
    }

    function client_edit() {
        check_ajax_referer('hrm_nonce');

        $client_id = intval( $_POST['id'] );

        $client = HRM_Client::getInstance()->new_client_form( $client_id );
        wp_send_json_success( array( 'success_msg' => __( 'Updated successfully' ), 'append_data' => $client  ) );
    }

    function new_client() {
        check_ajax_referer('hrm_nonce');
        $post   = array();
        $post   = $_POST;
        $url    = $_POST['url'];
        $client = HRM_Client::getInstance()->new_client( $post );
        if ( isset( $client->errors ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'User name or E-mail already exist', 'hrm' ), 'redirect' => $url ) );
        }

        if ( $client ) {
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;
             wp_send_json_success( array(
                'content' => ob_get_clean(),
                'success_msg' => __( 'Successfully update client', 'hrm' ),
                'redirect' => $url
            ));
        }
    }

    function punch_form_status() {
        check_ajax_referer('hrm_nonce');
        Hrm_Time::getInstance()->punch_form_status( $_POST );
        wp_send_json_success( array( 'success_msg' => __( 'Save changes!', 'hrm' ) ) );
    }

    function hrm_profile_pic_del() {
        check_ajax_referer('hrm_nonce');
        $file_id = (isset( $_POST['file_id'] )) ? intval( $_POST['file_id'] ) : 0;
        $employee_id = (isset( $_POST['employee_id'] )) ? intval( $_POST['employee_id'] ) : 0;
        $content = Hrm_Employee::getInstance()->delete_file( $file_id, true, $employee_id );

        wp_send_json_success(array( 'success_msg' => __( 'Deleted successfull', 'hrm' ), 'content' => $content ) );
    }

    function hrm_search() {
        check_ajax_referer('hrm_nonce');
        $page    = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );
        //$pagenum = $_POST['pagenum'];
        //$limit   = $_POST['limit'];

        ob_start();
            require_once $req_frm;
        wp_send_json_success( array( 'content' => ob_get_clean(), 'redirect' => add_query_arg( array( 'action_search' => 1, 'pagenum' => $pagenum, 'limit' => $limit ), $_POST['redirect'] ) ) );
    }

    function project_search() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;
        $page    = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );

        ob_start();
            require_once $req_frm;
        wp_send_json_success( array( 'content' => ob_get_clean() ) );
    }

    function file_delete() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;
        $page    = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );

        HRM_File::getInstance()->file_delete($post);

        ob_start();
            require_once $req_frm;
        wp_send_json_success( array(  'success_msg' => __( 'Deleted successfull', 'hrm' ), 'content' => ob_get_clean() ) );
    }

    function file_search() {
        check_ajax_referer('hrm_nonce');
        $page    = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );

        if ( empty( $_POST['doc_search'] ) ) {
            unset( $_POST['action'] );
        }
        ob_start();
            require_once $req_frm;
        wp_send_json_success( array( 'content' => ob_get_clean() ) );
    }

    function view_pagination() {
        check_ajax_referer('hrm_nonce');

        $page     = $_REQUEST['page'] = $_POST['page'];
        $tab      = $_POST['tab'];
        $subtab   = $_POST['subtab'];
        $req_frm  = urldecode( $_POST['req_frm'] );
        $_REQUEST['pagenum'] = 1;

        $search   = ( isset( $_POST['search_status'] ) && $_POST['search_status'] ) ? array( 'action_search' => 1 ) : array();
        $limit    = array( 'limit' => $_POST['limit'] );
        $query    = array_merge( $search, $limit );
        $redirect = add_query_arg( $query, $_POST['redirect'] );


        ob_start();
            require_once $req_frm;

        wp_send_json_success( array( 'content' => ob_get_clean(), 'redirect' => $redirect ) );
    }

    function pagination() {
        check_ajax_referer('hrm_nonce');

        $page    = $_REQUEST['page'] = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );

        ob_start();
            require_once $req_frm;
        $content = ob_get_clean();

        $search   = ( isset( $_POST['search_status'] ) && $_POST['search_status'] ) ? array( 'action_search' => 1 ) : array();
        $limit    = array( 'limit' => $_POST['limit'] );
        $pagenum  = array( 'pagenum' => $_POST['pagenum'] );
        $query    = array_merge( $search, $limit, $pagenum );
        $redirect = add_query_arg( $query, $_POST['redirect'] );

        wp_send_json_success( array( 'content' => $content, 'redirect' => $redirect ) );
    }

    function delete_inbox_file() {
        check_ajax_referer('hrm_nonce');

        $file_ids = $_POST['hrm_check'];
        $user_id = $_POST['user_id'];
        HRM_File::getInstance()->delete_inbox_file( $file_ids, $user_id );

        $page    = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );

        ob_start();
            require_once $req_frm;
        wp_send_json_success( array( 'content' => ob_get_clean() ) );
    }

    function edit_file() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;
        $edit_form = HRM_File::getInstance()->file_upload_form( $post );
        wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ), 'append_data' => $edit_form['append_data'], 'tinymce_id' => $edit_form['tinymce_id'] ) );
    }

    function file_upload() {
        check_ajax_referer('hrm_nonce');
        $post = $_POST;
        $content = HRM_File::getInstance()->file_user_set( $post );
        if ( $content ) {
            wp_send_json_success( array( 'success_msg' => __( 'Updated successfully' ), 'content' => $content['content'] ) );
        } else {
            wp_send_json_error( array( 'error_msg' => __( 'No file found!', 'hrm' ) ) );
        }

    }

    function hrm_delete_file() {
        check_ajax_referer('hrm_nonce');

        $file_id = (isset( $_POST['file_id'] )) ? intval( $_POST['file_id'] ) : 0;

        HRM_File::getInstance()->delete_file( $file_id, true );

        wp_send_json_success(array( 'success_msg' => __( 'Deleted successfull', 'hrm' ) ) );
    }

    function ajax_upload() {
        check_ajax_referer('hrm_nonce');
        $response = HRM_File::getInstance()->file_upload();

        if ( $response['success'] ) {
            $file = HRM_File::getInstance()->get_file( $response['file_id'] );

            $delete = sprintf( '<a href="#" data-id="%d" class="hrm-delete-file button">%s</a>', $file['id'], __( 'Delete File', 'hrm' ) );
            $hidden = sprintf( '<input type="hidden" name="hrm_attachment[]" value="%d" />', $file['id'] );
            $file_url = sprintf( '<a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s" /></a>', $file['url'], $file['thumb'], esc_attr( $file['name'] ) );

            $html = '<div class="hrm-uploaded-item">' . $file_url . ' ' . $delete . $hidden . '</div>';
            do_action('cpm_after_ajax_upload', $response, $file, $_POST );
            echo json_encode( array(
                'success' => true,
                'content' => $html
            ) );

            exit;
        }

        echo json_encode( array(
            'success' => false,
            'error' => $response['error']
        ) );

        exit;
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
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'deleted successfully', 'hrm' ) ) );
        } else {
            wp_send_json_error( array( 'error_msg' => __( 'Failed to delete', 'hrm' ) ) );
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
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;
            wp_send_json_success( array(
                'content' => ob_get_clean(),
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
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;
             wp_send_json_success( array(
                'content' => ob_get_clean(),
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
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );
            ob_start();
                require_once $req_frm;
             wp_send_json_success( array(
                'content' => ob_get_clean(),
                'success_msg' => __( 'Successfully update puch', 'hrm' ),
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
        if ( !isset( $postdata['hrm_check'] ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'You does not select any item!', 'hrm' ) ) );
        }
        foreach ( $postdata['hrm_check'] as $key => $porject_id ) {
            $project_delete = Hrm_Admin::getInstance()->project_delete( $porject_id );
            Hrm_Evaluation::getInstance()->parent_rating_delete( $porject_id );
        }

        $page    = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );

        if ( $project_delete ) {
            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'success_msg' => __( 'Deleted successfull', 'hrm' ), 'content' => ob_get_clean() ) );
        } else {
            wp_send_json_error( array(
                'error_msg' => __( 'Failed to deletet employee', 'hrm' ),
            ));
        }

    }

    function delete_employee() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;

        if ( !isset( $postdata['hrm_check'] ) || !is_array( $postdata['hrm_check'] ) ) {
            wp_send_json_error( array(
                'success_msg' => __( 'Failed to deletet employee', 'hrm' ),
            ));
        }
        $delete_user = false;
        if ( hrm_user_can_access( $postdata['tab'], null, 'delete' ) ) {
            $delete_user = hrm_Employee::getInstance()->delete_employee( $postdata['hrm_check'] );
        } else {
           wp_send_json_error( array(
                'error_msg' => __( 'You do not have permission deletet employee', 'hrm' ),
            ));
        }

        if ( $delete_user ) {
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;

            wp_send_json_success( array(
                'content' => ob_get_clean(),
                'success_msg' => __( 'Successfully deletet employee', 'hrm' ),
            ) );
        } else {
            wp_send_json_error( array(
                'error_msg' => __( 'Failed to deletet employee', 'hrm' ),
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
        wp_send_json_success( array('success_msg' => __( 'Update successfull', 'hrm' ), 'append_data' => $data ) );
    }

    function add_employer() {
        check_ajax_referer('hrm_nonce');

        $post = $_POST;
        $url = $_POST['url'];
        $user_id = hrm_Employeelist::getInstance()->add_new_employer( $post );

        if ( isset( $user_id->errors ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'User name or E-mail already exist', 'hrm' ), 'redirect' => $url ) );
        } else {
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Update successfull', 'hrm' ) ) );
        }
    }

    function update_leave_status() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $update = hrm_Leave::getInstance()->update_leave_status( $postdata );
        if ( $update ) {
            wp_send_json_success( array( 'success_msg' => __( 'Successfully update leave status', 'hrm' ) ) );
        } else {
           wp_send_json_error( array( 'error_msg' => __( 'Failed to update leave status', 'hrm' ) ) );
        }
    }

    function new_leave() {
        check_ajax_referer('hrm_nonce');
        $postdata = $_POST;
        $update = hrm_Leave::getInstance()->new_leave( $postdata );
        if ( isset( $update['error_msg'] ) ) {
            wp_send_json_error( array( 'error_msg' => $update['error_msg'] ) );
        }
        if( $update ) {
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );
            /*$_POST['type'] = '_search';
            $_POST['emp_id'] = $_POST['name'];
            $_POST['type_id'] = $_POST['type_id'];*/

            //unset( $_POST['from'], $_POST['to'], $_POST['leave_status'], $_POST['leave_comments'] );

            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Updated successfully', 'hrm' )  ) );
        } else {
            wp_send_json_error( array( 'error_msg' => __( 'Update Failed', 'hrm' ) ) );
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
                'label' => __( 'No user found!', 'hrm'),//'<div class="no-user-wrap"><p>' . __( 'No user found!', 'hrm' ) . '</p> <span class="button-primary">' . __( 'Create a new user?', 'hrm' ) . '</span></div>',
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
            wp_send_json_error( array( 'error_msg' => __( 'Update Failed', 'hrm' ) ) );
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
            $assign = isset( $_POST['assigned'] ) ? $_POST['assigned'] : 0;
            Hrm_Evaluation::getInstance()->new_inserted_task_rating( $_POST['project_id'], $assign );
            $status = false;
        }

        if( $task_id ) {
            $post = get_post($task_id);
            $project_id = $post->post_parent;
            if ( !isset($_POST['assigned']) ) {
                $assign_to = 0;
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

            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );
            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'success_msg' => __( 'Updated successfully' ), 'content' => ob_get_clean() ) );

        } else {
            wp_send_json_error( array( 'error_msg' => __( 'Update Failed', 'hrm' ) ) );
        }
    }

    function edit_project() {
        check_ajax_referer('hrm_nonce');
        $post_id = $_POST['id'];
        $post = get_post( $post_id );
        $data = Hrm_Admin::getInstance()->project_insert_form( $post );
        wp_send_json_success( array( 'success_msg' => __( 'Updated successfully' ), 'append_data' => $data  ) );

    }

    function edit_task() {
        check_ajax_referer('hrm_nonce');
        $post_id = $_POST['id'];
        $post = get_post( $post_id );
        $data = Hrm_Admin::getInstance()->task_form( $post );
        wp_send_json_success(  array( 'success_msg' => __( 'Updated successfully' ),'append_data' => $data ) );

    }

    function edit_sub_task() {
        check_ajax_referer('hrm_nonce');
        $post_id = $_POST['id'];
        $post = get_post( $post_id );
        $data = Hrm_Admin::getInstance()->sub_task_form( $post );
        wp_send_json_success(  array( 'success_msg' => __( 'Updated successfully' ),'append_data' => $data ) );

    }


    function insert_project() {
        check_ajax_referer('hrm_nonce');
        $is_update = ( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ) ? true : false;
        $url = isset( $_POST['url'] ) ? $_POST['url'] : '';
        $data = array(
            'post_title'   => $_POST['title'],
            'post_content' => $_POST['description'],
            'post_type'    => 'hrm_project',
            'post_status'  => 'publish'
        );

        if ( $is_update ) {
            $data['ID'] = $_POST['id'];
            $project_id = wp_update_post( $data );
            $status     = false;
        } else {
            $project_id = wp_insert_post( $data );
            $status = true;
        }

        if( $project_id ) {
            $this->insert_project_user_role( $_POST, $project_id  );
            Hrm_Admin::getInstance()->update_project_meta( $project_id, $_POST );
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'content' => ob_get_clean(), 'project_id' => $project_id, 'task_create_status' => $status, 'dataBreak' => $status, 'success_msg' => __( 'Updated successfully', 'hrm' ) ) );
        } else {
            wp_send_json_error( array('error_msg' => __( 'Update Failed', 'hrm' ) ) );
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
            wp_send_json_error( array( 'error_msg' => __( 'Update Failed', 'hrm' ) ) );
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
        $post = $_POST;
        Hrm_Admin::getInstance()->add_new_employer( $post );
        $page    = $_POST['page'];
        $tab     = $_POST['tab'];
        $subtab  = $_POST['subtab'];
        $req_frm = urldecode( $_POST['req_frm'] );

        ob_start();
            require_once $req_frm;
        wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Update successful', 'hrm' ) ) );
    }

    function user_delete() {
        check_ajax_referer('hrm_nonce');

        if ( isset( $_POST['hrm_check'] ) && is_array( $_POST['hrm_check'] ) && count( $_POST['hrm_check'] ) ) {

            foreach( $_POST['hrm_check'] as $user_id => $value ) {

                $delete_user = wp_delete_user( $user_id );
            }
        }
        if( $delete_user ) {
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Delete user successfully', 'hrm' ) ) );
        } else {
            wp_send_json_error( array( 'error_msg' => __( 'Delete Failed', 'hrm' ) ) );
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
                'label' => '<div class="no-user-wrap"><p>' . __( 'No user found!', 'hrm' ) . '</p> <span class="button-primary">' . __( 'Create a new user?', 'hrm' ) . '</span></div>',
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
            wp_send_json_error( array( 'error_msg' => __('Unknown Error!', 'hrm') ) );
        }
    }

    function new_admin_form_validate( $postdata ) {

        if( empty($postdata['admin_name']) ) {
            return new WP_Error( 'error', __('Username required ', 'hrm' ) );
        }

        if( empty($postdata['admin_email']) ) {
            return new WP_Error( 'error', __('Eamil required', 'hrm' ) );
        }

        if ( ! is_email($postdata['admin_email'] ) ) {
            return new WP_Error( 'error', __('Invalid email', 'hrm' ) );
        }

        if( username_exists( $postdata['admin_name'] ) ) {
            return new WP_Error( 'error', __('Username already exist', 'hrm' ) );
        }

        if( email_exists( $postdata['admin_email']) ) {
            return new WP_Error( 'error', __('Email already exist', 'hrm' ) );
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

    function singel_form_add() {
        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['table_option'] ) && empty( $_POST['table_option'] ) ) {
            wp_send_json_error( array( 'error_msg' => __('Update Failed', 'hrm') ) );
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
            wp_send_json_success( array( 'success_msg' => __( 'Updated Successfully', 'hrm' ) ) );
        } else {
            wp_send_json_error( array( 'error_msg' => __( 'Update Failed', 'hrm' ) ) );
        }
    }

    function delete() {
        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['hrm_check'] ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'Faild to deleted', 'hrm' ) ) );
        }

        if( ! isset( $_POST['table_option'] ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'Faild to deleted', 'hrm' ) ) );
        }

        if ( empty( $_POST['table_option'] ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'Faild to deleted', 'hrm' ) ) );
        }

        if ( !is_array( $_POST['hrm_check'] ) || !count( $_POST['hrm_check'] ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'Faild to deleted', 'hrm' ) ) );
        }

        $table_option = get_option( $_POST['table_option'] );

        global $wpdb;
        $table    = $wpdb->prefix . $table_option['table_name'];
        $users_id = $_POST['hrm_check'];

        foreach( $users_id as $id => $value ) {
            $delete = $wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
        }

        if ( $delete ) {
            $page    = $_POST['page'];
            $tab     = $_POST['tab'];
            $subtab  = $_POST['subtab'];
            $req_frm = urldecode( $_POST['req_frm'] );

            ob_start();
                require_once $req_frm;
            wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Deleted record successfully', 'hrm' ) ) );
        } else {
            wp_send_json_error( array( 'error_msg' => __( 'Failed to delete', 'hrm' ) ) );
        }

    }

    function edit() {
        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['table_option'] ) && empty( $_POST['table_option'] ) ) {
            wp_send_json_error();
        }
        $id                           = isset( $_POST['id'] ) ? $_POST['id'] : '';
        $table_option['table_option'] = array();
        $table_option                 = get_option( $_POST['table_option'] );

        $table     = isset( $table_option['table_name'] ) ? $table_option['table_name'] : '';
        $query_val = $this->edit_query( $table, $id );

        foreach ( $query_val  as $dbfield => $value ) {
            if( ! isset( $table_option['table_option'][$dbfield] ) || empty( $table_option['table_option'][$dbfield] ) ) {
                continue;
            }
            $set_form_field[$table_option['table_option'][$dbfield]] = $value;
        }
        $set_form_field['id'] = $id;

        $class_nam    = isset( $_POST['class_name'] ) ? $_POST['class_name'] : '';
        $function_nam = isset( $_POST['function_name'] ) ? $_POST['function_name'] : '';

        if ( method_exists( $class_nam, 'getInstance' ) ) {
            $data = $class_nam::getInstance()->$function_nam ( $set_form_field );

        } else if ( class_exists( $class_nam ) ) {
            $new_instance = new $class_nam ();
            $data         = $new_instance->$function_nam( $set_form_field );

        } else if ( function_exists( $function_nam ) ) {
            $data = $function_nam ( $set_form_field );
        }

        //$data = $_POST['class_name']::getInstance()->$_POST['function_name'] ( $set_form_field );
        wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ), 'append_data' => $data ) );

    }

    function edit_query( $table, $id ) {
        global $wpdb;
        $table = $wpdb->prefix . $table;
        return $wpdb->get_row("SELECT * FROM $table WHERE id = $id", ARRAY_A );
    }

    function add_new_data() {
        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['table_option'] ) && empty( $_POST['table_option'] ) ) {
            wp_send_json_error( array( 'error_msg'=> __( 'Failed!', 'hrm' ) ) );
        }

        $table_option = get_option( $_POST['table_option'] );

        if( ! is_array( $table_option ) || ! count( $table_option ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'Table option required!', 'hrm' ) ) );
        }

        $id = ( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ) ? $_POST['id'] : '';

        if( ! isset( $table_option['table_name'] ) || empty( $table_option['table_name'] ) ) {
            wp_send_json_error( array( 'error_msg' => __( 'Table name required!', 'hrm' ) ) );
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
            do_action( 'hrm_after_update_new_information', $_POST );

            $query_arg = array();
            if ( isset( $_POST['search_status'] ) && $_POST['search_status']  ) {
               $query_arg =  array_merge( $query_arg, array( 'action_search' => 1 ) );
            }

            if ( isset( $_POST['pagenum'] ) ) {
                $query_arg = array_merge( $query_arg, array( 'pagenum' => $_POST['pagenum'] ) );
            }

            if ( isset( $_POST['limit'] ) ) {
                $query_arg = array_merge( $query_arg, array( 'limit' => $_POST['limit'] ) );
            }

            $redirect = add_query_arg( $query_arg, $_POST['redirect'] );
        } else {
            $update = $wpdb->insert( $table, $data, $format );
            do_action( 'hrm_after_new_information', $_POST, $wpdb->insert_id );
            $redirect = $_POST['redirect'];
            unset( $_REQUEST['limit'] );
            unset( $_REQUEST['pagenum'] );
        }

        if( $update ) {
            ob_start();
                $page    = $_POST['page'];
                $tab     = $_POST['tab'];
                $subtab  = $_POST['subtab'];
                $req_frm = urldecode( $_POST['req_frm'] );

                    require_once $req_frm;
            do_action( 'hrm_after_save_data', $update, $update_status, $table_option['table_name'], $_POST );
            $content = ob_get_clean();
            wp_send_json_success(  array( 'content'=> $content, 'redirect' => $redirect, 'success_msg' => __( 'Updated successfully', 'hrm' )) );
        } else {
            wp_send_json_error( array( 'error_msg' => __( 'Failed!', 'hrm' ) ) );
        }
    }
}

