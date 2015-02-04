<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'leave' );

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}

?>
<!-- default $this for class hrm_Admin, $tab; -->
<div class="hrm-leave-configure" id="hrm-subtab-wrap">
    <?php Hrm_Settings::getInstance()->show_sub_tab_page( $page, $tab, $subtab ); ?>
</div>
