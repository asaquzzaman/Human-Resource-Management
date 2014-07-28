<?php
$employee_id = isset( $_GET['employee_id'] ) ? $_GET['employee_id'] : '';
$field['job_title'] = array(
    'label' => __( 'Membership', 'hrm' ),
    'type' => 'select',
    'option' => array('job'=> 'Membership'),
    'selected' => isset( $results->job_title_code ) ? $results->job_title_code : ''
);

$field['status'] = array(
    'label' => __( 'Subscription Paid By', 'hrm' ),
    'type' => 'select',
    'option' => array(
    	'enable' => 'Company',
    	'disble' => 'Individual',
    ),
    'selected' => isset( $results->emp_status ) ? $results->emp_status : ''
);

$field['joined_date'] = array(
    'label' => __( 'Subscription Amount', 'hrm' ),
    'type' => 'text',
    'value' => isset( $results->joined_date ) ? $results->joined_date : ''
);

$field['job_category'] = array(
    'label' => __( 'Currency', 'hrm' ),
    'type' => 'select',
    'option' => array( 'bd' => 'Bangladesh'),
    'selected' => isset( $results->emp_lastname ) ? $results->emp_lastname : ''
);


$field['contact_start'] = array(
    'label' => __( 'Subscription Commence Date ', 'hrm' ),
    'type' => 'text',
    'value' => isset( $results->emp_street2 ) ? $results->emp_street2 : ''
);



$field['contact_end'] = array(
    'label' => __( 'Subscription Renewal Date', 'hrm' ),
    'type' => 'text',
    'value' => isset( $results->city_code ) ? $results->city_code : ''
);




$field['header'] = 'Membership';
$field['action'] = 'ajax_referer_insert';
$field['table_option'] = 'hrm_employee';
$field['id'] = $employee_id;

echo hrm_Settings::getInstance()->visible_form_generator( $field );