<?php
/**
 * Plugin Name: WP human resource management
 * Plugin URI: http://wpspear.com/hrm/
 * Description: Organization, Industries and Office management
 * Author: asaquzzaman
 * Version: 2.2.17
 * Author URI: http://mishubd.com
 * License: GPL2
 * TextDomain: hrm
 */

/**
 * Copyright (c) 2013 Asaquzzaman Mishu (email: joy.mishu@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 * **********************************************************************
 */

require_once dirname (__FILE__) . '/vendor/autoload.php';

if ( version_compare( phpversion(), '5.6.0', '<' ) ) {
    add_action( 'admin_notices',  'hrm_php_version_notice'  );
    return;
}

/**
* php version notices
*  @return void
*/
function hrm_php_version_notice() {
    
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $php_version = phpversion();
    ?>
        <div class="error notice" id="pm-php-notice" style="padding: 1em; position: relative;">
            <p><?php echo sprintf( esc_html__("Your current PHP version is <strong>{$php_version}</strong>. You need to upgrade your PHP version to <strong>5.6 or later</strong> to run Human Resource Management.", "wedevs-project-manager" ) ); ?></p>
        </div>
    <?php 
}

class WP_Hrm {

    /**
     * @var The single instance of the class
     * @since 0.1
     */
    protected static $_instance = null;
    protected $addons = array();
    protected $addons_license = array();


    /**
     * Main HRM Instance
     *
     * @since 0.9
     * @static
     * @see hrm()
     * @return HRM - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct() {
        $this->define_constants();
        $this->includes();

        $this->instantiate();
        $this->init_action();
        $this->init_filter();
        //$this->migrate_db();
        register_activation_hook( __FILE__, array($this, 'install') );
    }

    function includes() {
        spl_autoload_register( array( __CLASS__, 'autoload' ) );
    }

    function migrate_db() {
        $migrater = new HRM\Core\Database();
        
        $migrater->create_migrations_table();
        $migrater->build_schema();
    }

    function autoload( $class ) {
        $name = explode( '_', $class );

        if ( isset( $name[1] ) ) {
            $class_name = strtolower( $name[1] );
            $filename = dirname( __FILE__ ) . '/class/' . $class_name . '.php';
            if ( file_exists( $filename ) ) {
                require_once $filename;
            }
        }
    }

    /**
     * Define cpmrp Constants
     *
     * @since 1.1
     * @return type
     */
    private function define_constants() {
        $this->define( 'HRM_VERSION', '2.2.17' );
        $this->define( 'HRM_DB_VERSION', '2.0' );
        $this->define( 'HRM_PATH', dirname( __FILE__ ) );
        $this->define( 'HRM_TEMPLATE_PATH', dirname( __FILE__ ) . '/templates' );
        $this->define( 'HRM_COMP_PATH', dirname( __FILE__ ) . '/asset/js/components' );
        $this->define( 'HRM_URL', plugins_url( '', __FILE__ ) );
        $this->define( 'HRM_PERMISSION_PURCHASE_URL', 'http://mishubd.com/product/hrm-permission/' );
    }

    /**
     * Define constant if not already set
     *
     * @since 1.1
     *
     * @param  string $name
     * @param  string|bool $value
     * @return type
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }

    function fornt_end() {
        $license_status = get_option( 'hrm_front_end_license' );
        if ( isset( $license_status->request_status ) ) {
            return;
        }
        ?>
         <div class="update-nag">
            <?php printf( 'If you want the <strong>front-end</strong> version of <strong>wp human resource management</strong> plugin,
            then please go & purchase it, <a href="http://mishubd.com/product/hrm-front-end/" target="_blank">HRM front-end</a>'  ); ?>
        </div>
        <?php
    }

    /**
     * Load plugin textdomain
     *
     * @since 0.3
     */
    function load_textdomain() {
        load_plugin_textdomain( 'hrm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    function init() {
        
        if ( ! defined( 'DOING_AJAX' ) ) {
            global $hrm_is_admin;
            $hrm_is_admin = is_admin() ? 1 : 0;
        } else {
            global $hrm_is_admin;

            if ( isset( $_REQUEST['is_admin'] ) ) {
                $hrm_is_admin = intval( $_REQUEST['is_admin'] );
            }
        }
        hrm_check_financial_year();
        Hrm_Init::getInstance()->register_post_type();
    }

    function init_action() {
        add_action( 'plugins_loaded', array($this, 'load_textdomain') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'init', 'hrm_set_capability' );
        add_action( 'admin_notices', array( $this, 'hrm_banner' ) );
        add_action( 'map_meta_cap', 'hrm_map_meta_cap', 10, 4 );
    }

    function hrm_banner() {
        
        if( empty( $GET['page'] ) ) {
            return;
        }
        if( hrm_clean( $_GET['page'] ) != 'hr_management' ) {
            return;
        }
        if ( class_exists('hrm_front') ) {
            return;
        }
        ?>
        <div id="message" class="updated notice notice-success">
            <p>
                WP HRM front-end version is available, please  
                <a target="_blank" href="http://wpspear.com/hrm/front-end/"><strong>get it now!</strong></a>
            </p>
        </div>
        <?php
    }

    function init_filter() {
        hrm_load_schema();
    }


    function instantiate() {
        Hrm_Scripts::getInstance();
        Hrm_Ajax::getInstance();
        Hrm_Admin::getInstance();
        Hrm_Leave::getInstance();
        Hrm_Employee::getInstance();
        Hrm_Update::getInstance();
        Hrm_Dashboard::getInstance();
        Hrm_Attendance::getInstance();
        Hrm_Payroll::getInstance();
        Hrm_Shift::getInstance();
        Hrm_Designation::getInstance();
    }

    function install() {
        $logged_in_user_id = get_current_user_id();

        new Hrm_Db();
        new Hrm_Update();

        update_option( 'hrm_admin', $logged_in_user_id );
        update_option( 'hrm_version', HRM_VERSION );
    
    }


    function admin_menu() {
        global $submenu;
        $capability    = 'hrm_employee'; //minimum level: subscriber
        $label         = hrm_menu_label();
        $hrm_page_slug = hrm_page_slug();
        
        if ( ! $hrm_page_slug ) {
            return;
        }

        $menu  = add_menu_page( __( 'HRM', 'hrm' ), __( 'HRM', 'hrm' ), $capability, $hrm_page_slug, array($this, 'admin_page_handler'), 'dashicons-groups'  );

        
        $submenu[$hrm_page_slug][] = [__( 'Dashboard', 'hrm' ), $capability, 'admin.php?page=hr_management#/dashboard'];
        $submenu[$hrm_page_slug][] = [__( 'Organization', 'hrm' ), $capability, 'admin.php?page=hr_management#/organization'];
        $submenu[$hrm_page_slug][] = [__( 'Departments', 'hrm' ), $capability, 'admin.php?page=hr_management#/departments'];
        $submenu[$hrm_page_slug][] = [__( 'Designation', 'hrm' ), $capability, 'admin.php?page=hr_management#/designation'];
        $submenu[$hrm_page_slug][] = [__( 'Employee', 'hrm' ), $capability, 'admin.php?page=hr_management#/employee'];
        $submenu[$hrm_page_slug][] = [__( 'Profile', 'hrm' ), $capability, 'admin.php?page=hr_management#/employees'];
        $submenu[$hrm_page_slug][] = [__( 'Payroll', 'hrm' ), $capability, 'admin.php?page=hr_management#/payroll'];
        $submenu[$hrm_page_slug][] = [__( 'Attendance', 'hrm' ), $capability, 'admin.php?page=hr_management#/attendance'];
        $submenu[$hrm_page_slug][] = [__( 'Leave', 'hrm' ), $capability, 'admin.php?page=hr_management#/leave'];
        $submenu[$hrm_page_slug]['recruitment'] = [ __( 'Recruitment', 'hrm' ), 'read', 'admin.php?page=hr_management#/recruitment' ];

        $this->addons = apply_filters( 'hrm_addons', array() );
        $this->addons_license = apply_filters( 'hrm_addons_license', array() );

        do_action( 'hrm_menu_before_load_scripts', $menu );

        $submenu[$hrm_page_slug][] = [__( 'Settings', 'hrm' ), $capability, 'admin.php?page=hr_management#/settings'];
        $submenu[$hrm_page_slug][] = [__( 'Add-Ons', 'hrm' ), $capability, 'admin.php?page=hr_management#/addons'];

        if ( !empty( $this->addons_license ) ) {
            add_submenu_page( 'hr_management', __( 'License', 'hrm' ), __( 'License', 'hrm' ), 'activate_plugins', 'hrm_addons_license', array( $this, 'addons_license' ) );
        }
        
        
        add_action( 'admin_print_styles-' . $menu, array( 'Hrm_Scripts', 'footer_tag' ) );
    }

    function addons_update() {
        HRM_Addons::init( $this->addons );
    }

    function addons_license() {
        HRM_Addons::licenses( $this->addons_license );
    }

    function admin_page_handler() {
        require_once HRM_PATH . '/templates/index.html';
    }
}

function hrm() {
    return WP_Hrm::instance();
}

//hrm instance.
hrm();



