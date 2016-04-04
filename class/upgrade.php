<?php

class HRM_Upgrade {

    const base_url   = 'http://mishubd.com';
    const product_id = 'hrm_pro';
    const option     = 'hrm_pro_license';
    const slug       = 'hrm_pro';
    const base_file  = 'hrm-pro.php';

    function __construct() {

        //add_action( 'admin_menu', array($this, 'admin_menu'), 49 );

        if ( is_multisite() ) {
            if ( is_main_site() ) {
                add_action( 'admin_notices', array($this, 'license_enter_notice') );
                //add_action( 'admin_notices', array($this, 'license_check_notice') );
            }
        } else {
            add_action( 'admin_notices', array($this, 'license_enter_notice') );
            //add_action( 'admin_notices', array($this, 'license_check_notice') );
        }

        add_filter( 'pre_set_site_transient_update_plugins', array($this, 'check_update') );
        add_filter( 'plugins_api', array(&$this, 'check_info'), 10, 3 );
    }

    /**
     * Add admin menu to User Frontend option
     *
     * @return void
     */
    function admin_menu() {
        //add_submenu_page( 'hrm_management', __( 'Updates', 'hrm' ), __( 'Updates', 'hrm' ), 'activate_plugins', 'hrm_updates', array($this, 'plugin_update') );
    }

    /**
     * Get license key
     *
     * @return array
     */
    function get_license_key() {
        return get_option( self::option, array() );
    }

    /**
     * Prompts the user to add license key if it's not already filled out
     *
     * @return void
     */
    function license_enter_notice() {

        if ( $key = $this->get_license_key() ) {
            return;
        }
        ?>
        <div class="error">
            <p><?php printf( __( 'Please <a href="%s">enter</a> your <strong>HRM-pro</strong> plugin license key to get regular update and support.' ), admin_url( 'admin.php?page=hrm_updates' ) ); ?></p>
        </div>
        <?php
    }

    /**
     * Check activation every 12 hours to the server
     *
     * @return void
     */
    function license_check_notice() {
        if ( !$key = $this->get_license_key() ) {
            return;
        }

        $error = __( 'Pleae activate your copy', 'hrm' );

        $license_status = get_option( self::option );

        if ( $license_status && $license_status->request_status ) {

            $status = get_transient( self::option );

            if ( false === $status ) {
                $status = $this->activation();

                $duration = 60 * 60 * 12; // 12 hour
                set_transient( self::option, $status, $duration );
            }

            if ( $status && $status->success ) {
                return;
            }

            // may be the request didn't completed
            if ( !isset( $status->error )) {
                return;
            }

            $error = $status->error;
        }
        ?>
        <div class="error">
            <p><strong><?php _e( 'WP Human Resource Management Error:', 'hrm' ); ?></strong> <?php echo $error; ?></p>
        </div>
        <?php
    }

    /**
     * Activation request to the plugin server
     *
     * @return object
     */
    function activation( $request = 'check' ) {
        $option = $this->get_license_key();
        if ( !$option ) {
            return;
        }

        $args = array(
            'request'     => $request,
            'email'       => $option['email'],
            'licence_key' => $option['key'],
            'product_id'  => self::product_id,
            'home_url'    => home_url()
        );

        $base_url   = add_query_arg( 'wc-api', 'software-api', self::base_url );
        $target_url = $base_url . '&' . http_build_query( $args, '', '&' );
        $response   = wp_remote_get( $target_url, array( 'timeout' => 15 ) );
        $update     = wp_remote_retrieve_body( $response );

        if ( is_wp_error( $response ) || $response['response']['code'] != 200 ) {
            return false;
        }

        return json_decode( $update );
    }

    /**
     * Integrates into plugin update api check
     *
     * @param object $transient
     * @return object
     */
    function check_update( $transient ) {

        if ( isset( $transient->checked ) && empty( $transient->checked ) ) {
            return $transient;
        }

        $remote_info = $this->get_info();

        if ( !$remote_info ) {
            return $transient;
        }

        list( $plugin_name, $plugin_version) = $this->get_current_plugin_info();

        if ( version_compare( $plugin_version, $remote_info->latest, '<' ) ) {

            $obj              = new stdClass();
            $obj->slug        = $remote_info->name;
            $obj->slug        = self::slug;
            $obj->new_version = $remote_info->latest;
            $obj->url         = self::base_url;

            if ( isset( $remote_info->latest_url ) ) {
                $obj->package = $remote_info->latest_url;
            }

            $basefile = plugin_basename( dirname( dirname( __FILE__ ) ) . '/' . self::base_file );
            $transient->response[$basefile] = $obj;
        }
        return $transient;
    }


    /**
     * Plugin changelog information popup
     *
     * @param type $false
     * @param type $action
     * @param type $args
     * @return \stdClass|boolean
     */
    function check_info( $false, $action, $args ) {

        if ( self::slug == $args->slug ) {

            $remote_info = $this->get_info();

            $obj = new stdClass();
            $obj->name  = $remote_info->name;
            $obj->slug = self::slug;
            $obj->new_version = $remote_info->latest;

            if ( isset( $remote_info->latest_url ) ) {
                $obj->download_link = $remote_info->latest_url;
            }

            $obj->sections = array(
                'description' => $remote_info->msg
            );

            return $obj;
        }

        return false;
    }

    /**
     * Collects current plugin information
     *
     * @return array
     */
    function get_current_plugin_info() {
        require_once ABSPATH . '/wp-admin/includes/plugin.php';

        $plugin_data = get_plugin_data( dirname( dirname( __FILE__ ) ) . '/' . self::base_file );
        $plugin_name = $plugin_data['Name'];
        $plugin_version = $plugin_data['Version'];

        return array($plugin_name, $plugin_version);
    }

    /**
     * Get plugin update information from server
     *
     * @global string $wp_version
     * @global object $wpdb
     * @return boolean
     */
    function get_info() {
        global $wp_version, $wpdb;

        list( $plugin_name, $plugin_version) = $this->get_current_plugin_info();

        if ( is_multisite() ) {
            $wp_install = network_site_url();
        } else {
            $wp_install = home_url();
        }

        $locale = apply_filters( 'core_version_check_locale', get_locale() );

        if ( method_exists( $wpdb, 'db_version' ) )
            $mysql_version = preg_replace( '/[^0-9.].*/', '', $wpdb->db_version() );
        else
            $mysql_version = 'N/A';

        $license = $this->get_license_key();

        $params = array(
            'timeout' => 30,
            'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url(),
            'body' => array(
                'name'          => $plugin_name,
                'slug'          => self::slug,
                'type'          => 'plugin',
                'version'       => $plugin_version,
                'site_url'      => $wp_install,
                'license'       => isset( $license->license_key ) ? $license->license_key : '',
                'license_email' => isset( $license->email ) ? $license->email : '',
                'product_id'    => self::product_id
            )
        );

        $response = wp_remote_post( self::base_url . '?action=hrm_pro_update_check', $params );
        $update = wp_remote_retrieve_body( $response );

        if ( is_wp_error( $response ) || $response['response']['code'] != 200 ) {
            return false;
        }

        return json_decode( $update );
    }

    /**
     * Plugin license enter admin UI
     *
     * @return void
     */
    function plugin_update() {

        $errors = array();
        if ( isset( $_POST['hrm_pro'] ) ) {
            if ( empty( $_POST['email'] ) ) {
                $errors[] = __( 'Empty email address', 'hrm' );
            }

            if ( empty( $_POST['license_key'] ) ) {
                $errors[] = __( 'Empty license key', 'hrm' );
            }

            if ( !$errors ) {
                update_option( self::option, array('email' => $_POST['email'], 'key' => $_POST['license_key']) );
                delete_transient( self::option );

                $license_status = get_option( self::option );

                if ( !isset( $license_status->request_status ) || $license_status->request_status != true ) {
                    $response = $this->activation( 'hrm_pro_activation' );
                    if ( $response && isset( $response->request_status ) && $response->request_status ) {

                        update_option( self::option, $response );
                    }
                }


                echo '<div class="updated"><p>' . __( 'Settings Saved', 'hrm' ) . '</p></div>';
            }
        }

        if ( isset( $_POST['delete_license'] ) ) {
            delete_option( self::option );
            delete_transient( self::option );
            delete_option( self::option );
        }

        $license = $this->get_license_key();
        $email = isset( $license->email ) && $license->email ? $license->email : '';
        $key = isset( $license->license_key ) && $license->license_key ? $license->license_key : '';
        ?>
        <div class="wrap">
            <?php screen_icon( 'plugins' ); ?>
            <h2><?php _e( 'Plugin Activation', 'hrm' ); ?></h2>

            <p class="description">
                Enter the E-mail address that was used for purchasing the plugin and the license key.
                We recommend you to enter those details to get regular <strong>plugin update and support</strong>.
            </p>

            <?php
            if ( $errors ) {
                foreach ($errors as $error) {
                    ?>
                    <div class="error"><p><?php echo $error; ?></p></div>
                    <?php
                }
            }

            $license_status = get_option( self::option );
            if ( !isset( $license_status->request_status ) || $license_status->request_status != true ) {
                ?>

                <form method="post" action="">
                    <table class="form-table">
                        <tr>
                            <th><?php _e( 'E-mail Address', 'hrm' ); ?></th>
                            <td>
                                <input type="email" name="email" class="regular-text" value="<?php echo esc_attr( $email ); ?>" required>
                                <span class="description"><?php _e( 'Enter your purchase Email address', 'hrm' ); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th><?php _e( 'License Key', 'hrm' ); ?></th>
                            <td>
                                <input type="text" name="license_key" class="regular-text" value="<?php echo esc_attr( $key ); ?>">
                                <span class="description"><?php _e( 'Enter your license key', 'hrm' ); ?></span>
                            </td>
                        </tr>
                    </table>

                    <?php submit_button( 'Save & Activate', 'hrm_pro', 'hrm_pro' ); ?>
                </form>
            <?php } else { ?>

                <div class="updated">
                    <p><?php _e( 'Plugin is activated', 'hrm' ); ?></p>
                </div>

                <form method="post" action="">
                    <?php submit_button( __( 'Delete License', 'hrm' ), 'delete', 'delete_license' ); ?>
                </form>

            <?php } ?>
        </div>
        <?php
    }

}


