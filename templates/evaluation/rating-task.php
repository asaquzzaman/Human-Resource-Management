<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'admin' );

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}

if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {
    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}


if ( ( isset( $_GET['action_search'] ) && $_GET['action_search'] ) )  {
    $search_status = true;
    $search_post = get_user_meta( get_current_user_id(), '_hrm_search_data', true );
} else if ( isset( $_POST['action_search'] ) ) {
    $search_status = true;
    $search_post = $_POST;
} else if ( isset( $_POST['search_status'] ) && $_POST['search_status'] ) {
    $search_status = true;
    $search_post = get_user_meta( get_current_user_id(), '_hrm_search_data', true );
} else {
    $search_status = false;
}

$manager_projects = Hrm_Evaluation::getInstance()->get_project_by_manager();
$author_projects = Hrm_Evaluation::getInstance()->get_project_by_author();

$projects = array_merge( $manager_projects->posts, $author_projects->posts );

$option_value = array();
$option_value['-1'] = __( '-Select-', 'hrm' );
foreach ( $projects as $key => $project ) {
	$option_value[$project->ID] = $project->post_title;
}

$search['project_id'] = array(
	'label'    => __( 'Project', 'hrm' ),
	'class'    => 'hrm-chosen',
	'id'	   => 'hrm-rank-task',
	'type'     => 'select',
	'option'   => $option_value,
	'selected' => '',
	'desc'     => __( 'Type project name', 'hrm' ),
	'extra' => array(
		'data-placeholder' => __( "Choose project", 'hrm' ),
    ),
);
$search['visibility']   = $search_status ? true : true;
$search['action'] = 'hrm_search';
$search['table_option'] = '';
$search['button'] = false;

echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'project', 'hrm' ) );

?>

<div class="hrm-evaluation-task-wrap"></div>

