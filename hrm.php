<?php
/**
 * Plugin Name: WP human resource management
 * Plugin URI: http://mishubd.com/plugin/human-resource-management-hrm/
 * Description: Organization, Industries and Office management
 * Author: asaquzzaman
 * Version: 1.1
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
class WP_Hrm {

    /**
     * @var The single instance of the class
     * @since 0.1
     */
    protected static $_instance = null;

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
        $this->include();

        $this->instantiate();
        $this->init_action();
        $this->init_filter();
        
        register_activation_hook( __FILE__, array($this, 'install') );
    }

    function include() {
        spl_autoload_register( array( __CLASS__, 'autoload' ) );

        $this->migrate_db();
    
    }

    function migrate_db() {
        $migrater = new \HRM\Core\Database\Migrater();
        
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
        $this->define( 'HRM_VERSION', '1.2' );
        $this->define( 'HRM_DB_VERSION', '0.2' );
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
            <?php printf( __( 'If you want the <strong>front-end</strong> version of <strong>wp human resource management</strong> plugin,
            then please go & purchase it, <a href="http://mishubd.com/product/hrm-front-end/" target="_blank">HRM front-end</a>' )  ); ?>
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

            if ( isset( $_REQUEST['hrm_dataAttr']['is_admin'] ) ) {
                $hrm_is_admin = $_REQUEST['hrm_dataAttr']['is_admin'];
            } else if ( isset( $_REQUEST['hrm_attr']['is_admin'] ) ) {
                $hrm_is_admin = $_REQUEST['hrm_attr']['is_admin'];
            } else if ( isset( $_REQUEST['is_admin'] ) ) {
                $hrm_is_admin = $_REQUEST['is_admin'];
            }
        }
        hrm_check_financial_year();
        Hrm_Init::getInstance()->register_post_type();
    }

    function init_action() {
        add_action( 'plugins_loaded', array($this, 'load_textdomain') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'admin_notices', array($this, 'fornt_end') );
        //add_action( 'wp_enqueue_scripts', array( 'Hrm_Scripts', 'init_scripts') );
        //add_action( 'admin_enqueue_scripts', array( 'Hrm_Scripts', 'init_scripts') );
        add_action( 'init', array( $this, 'init' ) );
        //add_action( 'wp_footer', array( 'Hrm_Scripts', 'footer_tag' ), 99999 );
        //add_action( 'admin_footer', array( 'Hrm_Scripts', 'footer_tag' ), 99999 );
        add_action( 'init', 'hrm_set_capability' );
    }

    function init_filter() {
        add_action( 'map_meta_cap', 'hrm_map_meta_cap', 10, 4 );
    }


    function instantiate() {

        Hrm_Ajax::getInstance();
        Hrm_Admin::getInstance();
        Hrm_Leave::getInstance();
        Hrm_Employee::getInstance();
        Hrm_Update::getInstance();
        Hrm_Dashboard::getInstance();
        Hrm_Attendance::getInstance();
    }

    function install() {
        $logged_in_user_id = get_current_user_id();

        new Hrm_Db();
        new Hrm_Update();

        update_option( 'hrm_admin', $logged_in_user_id );
        update_option( 'hrm_version', HRM_VERSION );
        update_option( 'hrm_db_version', HRM_DB_VERSION );

        Hrm_Settings::getInstance()->update_financial_year( 
            date( 'Y-07-01 H:i:s', strtotime( current_time('mysql') ) ) 
        );
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
        $submenu[$hrm_page_slug][] = [__( 'Attendance', 'hrm' ), $capability, 'admin.php?page=hr_management#/attendance'];
        $submenu[$hrm_page_slug][] = [__( 'Leave', 'hrm' ), $capability, 'admin.php?page=hr_management#/leave'];
        $submenu[$hrm_page_slug][] = [__( 'Settings', 'hrm' ), $capability, 'admin.php?page=hr_management#/settings'];

        
        add_action( 'admin_print_styles-' . $menu, array( 'Hrm_Scripts', 'footer_tag' ) );
    }

    function admin_page_handler() {
        require_once HRM_PATH . '/templates/index.html';

        // return;
        // if( !is_user_logged_in() ) {
        //     sprintf( 'Please <a href="%s">login</a>', wp_login_url() );
        //     return;
        // }
        // $current_user_id = get_current_user_id();
        // $user_status     = get_user_meta( $current_user_id, '_status', true );

        // if ( $user_status == 'no' ) {
        //     _e( '<div class="hrm wrap"><h1>This account temporary disabled!</h1></div>', 'hrm' );
        //     return;
        // }

        // $query_args = hrm_get_query_args();
        // $page       = $query_args['page'];
        // $tab        = $query_args['tab'];
        // $subtab     = $query_args['subtab'];
        // $vue        = ! empty( $_GET['active'] ) && $_GET['active'] == 'vue' ? true : false;

        // if ( $page == 'hr_management' && $vue ) {
        //     require_once HRM_PATH . '/templates/index.html';
        // } else {
        //     echo '<div class="hrm wrap" id="hrm">';
        //     if ( $tab === false ) {
        //         Hrm_Settings::getInstance()->show_page( $page );
        //     } else {
        //         Hrm_Settings::getInstance()->show_tab_page( $page, $tab, $subtab );
        //     }

        //     echo '</div>';
        // }
     
    }
}

function hrm() {
    return WP_Hrm::instance();
}

//hrm instance.
hrm();



