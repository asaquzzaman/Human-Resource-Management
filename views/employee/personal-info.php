<?php
if ( hrm_current_user_role() == 'hrm_employee' ) {
    $employee_id = get_current_user_id();
} else {
    $employee_id = isset( $_GET['employee_id'] ) ? $_GET['employee_id'] : '';
}

$country = hrm_Settings::getInstance()->country_list();

$field['user_id'] = array(
    'type' => 'hidden',
    'value' => $employee_id
);


$field['gender'] = array(
    'label'  => __( 'Gender', 'hrm' ),
    'type'   => 'radio',
    'desc'   => 'select your gender',
    'fields' => array(
        array(
            'label'   => __( 'Male', 'hrm' ),
            'value'   => 'male',
            'checked' => $this->get_emp_meta( $employee_id, '_gender' ),
        ),
        array(
            'label'   => __( 'Female', 'hrm' ),
            'value'   => 'female',
            'checked' => $this->get_emp_meta( $employee_id, '_gender' ),
        ),
    ),
);

$field['marital_status'] = array(
    'label'    => __( 'Marital Status', 'hrm' ),
    'type'     => 'select',
    'selected' => $this->get_emp_meta( $employee_id, '_marital_status' ),
    'option'   => array(
        ''     => __( '--Select--', 'hrm' ),
        'single'  => __( 'Single', 'hrm' ),
        'married' => __( 'Married', 'hrm' )
    )
);

$field['national_code'] = array(
    'label'    => __( 'Nationality', 'hrm' ),
    'type'     => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_national_code' )
);

$field['birthday'] = array(
    'label' => __( 'Birthday', 'hrm' ),
    'type'  => 'text',
    'class' => 'hrm-datepicker',
    'value' => get_date2mysql( $this->get_emp_meta( $employee_id, '_birthday' ) ),
);

$field['street1'] = array(
    'label' => __( 'Address Street 1', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_street1' )
);

$field['street2'] = array(
    'label' => __( 'Address Street 2', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_street2' )
);

$field['city_code'] = array(
    'label' => __( 'City', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_city_code' )
);


$field['state'] = array(
    'label' => __( 'State/Province', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_state' )
);

$field['zip'] = array(
    'label' => __( 'Zip/Postal Code', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_zip' )
);


$field['country_code'] = array(
    'label' => __( 'Country', 'hrm' ),
    'type' => 'select',
    'option' => $country,
    'selected' => $this->get_emp_meta( $employee_id, '_country_code' ),
    'desc' => 'Chose your country'
);

$field['work_mobile'] = array(
    'label' => __( 'Work Telephone', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_work_mobile' )
);

$field['work_email'] = array(
    'label' => __( 'Email', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_work_email' ),
    'extra' => array(
        'data-hrm_validation' => true,
        'data-hrm_email' => true,
        'data-hrm_email_error_msg'=> __( 'Please enter a valid email', 'hrm' ),
    ),
);

$field['header']       = 'Personal Information';
$field['action']       = 'update_my_info';
$field['table_option'] = 'hrm_personal_info';
$field['id']           = isset( $results->id ) ? $results->id : '';
$field['tab']          = $tab;
$field['sub_tab']      = $subtab;

echo hrm_Settings::getInstance()->visible_form_generator( $field );

?>

