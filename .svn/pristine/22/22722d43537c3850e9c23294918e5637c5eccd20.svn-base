<?php
//default $this for class hrm_Admin, $tab, $subtab;
$data = get_option( 'hrm_work_week' );

$field['saturday'] = array(
    'label' => __( 'Saturday', 'hrm' ),
    'type' => 'select',
    'option' => array(
        'full' => 'Full Day',
        'half' => 'Half Day',
        'non' => 'Non-Working Day'
    ),

    'selected' => isset( $data['data']['saturday'] ) ? $data['data']['saturday'] : ''
);
$field['sunday'] = array(
    'label' => __( 'Sunday', 'hrm' ),
    'type' => 'select',
    'option' => array(
        'full' => 'Full Day',
        'half' => 'Half Day',
        'non' => 'Non-Working Day'
    ),
    'selected' => isset( $data['data']['sunday'] ) ? $data['data']['sunday'] : ''
);
$field['monday'] = array(
    'label' => __( 'Monday', 'hrm' ),
    'type' => 'select',
    'option' => array(
        'full' => 'Full Day',
        'half' => 'Half Day',
        'non' => 'Non-Working Day'
    ),
    'selected' => isset( $data['data']['monday'] ) ? $data['data']['monday'] : ''
);


$field['tuesday'] = array(
    'label' => __( 'Tuesday', 'hrm' ),
    'type' => 'select',
    'option' => array(
        'full' => 'Full Day',
        'half' => 'Half Day',
        'non' => 'Non-Working Day'
    ),
    'selected' => isset( $data['data']['tuesday'] ) ? $data['data']['tuesday'] : ''
);
$field['wednesday'] = array(
    'label' => __( 'Wednesday', 'hrm' ),
    'type' => 'select',
    'option' => array(
        'full' => 'Full Day',
        'half' => 'Half Day',
        'non' => 'Non-Working Day'
    ),
    'selected' => isset( $data['data']['wednesday'] ) ? $data['data']['wednesday'] : ''
);
$field['thursday'] = array(
    'label' => __( 'Thursday', 'hrm' ),
    'type' => 'select',
    'option' => array(
        'full' => 'Full Day',
        'half' => 'Half Day',
        'non' => 'Non-Working Day'
    ),
    'selected' => isset( $data['data']['thursday'] ) ? $data['data']['thursday'] : ''
);



$field['friday'] = array(
    'label' => __( 'Friday', 'hrm' ),
    'type' => 'select',
    'option' => array(
        'full' => 'Full Day',
        'half' => 'Half Day',
        'non' => 'Non-Working Day'
    ),
    'selected' => isset( $data['data']['friday'] ) ? $data['data']['friday'] : ''
);

$field['header'] = 'Work Week';
$field['action'] = 'single_form';
$field['table_option'] = 'hrm_work_week';
$field['tab'] = $tab;
$field['subtab'] = $subtab;
$field['submit_btn'] = false;

echo hrm_Settings::getInstance()->visible_form_generator( $field );