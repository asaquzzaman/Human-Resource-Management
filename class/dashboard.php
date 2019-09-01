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
            'role' => 'administrator',
        ]);
        
        foreach ( $admins as $key => $value ) {
            unset( $value->user_login );
            unset( $value->user_pass );
            $value->avatar = hrm_get_avater( $value->ID );
        }
        
        return $admins;
    }

    function get_hrm_managers() {
        $managers = get_users([
            'role' => hrm_manager_role_key(),
        ]);
        
        foreach ( $managers as $key => $value ) {
            unset( $value->user_login );
            unset( $value->user_pass );
            $value->avatar = hrm_get_avater( $value->ID );
        }

        return $managers;
    }

    function total_employees() {
        $employees = new WP_User_Query([
            'role__in'   => [hrm_employee_role_key(),hrm_manager_role_key()],
            'number' => 1
        ]);

        return $employees->total_users;
    }

    function total_male_employess() {
        $male_employees = new WP_User_Query(array(
            'role__in'   => array( hrm_manager_role_key(), hrm_employee_role_key() ),
            'number' => -1,
            'meta_query' => array(
                array(
                    'key'     => 'hrm_gender',
                    'value'   => '1',
                    'compare' => '='
                )
            )
        ));
        
        return $male_employees->total_users;
    }

    function total_female_employees() {
        $female_employees = new WP_User_Query([
            'role__in'   => array( hrm_manager_role_key(), hrm_employee_role_key() ),
            'number' => -1,
            'meta_query' => [
                [
                    'key'     => 'hrm_gender',
                    'value'   => '2',
                    'compare' => '='
                ]
            ]
        ]);

        return $female_employees->total_users;
    }
}