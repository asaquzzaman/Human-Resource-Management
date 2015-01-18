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


/*
        $sections['qualification'] = array(
            'id' => 'hrm-qualification',
            'title' => __( 'Qualification', 'hrm' ),
            'file_name' => 'qualification',
            'submenu' => array(
                'skills' => array(
                    'title' => __( 'Skills', 'hrm' ),
                    'file_name' => 'skills',
                ),

                'education' => array(
                    'title' => __( 'Education', 'hrm' ),
                    'file_name' => 'education',
                ),
            ),

        );

        $sections['project_info'] = array(
            'id' => 'hrm-project-info',
            'title' => __( 'Project info', 'hrm' ),
            'file_name' => 'project-info',
            'submenu' => array(
                'skills' => array(
                    'title' => __( 'Customers', 'hrm' ),
                    'file_name' => 'customer',
                ),

                'education' => array(
                    'title' => __( 'Projects', 'hrm' ),
                    'file_name' => 'project',
                ),
            ),

        );*/



        $menu = apply_filters( 'hrm_pim_menu_tabs', $sections );

        if( ! empty( $menu ) && is_array( $menu ) ) {
            return $menu;
        }

        return array();
    }

    function show_tab_page() {
        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';
        $menu = $this->menu_section();

        if( empty( $tab ) && count( $menu )  ) {
            $tab = key( $menu );
            $file_name = isset( $menu[$tab]['file_name'] ) ? $menu[$tab]['file_name'] : '';
            $path = dirname (__FILE__) . '/../templates/pim/' .$file_name. '.php';

            if( file_exists( $path ) ) {
                require_once $path;
            } else {
                echo 'Page not found';
            }
        } else {
            $file_name = isset( $menu[$tab]['file_name'] ) ? $menu[$tab]['file_name'] : '';
            $path = dirname (__FILE__) . '/../templates/pim/' .$file_name. '.php';

            if( file_exists( $path ) ) {
                require_once $path;
            } else {
                echo 'Page not found';
            }
        }
    }
}