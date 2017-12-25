<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

function hrm_user_can_access( $page = null, $tab = null, $subtab = null, $access_point = null, $user_id = null ) {
    if( ! apply_filters( 'hrm_free_permission', false ) ) {
        return true;
    }

    if ( $user_id === null ) {
        $user_id = get_current_user_id();
    }

    $current_user = get_user_by( 'id', $user_id );

    $super_admin = get_option( 'hrm_admin', true );
    $user_role = reset( $current_user->roles );

    if ( $user_id == $super_admin ) {
        return true;
    }

    if ( $user_role == 'administrator' ) {
        return true;
    }

    $get_role = get_role( $user_role );
    $get_role_cap = $get_role->capabilities;

    if ( ! array_key_exists( $page, $get_role_cap ) ) {
        return false;
    }

    if ( $tab === null ) {
        return true;
    }

    $menu = hrm_page();

    //if tab has no access role
    if ( isset( $menu[$page][$tab]['follow_access_role'] ) && ! $menu[$page][$tab]['follow_access_role'] ) {
        return true;
    }

    //for custom access role
    $inside_tab_role = false;
    $inside_subtab_role = false;

    if ( isset( $menu[$page][$tab]['role'] ) && is_array( $menu[$page][$tab]['role'] ) ) {
        $inside_tab_role = array_key_exists( $access_point, $menu[$page][$tab]['role'] ) ? true : false;
    }

    if ( isset( $menu[$page][$tab]['submenu'] ) && isset( $menu[$page][$tab]['submenu']['role'] ) ) {
        if ( is_array( $menu[$page][$tab]['submenu']['role'] ) && array_key_exists( $access_point, $menu[$page][$tab]['submenu']['role'] ) ) {
            $inside_subtab_role = true;
        }
    }

    if ( $inside_tab_role ) {
       if ( user_can( $user_id, $tab .'_'. $access_point ) ) {
            return true;
        }
    }

    if ( $inside_subtab_role ) {
       if ( user_can( $user_id, $subtab .'_'. $access_point ) ) {
            return true;
        }
    }
    //end

    //check permission for view, edit, delete
    if ( $subtab == null && user_can( $user_id, $tab .'_'. $access_point ) ) {
        return true;
    } else if ( $subtab == null && ! user_can( $user_id, $tab .'_'. $access_point ) ) {
        return false;
    }

    if ( ! user_can( $user_id, $tab .'_'. $access_point ) ) {
        return false;
    }

    if ( user_can( $user_id, $subtab .'_'. $access_point ) ) {
        return true;
    }

    return false;
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

function hrm_get_header( $page, $tab, $subtab = false ) {
    $menu = hrm_page();
    ?>
    <h2 class="nav-tab-wrapper">
        <?php

        foreach ( $menu[$page] as $key => $tab_event ) {

            $active = ( $tab == $key ) ? 'nav-tab-active' : '';

            $url = hrm_admin_menu_url( $key );
            printf( '<a href="%1$s" class="nav-tab %4$s" id="%2$s-tab">%3$s</a>',$url, $tab_event['id'], $tab_event['title'], $active );
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
                    printf( '<li><a class="%4$s" href="%1$s" id="%2$s-tab">%3$s</a></li> | ',$sub_url , $sub_event['id'], $sub_event['title'], $sub_active );
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

function hrm_get_query_args() {

    $menu = hrm_page();

    $page = isset( $_GET['page'] ) && !empty( $_GET['page'] ) ? $_GET['page'] : false;

    if ( !$page ) {
        $query = array(
            'page'   => false,
            'tab'    => false,
            'subtab' => false,
        );
        return apply_filters( 'hrm_query_var', $query );
    }

    if ( isset( $_GET['tab'] ) && !empty( $_GET['tab'] ) ) {
        $tab = $_GET['tab'];
    } else if ( isset( $menu[$page] ) && is_array( $menu[$page] ) ) {
        $tab = array_keys( $menu[$page] );
        $tab = reset( $tab );
        $tab = isset( $menu[$page]['tab'] ) && ( $menu[$page]['tab'] === false ) ? false : $tab;
    } else {
        $tab = false;
    }

    if ( !$tab ) {
        $query = array(
            'page' => $page,
            'tab'  => false,
            'subtab' => false,
        );

        return apply_filters( 'hrm_query_var', $query );
    }

    if ( isset( $_GET['sub_tab'] ) && !empty( $_GET['sub_tab'] ) ) {
        $subtab = $_GET['sub_tab'];
    } else if ( isset( $menu[$page][$tab]['submenu'] ) && count( $menu[$page][$tab]['submenu'] ) ) {
        $subtab = array_keys( $menu[$page][$tab]['submenu'] );
        $subtab = reset( $subtab );
    } else {
        $subtab = false;
    }
    if ( !$subtab ) {
        $query = array(
            'page'   => $page,
            'tab'    => $tab,
            'subtab' => false,
        );
        return apply_filters( 'hrm_query_var', $query );
    } else {
        $query = array(
            'page'   => $page,
            'tab'    => $tab,
            'subtab' => $subtab,
        );

        return apply_filters( 'hrm_query_var', $query );
    }
}

function hrm_pagenum() {
    return isset( $_REQUEST['pagenum'] ) ? intval( $_REQUEST['pagenum'] ) : 1;
}

function hrm_result_limit() {

    if ( isset( $_REQUEST['limit'] ) && $_REQUEST['limit'] != '-1' ) {
        return intval( $_REQUEST['limit'] );
    } else if ( isset( $_REQUEST['hrm_attr']['limit'] ) && $_REQUEST['hrm_attr']['limit'] != '-1' ) {
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
        echo '<script type="text/html" id="tmpl-' . $id . '">' . "\n";
        include_once $file_path;
        echo "\n" . '</script>' . "\n";
    }
}

function hrm_load_orm() {
    $capsule = new Capsule;
   
    $status = $capsule->addConnection( config('db') );

    // Setup eloquent model events
    $capsule->setEventDispatcher(new Dispatcher(new Container));

    // Make this Capsule instance available globally via static methods... (optional)
    $capsule->setAsGlobal();

    // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
    $capsule->bootEloquent();
}

function pr($data) {
    echo '<pre>'; print_r($data); '</pre>';
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
    $vue        = ! empty( $_GET['active'] ) && $_GET['active'] == 'vue' ? true : false;


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
        'manage_hrm_organization',
        'manage_employee',
        'edit_employee',
        'manage_attendance',
        'hrm_employee',
        'manage_leave',
        'manage_location',
        'manage_notice',
        'manage_department',
        'manage_settings'
    );
}

function hrm_employee_capability() {
    return array(
        'edit_employee',
        'hrm_employee'
    );
}

function hrm_employee_role_key() {
    return 'hrm_employee';
}

function hrm_get_roles( $role = false ) {
    $roles = array(
        hrm_employee_role_key() => 'Employee',
        hrm_manager_role_key()  => 'Manager'
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
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}








