<div id="hrm-subtab-wrap">
<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'time' );

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}

if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {
    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}
?>



