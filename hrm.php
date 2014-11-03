<?php
/**
 * Plugin Name: WP human resource management
 * Plugin URI: https://github.com/asaquzzaman/hrm
 * Description: Organization, Industries and Office management
 * Author: asaquzzaman
 * Version: 0.1
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


function hrm_autoload( $class ) {
    $name = explode( '_', $class );

    if ( isset( $name[1] ) ) {
        $class_name = strtolower( $name[1] );
        $filename = dirname( __FILE__ ) . '/class/' . $class_name . '.php';
        if ( file_exists( $filename ) ) {
            require_once $filename;
        }
    }
}
spl_autoload_register( 'hrm_autoload' );

require_once dirname (__FILE__) . '/include/function.php';
require_once dirname (__FILE__) . '/include/urls.php';
require_once dirname (__FILE__) . '/include/page.php';

class Wp_Hrm {

    private $is_admin;

    function __construct() {
        $this->version = '0.1';
        $this->db_version = '0.1';
        $this->is_admin = ( is_admin() ) ? 'yes' : 'no';
        $this->instantiate();
        add_action( 'plugins_loaded', array($this, 'load_textdomain') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
        register_activation_hook( __FILE__, array($this, 'install') );
    }

    /**
     * Load plugin textdomain
     *
     * @since 0.3
     */
    function load_textdomain() {
        load_plugin_textdomain( 'hrm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }


    function admin_scripts() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_script( 'jquery-ui-autocomplete');
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'hrm_chosen', plugins_url( '/asset/js/chosen.jquery.js', __FILE__ ), array( 'jquery' ), false, true);
        wp_enqueue_script( 'hrm_admin', plugins_url( '/asset/js/hrm.js', __FILE__ ), array( 'jquery' ), false, true);


        wp_localize_script( 'hrm_admin', 'hrm_ajax_data', array(
            'ajax_url'    => admin_url( 'admin-ajax.php' ),
            '_wpnonce'    => wp_create_nonce( 'hrm_nonce' ),
            'is_admin'    => $this->is_admin,
            'confirm_msg' => __( 'Are you sure!', 'hrm'),
            'success_msg' => __( 'Changed Successfully', 'hrm' )
        ));

        wp_enqueue_style( 'hrm-chosen', plugins_url( '/asset/css/chosen.css', __FILE__ ), false, false, 'all' );
        wp_enqueue_style( 'hrm-admin', plugins_url( '/asset/css/admin.css', __FILE__ ), false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui', plugins_url( '/asset/css/jquery-ui.css', __FILE__ ), false, false, 'all' );

    }

    function instantiate() {

        Hrm_Ajax::getInstance();
        Hrm_Admin::getInstance();
        Hrm_Leave::getInstance();
        Hrm_Employee::getInstance();
    }

    function install() {
        $logged_in_user_id = get_current_user_id();
        update_option( 'hrm_admin', $logged_in_user_id );
        update_option( 'hrm_version', $this->version );
        update_option( 'hrm_db_version', $this->db_version );

        new Hrm_Db();
    }

    function pim_scripts() {
        $this->admin_scripts();
    }

    function leave_scripts() {
        $this->admin_scripts();
    }

    function employer_scripts() {
        $this->admin_scripts();
    }

    function admin_menu() {
        $capability = 'read'; //minimum level: subscriber
        if ( hrm_current_user_role() != 'hrm_employer' ) {
            $menu           = add_menu_page( __( 'HRM', 'hrm' ), __( 'HRM', 'hrm' ), $capability, 'hrm_management', array($this, 'admin_page_handler'), ''  );
            $admin_sub_menu = add_submenu_page( 'hrm_management', __( 'Admin', 'hrm' ), __( 'Admin', 'hrm' ), $capability, 'hrm_management', array($this, 'admin_page_handler') );
            $pim            = add_submenu_page( 'hrm_management', __( 'Pim', 'hrm' ), __( 'Pim', 'hrm' ), $capability, 'hrm_pim', array( $this, 'admin_page_handler' ) );
            $leave          = add_submenu_page( 'hrm_management', __( 'Leave', 'hrm' ), __( 'Leave', 'hrm' ), $capability, 'hrm_leave', array( $this, 'admin_page_handler' ) );

            add_action( 'admin_print_styles-' . $admin_sub_menu, array($this, 'admin_scripts') );
            add_action( 'admin_print_styles-' . $pim, array( $this, 'pim_scripts') );
            add_action( 'admin_print_styles-' . $leave, array( $this, 'leave_scripts' ) );
        } else {
            $user_id = get_current_user_id();
            $menu           = add_menu_page( __( 'HRM', 'hrm' ), __( 'Hrm My Info', 'hrm' ), $capability, 'hrm_employer', array($this, 'admin_page_handler') );
            $this->admin_scripts();
        }
    }


    function admin_page_handler() {
        $current_user_id = get_current_user_id();
        $user_status = get_user_meta( $current_user_id, '_status', true );
        
        if ( $user_status == 'no' ) {
            _e( '<div class="wrap"><h1>This account temporary disabled!</h1></div>', 'hrm' );
            return;
        }
        
        $page = isset( $_GET['page'] ) ? $_GET['page'] : '';

        if ( $page == 'hrm_management' ) {
            require_once dirname (__FILE__) . '/views/admin/header.php';

        } else if ( $page == 'hrm_pim' && ! isset( $_GET['employee_id'] ) ) {
            require_once dirname (__FILE__) . '/views/pim/header.php';

        } else if ( ( $page == 'hrm_pim' )  && isset( $_GET['employee_id'] ) ) {
            require_once dirname (__FILE__) . '/views/employee/header.php';
        
        } else if ( $page == 'hrm_leave' ) {
            require_once dirname (__FILE__) . '/views/leave/header.php';
        
        } else if ( $page == 'hrm_recruitment' ) {
            require_once dirname (__FILE__) . '/views/recruitment/header.php';
        
        } else if ( $page == 'hrm_employer' ) {
            require_once dirname (__FILE__) . '/views/employee/header.php';
        }
    }
}

new Wp_Hrm();
