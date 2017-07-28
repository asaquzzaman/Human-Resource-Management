<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'attendance' );

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}

?>
<!-- default $this for class hrm_Admin, $tab; -->
<div class="hrm-attendance" id="hrm-subtab-wrap">
	<router-view name="attendance_records"></router-view>
</div>

