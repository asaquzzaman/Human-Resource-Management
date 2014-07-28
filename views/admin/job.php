
<!-- default $this for class hrm_Admin, $tab; -->
<?php
if ( ! hrm_user_can_access( $tab, null, 'view' ) ) {

    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}
?>

<div class="hrm-job">
    <?php $this->show_sub_tab_page( $menu, $page, $tab, $subtab ); ?>
</div>