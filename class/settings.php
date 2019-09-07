<?php
use HRM\Models\Financial_Year;

class Hrm_Settings {
    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new hrm_Settings();
        }

        return self::$_instance;
    }

    function get_emp_meta( $id, $key, $status = true ) {
        return get_user_meta( $id, $key, $status );
    }

    function get_current_page_url( $page, $tab, $subtab ) {
        $url = add_query_arg( array( 'page' => $page, 'tab' => $tab, 'sub_tab' => $subtab ), admin_url('admin.php') );

        return apply_filters( 'hrm_redirect_url', $url, $page, $tab, $subtab );
    }

    function show_page( $page ) {
        $menu = hrm_page();

        $path = isset( $menu[$page]['file_path'] ) ? $menu[$page]['file_path'] : '';

        if( file_exists( $path ) ) {
            include_once $path;
        } else {
            esc_html_e('Page not found', 'hrm' );
        }
    }

    function show_tab_page( $page, $tab, $subtab, $nested_tab = '' ) {
        if ( !$tab ) {
            esc_html_e( 'Missing Tab Page!', 'hrm' );
            return;
        }

        $menu = hrm_page();
        $tab = empty( $nested_tab ) ? $tab : $nested_tab;

        $path = isset( $menu[$page][$tab]['file_path'] ) ? $menu[$page][$tab]['file_path'] : '';

        if( file_exists( $path ) ) {
            include_once $path;
        } else {
            esc_html_e('Page not found', 'hrm' );
        }

    }


    function show_sub_tab_page( $page, $tab, $subtab ) {

        $menu = hrm_page();
        if( !isset( $menu[$page][$tab]['submenu'] ) ) {
            return;
        }

        if( empty( $menu[$page][$tab]['submenu'] ) && count( $menu[$page][$tab]['submenu'] ) ) {

            $subtab = key( $menu[$page][$tab]['submenu'] );

            $path = isset( $menu[$page][$tab]['submenu'][$subtab]['file_path'] ) ? $menu[$page][$tab]['submenu'][$subtab]['file_path'] : '';
            $path = apply_filters( 'hrm_subtab_path', $path, $page, $tab, $subtab );

            if( file_exists( $path ) ) {
                include_once $path;
            } else {
                echo esc_attr_e('Page not found', 'hrm');
            }
        } else {

            $path = isset( $menu[$page][$tab]['submenu'][$subtab]['file_path'] ) ? $menu[$page][$tab]['submenu'][$subtab]['file_path'] : '';

            $path = apply_filters( 'hrm_subtab_path', $path, $page, $tab, $subtab );

            if( file_exists( $path ) ) {
                include_once $path;
            } else {
                echo esc_attr_e('Page not found', 'hrm');
            }
        }
    }

    // function hrm_query( $table, $limit = 0, $pagenum = 1 ) {
    //     global $wpdb;
    //     $tabledb = $wpdb->prefix . $table;
    //     $offset = ( $pagenum - 1 ) * $limit;

    //     if ( $limit ) {
    //         $limit = "LIMIT $offset,$limit";
    //     }

    //     if ( !$limit ) {
    //         $results = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb ORDER BY id desc" );
    //     } else {
    //         $results = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb ORDER BY id desc $limit" );
    //     }

    //     $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );

    //     return $results;
    // }


    function update_table_option( $table_option_name, $table_option ) {
       return update_option( $table_option_name, $table_option );
    }

    function country_list() {
        $list = include dirname( __FILE__ ) . '/../include/iso_country_codes.php';

        return array_merge( $list );
    }

    function get_country_by_code( $code ) {
        $country_list = $this->country_list();

        if ( isset($country_list[$code])) {
            return $country_list[$code];
        }

        return false;
    }

    function get_currency_list() {

        $currency = apply_filters( 'hrm_currency', array(
            'AUD' => __( 'Australian Dollars', 'cpm' ),
            'BRL' => __( 'Brazilian Real', 'cpm' ),
            'CAD' => __( 'Canadian Dollars', 'cpm' ),
            'RMB' => __( 'Chinese Yuan', 'cpm' ),
            'CZK' => __( 'Czech Koruna', 'cpm' ),
            'DKK' => __( 'Danish Krone', 'cpm' ),
            'EUR' => __( 'Euros', 'cpm' ),
            'HKD' => __( 'Hong Kong Dollar', 'cpm' ),
            'HUF' => __( 'Hungarian Forint', 'cpm' ),
            'IDR' => __( 'Indonesia Rupiah', 'cpm' ),
            'INR' => __( 'Indian Rupee', 'cpm' ),
            'ILS' => __( 'Israeli Shekel', 'cpm' ),
            'JPY' => __( 'Japanese Yen', 'cpm' ),
            'KRW' => __( 'South Korean Won', 'cpm' ),
            'MYR' => __( 'Malaysian Ringgits', 'cpm' ),
            'MXN' => __( 'Mexican Peso', 'cpm' ),
            'NOK' => __( 'Norwegian Krone', 'cpm' ),
            'NZD' => __( 'New Zealand Dollar', 'cpm' ),
            'PHP' => __( 'Philippine Pesos', 'cpm' ),
            'PLN' => __( 'Polish Zloty', 'cpm' ),
            'GBP' => __( 'Pounds Sterling', 'cpm' ),
            'RON' => __( 'Romanian Leu', 'cpm' ),
            'SGD' => __( 'Singapore Dollar', 'cpm' ),
            'ZAR' => __( 'South African rand', 'cpm' ),
            'SEK' => __( 'Swedish Krona', 'cpm' ),
            'CHF' => __( 'Swiss Franc', 'cpm' ),
            'TWD' => __( 'Taiwan New Dollars', 'cpm' ),
            'THB' => __( 'Thai Baht', 'cpm' ),
            'TRY' => __( 'Turkish Lira', 'cpm' ),
            'USD' => __( 'US Dollars', 'cpm' ),
        ) );

        return array_unique( $currency );
    }

    function send( $to, $subject, $message, $sender_id ) {
        
        $current_user = get_user_by( 'id', $sender_id );
        $reply        = 'no-reply@' . preg_replace( '#^www\.#', '', strtolower( hrm_clean( $_SERVER['SERVER_NAME'] ) ) );
        $reply_to     = "Reply-To: <$reply>";
        $content_type = 'Content-Type: text/html';
        $charset      = 'Charset: UTF-8';
        $blogname     = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $from_email   = $current_user->user_email;
        $from         = "From: $blogname <$from_email>";

        $headers = array(
            $reply_to,
            $content_type,
            $charset,
            $from
        );

        wp_mail( $to, $subject, $message, $headers );
    }



    /*
     *
     * @Create an HTML drop down menu
     *
     * @param string $name The element name and ID
     *
     * @param int $selected The month to be selected
     *
     * @return string
     *
     */
    function month( $selected = false ) {
        $months = array(
            '-1' => __( '--None--', 'hrm' ),
            1    => __( 'january', 'hrm' ),
            2    => __('february', 'hrm' ),
            3    => __('march', 'hrm' ),
            4    => __('april', 'hrm' ),
            5    => __('may', 'hrm' ),
            6    => __('june', 'hrm' ),
            7    => __('july', 'hrm' ),
            8    => __('august', 'hrm' ),
            9    => __('september', 'hrm' ),
            10   => __('october', 'hrm' ),
            11   => __('november', 'hrm' ),
            12   => __('december', 'hrm' )
        );
        /*** the current month ***/
       // $selected = is_null($selected) ? date('n', time()) : $selected;

        return $selected ? $months[$selected] : $months;
    }

    function year( $selected = false ) {
        $year = array( '-1' => __( '--None--', 'hrm' ) );
        for( $i = 2010; $i <= 2050; $i++ ) {
            $year[$i] = $i;
        }

        return $selected ? $year[$selected] : $year;
    }

    public static function ajax_update_settings() {
        check_ajax_referer('hrm_nonce');
        
        $postdata = [
            'hrm_financial_year' => isset( $_POST['hrm_financial_year'] ) ? hrm_clean( $_POST['hrm_financial_year'] ) : '',
        ];

        self::getInstance()->update_settings($postdata);

        wp_send_json_success();
    }

    public function update_settings( $settings ) {
        if ( empty( $settings['hrm_financial_year'] ) ) {
            $current_date = current_time( 'mysql' );
        } else {
            $current_date = $settings['hrm_financial_year'];
        }
        
        $this->update_financial_year( $current_date );
    }

    function update_financial_year( $date ) {
        $hrm_financial_year = date('Y-m-d H:i:s', strtotime( $date ) );
        $count = Financial_Year::count();
        
        if ( $count > 0 ) {
            
            $last_row = Financial_Year::orderBy('id', 'desc')->first();
            
            Financial_Year::where('id', $last_row->id)->update([
                'start' => $hrm_financial_year
            ]);
            
        } else {
            Financial_Year::create(array(
                'start' => $hrm_financial_year
            ));
        }
    }

    function insert_financial_year( $date ) {
        $hrm_financial_year = date('Y-m-d H:i:s', strtotime( $date ) );
       
        Financial_Year::create(array(
            'start' => $hrm_financial_year
        ));
       
    }

    public function get_settings() {

        return array(
            'hrm_financial_year' => $this->get_financial_year()
        );
    }

    public function get_financial_year() {
        $count = Financial_Year::count();

        if ( $count > 0 ) {
            $last_row = Financial_Year::orderBy('id', 'desc')->first();
            return date('Y-m-d', strtotime( $last_row->start ) );
        } else {
            $current_date   = date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) );
            $financial_date = date( 'Y-07-01', strtotime( current_time( 'mysql' ) ) );

            if ( $financial_date > $current_date ) {
                return date( 'Y-07-01', strtotime( $current_date . '-1 year' ) );
            } else {
                return $financial_date;
            }

        }
    }

    public function hrm_email_settings () {
        check_ajax_referer('hrm_nonce');

        $settings = get_option( 'hrm_email_settings', [
            'form_email' => get_bloginfo( 'admin_email' )
        ]);

        $settings['form_email'] = !empty( $_POST['form_email'] ) && is_email( $_POST['form_email'] ) ? sanitize_email( $_POST['form_email'] ) : $settings['form_email'];
        $settings['email_type'] = !empty( $_POST['email_type'] )  ? hrm_clean( $_POST['email_type'] ) : $settings['email_type'];

        update_option( 'hrm_email_settings', $settings);
        wp_send_json_success(true);
    }

}