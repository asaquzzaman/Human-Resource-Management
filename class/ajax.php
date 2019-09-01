<?php
class Hrm_Ajax {
    private static $instance;

    public static $crud;

    public static function getInstance() {
        if( ! self::$instance ) {
            self::$instance = new hrm_Ajax();
        }

        return self::$instance;
    }

    function __construct() {
        add_action( 'init', array( $this, 'action' ), 11 );
    }

    function action() {
        self::$crud = new HRM\Core\Crud\Crud();

        add_action( 'wp_ajax_ajax_referer_insert', array( $this, 'add_new_data' ) );
        add_action( 'wp_ajax_hrm_form_edit', array( $this, 'edit' ) );
        add_action( 'wp_ajax_single_form', array( $this, 'singel_form_add' ) );
        add_action( 'wp_ajax_hrm_get_organigation_info', array( $this, 'get_organization_info' ) );
        add_action( 'wp_ajax_hrm_delete', array( $this, 'delete' ) );
        add_action( 'wp_ajax_hrm_autocomplete', array( $this, 'hrm_autocomplete_action' ) );
        add_action( 'wp_ajax_user_create', array( $this, 'create_user' ) );
        add_action( 'wp_ajax_search_users', array( $this, 'search_users' ) );
        add_action( 'wp_ajax_search_emp_leave_records', array( 'Hrm_Leave', 'search_emp_leave_records' ) );
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
        add_action( 'wp_ajax_change_status', array( $this, 'update_status' ) );
        add_action( 'wp_ajax_new_employer', array( $this, 'add_employer' ) );
        add_action( 'wp_ajax_employer_edit', array( $this, 'edit_employer' ) );
        add_action( 'wp_ajax_update_my_info', array( $this, 'edit_my_info' ) );

        add_action( 'wp_ajax_project_worker', array( $this, 'find_project_worker' ) );
        add_action( 'wp_ajax_tast_complete', array( $this, 'complete_task' ) );
        add_action( 'wp_ajax_tast_incomplete', array( $this, 'incomplete_task' ) );
        add_action( 'wp_ajax_employee_delete', array( $this, 'delete_employee' ) );
        add_action( 'wp_ajax_delete_project', array( $this, 'project_delete' ) );
        add_action( 'wp_ajax_change_admin_status', array( $this, 'change_admin_status' ) );
        
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
        
        add_action( 'wp_ajax_create_new_department', array( 'Hrm_Admin', 'ajax_update_department' ) );
        add_action( 'wp_ajax_get_departments', array( 'Hrm_Admin', 'ajax_get_departments' ) );
        add_action( 'wp_ajax_delete_department', array( 'Hrm_Admin', 'ajax_delete_department' ) );

        //add_action( 'wp_ajax_punch_in', array( 'Hrm_Attendance', 'ajax_punch_in' ) );
        
        add_action( 'wp_ajax_punch_out', array( 'Hrm_Attendance', 'ajax_punch_out' ) );
        add_action( 'wp_ajax_get_attendance', array( 'Hrm_Attendance', 'ajax_get_attendance' ) );
        add_action( 'wp_ajax_attendance_configuration', array( 'Hrm_Attendance', 'ajax_attendance_configuration' ) );
        add_action( 'wp_ajax_leave_header', array( 'Hrm_Leave', 'ajax_leave_header' ) );
        add_action( 'wp_ajax_create_new_leave_type', array( 'Hrm_Leave', 'ajax_create_new_leave_type' ) );
        add_action( 'wp_ajax_get_leave_type', array( 'Hrm_Leave', 'ajax_get_leave_type' ) );
        add_action( 'wp_ajax_create_new_holidays', array( 'Hrm_Leave', 'ajax_create_new_holidays' ) );
        add_action( 'wp_ajax_get_holidays', array( 'Hrm_Leave', 'ajax_get_holidays' ) );
        add_action( 'wp_ajax_delete_holiday', array( 'Hrm_Leave', 'ajax_delete_holiday' ) );
        add_action( 'wp_ajax_save_work_week', array( 'Hrm_Leave', 'ajax_save_work_week' ) );
        add_action( 'wp_ajax_get_work_week', array( 'Hrm_Leave', 'ajax_get_work_week' ) );
        add_action( 'wp_ajax_get_leave_records_init_data', array( 'Hrm_Leave', 'get_leave_records_init_data' ) );
        add_action( 'wp_ajax_get_leave_record_events', array( 'Hrm_Leave', 'ajax_get_leave_record_events' ) );
        //array( 'Hrm_Leave', 'update_leave' )
        
        add_action( 'wp_ajax_create_new_leave', array( 'Hrm_Leave', 'ajax_create_new_leave' ) );
        add_action( 'wp_ajax_get_leave_form_settings', array( 'Hrm_Leave', 'ajax_get_leave_form_settings' ) );
        add_action( 'wp_ajax_save_leave_form_settings', array( 'Hrm_Leave', 'ajax_save_leave_form_settings' ) );
        add_action( 'wp_ajax_update_leave', array( 'Hrm_Leave', 'ajax_update_leave' ) );
        add_action( 'wp_ajax_delete_leave', array( 'Hrm_Leave', 'ajax_delete_leave' ) );
        add_action( 'wp_ajax_update_settings', array( 'Hrm_Settings', 'ajax_update_settings' ) );
        add_action( 'wp_ajax_hrm_email_settings', array( 'Hrm_Settings', 'hrm_email_settings' ) );
        add_action( 'wp_ajax_delete_leave_type', array( 'Hrm_Leave', 'ajax_delete_leave_type' ) );
        add_action( 'wp_ajax_hrm_user_can', array( $this, 'user_can' ) );
        add_action( 'wp_ajax_get_employee_leave_summery', array( 'Hrm_Leave', 'ajax_get_employee_leave_summery' ) );
        add_action( 'wp_ajax_get_employee_dropdown', array( 'Hrm_Leave', 'ajax_get_employee_dropdown' ) );

        add_action( 'wp_ajax_hrm_insert_record', 'hrm_ajax_insert_records' );
        add_action( 'wp_ajax_hrm_update_record', 'hrm_ajax_update_records' );
        add_action( 'wp_ajax_hrm_get_records', 'hrm_ajax_get_records' );
        add_action( 'wp_ajax_hrm_delete_record', 'hrm_ajax_delete_records' );
    }

    
    function singel_form_add() {
        check_ajax_referer('hrm_nonce');
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

    function user_can() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        
        $user_id = intval( $post['user_id'] );
        $cap = $post['cap'];

        wp_send_json_success( hrm_user_can( $cap, $user_id ) );
    }

    function punch_form_status() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        Hrm_Time::getInstance()->punch_form_status( $POST );
        wp_send_json_success( array( 'success_msg' => __( 'Save changes!', 'hrm' ) ) );
    }

    function hrm_profile_pic_del() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        $file_id = (isset( $POST['file_id'] )) ? intval( $POST['file_id'] ) : 0;
        $employee_id = (isset( $POST['employee_id'] )) ? intval( $POST['employee_id'] ) : 0;
        $content = Hrm_Employee::getInstance()->delete_file( $file_id, true, $employee_id );

        wp_send_json_success(array( 'success_msg' => __( 'Deleted successfull', 'hrm' ), 'content' => $content ) );
    }

    // function edit_file() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $post = $POST;
    //     $edit_form = HRM_File::getInstance()->file_upload_form( $post );
    //     wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ), 'append_data' => $edit_form['append_data'], 'tinymce_id' => $edit_form['tinymce_id'] ) );
    // }

    // function file_upload() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $post = $POST;
    //     $content = HRM_File::getInstance()->file_user_set( $post );
    //     if ( $content ) {
    //         wp_send_json_success( array( 'success_msg' => __( 'Updated successfully' ), 'content' => $content['content'] ) );
    //     } else {
    //         wp_send_json_error( array( 'error_msg' => __( 'No file found!', 'hrm' ) ) );
    //     }

    // }

    function hrm_delete_file() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );

        $file_id = (isset( $POST['file_id'] )) ? intval( $POST['file_id'] ) : 0;

        HRM_File::getInstance()->delete_file( $file_id, true );

        wp_send_json_success(array( 'success_msg' => __( 'Deleted successfull', 'hrm' ) ) );
    }

    // function single_tab_user_role() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $post = $POST;
    //     hrm_single_tab_user_role_change( $post );
    // }

    // function time_editable() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $post = $POST;

    //     $edit_form = Hrm_Time::getInstance()->generate_edit_form( $post );
    //     wp_send_json_success( array( 'content' => $edit_form ) );
    // }

    // function change_admin_status() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $user_id = intval( $POST['user_id'] );
    //     $status = sanitize_text_field( $POST['status'] );
    //     $changed = Hrm_Admin::getInstance()->change_admin_status( $user_id, $status );

    //     if ( $changed ) {
    //         wp_send_json_success();
    //     } else {
    //         wp_send_json_error();
    //     }
    // }

    // function edit_my_info() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $postdata = $POST;
    //     $table_option = get_option( $postdata['table_option'] );
    //     $user_id = hrm_employee::getInstance()->edit_my_info( $postdata, $table_option );
    //     if ( $user_id ) {
    //         wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ) ) );
    //     } else {
    //         wp_send_json_error();
    //     }
    // }

    // function edit_employer() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $id = $POST['id'];
    //     $user = get_user_by( 'id', $id );
    //     $data = hrm_Employeelist::getInstance()->new_employee_form( $user );
    //     wp_send_json_success( array('success_msg' => __( 'Update successfull', 'hrm' ), 'append_data' => $data ) );
    // }

    // function add_employer() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );

    //     $post = $POST;
    //     $url = $POST['url'];
    //     $user_id = hrm_Employeelist::getInstance()->add_new_employer( $post );

    //     if ( isset( $user_id->errors ) ) {
    //         wp_send_json_error( array( 'error_msg' => __( 'User name or E-mail already exist', 'hrm' ), 'redirect' => $url ) );
    //     } else {
    //         $page    = $POST['page'];
    //         $tab     = $POST['tab'];
    //         $subtab  = $POST['subtab'];
    //         $req_frm = urldecode( $POST['req_frm'] );

    //         ob_start();
    //             require_once $req_frm;
    //         wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Update successfull', 'hrm' ) ) );
    //     }
    // }

    // function update_status() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $postdata = $POST;
    //     $update = hrm_Leave::getInstance()->update_status( $postdata );
    //     if ( $update ) {
    //         wp_send_json_success( array( 'success_msg' => __( 'Successfully update leave status', 'hrm' ) ) );
    //     } else {
    //        wp_send_json_error( array( 'error_msg' => __( 'Failed to update leave status', 'hrm' ) ) );
    //     }
    // }

    // function new_leave() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $postdata = $POST;
    //     $update = hrm_Leave::getInstance()->new_leave( $postdata );
    //     if ( isset( $update['error_msg'] ) ) {
    //         wp_send_json_error( array( 'error_msg' => $update['error_msg'] ) );
    //     }
    //     if( $update ) {
    //         $page    = $POST['page'];
    //         $tab     = $POST['tab'];
    //         $subtab  = $POST['subtab'];
    //         $req_frm = urldecode( $POST['req_frm'] );
            /*$POST['type'] = '_search';
            $POST['emp_id'] = $POST['name'];
            $POST['type_id'] = $POST['type_id'];*/

            //unset( $POST['from'], $POST['to'], $POST['status'], $POST['comments'] );

    //         ob_start();
    //             require_once $req_frm;
    //         wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Updated successfully', 'hrm' )  ) );
    //     } else {
    //         wp_send_json_error( array( 'error_msg' => __( 'Update Failed', 'hrm' ) ) );
    //     }
    // }

    // function find_project_worker() {
    //     $users = get_users( array(
    //         'search' => '*' . $POST['search_admin'] . '*',
    //         'search_columns' => array( 'user_login', 'user_email', 'nicename' ),
    //     ) );
    //     $data = array();
    //     foreach( $users as $user) {
    //         $data[] = array(
    //             'label' => $user->display_name,
    //             '_user_meta' => Hrm_Admin::getInstance()->project_user_meta( $user->display_name, $user->ID, $user ),
    //         );
    //     }
    //     if( count($data) ) {
    //         $user_info = json_encode( $data );
    //     } else {
    //         $data[] = array(
    //             'label' => __( 'No user found!', 'hrm'),//'<div class="no-user-wrap"><p>' . __( 'No user found!', 'hrm' ) . '</p> <span class="button-primary">' . __( 'Create a new user?', 'hrm' ) . '</span></div>',
    //             'value' => 'hrm_create_user',
    //             '_user_meta' =>'',
    //         );
    //         $user_info = json_encode( $data );
    //     }

    //     wp_send_json_success( $user_info );
    // }

    // function insert_user( $project_id, $user_id, $role ) {
    //     global $wpdb;
    //     $table = $wpdb->prefix . 'hrm_user_role';
    //     $data = array(
    //         'project_id' => $project_id,
    //         'user_id' => $user_id,
    //         'role' => $role,
    //     );
    //     $format = array( '%d', '%d', '%s' );
    //     $wpdb->insert( $table, $data, $format );
    // }

    // function skill_add() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $id = isset( $POST['id'] ) ? $POST['id'] : '';
    //     global $wpdb;
    //     $table = $wpdb->prefix . 'skill';

    //     $user_name = isset( $POST['user_name'] ) ? $POST['user_name'] : '';

    //     $url = $POST['url'];

    //     if( ! empty( $id ) ) {
    //         $data = array(
    //             'description' => $POST['skill_desc'],
    //         );
    //         $format = array( '%s');
    //         $update = $wpdb->update( $table, $data, array( 'id' => $id ), $format );
    //     } else {
    //         $results = $wpdb->get_results("SELECT id FROM " . $wpdb->prefix . "skill", ARRAY_A );
    //         $results = wp_list_pluck( $results, 'id' );

    //         foreach ( $POST['user_id'] as $key => $id ) {

    //             if ( in_array( $id, $results ) ) {
    //                 $update = true;
    //                 continue;
    //             }

    //             $data = array(
    //                 'id' => $id,
    //                 'name' => $user_name[$key],
    //                 'description' => $POST['skill_desc'],
    //             );
    //             $format = array( '%d', '%s', '%s');

    //             $update = $wpdb->insert( $table, $data, $format );
    //         }

    //     }

    //     if( $update ) {
    //         wp_send_json_success( array( 'success_msg' => __( 'Update successfull', 'hrm' ), 'redirect' => $url ) );
    //     } else {
    //         wp_send_json_error( array( 'error_msg' => __( 'Update Failed', 'hrm' ) ) );
    //     }
    // }

    // function user_role_edit_form_prepare() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $data = $POST['class_name']::getInstance()->$POST['function_name'] ( $POST['id'] );

    //     wp_send_json_success( array( 'append_data' => $data ) );
    // }

    // function user_role_update() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $post = $POST;
    //     Hrm_Admin::getInstance()->add_new_employer( $post );
    //     $page    = $POST['page'];
    //     $tab     = $POST['tab'];
    //     $subtab  = $POST['subtab'];
    //     $req_frm = urldecode( $POST['req_frm'] );

    //     ob_start();
    //         require_once $req_frm;
    //     wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Update successful', 'hrm' ) ) );
    // }

    // function user_delete() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );

    //     if ( isset( $POST['hrm_check'] ) && is_array( $POST['hrm_check'] ) && count( $POST['hrm_check'] ) ) {

    //         foreach( $POST['hrm_check'] as $user_id => $value ) {

    //             $delete_user = wp_delete_user( $user_id );
    //         }
    //     }
    //     if( $delete_user ) {
    //         $page    = $POST['page'];
    //         $tab     = $POST['tab'];
    //         $subtab  = $POST['subtab'];
    //         $req_frm = urldecode( $POST['req_frm'] );

    //         ob_start();
    //             require_once $req_frm;
    //         wp_send_json_success( array( 'content' => ob_get_clean(), 'success_msg' => __( 'Delete user successfully', 'hrm' ) ) );
    //     } else {
    //         wp_send_json_error( array( 'error_msg' => __( 'Delete Failed', 'hrm' ) ) );
    //     }

    // }

    // function get_user_role() {

    //     $data = $POST['class_name']::getInstance()->$POST['function_name'] ( $POST['role_name'], $POST['display_name'] );

    //     wp_send_json_success( array( 'append_data' => $data ) );
    // }

    // function search_users() {
    //     check_ajax_referer('hrm_nonce');
    //     $POST = wp_unslash( $_POST );
    //     $send = [];
    //     $users = get_users( array(
    //         'search' => '*' . $POST['user'] . '*',
    //         'search_columns' => array( 'user_login', 'user_email', 'nicename' ),
    //     ));
        
    //     foreach( $users as $user ) {
    //         $send[] = $user->data;
    //     }
        
    //     wp_send_json_success( $send );
    // }



    // function create_user() {

    //     parse_str( $POST['data'], $postdata );

    //     $validate = $this->new_admin_form_validate( $postdata );

    //     if ( is_wp_error( $validate ) ) {
    //         wp_send_json_error( $validate->errors['error'][0] );
    //     }

    //     $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
    //     $first_name = sanitize_text_field( $postdata['first_name'] );
    //     $last_name = sanitize_text_field( $postdata['last_name'] );
    //     $display_name = $first_name .' '. $last_name;

    //     $userdata = array(
    //         'user_login'   => $postdata['admin_name'],
    //         'user_pass'    =>  $random_password,
    //         'user_email'   => $postdata['admin_email'],
    //         'first_name'   => $first_name,
    //         'last_name'    => $last_name,
    //         'display_name' => $display_name,
    //     );

    //     $user_id = wp_insert_user( $userdata );

    //     if( $user_id ) {
    //         update_user_meta( $user_id, '_user_flag', 1 );
    //         update_user_meta( $user_id, 'first_name', $first_name );
    //         update_user_meta( $user_id, 'last_name', $last_name );
    //         update_user_meta( $user_id, 'hrm_admin_level', 'admin' );

    //         wp_new_user_notification( $user_id, $random_password );

    //         $user_meta = Hrm_Admin::getInstance()->create_user_meta( $display_name, $user_id );
    //         wp_send_json_success( array(
    //             'success_msg' => __('Create admin successfull', 'hrm'),
    //              '_user_meta' => $user_meta,
    //         ));
    //     } else {
    //         wp_send_json_error( array( 'error_msg' => __('Unknown Error!', 'hrm') ) );
    //     }
    // }

    // function new_admin_form_validate( $postdata ) {

    //     if( empty($postdata['admin_name']) ) {
    //         return new WP_Error( 'error', __('Username required ', 'hrm' ) );
    //     }

    //     if( empty($postdata['admin_email']) ) {
    //         return new WP_Error( 'error', __('Eamil required', 'hrm' ) );
    //     }

    //     if ( ! is_email($postdata['admin_email'] ) ) {
    //         return new WP_Error( 'error', __('Invalid email', 'hrm' ) );
    //     }

    //     if( username_exists( $postdata['admin_name'] ) ) {
    //         return new WP_Error( 'error', __('Username already exist', 'hrm' ) );
    //     }

    //     if( email_exists( $postdata['admin_email']) ) {
    //         return new WP_Error( 'error', __('Email already exist', 'hrm' ) );
    //     }

    //     return true;
    // }

    // function hrm_autocomplete_action() {

    //     if( ! isset( $POST['table_option'] ) && empty( $POST['table_option'] ) ) {
    //         wp_send_json_error( __( 'Error occured', 'hrm' ) );
    //     }
    //     $table_option['table_option'] = array();
    //     $table_option = get_option( $POST['table_option'] );

    //     $search_field = $POST['search_field'];
    //     $search_value = trim( $POST['search_value'] );
    //     $where = $search_field .' LIKE ' ."'%".$search_value."%'";

    //     global $wpdb;
    //     $tabledb = $wpdb->prefix . $table_option['table_name'];

    //     $results = $wpdb->get_results("SELECT id, $search_field FROM $tabledb WHERE $where ORDER BY id DESC");

    //     if( $results ) {
    //         foreach ($results as $key => $value) {
    //             $data[] = array(
    //                 'label' => $value->$search_field,
    //                 'value' => $value->$search_field,
    //                 'id' => $value->id
    //             );
    //         }
    //     } else {
    //         wp_send_json_error( __( 'Error occured', 'hrm' ) );
    //     }

    //     $user_info = json_encode( $data );
    //     wp_send_json_success( $user_info );
    // }


    function get_organization_info(){
        $info          = get_option( 'hrm_general_info', array() );
        $country_lists = hrm_Settings::getInstance()->country_list();
        $lists         = [];
        
        foreach ( $country_lists as $key => $value ) {
            $lists[] = ['iso' => $key, 'country' => $value];
        }
        wp_send_json_success( [ 
            'data'      => empty( $info['data'] ) ? [] : $info['data'],
            'countries' => $lists,
        ] );
    }

    // function edit_query( $table, $id ) {
    //     global $wpdb;
    //     $table = $wpdb->prefix . $table;
    //     return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %d", $id ), ARRAY_A );
    // }
}

