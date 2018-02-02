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
        self::footer_tag();
  //   	$sub_tab = self::get_sub_tab();

		// switch ( $sub_tab ) {
		// 	case 'department':
		// 		self::department();
		// 		break;

  //           case 'hrm_attendance':
  //               self::attendance_scripts();
  //               break;
			
		// 	default:
		// 		self::admin_default();
		// 		break;
		// }
    }

    // public static function admin_localize($key) {
    //     wp_localize_script( $key, 'HRM_Admin', array(
    //         'ajax_url'    => admin_url( 'admin-ajax.php' ),
    //         'nonce'       => wp_create_nonce( 'hrm_nonce' ),
    //         'message'     => hrm_message(),
    //         'confirm_msg' => __( 'Are you sure!', 'hrm'),
    //         'success_msg' => __( 'Changed Successfully', 'hrm' )
    //     ));
    // }

    // public static function department() {

    //     self::admin_default();
    //     wp_enqueue_script( 'hrm-main-vue', HRM_URL . '/assets/js/vue/vue.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-main-vuex', HRM_URL . '/assets/js/vue/vuex.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-main-vue-route', HRM_URL . '/assets/js/vue/vue-router.js', array(), false, true);
    //     self::admin_localize( 'hrm-main-vue' );
    //     wp_enqueue_script( 'hrm-root-mixin', HRM_URL . '/assets/js/hrm-common-mixin.js', array(), time(), true );
        
        
    //     wp_enqueue_script( 'hrm-department-edit-btn', HRM_URL . '/assets/js/components/department/department-edit-btn.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-department-add-btn', HRM_URL . '/assets/js/components/department/department-add-btn.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-department-del-btn', HRM_URL . '/assets/js/components/department/department-del-btn.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-department-search', HRM_URL . '/assets/js/components/department/department-search.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-department-paginate-drop-dwon', HRM_URL . '/assets/js/components/department/department-paginate-drop-down.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-department-table', HRM_URL . '/assets/js/components/department/department-table.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-department-pagination', HRM_URL . '/assets/js/components/department/department-pagination.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-new-department-form', HRM_URL . '/assets/js/components/department/new-department-form.js', array(), false, true);
        
    //     wp_enqueue_script( 'hrm-admin-store', HRM_URL . '/assets/js/admin/admin-vue-store.js', array(), time(), true );
    //     wp_enqueue_script( 'hrm-admin-vue', HRM_URL . '/assets/js/admin/admin-vue.js', array(), time(), true );
    //     wp_enqueue_style( 'hrm-admin', HRM_URL . '/assets/css/admin.css', false, false, 'all' );
    // }

    // public static function admin_default() {
    // 	global $hrm_is_admin;

    // 	wp_enqueue_script( 'jquery' );
    //     wp_enqueue_script( 'jquery-ui-dialog' );
    //     wp_enqueue_script( 'jquery-ui-autocomplete');
    //     wp_enqueue_script( 'jquery-ui-datepicker' );
    //     wp_enqueue_script( 'jquery-ui-slider' );
    //     wp_enqueue_script( 'hrm-library', HRM_URL . '/assets/js/library.js', false, false, false );
    //     wp_enqueue_script( 'hrm-config', HRM_URL . '/assets/js/config.js', array('hrm-library'), false, false );
    //     wp_enqueue_script( 'hrm_chosen', HRM_URL . '/assets/js/chosen.jquery.min.js', array( 'jquery' ), false, true);
    //     wp_enqueue_script( 'hrm_datetimepicker', HRM_URL . '/assets/js/jquery-ui-timepicker.js', array( 'jquery' ), false, true);
    //     wp_enqueue_script( 'hrm-jquery.dataTables', HRM_URL . '/assets/js/jquery.dataTables.min.js', array( 'jquery' ), false, true);
    //     wp_enqueue_script( 'hrm_admin', HRM_URL . '/assets/js/hrm.js', array( 'jquery' ), false, true);

    //     wp_localize_script( 'hrm_admin', 'HRM_Vars', array(
    //         'is_admin'    => $hrm_is_admin,
    //         'confirm_msg' => __( 'Are you sure!', 'hrm'),
    //         'success_msg' => __( 'Changed Successfully', 'hrm' ),
    //         'ajax_url'        => admin_url( 'admin-ajax.php' ),
    //         'nonce'           => wp_create_nonce( 'hrm_nonce' ),
    //         'time_zone'       => hrm_get_wp_timezone(),
    //         'wp_date_format'  => get_option( 'date_format' ),
    //         'wp_time_format'  => get_option( 'time_format' ),
    //         'message'         => hrm_message(),
    //         'current_user'    => wp_get_current_user(),
    //         'settings'        => Hrm_Settings::getInstance()->get_settings(),
    //         'current_date'    => current_time( 'mysql' ),
    //         'financial_start' => hrm_financial_start_date(),
    //         'financial_end'   => hrm_financial_end_date(),
    //         'user_role' => hrm_current_user_role(),
    //         'home_url'   => home_url(),
    //         'hrm_url'     => HRM_URL
    //     ));

    //     //wp_enqueue_style( 'hrm-jquery.dataTables-style', HRM_URL . '/assets/css/jquery.dataTables.css', false, false, 'all' );
    //     //wp_enqueue_style( 'hrm-jquery.dataTables_themeroller', HRM_URL . '/assets/css/jquery.dataTables_themeroller.css', false, false, 'all' );
    //     wp_enqueue_style( 'hrm-admin', HRM_URL . '/assets/css/admin.css', false, false, 'all' );
    //     wp_enqueue_style( 'hrm-chosen', HRM_URL . '/assets/css/chosen.min.css', false, false, 'all' );
    //     wp_enqueue_style( 'hrm-jquery-ui', HRM_URL . '/assets/css/jquery-ui.css', false, false, 'all' );
    //     wp_enqueue_style( 'hrm-jquery-ui-timepicker', HRM_URL . '/assets/css/jquery-ui-timepicker-addon.css', false, false, 'all' );
    // }

    /**
     * Attendance scripts
     * 
     * @return void
     */
    // public static function attendance_scripts() {
    //     self::admin_default();
    //     wp_enqueue_script( 'hrm-main-vue', HRM_URL . '/assets/js/vue/vue.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-main-vuex', HRM_URL . '/assets/js/vue/vuex.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-main-vue-route', HRM_URL . '/assets/js/vue/vue-router.js', array(), false, true);
    //     self::admin_localize( 'hrm-vue' );
    //     wp_enqueue_script( 'hrm-root-mixin', HRM_URL . '/assets/js/hrm-common-mixin.js', array(), time(), true );
    //     wp_enqueue_script( 'hrm-attendance-vue-store', HRM_URL . '/assets/js/attendance/attendance-vue-store.js', array(), false, true );
        
    //     wp_enqueue_script( 'hrm-attendance-header', HRM_URL . '/assets/js/components/attendance/attendance-header.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-attendance-punch-in-out-btn', HRM_URL . '/assets/js/components/attendance/attendance-punch-in-out-btn.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-attendance-user-search', HRM_URL . '/assets/js/components/attendance/attendance-user-search.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-attendance-records', HRM_URL . '/assets/js/components/attendance/attendance-records.js', array(), false, true);
    //     wp_enqueue_script( 'hrm-attendance-configuration', HRM_URL . '/assets/js/components/attendance/attendance-configuration.js', array(), false, true);
        
    //     wp_enqueue_script( 'hrm-attendance-vue', HRM_URL . '/assets/js/attendance/attendance-vue.js', array(), false, true );
    //     wp_enqueue_style( 'hrm-admin', HRM_URL . '/assets/css/admin.css', false, false, 'all' );

        
    // }

    /**
     * Leave scripts
     * 
     * @return void
     */
    // public static function leave_scripts() {
    //     self::footer_tag();
    // }

    /**
     * Common scripts
     * 
     * @return void
     */
    // public static function hrm_vue_scripts() {
    //     wp_enqueue_script( 'hrm-vue-multiselect' );
    //     wp_enqueue_style( 'hrm-vue-multiselect' );
    //     wp_enqueue_script( 'hrm-directive', HRM_URL . '/assets/js/hrm-directive.js', array(), time(), true);
    //     wp_enqueue_script( 'hrm-root-vue', HRM_URL . '/assets/js/hrm-vue.js', false, time(), true);
    // }

    /**
     * Header scripts
     * 
     * @return void
     */
    // public static function init_scripts() {
    //     wp_enqueue_media();
    //     wp_enqueue_script( 'hrm-library', HRM_URL . '/assets/js/library.js', false, false, false );
    //     wp_enqueue_script( 'hrm-config', HRM_URL . '/assets/js/config.js', array('hrm-library'), false, false );
        

    //     wp_enqueue_style( 'hrm-toastr', HRM_URL . '/assets/css/toastr/toastr.min.css', array(), time(), 'all' );
    //     wp_enqueue_style( 'hrm-fontawesome', HRM_URL . '/assets/css/fontawesome/font-awesome.min.css', array(), time(), 'all' );
    //     wp_register_style( 'hrm-vue-multiselect', HRM_URL . '/assets/css/vue-multiselect/vue-multiselect.min.css', array(), time(), 'all' );
    //     wp_register_style( 'hrm-jquery-fullcalendar', HRM_URL . '/assets/css/jquery-fullcalendar/fullcalendar.min.css', array(), time(), 'all' );
    // }

    public static function footer_tag() {

        
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_media();
        wp_enqueue_script( 'hrm-library', HRM_URL . '/assets/js/library.js', false, false, false );
        wp_enqueue_script( 'hrm-config', HRM_URL . '/assets/js/config.js', array('hrm-library'), false, false );
        
        wp_enqueue_script( 'hrm-vue', HRM_URL . '/assets/js/hrm-bundle.js', array('jquery','hrm-config'), false, true );

        wp_localize_script( 'hrm-library', 'HRM_Vars', array(
            'ajax_url'        => admin_url( 'admin-ajax.php' ),
            'nonce'           => wp_create_nonce( 'hrm_nonce' ),
            'time_zone'       => hrm_get_wp_timezone(),
            'wp_date_format'  => get_option( 'date_format' ),
            'wp_time_format'  => get_option( 'time_format' ),
            'message'         => hrm_message(),
            'confirm_msg'     => __( 'Are you sure!', 'hrm'),
            'success_msg'     => __( 'Changed Successfully', 'hrm' ),
            'current_user'    => wp_get_current_user(),
            'settings'        => Hrm_Settings::getInstance()->get_settings(),
            'current_date'    => current_time( 'mysql' ),
            'financial_start' => hrm_financial_start_date(),
            'financial_end'   => hrm_financial_end_date(),
            'user_role' => hrm_current_user_role(),
            'permalink' => get_permalink(),
            'home_url'   => home_url(),
            'hrm_url'     => HRM_URL,
            'plupload'      => array(
                'browse_button'       => 'hrm-upload-pickfiles',
                'container'           => 'hrm-upload-container',
                'max_file_size'       => '10485760b',
                'url'                 => admin_url( 'admin-ajax.php' ) . '?action=hrm_ajax_upload&nonce=' . wp_create_nonce( 'hrm_ajax_upload' ),
                'flash_swf_url'       => includes_url( 'js/plupload/plupload.flash.swf' ),
                'silverlight_xap_url' => includes_url( 'js/plupload/plupload.silverlight.xap' ),
                'filters'             => array( array( 'title' => __( 'Allowed Files' ), 'extensions' => '*' ) ),
                'resize'              => array( 'width' => ( int ) get_option( 'large_size_w' ), 'height' => ( int ) get_option( 'large_size_h' ), 'quality' => 100 )
            ),
        ));

        wp_enqueue_style( 'hrm-vue-multiselect', HRM_URL . '/assets/css/vue-multiselect/vue-multiselect.min.css', array(), time(), 'all' );
        wp_enqueue_style( 'hrm-toastr', HRM_URL . '/assets/css/toastr/toastr.min.css', array(), time(), 'all' );
        wp_enqueue_style( 'hrm-jquery-fullcalendar', HRM_URL . '/assets/css/jquery-fullcalendar/fullcalendar.min.css', array(), time(), 'all' );
        wp_enqueue_style( 'hrm-admin', HRM_URL . '/assets/css/admin.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-chosen', HRM_URL . '/assets/css/chosen.min.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui', HRM_URL . '/assets/css/jquery-ui.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui-timepicker', HRM_URL . '/assets/css/jquery-ui-timepicker-addon.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-preloader', HRM_URL . '/assets/css/Elegant-Loading-Indicator/preloader.css', false, false, 'all' );
    }
}




