<?php
class Hrm_JsTemplate {
	private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    function __construct() {
        add_action( 'admin_footer', array($this, 'admin_footer') );
    }

    public function admin_footer() {

    	$page = self::get_page();

    	switch ( $page ) {
    		case hrm_admin_page():
    			self::admin();
    			break;

            case hrm_attendance_page():
                self::attendance();
                break;

            case hrm_leave_page():
                self::leave();
                break;
    		
    		default:
    			# code...
    			break;
    	}

    }

    public static function get_page() {
    	$query_args = hrm_get_query_args();
		return $query_args['page'];
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
				//self::admin_default();
				break;
		}
    }

    public static function department() {
    	hrm_get_js_template( HRM_COMP_PATH . '/department/department-add-btn.php', 'hrm-department-add-btn' );
        hrm_get_js_template( HRM_COMP_PATH . '/department/department-edit-btn.php', 'hrm-department-edit-btn' );
    	hrm_get_js_template( HRM_COMP_PATH . '/department/department-del-btn.php', 'hrm-department-del-btn' );
    	hrm_get_js_template( HRM_COMP_PATH . '/department/department-search.php', 'hrm-department-search' );
    	hrm_get_js_template( HRM_COMP_PATH . '/department/department-paginate-drop-down.php', 'hrm-department-paginate-drop-down' );
    	hrm_get_js_template( HRM_COMP_PATH . '/department/department-table.php', 'hrm-department-table' );
    	hrm_get_js_template( HRM_COMP_PATH . '/department/department-pagination.php', 'hrm-department-pagination' );
        hrm_get_js_template( HRM_COMP_PATH . '/department/new-department-form.php', 'hrm-new-department-form' );
    }

    /**
     * Attendance js templaate
     * 
     * @return voide
     */
    public static function attendance() {
        hrm_get_js_template( HRM_COMP_PATH . '/attendance/attendance.php', 'hrm-attendance' );
        hrm_get_js_template( HRM_COMP_PATH . '/attendance/attendance-header.php', 'hrm-attendance-header' );
        hrm_get_js_template( HRM_COMP_PATH . '/attendance/attendance-punch-in-out-btn.php', 'hrm-attendance-punch-in-out-btn' );
        hrm_get_js_template( HRM_COMP_PATH . '/attendance/attendance-user-search.php', 'hrm-attendance-user-search' );
        hrm_get_js_template( HRM_COMP_PATH . '/attendance/attendance-records.php', 'hrm-attendance-records' );
        hrm_get_js_template( HRM_COMP_PATH . '/attendance/attendance-configuration.php', 'hrm-attendance-configuration' );
  
    }

    /**
     * Leave js templaate
     * 
     * @return voide
     */
    public static function leave() {
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-records.php', 'hrm-leave-records' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-configuration.php', 'hrm-leave-configuration' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave.php', 'hrm-leave' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-header.php', 'hrm-leave-header' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-records-form.php', 'hrm-leave-records-form' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-records-add-btn.php', 'hrm-leave-records-add-btn' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-holidays.php', 'hrm-leave-holidays' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-work-week.php', 'hrm-leave-work-week' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-type.php', 'hrm-leave-type' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-type-form.php', 'hrm-leave-type-form' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-type-records.php', 'hrm-leave-type-records' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-type-add-btn.php', 'hrm-leave-type-add-btn' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-records-render.php', 'hrm-leave-records-render' );

        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-holidays-form.php', 'hrm-leave-holidays-form' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-holidays-record.php', 'hrm-leave-holidays-record' );
        hrm_get_js_template( HRM_COMP_PATH . '/leave/leave-holidays-add-btn.php', 'hrm-leave-holidays-add-btn' );
    }
}
