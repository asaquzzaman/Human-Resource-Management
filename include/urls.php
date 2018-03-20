<?php
function hrm_tab_menu_url( $tab = null, $page ) {
    $url = sprintf( '%1s?page=%2s&tab=%3s', admin_url( 'admin.php' ), $page, $tab );
    //$url = sprintf( '%1s?page=%2s', admin_url( 'admin.php' ), $page, $tab );
    return apply_filters( 'hrm_tab_menu_url', $url, $page, $tab );
}

function hrm_subtab_menu_url( $tab = null, $sub_tab = null, $page ) {
    $url = sprintf( '%1s?page=%2s&tab=%3s&sub_tab=%4s', admin_url( 'admin.php' ), $page, $tab, $sub_tab );
    return apply_filters( 'hrm_subtab_menu_url', $url, $page, $tab, $sub_tab );
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

function hrm_employee_profile_url( $page, $tab, $employee_id ) {
    $admin_url = add_query_arg(
        array(
            'page'        => $page,
            'tab'         => $tab,
            'employee_id' => trim( $employee_id )
        ), admin_url( 'admin.php' )
    );

    return apply_filters( 'hrm_employee_profile', $admin_url, $page, $tab, $employee_id );

}

function hrm_job_title() {
    $page_name = hrm_admin_page();
    $tab = 'job';
    $sub_tab = 'job_title';
    $url = admin_url( 'admin.php?' ) . 'page='.$page_name.'&tab='.$tab.'&sub_tab='.$sub_tab;
    return apply_filters( 'hrm_job_title_url', $url, $page_name, $tab, $sub_tab );
}

function hrm_job_category() {
    $page_name = hrm_admin_page();
    $tab = 'job';
    $sub_tab = 'job_categories';
    $url = admin_url( 'admin.php?' ) . 'page='.$page_name.'&tab='.$tab.'&sub_tab='.$sub_tab;
    return apply_filters( 'hrm_job_category_url', $url, $page_name, $tab, $sub_tab );
}

function hrm_job_location() {
    $page_name = hrm_admin_page();
    $tab = 'organization';
    $sub_tab = 'location';
    $url = admin_url( 'admin.php?' ) . 'page='.$page_name.'&tab='.$tab.'&sub_tab='.$sub_tab;
    return apply_filters( 'hrm_job_location_url', $url, $page_name, $tab, $sub_tab );
}

function hrm_new_role_url() {
    $page_name = hrm_admin_page();
    $tab = 'admin';
    $sub_tab = 'admin_role';
    $url = admin_url( 'admin.php?' ) . 'page='.$page_name.'&tab='.$tab.'&sub_tab='.$sub_tab;
    return apply_filters( 'hrm_new_role_url', $url, $page_name, $tab, $sub_tab );
}

function hrm_new_pay_grade_url() {
    $page_name = hrm_admin_page();
    $tab = 'job';
    $sub_tab = 'pay_grade';
    $url = admin_url( 'admin.php?' ) . 'page='.$page_name.'&tab='.$tab.'&sub_tab='.$sub_tab;
    return apply_filters( 'hrm_new_pay_grade_url', $url, $page_name, $tab, $sub_tab );
}