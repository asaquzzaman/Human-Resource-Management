<?php

class Hrm_Scripts {
	private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new Hrm_Scripts();
        }

        return self::$_instance;
    }

    public static function get_sub_tab() {
    	$query_args = hrm_get_query_args();

		$tab     = $query_args['tab'];
		$sub_tab = $query_args['subtab'] ? $query_args['subtab'] : $tab;

		return $sub_tab;
    }

    public static function admin() {
    	$sub_tab = self::get_sub_tab();

		switch ( $sub_tab ) {
			case 'department':
				self::department();
				break;
			
			default:
				self::admin_default();
				break;
		}
    }

    public static function admin_localize($key) {
        wp_localize_script( $key, 'HRM_Admin', array(
            'ajax_url'    => admin_url( 'admin-ajax.php' ),
            'nonce'       => wp_create_nonce( 'hrm_nonce' ),
            'message'     => hrm_message(),
            'confirm_msg' => __( 'Are you sure!', 'hrm'),
            'success_msg' => __( 'Changed Successfully', 'hrm' )
        ));
    }

    public static function department() {
        self::admin_default();
    	wp_enqueue_script( 'hrm-vue' );
        wp_enqueue_script( 'hrm-vuex' );
        wp_enqueue_script( 'hrm-vue-router' );
        self::admin_localize( 'hrm-vue' );
        wp_enqueue_script( 'hrm-root-mixin' );
        
        wp_enqueue_script( 'hrm-department-edit-btn', HRM_URL . '/asset/js/components/department/department-edit-btn.js', array(), false, true);
        wp_enqueue_script( 'hrm-department-add-btn', HRM_URL . '/asset/js/components/department/department-add-btn.js', array(), false, true);
        wp_enqueue_script( 'hrm-department-del-btn', HRM_URL . '/asset/js/components/department/department-del-btn.js', array(), false, true);
        wp_enqueue_script( 'hrm-department-search', HRM_URL . '/asset/js/components/department/department-search.js', array(), false, true);
        wp_enqueue_script( 'hrm-department-paginate-drop-dwon', HRM_URL . '/asset/js/components/department/department-paginate-drop-down.js', array(), false, true);
        wp_enqueue_script( 'hrm-department-table', HRM_URL . '/asset/js/components/department/department-table.js', array(), false, true);
        wp_enqueue_script( 'hrm-department-pagination', HRM_URL . '/asset/js/components/department/department-pagination.js', array(), false, true);
        wp_enqueue_script( 'hrm-new-department-form', HRM_URL . '/asset/js/components/department/new-department-form.js', array(), false, true);
        
        wp_enqueue_script( 'hrm-admin-vue-store' );
        wp_enqueue_script( 'hrm-admin-vue' );
        wp_enqueue_style( 'hrm-admin', HRM_URL . '/asset/css/admin.css', false, false, 'all' );
    }

    public static function admin_default() {
    	global $hrm_is_admin;

    	wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_script( 'jquery-ui-autocomplete');
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'hrm_chosen', HRM_URL . '/asset/js/chosen.jquery.min.js', array( 'jquery' ), false, true);
        wp_enqueue_script( 'hrm_datetimepicker', HRM_URL . '/asset/js/jquery-ui-timepicker.js', array( 'jquery' ), false, true);
        wp_enqueue_script( 'hrm-jquery.dataTables', HRM_URL . '/asset/js/jquery.dataTables.min.js', array( 'jquery' ), false, true);
        wp_enqueue_script( 'hrm_admin', HRM_URL . '/asset/js/hrm.js', array( 'jquery' ), false, true);

        wp_localize_script( 'hrm_admin', 'hrm_ajax_data', array(
            'ajax_url'    => admin_url( 'admin-ajax.php' ),
            'nonce'       => wp_create_nonce( 'hrm_nonce' ),
            'is_admin'    => $hrm_is_admin,
            'message'     => hrm_message(),
            'confirm_msg' => __( 'Are you sure!', 'hrm'),
            'success_msg' => __( 'Changed Successfully', 'hrm' )
        ));

        //wp_enqueue_style( 'hrm-jquery.dataTables-style', HRM_URL . '/asset/css/jquery.dataTables.css', false, false, 'all' );
        //wp_enqueue_style( 'hrm-jquery.dataTables_themeroller', HRM_URL . '/asset/css/jquery.dataTables_themeroller.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-admin', HRM_URL . '/asset/css/admin.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-chosen', HRM_URL . '/asset/css/chosen.min.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui', HRM_URL . '/asset/css/jquery-ui.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui-timepicker', HRM_URL . '/asset/css/jquery-ui-timepicker-addon.css', false, false, 'all' );
    }

    /**
     * Attendance scripts
     * 
     * @return void
     */
    public static function attendance_scripts() {
        self::admin_default();
        self::admin_localize( 'hrm-vue' );

        wp_enqueue_script( 'hrm-attendance-vue-store', HRM_URL . '/asset/js/components/attendance/attendance-store.js', array(), false, true );
        wp_enqueue_script( 'hrm-attendance-header', HRM_URL . '/asset/js/components/attendance/attendance-header.js', array(), false, true);
        wp_enqueue_script( 'hrm-attendance-punch-in-out-btn', HRM_URL . '/asset/js/components/attendance/attendance-punch-in-out-btn.js', array(), false, true);
        wp_enqueue_script( 'hrm-attendance-user-search', HRM_URL . '/asset/js/components/attendance/attendance-user-search.js', array(), false, true);
        wp_enqueue_script( 'hrm-attendance-records', HRM_URL . '/asset/js/components/attendance/attendance-records.js', array(), false, true);
        wp_enqueue_script( 'hrm-attendance-configuration', HRM_URL . '/asset/js/components/attendance/attendance-configuration.js', array(), false, true);

        wp_enqueue_script( 'hrm-attendance-router', HRM_URL . '/asset/js/components/attendance/attendance-router.js', array(), false, true );
        wp_enqueue_script( 'hrm-attendance-vue', HRM_URL . '/asset/js/components/attendance/attendance.js', array(), false, true );

        wp_enqueue_style( 'hrm-admin', HRM_URL . '/asset/css/admin.css', false, false, 'all' );

        self::hrm_vue_scripts();
    }

    /**
     * Leave scripts
     * 
     * @return void
     */
    public static function leave_scripts() {

        self::admin_default();

        wp_enqueue_script( 'hrm-leave-vue-store', HRM_URL . '/asset/js/components/leave/leave-store.js', array(), false, true );
        wp_enqueue_script( 'hrm-leave-header', HRM_URL . '/asset/js/components/leave/leave-header.js', array(), false, true);
        wp_enqueue_script( 'hrm-vue-multi', HRM_URL . '/asset/js/components/leave/leave-header.js', array(), false, true);

        wp_enqueue_script( 'hrm-vue-multiselect' );

        wp_enqueue_script( 'hrm-leave-records-form', HRM_URL . '/asset/js/components/leave/leave-records-form.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-records-add-btn', HRM_URL . '/asset/js/components/leave/leave-records-add-btn.js', array(), false, true);

        wp_enqueue_script( 'hrm-leave-holidays-add-btn', HRM_URL . '/asset/js/components/leave/leave-holidays-add-btn.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-holidays-form', HRM_URL . '/asset/js/components/leave/leave-holidays-form.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-holidays-record', HRM_URL . '/asset/js/components/leave/leave-holidays-record.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-holidays', HRM_URL . '/asset/js/components/leave/leave-holidays.js', array(), false, true);

        wp_enqueue_script( 'hrm-leave-type-add-btn', HRM_URL . '/asset/js/components/leave/leave-type-add-btn.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-type-form', HRM_URL . '/asset/js/components/leave/leave-type-form.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-type-records', HRM_URL . '/asset/js/components/leave/leave-type-records.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-type', HRM_URL . '/asset/js/components/leave/leave-type.js', array(), false, true);
        
        wp_enqueue_script( 'hrm-leave-work-week', HRM_URL . '/asset/js/components/leave/leave-work-week.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-records', HRM_URL . '/asset/js/components/leave/leave-records.js', array(), false, true);
        wp_enqueue_script( 'hrm-leave-configuration', HRM_URL . '/asset/js/components/leave/leave-configuration.js', array(), false, true);

        wp_enqueue_script( 'hrm-leave-router', HRM_URL . '/asset/js/components/leave/leave-router.js', array(), false, true );
        wp_enqueue_script( 'hrm-leave-vue', HRM_URL . '/asset/js/components/leave/leave.js', array(), false, true );
        wp_enqueue_style( 'hrm-admin', HRM_URL . '/asset/css/admin.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-vue-multiselect' );

        self::hrm_vue_scripts();
    }

    /**
     * Common scripts
     * 
     * @return void
     */
    public static function hrm_vue_scripts() {

        wp_enqueue_script( 'hrm-directive', HRM_URL . '/asset/js/hrm-directive.js', array(), time(), true);
        wp_enqueue_script( 'hrm-root-vue', HRM_URL . '/asset/js/hrm-vue.js', false, time(), true);
    }

    /**
     * Header scripts
     * 
     * @return void
     */
    public static function init_scripts() {
        wp_enqueue_media();
        wp_enqueue_script( 'hrm-toastr', HRM_URL . '/asset/js/toastr/toastr.min.js', array(), time(), true );
        
        wp_enqueue_script( 'hrm-vue', HRM_URL . '/asset/js/vue/vue.js', array( 'jquery' ), time(), true );
        wp_enqueue_script( 'hrm-vuex', HRM_URL . '/asset/js/vue/vuex.js', array( 
            'jquery',
            'hrm-vue', 
        ), time(), true );

        wp_enqueue_script( 'hrm-vue-router', HRM_URL . '/asset/js/vue/vue-router.js', array( 
            'jquery',
            'hrm-vue',
        ), time(), true );

        //Should be loaded inside the hader tag
        wp_enqueue_script( 'hrm-root-router', HRM_URL . '/asset/js/hrm-router.js', array(), time(), false );
        wp_enqueue_script( 'hrm-root-mixin', HRM_URL . '/asset/js/hrm-mixin.js', array(), time(), false );
        wp_enqueue_script( 'hrm-root-store', HRM_URL . '/asset/js/hrm-store.js', array(), time(), false );

        wp_register_script( 'hrm-vue-multiselect', HRM_URL . '/asset/js/vue-multiselect/vue-multiselect.min.js', array(), time(), true );
        

        wp_register_script( 'hrm-admin-vue-store', HRM_URL . '/asset/js/admin/admin-vue-store.js', array(), time(), true );
        wp_register_script( 'hrm-admin-vue', HRM_URL . '/asset/js/admin/admin-vue.js', array(), time(), true );

        wp_enqueue_style( 'hrm-toastr', HRM_URL . '/asset/css/toastr/toastr.min.css', array(), time(), 'all' );
        wp_enqueue_style( 'hrm-fontawesome', HRM_URL . '/asset/css/fontawesome/font-awesome.min.css', array(), time(), 'all' );
        wp_register_style( 'hrm-vue-multiselect', HRM_URL . '/asset/css/vue-multiselect/vue-multiselect.min.css', array(), time(), 'all' );
    }

    public static function footer_tag() {
        //self::attendance_scripts();
    }
}




