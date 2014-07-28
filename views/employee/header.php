<?php
$instance = hrm_Pim::getInstance();

//$menu[$page] always return array
//$menu[$page] = hrm_Employee::getInstance()->menu_section();
//pri($menu[$page]);
$page = $_GET['page'];
$menu = hrm_page();
if ( isset( $_GET['employee_id'] ) && !empty( $_GET['employee_id'] ) ) {
    unset( $menu['hrm_pim']['employee_list'] );
}

?>

<h2 class="nav-tab-wrapper">
    <?php
    $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : key( $menu[$page] );
    $employee_id = isset( $_GET['employee_id'] ) ? $_GET['employee_id'] : '';

    foreach ( $menu[$page] as $key => $tab_event ) {

        $active = ( $tab == $key ) ? 'nav-tab-active' : '';

        $url = hrm_employee_menu_url( $page, $key, $employee_id );

        printf( '<a href="%1$s" class="nav-tab %4$s" id="%2$s-tab">%3$s</a>',$url, $tab_event['id'], $tab_event['title'], $active );
    }

    ?>
</h2>

<h3 class="hrm-sub-nav">
    <ul class="hrm-subsubsub">
        <?php

        if( isset( $_GET['sub_tab'] ) && !empty( $_GET['sub_tab'] ) ) {
            $subtab = $_GET['sub_tab'];
        } else if( isset( $menu[$page][$tab]['submenu'] ) && is_array( $menu[$page][$tab]['submenu'] ) ) {
            $subtab = key( $menu[$page][$tab]['submenu'] );
        }

        if( isset( $menu[$page][$tab]['submenu'] ) && is_array( $menu[$page][$tab]['submenu'] ) && count( $menu[$page][$tab]['submenu'] )  ) {
            foreach ( $menu[$page][$tab]['submenu'] as $sub_key => $sub_event ) {
                $sub_active = ( $sub_key == $subtab ) ? 'hrm-sub-current' : '';
                $sub_event['id'] = isset( $sub_event['id'] ) ? $sub_event['id'] : '';
                $sub_url = hrm_employee_sub_menu_url( $page, $tab, $sub_key, $employee_id );
                printf( '<li><a class="%4$s" href="%1$s" id="%2$s-tab">%3$s</a></li> | ',$sub_url , $sub_event['id'], $sub_event['title'], $sub_active );
            }
        }

        ?>
    </ul>
</h3>
<?php $subtab = isset( $subtab ) ? $subtab : ''; ?>

<?php hrm_Settings::getInstance()->show_tab_page( $menu, $page, $tab, $subtab ); ?>