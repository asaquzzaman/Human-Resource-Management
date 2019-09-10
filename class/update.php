<?php

class Hrm_Update {

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Binding all events
     *
     * @since 0.1
     *
     * @return void
     */
    function __construct() {
        self::$updates = array(
            '1.1' => HRM_PATH . '/include/updates/update-1.1.php',
            '1.2' => HRM_PATH . '/include/updates/update-1.2.php',
            '2.0' => HRM_PATH . '/include/updates/update-2.0.php',
            '2.1' => HRM_PATH . '/include/updates/update-2.1.php',
        );
        $this->init();
    }

    // function change_employee_role_name() {
    // 	$version = get_option( 'hrm_version' );
 
    //     if ( version_compare( $version, '0.1', '<' ) ) {
    //         return;
    //     }

    //     $args = array(
    //     	'role' => 'hrm_employer'
    //     );

    //     $users = get_users( $args );

    //     foreach ( $users as $key => $user ) {
    //     	wp_update_user( array(
    //     		'ID' => $user->ID,
    //     		'role' => 'hrm_employee'
    //     	));

    //     	update_user_meta( $user->ID, '_hrm_user_role', 'hrm_employee' );
    //     }
    // }
    

    /** @var array DB updates that need to be run */
    private static $updates = array();

    /**
     * Binding all events
     *
     * @since 0.1
     *
     * @return void
     */
    public function init() {
        add_action( 'admin_notices', array( $this, 'show_update_notice' ) );
        add_action( 'admin_init', array( $this, 'do_updates' ) );
    }

    /**
     * Check if need any update
     *
     * @since 1.0
     *
     * @return boolean
     */
    public static function is_needs_update() {
        $installed_version = get_option( 'HRM_VERSION' );

        // may be it's the first install
        if ( ! $installed_version ) {
            return false;
        }

        if ( version_compare( $installed_version, HRM_VERSION, '<' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Show update notice
     *
     * @since 1.0
     *
     * @return void
     */
    public static function show_update_notice() {
        if ( ! current_user_can( 'update_plugins' ) || ! self::is_needs_update() ) {
            return;
        }
        
        $last_file_key           = array_keys( self::$updates );
        $latest_version_file_key = end( $last_file_key );
        
        if ( ! is_null( HRM_VERSION ) && version_compare( HRM_VERSION, $latest_version_file_key, '<=' ) ) {
            ?>
                <div id="message" class="updated">
                    <p><<strong>WP HRM Data Update Required</strong> We need to update your install to the latest version</p>
                    <p class="submit"><a href="<?php echo esc_url( add_query_arg( [ 'HRM_do_update' => true ], esc_url( $_SERVER['REQUEST_URI'] ) ) ); ?>" class="HRM-update-btn button-primary"><?php esc_html_e( 'Run the updater', 'hrm' ); ?></a></p>
                </div>

                <script type="text/javascript">
                    jQuery('.HRM-update-btn').click('click', function(){
                        return confirm( '<?php esc_html_e( 'It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', 'hrm' ); ?>' );
                    });
                </script>
            <?php
        } else {
            update_option( 'hrm_version', HRM_VERSION );
        }

        ?>
        <?php
    }

    /**
     * Do all updates when Run updater btn click
     *
     * @since 1.0
     *
     * @return void
     */
    public static function do_updates() {
        if ( isset( $_GET['HRM_do_update'] ) && hrm_clean( $_GET['HRM_do_update'] ) ) {
            $this->perform_updates();
        }
    }

    /**
     * Perform all updates
     *
     * @since 1.0
     *
     * @return void
     */
    public static function perform_updates() {
        if ( ! self::is_needs_update() ) {
            return;
        }

        $installed_version = get_option( 'hrm_db_version' );

        foreach ( self::$updates as $version => $path ) {
            if ( version_compare( $installed_version, $version, '<' ) ) {
                include $path;
                update_option( 'hrm_db_version', $version );
            }
        }

        $location = remove_query_arg( ['HRM_do_update'], hrm_clean( $_SERVER['REQUEST_URI'] ) );
        wp_redirect( $location );
        exit();
    }

}