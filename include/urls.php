<?php
function hrm_tab_menu_url( $tab = null, $page ) {
    $url = sprintf( '%1s?page=%2s&tab=%3s', admin_url( 'admin.php' ), $page, $tab );
    return apply_filters( 'hrm_tab_menu_url', $url, $tab );
}

function hrm_subtab_menu_url( $tab = null, $sub_tab = null, $page ) {
    $url = sprintf( '%1s?page=%2s&tab=%3s&sub_tab=%4s', admin_url( 'admin.php' ), $page, $tab, $sub_tab );
    return apply_filters( 'hrm_subtab_menu_url', $url, $tab, $sub_tab );
}

function hrm_employee_menu_url( $page, $tab = null, $employee_id = null ) {

    $url = sprintf( '%1s?page='.$page.'&employee_id=%s&tab=%3s', admin_url( 'admin.php' ),$employee_id,$tab );
    return apply_filters( 'hrm_employee_menu_url', $url, $page, $tab, $employee_id );
}
function hrm_employee_sub_menu_url( $page, $tab = null, $sub_tab = null, $employee_id = null ) {
    $url = sprintf( '%s?page='.$page.'&tab=%2s&sub_tab=%3s&employee_id=%4s', admin_url( 'admin.php' ), $tab, $sub_tab, $employee_id );
    return apply_filters( 'hrm_employee_sub_menu_url', $url, $page, $tab, $sub_tab, $employee_id );
}

function hrm_pim_menu_url( $tab = null ) {

    $url = sprintf( '%1s?page=hrm_pim&tab=%3s', admin_url( 'admin.php' ),$tab );
    //false mean nested_tab
    return apply_filters( 'hrm_pim_menu_url', $url, $tab, false );
}

function hrm_pim_nested_menu_url( $tab = null ) {
    $url = sprintf( '%1s?page=hrm_pim&nested_tab=%3s', admin_url( 'admin.php' ),$tab );
    //true mean nested tab
    return apply_filters( 'hrm_pim_menu_url', $url, $tab, true );
}

function hrm_sub_tab_url( $page = null, $tab = null, $sub_tab = null ) {
    $url = sprintf( '%s?page=%2s&tab=%3s&sub_tab=%4s', admin_url( 'admin.php' ), $page, $tab, $sub_tab );
    return apply_filters( 'hrm_admin_general_info_url', $url, $page, $tab, $sub_tab );
}

function hrm_tab_url( $page = null, $tab = null ) {
    $url = sprintf( '%1s?page=%2s&tab=%3s', admin_url( 'admin.php' ), $page, $tab );
    return apply_filters( 'hrm_admin_header_menu_url', $url, $page, $tab );
}

function hrm_task_assing_user_url( $page, $tab, $user_id ) {
    $url = admin_url( 'admin.php?' ) . 'page='.$page.'&employee_id='.$user_id.'&tab='. $tab;
    return apply_filters( 'hrm_task_assign_user_url', $url, $page, $tab, $user_id );
}