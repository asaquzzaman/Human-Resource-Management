<?php
function hrm_user_can_access( $tab = null, $subtab = null, $access_point = null, $inside_role = false  ) {


    $user_id = get_current_user_id();
    $super_admin = get_option( 'hrm_admin', true );

    if ( $user_id == $super_admin ) {
        return true;
    }

    $page = hrm_page();

    //if tab has no access role
    if ( isset( $page[$_GET['page']][$tab]['follow_access_role'] ) && ! $page[$_GET['page']][$tab]['follow_access_role'] ) {
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

function get_date2mysql( $date ) {
    if ( empty( $date ) ) {
        return;
    }
    $date = strtotime( $date );
    $format = 'M j, Y';
    return date_i18n( $format, $date );
}

/*function pri( $data ) {
    echo '<pre>'; print_r( $data ); echo '</pre>';
}*/