<?php
if ( $page == 'hrm_pim' && ! hrm_user_can_access( $tab, $subtab, 'view' ) ) {
    ?>
    <h1><?php _e( 'You do not have permission to access this page', 'hrm' ); ?>
    <?php
    return;
}

?>
<div class="hrm-organization">
    <?php hrm_Settings::getInstance()->show_sub_tab_page( $menu, $page, $tab, $subtab ); ?>
</div>