<?php
$menu = hrm_page();
?>

<h2 class="nav-tab-wrapper">
    <?php

    foreach ( $menu[$page] as $key => $tab_event ) {
        if ( isset( $tab_event['nested_tab'] ) && $tab_event['nested_tab'] === true ) {
            continue;
        }

        $active = ( $tab == $key ) ? 'nav-tab-active' : '';
        $url = empty( $tab_event['url'] ) ? '/' : $tab_event['url'];
        
        printf( '<router-link to="%s">Go to Bar</router-link>', $url );
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
                $sub_url = hrm_subtab_menu_url( $tab, $sub_key, $page );
                printf( '<li><a class="%4$s" href="%1$s" id="%2$s-tab">%3$s</a></li> | ',$sub_url , $sub_event['id'], $sub_event['title'], $sub_active );
            }
        ?>
    </ul>
</h3>


