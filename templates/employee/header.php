<?php
$menu = hrm_page();
$employee_id = hrm_get_employee_id();
?>
<h2 class="nav-tab-wrapper">
    <?php

    foreach ( $menu[$page] as $key => $tab_event ) {
        if ( !isset( $tab_event['nested_tab'] ) ) {
            continue;
        }

        if ( !$tab_event['nested_tab'] ) {
            continue;
        }

        $active = ( $tab == $key ) ? 'nav-tab-active' : '';
        $url = hrm_employee_menu_url($page, $key, $employee_id); //hrm_tab_menu_url( $key, $page );
        //$url = add_query_arg( array( 'employee_id' => $employee_id ), $url );
        printf( '<a href="%1$s" class="nav-tab %4$s" id="%2$s-tab">%3$s</a>',$url, $tab_event['id'], $tab_event['title'], $active );
    }

    ?>
</h2>
<?php
if ( ! $subtab ) {
   if( !isset( $menu[$page][$tab]['submenu'] ) ) {
        return;
    }

    if ( !count( $menu[$page][$tab]['submenu'] ) ) {
        return;
    }

    $subtab = key( $menu[$page][$tab]['submenu'] );
}

if ( ! $subtab ) {
    return;
}

?>
<h3 class="hrm-sub-nav">
    <ul class="hrm-subsubsub">
        <?php
            foreach ( $menu[$page][$tab]['submenu'] as $sub_key => $sub_event ) {
                $sub_active = ( $sub_key == $subtab ) ? 'hrm-sub-current' : '';
                $sub_event['id'] = isset( $sub_event['id'] ) ? $sub_event['id'] : '';
                $sub_url = hrm_employee_sub_menu_url( $page, $tab, $sub_key, $employee_id );//hrm_subtab_menu_url( $tab, $sub_key, $page );
                //$sub_url = add_query_arg( array( 'employee_id' => $employee_id ), $sub_url );
                printf( '<li><a class="%4$s" href="%1$s" id="%2$s-tab">%3$s</a></li> | ',$sub_url , $sub_event['id'], $sub_event['title'], $sub_active );
            }
        ?>
    </ul>
</h3>


