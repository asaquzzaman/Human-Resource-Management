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
    		case 'hrm_management':
    			self::admin();
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
}