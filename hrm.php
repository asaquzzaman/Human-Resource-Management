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
        add_action( 'wp_enqueue_scripts', array( 'Hrm_Scripts', 'init_scripts') );
        add_action( 'admin_enqueue_scripts', array( 'Hrm_Scripts', 'init_scripts') );
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_footer', array( 'Hrm_Scripts', 'footer_tag' ), 99999 );
        add_action( 'admin_footer', array( 'Hrm_Scripts', 'footer_tag' ), 99999 );
    }

    static function admin_scripts() {
        global $hrm_is_admin;

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_script( 'jquery-ui-autocomplete');
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'hrm_chosen', plugins_url( '/asset/js/chosen.jquery.min.js', __FILE__ ), array( 'jquery' ), false, true);
        wp_enqueue_script( 'hrm_datetimepicker', plugins_url( '/asset/js/jquery-ui-timepicker.js', __FILE__ ), array( 'jquery' ), false, true);
        wp_enqueue_script( 'hrm-jquery.dataTables', plugins_url( '/asset/js/jquery.dataTables.min.js', __FILE__ ), array( 'jquery' ), false, true);
        wp_enqueue_script( 'hrm_admin', plugins_url( '/asset/js/hrm.js', __FILE__ ), array( 'jquery' ), false, true);

        wp_localize_script( 'hrm_admin', 'HRM_Vars', array(
            'is_admin'    => $hrm_is_admin,
            'confirm_msg' => __( 'Are you sure!', 'hrm'),
            'success_msg' => __( 'Changed Successfully', 'hrm' ),
            'ajax_url'        => admin_url( 'admin-ajax.php' ),
            'nonce'           => wp_create_nonce( 'hrm_nonce' ),
            'time_zone'       => hrm_get_wp_timezone(),
            'wp_date_format'  => get_option( 'date_format' ),
            'wp_time_format'  => get_option( 'time_format' ),
            'message'         => hrm_message(),
            'current_user'    => wp_get_current_user(),
            'settings'        => Hrm_Settings::getInstance()->get_settings(),
            'current_date'    => current_time( 'mysql' ),
            'financial_start' => hrm_financial_start_date(),
            'financial_end'   => hrm_financial_end_date()
        ));

        //wp_enqueue_style( 'hrm-jquery.dataTables-style', plugins_url( '/asset/css/jquery.dataTables.css', __FILE__ ), false, false, 'all' );
        //wp_enqueue_style( 'hrm-jquery.dataTables_themeroller', plugins_url( '/asset/css/jquery.dataTables_themeroller.css', __FILE__ ), false, false, 'all' );
        wp_enqueue_style( 'hrm-admin', plugins_url( '/asset/css/admin.css', __FILE__ ), false, false, 'all' );
        wp_enqueue_style( 'hrm-chosen', plugins_url( '/asset/css/chosen.min.css', __FILE__ ), false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui', plugins_url( '/asset/css/jquery-ui.css', __FILE__ ), false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui-timepicker', plugins_url( '/asset/css/jquery-ui-timepicker-addon.css', __FILE__ ), false, false, 'all' );

    }

    function instantiate() {

        Hrm_Ajax::getInstance();
        Hrm_Admin::getInstance();
        Hrm_Leave::getInstance();
        Hrm_Employee::getInstance();
        Hrm_JsTemplate::getInstance();
        Hrm_Update::getInstance();
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

    function pim_scripts() {
        $this->admin_scripts();
        wp_enqueue_script( 'jquery-ui' );
        wp_enqueue_script( 'jquery-ui-mouse' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'plupload-handlers' );
    }

    function leave_scripts() {
        $this->admin_scripts();
    }

    function employee_scripts() {
        $this->admin_scripts();
    }

    function attendance_scripts() {
        $this->admin_scripts();
    }

    function evaluation_scripts() {
        $this->admin_scripts();
    }

    function author_scripts() {
        $this->admin_scripts();
    }

    function employer_scripts() {
        $this->admin_scripts();
        wp_enqueue_script( 'jquery-ui' );
        wp_enqueue_script( 'jquery-ui-mouse' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'plupload-handlers' );
    }

    static function file_scripts() {
        self::admin_scripts();
        wp_enqueue_script( 'jquery-ui' );
        wp_enqueue_script( 'jquery-ui-mouse' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'plupload-handlers' );
        wp_enqueue_script( 'hrm-file', plugins_url( '/asset/js/file.js', __FILE__ ) );
    }


    function admin_menu() {
        $capability    = 'read'; //minimum level: subscriber
        $label         = hrm_menu_label();
        $hrm_page_slug = hrm_page_slug();
        
        if ( ! $hrm_page_slug ) {
            return;
        }

        $menu  = add_menu_page( __( 'HRM', 'hrm' ), __( 'HRM', 'hrm' ), $capability, $hrm_page_slug, array($this, 'admin_page_handler'), 'dashicons-groups'  );

        foreach ( hrm_menu_label() as $page_slug => $page_label ) {
            if ( hrm_user_can_access( $page_slug ) ) {
                $style_slug[$page_slug] = add_submenu_page( $hrm_page_slug, $page_label, $page_label, $capability, $page_slug, array($this, 'admin_page_handler') );
            }
        }

        if( isset( $style_slug[hrm_organization_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_organization_page()], array( 'Hrm_Scripts', 'admin') );
        }

        if( isset( $style_slug[hrm_department_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_department_page()], array( 'Hrm_Scripts', 'department') );
        }

        if( isset( $style_slug[hrm_admin_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_admin_page()], array( 'Hrm_Scripts', 'admin') );
        }

        if( isset( $style_slug[hrm_pim_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_pim_page()], array( $this, 'pim_scripts') );
        }

        if( isset( $style_slug[hrm_client_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_client_page()], array( $this, 'admin_scripts') );
        }

        if( isset( $style_slug[hrm_project_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_project_page()], array( $this, 'admin_scripts') );
        }

        if( isset( $style_slug[hrm_leave_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_leave_page()], array( 'Hrm_Scripts', 'leave_scripts') );
        }

        if( isset( $style_slug[hrm_attendance_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_attendance_page()], array( 'Hrm_Scripts', 'attendance_scripts') );
        }

        if( isset( $style_slug[hrm_evaluation_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_evaluation_page()], array( $this, 'evaluation_scripts') );
        }

        if( isset( $style_slug[hrm_file_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_file_page()], array( $this, 'file_scripts') );
        }

        if( isset( $style_slug[hrm_employee_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_employee_page()], array( $this, 'pim_scripts') );
        }

        if( isset( $style_slug[hrm_salary_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_salary_page()], array( $this, 'admin_scripts') );
        }

        if( isset( $style_slug[hrm_permission_page()] ) ) {
            add_action( 'admin_print_styles-' . $style_slug[hrm_permission_page()], array( $this, 'admin_scripts') );
        }

        do_action( 'hrm_admin_menu', $this, $style_slug );

    }

    //     function admin_page_handler() {
    //     if( !is_user_logged_in() ) {
    //         sprintf( 'Please <a href="%s">login</a>', wp_login_url() );
    //         return;
    //     }
    //     $current_user_id = get_current_user_id();
    //     $user_status = get_user_meta( $current_user_id, '_status', true );

    //     if ( $user_status == 'no' ) {
    //         _e( '<div class="hrm wrap"><h1>This account temporary disabled!</h1></div>', 'hrm' );
    //         return;
    //     }

    //     $query_args = hrm_get_query_args();
    //     $page       = $query_args['page'];
    //     $tab        = $query_args['tab'];
    //     $subtab     = $query_args['subtab'];

    //     echo '<div class="hrm wrap" id="hrm">';
    //     if ( $tab === false ) {
    //         Hrm_Settings::getInstance()->show_page( $page );
    //     } else {
    //         Hrm_Settings::getInstance()->show_tab_page( $page, $tab, $subtab );
    //     }

    //     echo '</div>';
    // }


    function admin_page_handler() {
        if( !is_user_logged_in() ) {
            sprintf( 'Please <a href="%s">login</a>', wp_login_url() );
            return;
        }
        $current_user_id = get_current_user_id();
        $user_status = get_user_meta( $current_user_id, '_status', true );

        if ( $user_status == 'no' ) {
            _e( '<div class="hrm wrap"><h1>This account temporary disabled!</h1></div>', 'hrm' );
            return;
        }

        $query_args = hrm_get_query_args();
        $page       = $query_args['page'];
        $tab        = $query_args['tab'];
        $subtab     = $query_args['subtab'];


        if ( 
            $page == 'hrm_leave'
            ||
            $page == 'hrm_settings'
         ) {

            require_once HRM_PATH . '/templates/index.html';
        } else {
            echo '<div class="hrm wrap" id="hrm">';
            if ( $tab === false ) {
                Hrm_Settings::getInstance()->show_page( $page );
            } else {
                Hrm_Settings::getInstance()->show_tab_page( $page, $tab, $subtab );
            }

            echo '</div>';
        }
     
    }
}

function hrm() {
    return WP_Hrm::instance();
}

//hrm instance.
hrm();



