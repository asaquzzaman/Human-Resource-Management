<div class="hrm-update-notification"></div>
<?php

if ( ! hrm_user_can_access( $tab, $subtab, 'view' ) ) {

    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}
?>

<?php
$country = hrm_Settings::getInstance()->country_list();

//default $this for class hrm_Admin, $tab, $subtab;
$field_value = Hrm_Admin::getInstance()->get_general_info();

$field['organization_name'] = array(
    'label' => __( 'Organization Name', 'hrm' ),
    'class' => 'required',
    'type' => 'text',
    'value' => isset( $field_value['data']['organization_name'] ) ? $field_value['data']['organization_name'] : '',
    'extra' => array(
        'data-hrm_validation' => true,
        'data-hrm_required' => true,
        'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
    ),
);
$field['tax_id'] = array(
    'label' => __( 'Tax ID', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['tax_id'] ) ? $field_value['data']['tax_id'] : ''
);
$field['registration_number'] = array(
    'label' => __( 'Registration Number', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['registration_number'] ) ? $field_value['data']['registration_number'] : ''
);


$field['phone'] = array(
    'label' => __( 'Phone', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['phone'] ) ? $field_value['data']['phone'] : ''
);
$field['fax'] = array(
    'label' => __( 'Fax', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['fax'] ) ? $field_value['data']['fax'] : ''
);
$field['email'] = array(
    'label' => __( 'email', 'hrm' ),
    'type' => 'email',
    'value' => isset( $field_value['data']['email'] ) ? $field_value['data']['email'] : ''
);



$field['addres_street_1'] = array(
    'label' => __( 'Address Street 1', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['addres_street_1'] ) ? $field_value['data']['addres_street_1'] : ''
);
$field['address_street_2'] = array(
    'label' => __( 'Address Street 2', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['address_street_2'] ) ? $field_value['data']['address_street_2'] : ''
);
$field['city'] = array(
    'label' => __( 'City', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['city'] ) ? $field_value['data']['city'] : ''
);


$field['state_province'] = array(
    'label' => __( 'State/Province', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['state_province'] ) ? $field_value['data']['state_province'] : ''
);
$field['zip'] = array(
    'label' => __( 'Zip/Postal Code', 'hrm' ),
    'type' => 'text',
    'value' => isset( $field_value['data']['zip'] ) ? $field_value['data']['zip'] : ''
);
$field['country'] = array(
    'label' => __( 'Country', 'hrm' ),
    'type' => 'select',
    'option' => $country,
    'selected' => isset( $field_value['data']['country'] ) ? $field_value['data']['country'] : '' ,
    'desc' => 'Chose your country'
);
$field['note'] = array(
    'label' => __( 'Note', 'hrm' ),
    'type' => 'textarea',
    'value' => isset( $field_value['data']['note'] ) ? $field_value['data']['note'] : ''
);
$field['header'] = 'General Information';
$field['action'] = 'single_form';
$field['table_option'] = 'hrm_general_info';
$field['tab'] = $tab;
$field['subtab'] = $subtab;

echo Hrm_Settings::getInstance()->visible_form_generator( $field );


