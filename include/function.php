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

function hrm_single_tab_user_role_change( $post ) {
    var_dump( $post ); die();
}

/*function pri( $data ) {
    echo '<pre>'; print_r( $data ); echo '</pre>';
}*/