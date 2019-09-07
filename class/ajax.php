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
        //add_action( 'wp_ajax_single_form', array( $this, 'singel_form_add' ) );
        add_action( 'wp_ajax_update_general_info', array( $this, 'update_general_info' ) );
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
    

    function update_general_info() {
        check_ajax_referer('hrm_nonce');
        
        if ( hrm_current_user_role() != hrm_manager_role_key() && !hrm_is_current_user_administrator() ) {
            wp_send_json_error( array( 'success_msg' => __( 'Something went wrong!', 'hrm' ) ) );
        }
        update_option( 'organization_name', hrm_clean( $_POST['organization_name'] ) );
        update_option( 'tax_id', hrm_clean( $_POST['tax_id'] ) );
        update_option( 'registration_number', hrm_clean( $_POST['registration_number'] ) );
        update_option( 'phone', hrm_clean( $_POST['phone'] ) );
        update_option( 'fax', hrm_clean( $_POST['fax'] ) );
        update_option( 'addres_street_1', hrm_clean( $_POST['addres_street_1'] ) );
        update_option( 'address_street_2', hrm_clean( $_POST['address_street_2'] ) );
        update_option( 'city', hrm_clean( $_POST['city'] ) );
        update_option( 'state_province', hrm_clean( $_POST['state_province'] ) );
        update_option( 'zip', hrm_clean( $_POST['zip'] ) );
        update_option( 'country', hrm_clean( $_POST['country'] ) );
        update_option( 'note', hrm_clean( $_POST['note'] ) );

        wp_send_json_success( array( 'success_msg' => __( 'Updated Successfully', 'hrm' ) ) );
    }

    function user_can() {
        check_ajax_referer('hrm_nonce');
        
        $user_id = intval( $_POST['user_id'] );
        $cap = hrm_clean( $_POST['cap'] );

        wp_send_json_success( hrm_user_can( $cap, $user_id ) );
    }

    function punch_form_status() {
        check_ajax_referer('hrm_nonce');

        $postdata = [
            'status' => hrm_clean( $_POST['status'] ),
        ];
        
        Hrm_Time::getInstance()->punch_form_status( $postdata );
        wp_send_json_success( array( 'success_msg' => __( 'Save changes!', 'hrm' ) ) );
    }

    function hrm_profile_pic_del() {
        check_ajax_referer('hrm_nonce');
        
        $file_id     = isset( $_POST['file_id'] ) ? intval( $_POST['file_id'] ) : 0;
        $employee_id = isset( $_POST['employee_id'] ) ? intval( $_POST['employee_id'] ) : 0;
        $content     = Hrm_Employee::getInstance()->delete_file( $file_id, true, $employee_id );

        wp_send_json_success(array( 'success_msg' => __( 'Deleted successfull', 'hrm' ), 'content' => $content ) );
    }

    function hrm_delete_file() {
        check_ajax_referer('hrm_nonce');
        
        $file_id = isset( $_POST['file_id'] ) ? intval( $_POST['file_id'] ) : 0;

        HRM_File::getInstance()->delete_file( $file_id, true );

        wp_send_json_success(array( 'success_msg' => __( 'Deleted successfull', 'hrm' ) ) );
    }

    function get_organization_info() {
        $info          = [
            'organization_name'   => get_option( 'organization_name' ),
            'tax_id'              => get_option( 'tax_id' ),
            'registration_number' => get_option( 'registration_number' ),
            'phone'               => get_option( 'phone' ),
            'fax'                 => get_option( 'fax' ),
            'addres_street_1'     => get_option( 'addres_street_1' ),
            'address_street_2'    => get_option( 'address_street_2' ),
            'city'                => get_option( 'city' ),
            'state_province'      => get_option( 'state_province' ),
            'zip'                 => get_option( 'zip' ),
            'country'             => get_option( 'country' ),
            'note'                => get_option( 'note' ),
        ];

        $country_lists = hrm_Settings::getInstance()->country_list();
        $lists         = [];
        
        foreach ( $country_lists as $key => $value ) {
            $lists[] = ['iso' => $key, 'country' => $value];
        }
        wp_send_json_success( [ 
            'data'      => empty( $info ) ? [] : $info,
            'countries' => $lists,
        ] );
    }

}

