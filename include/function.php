<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;
use HRM\Core\Crud\Crud;

function hrm_ajax_delete_records() {
    check_ajax_referer('hrm_nonce');

    $records = hrm_delete_records();
    wp_send_json_success( $records );
}

function hrm_delete_records() {
    return Crud::data_process();
}

function hrm_ajax_get_records() {
    check_ajax_referer('hrm_nonce');

    $records = hrm_get_records();
    wp_send_json_success( $records );
}

function hrm_get_records() {
    return Crud::data_process();
}

function hrm_ajax_insert_records() {
    check_ajax_referer('hrm_nonce');
    
    $records = hrm_insert_records();
    wp_send_json_success( $records );
}

function hrm_insert_records() {
    return Crud::data_process();
}

function hrm_ajax_update_records() {
    check_ajax_referer('hrm_nonce');

    $records = hrm_update_records();
    wp_send_json_success( $records );
}

function hrm_update_records() {
    return Crud::data_process();
}


function hrm_user_can( $cap, $user_id = false) {

    if ( $user_id ) {
        return current_user_can( $cap, $user_id );
    }

    // check is current user administrator
    if ( current_user_can('manage_options') ) {
        return true;
    }

    return current_user_can( $cap );

}

function hrm_map_meta_cap( $caps, $cap, $user_id, $args ) {
    switch ( $cap ) {
        case 'edit_employee':
            $employee_id = isset( $args[0] ) ? $args[0] : false;
            
            if ( $user_id == $employee_id ) {
                $caps = [$cap];
            } else {
                $caps = ['not_allow'];
            }
            
            break;
    }

    return $caps;
}

function hrm_is_current_user_administrator() {

    $current_user = wp_get_current_user();
    $user_roles   = is_array( $current_user->roles ) ? $current_user->roles : array();

    if ( in_array( 'administrator', $user_roles ) ) {
        return true;
    }

    return false;
}

function hrm_current_user_role( $user_id = false ) {
    if ( $user_id ) {
        $current_user = get_user_by( 'id', $user_id );   
    } else {
        global $current_user;    
    }
    
    $roles          = hrm_get_roles();
    $selected_role  = array_intersect_key( $roles, array_flip( $current_user->roles ) );
    
    return $selected_role ? key( $selected_role ) : false;
}

function hrm_current_user_display_role() {
    $role = hrm_current_user_role();

    if ( $role ) {
        return hrm_get_roles( $role );
    }

    return false;
}

/**
 * Helper function for converting a normal date string to unix date/time string
 *
 * @since 0.1
 * @param string $date
 * @param int $gmt
 * @return string
 */
function hrm_date2mysql( $date, $gmt = 0 ) {
    if ( empty( $date ) ) {
        return;
    }

    $time = strtotime( $date );
    return ( $gmt ) ? gmdate( 'Y-m-d H:i:s', $time ) : gmdate( 'Y-m-d H:i:s', ( $time + ( get_option( 'timezone_string' ) * 3600 ) ) );
}

function hrm_get_date2mysql( $date ) {
    if ( empty( $date ) ) {
        return;
    }
    $date = strtotime( $date );
    $format = 'M j, Y';
    return date_i18n( $format, $date );
}

function hrm_get_time( $time, $strtotime = true ) {
    $time_format = get_option( 'time_format' );
    $time_format = apply_filters( 'hrm_time_format', $time_format );
    if ( $strtotime ) {
        $time = strtotime( $time );
    }
    return date( $time_format, $time );
}

function hrm_get_date( $date, $default = false, $gmt = false ) {
    if ( strtotime( $date ) < 0 ) {
        return '';
    }
    
    $date_format = get_option( 'date_format' );

    if ( $default ) {
        $date_format = $default;
    }

    $date_format = apply_filters( 'hrm_date_format', $date_format );

    return date_i18n( $date_format, strtotime( $date ), $gmt );
}

function hrm_get_date_time( $time, $default = false ) {
    $date_format      = get_option( 'date_format' );
    $time_format      = get_option( 'time_format' );
    $date_time_format = $date_format .' '. $time_format;
    
    if ( $default ) {
        $date_time_format = $default;
    }

    $date_time_format = apply_filters( 'hrm_date_time_format', $date_time_format );

    return date_i18n( $date_time_format, strtotime( $time ) );
}

function hrm_second_to_time( $seconds ) {
    $total_second = $seconds;
    // extract hours
    $hours = floor( $seconds / (60 * 60) );

    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor( $divisor_for_minutes / 60 );

    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil( $divisor_for_seconds );

    // return the final array
    $obj = array(
        "hour"         => str_pad( (int) $hours, 2, '0', STR_PAD_LEFT ),
        "minute"       => str_pad( (int) $minutes, 2, '0', STR_PAD_LEFT ),
        "second"       => str_pad( (int) $seconds, 2, '0', STR_PAD_LEFT ),
        'total_second' => $total_second
    );

    return $obj;
}

function hrm_second_to_time_short_form( $seconds ) {
  $t = round($seconds);
  return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}

function hrm_get_second( $start, $end ) {
    if( strtotime( $start ) < 0 ) {
        return 0;
    }

    if( strtotime( $end ) < 0 ) {
        return 0;
    }

    $start = date( 'H:i', strtotime( $start ) );
    $end = date( 'H:i', strtotime( $end ) );

    if (  $start > $end ) {
        $end = date( 'Y-m-d H:i', strtotime( $end . '+1 day' ) );
        $start = date( 'Y-m-d H:i', strtotime( $start ) );
    } else {
        $end = date( 'Y-m-d H:i', strtotime( $end ) );
        $start = date( 'Y-m-d H:i', strtotime( $start ) );
    }

    return strtotime( $end ) - strtotime( $start );
}

function hrm_get_header( $page, $tab, $subtab = false ) {
    $menu = hrm_page();
    ?>
    <h2 class="nav-tab-wrapper">
        <?php

        foreach ( $menu[$page] as $key => $tab_event ) {

            $active = ( $tab == $key ) ? 'nav-tab-active' : '';

            $url = hrm_admin_menu_url( $key );
            printf( 
                '<a href="%1$s" class="nav-tab %4$s" id="%2$s-tab">%3$s</a>', 
                esc_url( $url ), 
                intval( $tab_event['id'] ), 
                esc_attr( $tab_event['title'] ), 
                esc_attr( $active ) 
            );
        }

        ?>
    </h2>
    <?php
    if ( ! $subtab ) {
       return;
    }

    if( !isset( $menu[$page][$tab]['submenu'] ) ) {
        return;
    }

    if ( !count( $menu[$page][$tab]['submenu'] ) ) {
        return;
    }

    $subtab = key( $menu[$page][$tab]['submenu'] );
    ?>
    <h3 class="hrm-sub-nav">
        <ul class="hrm-subsubsub">
            <?php
                foreach ( $menu[$page][$tab]['submenu'] as $sub_key => $sub_event ) {
                    $sub_active = ( $sub_key == $subtab ) ? 'hrm-sub-current' : '';
                    $sub_event['id'] = isset( $sub_event['id'] ) ? $sub_event['id'] : '';
                    $sub_url = hrm_admin_sub_menu_url( $tab, $sub_key );
                    printf( 
                        '<li><a class="%4$s" href="%1$s" id="%2$s-tab">%3$s</a></li> | ',
                        esc_url( $sub_url ), 
                        intval( $sub_event['id'] ), 
                        esc_attr( $sub_event['title'] ), 
                        esc_attr( $sub_active )
                    );
                }
            ?>
        </ul>
    </h3>
    <?php
}

function hrm_get_employee_id() {
    $query = hrm_get_query_args();
    $menu  = hrm_page();
    $page  = $query['page'];
    $tab   = $query['tab'];
    
    if ( !isset( $menu[$page][$tab]['nested_tab'] ) ) {
        return false;
    }

    if ( !$menu[$page][$tab]['nested_tab'] ) {
        return false;
    }

    $employee_id = !empty( $_GET['employee_id'] ) ? intval( $_GET['employee_id'] ) : false;

    return $employee_id;
}

function hrm_pagenum() {
    
    return isset( $_REQUEST['pagenum'] ) ? intval( $_REQUEST['pagenum'] ) : 1;
}

function hrm_result_limit() {
    
    if ( isset( $_REQUEST['limit'] ) && $_REQUEST['limit'] != '-1' ) {
        return intval( $_REQUEST['limit'] );
    } else if ( isset( $_REQUEST['hrm_attr']['limit'] ) && intval( $_REQUEST['hrm_attr']['limit'] ) != '-1' ) {
        return intval( $_REQUEST['hrm_attr']['limit'] );
    } else {
        return 2;
    }
}

function hrm_log( $type = '', $msg = '' ) {

    $msg = sprintf( "[%s][%s] %s\n", date( 'd.m.Y H:i:s' ), $type, $msg );
    error_log( $msg, 3, dirname( __FILE__ ) . '/log.txt' );

}

function hrm_message() {
    $message = array(
        'datatable_pagination' => __( '--Select Pagination--', 'hrm' ),
        'searchPlaceholder'    => __( 'Seach...', 'hrm' ),
        'dtb_pag_all'          => __( 'All', 'hrm' ),
     );

    return apply_filters( 'hrm_message', $message );
}

function hrm_page_slug() {
    $menu = hrm_menu_label();
    foreach ( $menu as $page_slug => $value ) {
        break;
    }

    return $page_slug ? $page_slug : false;
}

/**
 * Embed a JS template page with its ID
 * 
 * @since  0.1
 *
 * @param  string  the file path of the file
 * @param  string  the script id
 *
 * @return void
 */
function hrm_get_js_template( $file_path, $id ) {
   
    if ( file_exists( $file_path ) ) {
        echo '<script type="text/html" id="tmpl-' . intval( $id ) . '">' . "\n";
        include_once $file_path;
        echo "\n" . '</script>' . "\n";
    }
}


function hr_pr() {
    $args = func_get_args();

    foreach ( $args as $arg ) {
        echo '<pre>'; print_r( $arg ); '</pre>';
    }
}

/**
 * WP Timezone Settings
 *
 * @since 2.0.0
 *
 * @return string
 */
function hrm_get_wp_timezone() {
    $momentjs_tz_map = array(
        'UTC-12'    => 'Etc/GMT+12',
        'UTC-11.5'  => 'Pacific/Niue',
        'UTC-11'    => 'Pacific/Pago_Pago',
        'UTC-10.5'  => 'Pacific/Honolulu',
        'UTC-10'    => 'Pacific/Honolulu',
        'UTC-9.5'   => 'Pacific/Marquesas',
        'UTC-9'     => 'America/Anchorage',
        'UTC-8.5'   => 'Pacific/Pitcairn',
        'UTC-8'     => 'America/Los_Angeles',
        'UTC-7.5'   => 'America/Edmonton',
        'UTC-7'     => 'America/Denver',
        'UTC-6.5'   => 'Pacific/Easter',
        'UTC-6'     => 'America/Chicago',
        'UTC-5.5'   => 'America/Havana',
        'UTC-5'     => 'America/New_York',
        'UTC-4.5'   => 'America/Halifax',
        'UTC-4'     => 'America/Manaus',
        'UTC-3.5'   => 'America/St_Johns',
        'UTC-3'     => 'America/Sao_Paulo',
        'UTC-2.5'   => 'Atlantic/South_Georgia',
        'UTC-2'     => 'Atlantic/South_Georgia',
        'UTC-1.5'   => 'Atlantic/Cape_Verde',
        'UTC-1'     => 'Atlantic/Azores',
        'UTC-0.5'   => 'Atlantic/Reykjavik',
        'UTC+0'     => 'Etc/UTC',
        'UTC'       => 'Etc/UTC',
        'UTC+0.5'   => 'Etc/UTC',
        'UTC+1'     => 'Europe/Madrid',
        'UTC+1.5'   => 'Europe/Belgrade',
        'UTC+2'     => 'Africa/Tripoli',
        'UTC+2.5'   => 'Asia/Amman',
        'UTC+3'     => 'Europe/Moscow',
        'UTC+3.5'   => 'Asia/Tehran',
        'UTC+4'     => 'Europe/Samara',
        'UTC+4.5'   => 'Asia/Kabul',
        'UTC+5'     => 'Asia/Karachi',
        'UTC+5.5'   => 'Asia/Kolkata',
        'UTC+5.75'  => 'Asia/Kathmandu',
        'UTC+6'     => 'Asia/Dhaka',
        'UTC+6.5'   => 'Asia/Rangoon',
        'UTC+7'     => 'Asia/Bangkok',
        'UTC+7.5'   => 'Asia/Bangkok',
        'UTC+8'     => 'Asia/Shanghai',
        'UTC+8.5'   => 'Asia/Pyongyang',
        'UTC+8.75'  => 'Australia/Eucla',
        'UTC+9'     => 'Asia/Tokyo',
        'UTC+9.5'   => 'Australia/Darwin',
        'UTC+10'    => 'Australia/Brisbane',
        'UTC+10.5'  => 'Australia/Adelaide',
        'UTC+11'    => 'Australia/Melbourne',
        'UTC+11.5'  => 'Pacific/Norfolk',
        'UTC+12'    => 'Asia/Anadyr',
        'UTC+12.75' => 'Asia/Anadyr',
        'UTC+13'    => 'Pacific/Fiji',
        'UTC+13.75' => 'Pacific/Chatham',
        'UTC+14'    => 'Pacific/Tongatapu',
    );

    $current_offset = get_option('gmt_offset');
    $tzstring       = get_option('timezone_string');

    // Remove old Etc mappings. Fallback to gmt_offset.
    if ( false !== strpos( $tzstring, 'Etc/GMT' ) ) {
        $tzstring = '';
    }

    if ( empty( $tzstring ) ) { // Create a UTC+- zone if no timezone string exists
        if ( 0 == $current_offset ) {
            $tzstring = 'UTC+0';
        } elseif ($current_offset < 0) {
            $tzstring = 'UTC' . $current_offset;
        } else {
            $tzstring = 'UTC+' . $current_offset;
        }

    }

    if ( array_key_exists( $tzstring , $momentjs_tz_map ) ) {
        $tzstring = $momentjs_tz_map[ $tzstring ];
    }

    return $tzstring;
}

/**
 * Get Company financial start date
 *
 * @since  0.1
 *
 * @return string date
 */
function hrm_financial_start_date() {
    return HRM_Settings::getInstance()->get_financial_year();
    return date( 'Y-m-d H:i:s', mktime( 0, 0, 0,  erp_get_option( 'gen_financial_month', 'erp_settings_general', 1 ), 1 ) );
}

/**
 * Get Company financial end date
 *
 * @since  0.1
 *
 * @return string date
 */
function hrm_financial_end_date() {
    $start_date = hrm_financial_start_date();
    return  date( 'Y-m-t', strtotime( '+11 month', strtotime( $start_date ) ) );
}

function hrm_load_schema() {
    $contents = [];
    $files = glob( __DIR__ . "/../db/migrations/*.php" );
    
    $files = apply_filters( 'hrm_load_schema_files', $files );
    
    if ( $files === false ) {
        throw new RuntimeException( "Failed to glob for migration files" );
    }

    foreach ( $files as $file ) {
        $contents[basename( $file, '.php' )] = file_get_contents( $file );
    }

    unset( $file );
    unset( $files );

    return $contents;
}

function hrm_check_financial_year() {    
    $start_date = new DateTime( hrm_financial_start_date() );
    $last_date  = new DateTime( hrm_financial_end_date() ); 
 
    $diff = $last_date->diff( $start_date );

    //As of PHP 5.2.2, DateTime objects can be compared using comparison operators.
    if ( $diff->y > 0 ) {
        Hrm_Settings::getInstance()->insert_financial_year( current_time( 'mysql' ) );
    } 
}

function hrm_get_current_financial_id() {
    return HRM\Models\Financial_Year::orderBy('id', 'desc')
            ->first()
            ->id;
}

function hrm_can_load_footer_tag() {
    $query_args = hrm_get_query_args();
    
    $page       = $query_args['page'];
    $tab        = $query_args['tab'];
    $subtab     = $query_args['subtab'];
    $vue        = ! empty( $_GET['active'] ) && hrm_clean( $_GET['active'] ) == 'vue' ? true : false;


    if ( 
        $page == 'hr_management' && $vue
    ) { 
        return true;
    }

    return false;
}

function hrm_manager_role_key() {
    return 'hrm_manager';
}

function hrm_manager_capability() {
    return array(
        'manage_employee_profile',
        'manage_organization',
        'manage_employee',
        'edit_employee',
        'manage_attendance',
        'hrm_employee',
        'manage_leave',
        'manage_location',
        'manage_notice',
        'manage_department',
        'manage_settings',
        'manage_designation',
        'manage_payroll',
        'payroll_revistion',
        'manage_loan'
    );
}

function hrm_employee_capability() {
    return array(
        'edit_employee',
        'hrm_employee',
        'payroll_revistion',
    );
}

function hrm_employee_role_key() {
    return 'hrm_employee';
}

function hrm_get_roles( $role = false ) {
    $roles = array(
        hrm_employee_role_key() => 'Employee',
        hrm_manager_role_key()  => 'Manager',
    );

    if ( $role ) {
        return $roles[$role];
    }

    return $roles;
}

function hrm_set_capability() {
    hrm_set_manager_capability();
    hrm_set_employee_capability();
    hrm_set_administrator_capability();
}

function hrm_set_manager_capability() {
    $role = get_role( hrm_manager_role_key() );
    
    if ( ! $role ) {
        Hrm_Admin::getInstance()->employer_role();
        $role = get_role( hrm_manager_role_key() );
    }
    
    foreach ( hrm_manager_capability() as $key => $cap ) {
        $role->add_cap( $cap );
    }
}

function hrm_set_employee_capability() {
    $role = get_role( hrm_employee_role_key() );

    if ( ! $role ) {
        Hrm_Admin::getInstance()->employer_role();
        $role = get_role( hrm_employee_role_key() );
    }

    foreach ( hrm_employee_capability() as $key => $cap ) {
        $role->add_cap( $cap );
    }
}

function hrm_set_administrator_capability() {
    $role = get_role( 'administrator' );

    foreach ( hrm_manager_capability() as $key => $cap ) {
        $role->add_cap( $cap );
    }
}

function hrm_get_client_ip() {
    
    $ipaddress = '';

    if ( isset($_SERVER['HTTP_CLIENT_IP'] ) ) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if ( isset( $_SERVER['HTTP_X_FORWARDED'] ) ) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if ( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) ) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if ( isset( $_SERVER['HTTP_FORWARDED'] ) ) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

function hrm_validateDate($date, $format = 'Y-m-d H:i:s'){
    $date = date( $format, strtotime( $date ) );
    $d    = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function hrm_country_list() {
    $list = include dirname( __FILE__ ) . '/iso_country_codes.php';

    return array_merge( array('' => '- Select -'), $list );
}

function hrm_get_country_by_code( $code ) {
    $country_list = hrm_country_list();

    if ( isset($country_list[$code])) {
        return $country_list[$code];
    }

    return false;
}

function hrm_per_page() {
    return 20;
}

function valid_date_time($date, $format = 'Y-m-d H:i:s') {
    $date = date( 'Y-m-d H:i:s', strtotime($date) );
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function hrm_employee_status( $status = false ) {
    $data = array(
        1 => 'Active',
        2 => 'Disable',
        3 => 'Trminate',
    );

    return $status ? $data[$status] : $data;
}

function hrm_employee_gender( $gender = false ) {
    $data = array(
        1 => 'Male',
        2 => 'Female',
        3 => 'Others'
    );

    return $gender ? $data[$gender] : $data;
}

function hrm_tb_prefix() {
    global $wpdb;

    return $wpdb->prefix;
}

function hrm_get_avater( $user_id ) {
    $profile_pic = Hrm_Employee::getInstance()->get_profile_picture( $user_id );
    return empty( $profile_pic ) ? get_avatar_url( $user_id ) : $profile_pic[0]['thumb'];
}

function hrmpr() {
    $args = func_get_args();

    foreach ( $args as $arg ) {
        echo '<pre>'; print_r( $arg ); '</pre>';
    }
}

/**
 * Clean variables using hrm_clean. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function hrm_clean( $var ) {
    if ( is_array( $var ) ) {
        return array_map( 'hrm_clean', $var );
    } else {
        return is_scalar( $var ) ? sanitize_text_field( wp_unslash( $var ) ) : $var;
    }
}


