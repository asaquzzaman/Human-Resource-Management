<?php

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

$search['action'] = 'hrm_search';
$search['table_option'] = '';
$search['button'] = false;

echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'project', 'hrm' ) );

?>

<div class="hrm-evaluation-task-wrap"></div>

