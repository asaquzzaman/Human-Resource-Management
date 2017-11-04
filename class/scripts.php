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


    }

    /**
     * Common scripts
     * 
     * @return void
     */
    public static function hrm_vue_scripts() {
        wp_enqueue_script( 'hrm-vue-multiselect' );
        wp_enqueue_style( 'hrm-vue-multiselect' );
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
        wp_enqueue_script( 'hrm-config', HRM_URL . '/asset/js/config.js', false, false, false );
        
        wp_register_script( 'hrm-moment', HRM_URL . '/asset/js/moment/moment.min.js', array(), time(), true );
        wp_register_script( 'hrm-jquery-fullcalendar', HRM_URL . '/asset/js/jquery-fullcalendar/fullcalendar.min.js', array( 'hrm-moment' ), time(), true );
        
        wp_enqueue_script( 'hrm-toastr', HRM_URL . '/asset/js/toastr/toastr.min.js', array(), time(), true );

        //Should be loaded inside the hader tag
        // wp_enqueue_script( 'hrm-root-router', HRM_URL . '/asset/js/hrm-router.js', array(), time(), false );
        // wp_enqueue_script( 'hrm-root-mixin', HRM_URL . '/asset/js/hrm-mixin.js', array(), time(), false );
        // wp_enqueue_script( 'hrm-root-store', HRM_URL . '/asset/js/hrm-store.js', array(), time(), false );

        wp_register_script( 'hrm-vue-multiselect', HRM_URL . '/asset/js/vue-multiselect/vue-multiselect.min.js', array(), time(), true );
        

        wp_register_script( 'hrm-admin-vue-store', HRM_URL . '/asset/js/admin/admin-vue-store.js', array(), time(), true );
        wp_register_script( 'hrm-admin-vue', HRM_URL . '/asset/js/admin/admin-vue.js', array(), time(), true );

        wp_enqueue_style( 'hrm-toastr', HRM_URL . '/asset/css/toastr/toastr.min.css', array(), time(), 'all' );
        wp_enqueue_style( 'hrm-fontawesome', HRM_URL . '/asset/css/fontawesome/font-awesome.min.css', array(), time(), 'all' );
        wp_register_style( 'hrm-vue-multiselect', HRM_URL . '/asset/css/vue-multiselect/vue-multiselect.min.css', array(), time(), 'all' );
        wp_register_style( 'hrm-jquery-fullcalendar', HRM_URL . '/asset/css/jquery-fullcalendar/fullcalendar.min.css', array(), time(), 'all' );
    }

    public static function footer_tag() {
        ob_start();
        include HRM_PATH . '/asset/js/moment/latest.json';
        $time_zone_string      = ob_get_clean();
        $json_time_zone_string = json_decode( $time_zone_string, true );

        wp_register_script( 'hrm-moment', HRM_URL . '/asset/js/moment/moment.js', array(), time(), true );
        wp_register_script( 'hrm-moment-time-zone', HRM_URL . '/asset/js/moment/moment-timezone.js', array('hrm-moment'), time(), true );

        wp_enqueue_script( 'hrm-jquery-sweetalert', HRM_URL . '/asset/js/sweetalert/sweetalert.min.js', false, time(), true );
        wp_enqueue_script( 'hrm-jquery-preloader', HRM_URL . '/asset/js/Elegant-Loading-Indicator/jquery.preloader.js', false, time(), true );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'hrm-jquery-fullcalendar', HRM_URL . '/asset/js/jquery-fullcalendar/fullcalendar.min.js', array( 'hrm-moment' ), time(), true );
        wp_enqueue_script( 'hrm-datetimepicker', HRM_URL . '/asset/js/jquery-ui-timepicker.js', array( 'jquery' ), false, true);
        wp_enqueue_style( 'hrm-vue-multiselect', HRM_URL . '/asset/css/vue-multiselect/vue-multiselect.min.css', array(), time(), 'all' );
        wp_enqueue_script( 'hrm-vue', HRM_URL . '/asset/js/hrm-bundle.js', array('jquery','jquery-ui-datepicker', 'hrm-datetimepicker', 'hrm-moment-time-zone'), false, true );

        wp_localize_script( 'hrm-vue', 'HRM_Vars', array(
            'time_zones'  => $json_time_zone_string['zones'],
            'time_links'  => $json_time_zone_string['links'],
            'ajax_url'    => admin_url( 'admin-ajax.php' ),
            'nonce'       => wp_create_nonce( 'hrm_nonce' ),
            'time_zone'   => hrm_get_wp_timezone(),
            'wp_date_format' => get_option( 'date_format' ),
            'wp_time_format' => get_option( 'time_format' ),
            'message'     => hrm_message(),
            'confirm_msg' => __( 'Are you sure!', 'hrm'),
            'success_msg' => __( 'Changed Successfully', 'hrm' ),
            'current_user' => wp_get_current_user(),
            'settings'    => Hrm_Settings::getInstance()->get_settings(),
            'current_date' => current_time( 'mysql' ),
        ));

        wp_enqueue_style( 'hrm-jquery-fullcalendar', HRM_URL . '/asset/css/jquery-fullcalendar/fullcalendar.min.css', array(), time(), 'all' );
        wp_enqueue_style( 'hrm-admin', HRM_URL . '/asset/css/admin.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-chosen', HRM_URL . '/asset/css/chosen.min.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui', HRM_URL . '/asset/css/jquery-ui.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui-timepicker', HRM_URL . '/asset/css/jquery-ui-timepicker-addon.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-preloader', HRM_URL . '/asset/css/Elegant-Loading-Indicator/preloader.css', false, false, 'all' );
    }
}




