<?php
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

function hrm_current_user_role() {
    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = reset($user_roles);

    return $user_role;
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
    $time_format = get_option('time_format');
    $time_format = apply_filters( 'hrm_time_format', $time_format );
    if ( $strtotime ) {
        $time = strtotime( $time );
    }
    return date( $time_format, $time );
}

function hrm_get_punch_in_time( $time, $strtotime = true ) {
    $date_format = get_option('date_format');
    $time_format = get_option('time_format');
    if ( $strtotime ) {
        $time = strtotime($time);
    }

    $format = $date_format .' '. $time_format;
    return date( $format , $time );
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

    $msg = sprintf( "[%s][%s] %s\n", date( 'd.m.Y h:i:s' ), $type, $msg );
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

function hrm_get_role() {
    global $wp_roles;

    if ( !$wp_roles ) {
        $wp_roles = new WP_Roles();
    }

    return $wp_roles->get_names();
}

function hrm_page_slug() {
    $menu = hrm_menu_label();
    foreach ( $menu as $page_slug => $value ) {
        break;
    }

    return $page_slug ? $page_slug : false;
}

