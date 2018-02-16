<?php

class Hrm_Dashboard {

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new Hrm_Dashboard();
        }

        return self::$_instance;
    }


    function __construct() {
        add_action( 'wp_ajax_hrm_get_dashboard_header_block', array( $this, 'ajax_get_dashboard_header_block' ) );
    }

    function ajax_get_dashboard_header_block() {
        check_ajax_referer('hrm_nonce');
        $dashboard = self::getInstance()->get_dashboard_header_block();
        wp_send_json_success($dashboard);
    }

    function get_dashboard_header_block() {
        return [
            'administrators' => $this->get_administrators(),
            'managers'       => $this->get_hrm_managers(),
            'employees'      => $this->total_employees(),
            'males'          => $this->total_male_employess(),
            'females'        => $this->total_female_employees(),
        ];
    }

    function get_administrators() {
        $admins = get_users([
            'role' => 'administrator'
        ]);

        foreach ( $admins as $key => $value ) {
            $value->avatar = get_avatar_url( $value->ID );
        }

        return $admins;
    }

    function get_hrm_managers() {
        $managers = get_users([
            'role' => hrm_manager_role_key()
        ]);

        foreach ( $managers as $key => $value ) {
            $value->avatar = get_avatar_url( $value->ID );
        }

        return $managers;
    }

    function total_employees() {
        $employees = new WP_User_Query([
            'role'   => hrm_employee_role_key(),
            'number' => 1
        ]);

        return $employees->total_users;
    }

    function total_male_employess() {
        $male_employees = new WP_User_Query([
            'role'   => hrm_employee_role_key(),
            'number' => 1,
            'meta_query' => [
                [
                    'key'     => 'gender',
                    'value'   => 'male',
                    'compare' => '='
                ]
            ]
        ]);

        return $male_employees->total_users;
    }

    function total_female_employees() {
        $female_employees = new WP_User_Query([
            'role'   => hrm_employee_role_key(),
            'number' => 1,
            'meta_query' => [
                [
                    'key'     => 'gender',
                    'value'   => 'female',
                    'compare' => '='
                ]
            ]
        ]);

        return $female_employees->total_users;
    }
}