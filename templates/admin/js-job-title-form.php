<?php
	
    $job['job_id'] = array(
        'value' => '',
        'type'  => 'hidden',
    );
	
	//hidden form
	$job['job_title'] = array(
	    'label' =>  __( 'job Title', 'hrm' ),
	    'value' => '',
	    'type' => 'text',
	    'extra' => array(
	        'data-hrm_validation' => true,
	        'data-hrm_required' => true,
	        'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
	    ),
	);
	$job['job_description'] = array(
	    'label' =>  __( 'Job Description', 'hrm' ),
	    'value' => '',
	    'type' => 'text',
	);

	$job['note'] = array(
	    'label' =>  __( 'Note', 'hrm' ),
	    'value' => '',
	    'type' => 'textarea',
	);
	///$job['action'] = 'hrm_new_job_title';
	$job['table_option'] = 'hrm_job_title_option';
	$job['header'] = 'Job Title';
	$job['cancel_id'] = 'hrm_new_job_title_cancel';
	$job['submit_id'] = 'hrm_new_job_title_submit';
	
	echo hrm_Settings::getInstance()->visible_form_generator( $job );


