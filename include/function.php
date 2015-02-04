<?php
function hrm_user_can_access( $tab = null, $subtab = null, $access_point = null, $inside_role = false  ) {


    $user_id = get_current_user_id();
    $super_admin = get_option( 'hrm_admin', true );

    if ( $user_id == $super_admin ) {
        return true;
    }

    $page = hrm_page();

    //if tab has no access role
    if ( isset( $page[$_REQUEST['page']][$tab]['follow_access_role'] ) && ! $page[$_REQUEST['page']][$tab]['follow_access_role'] ) {
        return true;
    }


    $current_user_role = hrm_current_user_role();
    $roles =  get_role( $current_user_role );

    if ( $inside_role ) {
        return  isset( $roles->capabilities[$access_point] ) ? $access_point : false;
    }

    $tab_access = isset( $roles->capabilities[$tab.'_'.$access_point] ) ? $roles->capabilities[$tab.'_'.$access_point] : '';
    $subtab_access = isset( $roles->capabilities[$subtab.'_'.$access_point] ) ? $roles->capabilities[$subtab.'_'.$access_point] : '';

    if( $tab_access != $access_point ) {
        return false;
    }

    if( $subtab == null ) {
        if( $roles->capabilities[$tab.'_'.$access_point] == $access_point ) {
            return true;
        } else {
            return false;
        }
    }

    if( $subtab_access != $access_point ) {
        return false;
    }

    if( isset( $roles->capabilities[$subtab.'_'.$access_point] ) && $roles->capabilities[$subtab.'_'.$access_point]  == $access_point ) {
        return true;
    } else {
        return false;
    }

}

function hrm_current_user_role() {
    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

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
    } else if ( isset( $menu[$page] ) && count( $menu[$page] ) ) {
        $tab =  array_keys( $menu[$page] );
        $tab = reset( $tab );
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
    return isset( $_POST['pagenum'] ) ? intval( $_POST['pagenum'] ) : 1;
}

function hrm_result_limit() {

    if ( isset( $_POST['limit'] ) && $_POST['limit'] ) {
        return intval( $_POST['limit'] );
    } else if ( isset( $_POST['hrm_attr']['limit'] ) && $_POST['hrm_attr']['limit'] ) {
        return intval( $_POST['hrm_attr']['limit'] );
    } else {
        return 2;
    }
}

