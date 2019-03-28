<?php

class Hrm_Scripts {
	private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new Hrm_Scripts();
        }

        return self::$_instance;
    }

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array ( $this, 'register_scripts' ) );
        add_action( 'wp_enqueue_scripts', array ( $this, 'register_scripts' ) );
    }

    public static function register_scripts() {
        $scripts = self::scripts();

        foreach ( $scripts as $script ) {

            wp_register_script( 
                $script['id'], 
                $script['url'], 
                $script['dependency'], 
                HRM_VERSION, 
                $script['in_footer'] 
            );
        }
    }


    public static function footer_tag() {

        wp_enqueue_media();
        do_action( 'hrm_before_load_script' );
        wp_enqueue_script( 'hrm-scripts' );

        wp_localize_script( 'hrm-uploader', 'HRM_Vars', array(
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
            "email_settings"  => get_option( 'hrm_email_settings', [
                'form_email' => get_bloginfo( 'admin_email' )
            ] ),
            'current_date'    => current_time( 'mysql' ),
            'financial_start' => hrm_financial_start_date(),
            'financial_end'   => hrm_financial_end_date(),
            'user_role'       => hrm_current_user_role(),
            'hrm_roles'       => hrm_get_roles(),
            'permalink'       => get_permalink(),
            'home_url'        => home_url(),
            'hrm_url'         => HRM_URL,
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

        wp_enqueue_style( 'hrm-vue-multiselect', HRM_URL . '/assets/css/vue-multiselect/vue-multiselect.min.css', array(), HRM_VERSION, 'all' );
        wp_enqueue_style( 'hrm-toastr', HRM_URL . '/assets/css/toastr/toastr.min.css', array(), HRM_VERSION, 'all' );
        wp_enqueue_style( 'hrm-jquery-fullcalendar', HRM_URL . '/assets/css/jquery-fullcalendar/fullcalendar.min.css', array(), HRM_VERSION, 'all' );
        wp_enqueue_style( 'hrm-admin', HRM_URL . '/assets/css/admin.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-chosen', HRM_URL . '/assets/css/chosen.min.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui', HRM_URL . '/assets/css/jquery-ui.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-ui-timepicker', HRM_URL . '/assets/css/jquery-ui-timepicker-addon.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-jquery-preloader', HRM_URL . '/assets/css/Elegant-Loading-Indicator/preloader.css', false, false, 'all' );
        wp_enqueue_style( 'hrm-fontawesome', HRM_URL . '/assets/css/fontawesome/font-awesome.min.css', array(), HRM_VERSION, 'all' );
    }


    public static function scripts() {

        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        $scripts = [
            

            'hrm-config' => [
                'id'         => 'hrm-config',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/handler.js',
                'dependency' => ['jquery'],
                'in_footer'  => true
            ],

            'hrm-tiny-mce' => [
                'id'         => 'hrm-tiny-mce',
                'url'        => site_url( '/wp-includes/js/tinymce/tinymce.min.js' ),
                'dependency' => ['hrm-config'],
                'in_footer'  => true
            ],

            'hrm-time-picker' => [
                'id'         => 'hrm-time-picke',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/jquery-ui-timepicker/jquery-ui-timepicker'.$suffix.'.js',
                'dependency' => ['jquery-ui-datepicker','hrm-tiny-mce'],
                'in_footer'  => true
            ],

            'hrm-jed' => [
                'id'         => 'hrm-jed',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/i18n/jed.js',
                'dependency' => ['hrm-time-picke'],
                'in_footer'  => true
            ],
            
            'hrm-i18n' => [
                'id'         => 'hrm-i18n',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/i18n/i18n.js',
                'dependency' => ['hrm-jed'],
                'in_footer'  => true
            ],

            'hrm-vue' => [
                'id'         => 'hrm-vue',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/vue/vue'.$suffix.'.js',
                'dependency' => ['hrm-i18n'],
                'in_footer'  => true
            ],
            'hrm-vuex' => [
                'id'         => 'hrm-vuex',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/vue/vuex'.$suffix.'.js',
                'dependency' => ['hrm-vue'],
                'in_footer'  => true
            ],

            'hrm-vue-router' => [
                'id'         => 'hrm-vue-router',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/vue/vue-router'.$suffix.'.js',
                'dependency' => ['hrm-vuex'],
                'in_footer'  => true
            ],

            'hrm-vue-multiselect' => [
                'id'         => 'hrm-vue-multiselect',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/vue-multiselect/vue-multiselect.min.js',
                'dependency' => ['hrm-vue-router'],
                'in_footer'  => true
            ],

            'hrm-preloader' => [
                'id'         => 'hrm-preloader',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/Elegant-Loading-Indicator/jquery.preloader'.$suffix.'.js',
                'dependency' => ['hrm-vue-multiselect'],
                'in_footer'  => true
            ],
            'hrm-moment' => [
                'id'         => 'hrm-moment',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/moment/moment'.$suffix.'.js',
                'dependency' => ['hrm-preloader'],
                'in_footer'  => true
            ],

            'hrm-fullcalendar' => [
                'id'         => 'hrm-fullcalendar',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/fullcalendar/fullcalendar'.$suffix.'.js',
                'dependency' => ['hrm-moment'],
                'in_footer'  => true
            ],

            'hrm-toastr' => [
                'id'         => 'hrm-toastr',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/toastr/toastr'.$suffix.'.js',
                'dependency' => ['hrm-fullcalendar'],
                'in_footer'  => true
            ],

            'hrm-v-autocomplete' => [
                'id'         => 'hrm-v-autocomplete',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/v-autocomplete/v-autocomplete.min.js',
                'dependency' => ['hrm-toastr'],
                'in_footer'  => true
            ],

            'hrm-vue-library' => [
                'id'         => 'hrm-vue-library',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/library.js',
                'dependency' => ['hrm-v-autocomplete'],
                'in_footer'  => true
            ],

            'hrm-uploader' => [
                'id'         => 'hrm-uploader',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/uploader/uploader.js',
                'dependency' => ['hrm-vue-library'],
                'in_footer'  => true
            ],

            'font-awesome' => [
                'id'         => 'font-awesome',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/font-awesome/font-awesome.min.js',
                'dependency' => ['hrm-uploader'],
                'in_footer'  => true
            ],


            'hrm-const' => [
                'id'         => 'hrm-const',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/vendor/const.js',
                'dependency' => [
                    'jquery', 
                    'underscore',
                    'plupload-handlers',
                    'jquery-ui-dialog',
                    'jquery-ui-progressbar',
                    'jquery-ui-datepicker',
                    'jquery-ui-dialog', 
                    'jquery-ui-autocomplete',
                    'jquery-ui-sortable',
                    'font-awesome'
                ],
                'in_footer'  => true
            ],

            'hrm' => [
                'id'         => 'hrm-scripts',
                'url'        => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/hrm.js',
                'dependency' => [
                    'hrm-const'
                ],
                'in_footer'  => true
            ]
        ];

        return apply_filters( 'hrm_scripts', $scripts );
    }
}




