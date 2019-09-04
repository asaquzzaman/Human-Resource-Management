<?php
class Hrm_Pim {
    public static function getInstance() {
        static $_instant;

        if( ! $_instant ) {
            $_instant = new hrm_Pim();
        }

        return $_instant;
    }

    function menu_section() {
        $sections['employee_list'] = array(
            'id' => 'hrm-employee-list',
            'title' => __( 'Employee List', 'hrm' ),
            'file_name' => 'employee-list',
        );


        $menu = apply_filters( 'hrm_pim_menu_tabs', $sections );

        if( ! empty( $menu ) && is_array( $menu ) ) {
            return $menu;
        }

        return array();
    }

}