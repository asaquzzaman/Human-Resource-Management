<?php
     
    $add_field['category_id'] = array(
        'value' => '{{job_category.ID}}',
        'v-model' => 'job_category.ID',
    );
    $add_field['job_category'] = array(
        'label' =>  __( 'Category', 'hrm' ),
        'type' => 'text',
        'desc' => 'please insert category name',
        'value' => '',
        'extra' => array(
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),
    );

    $add_field['active'] = array(

        'label' => __( 'Status', 'hrm' ),
        'type' => 'checkbox',
        'desc' => 'please active this category',
        'fields' => array(
            array(
                'label' => __( 'active', 'hrm' ),
                'value' => 'yes',
                'checked' => '',
            ),
        )
    );

    $add_field['action'] = 'ajax_referer_insert';
    $add_field['table'] = 'hrm_job_category';
    $add_field['header'] = 'Job Catgory';
    $add_field['cancel_id'] = 'hrm_new_job_category_form_cancel';
    $add_field['submit_id'] = 'hrm_new_job_category_form_submit';

    echo hrm_Settings::getInstance()->visible_form_generator( $add_field );

