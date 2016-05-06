<?php
        $country = hrm_Settings::getInstance()->country_list();

   
       
        $location['location_id'] = array(
            'type' => 'hidden',
            'value' => '',
        );
        

        $location['name'] = array(
            'label' =>  __( 'Name', 'hrm' ),
            'type' => 'text',
            'value' => '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $location['country'] = array(
            'label' =>  __( 'Country', 'hrm' ),
            'type' => 'select',
            'option'=> $country,
            'selected' => '',
        );

        $location['province'] = array(
            'label' =>  __( 'State/Province', 'hrm' ),
            'type' => 'text',
            'value' => '',
        );
        $location['city'] = array(
            'label' =>  __( 'City', 'hrm' ),
            'type' => 'text',
            'value' => '',
        );

        $location['address'] = array(
            'label' =>  __( 'Address', 'hrm' ),
            'type' => 'textarea',
            'value' => '',
        );

        $location['zipcode'] = array(
            'label' =>  __( 'Zip/Postal Code', 'hrm' ),
            'type' => 'text',
            'value' => '',
        );
        $location['phone'] = array(
            'label' =>  __( 'Phone', 'hrm' ),
            'type' => 'text',
            'value' => '',
        );

        $location['fax'] = array(
            'label' =>  __( 'Fax', 'hrm' ),
            'type' => 'text',
            'value' => '',
        );
        $location['notes'] = array(
            'label' =>  __( 'Notes', 'hrm' ),
            'type' => 'textarea',
            'value' => '',
        );
        $location['action'] = 'ajax_referer_insert';
        $location['table_option'] = 'hrm_location_option';
        $location['header'] = 'Location';
        $location['cancel_id'] = 'hrm_new_job_location_form_cancel';
        $location['submit_id'] = 'hrm_new_job_location_form_submit';
 
        echo hrm_Settings::getInstance()->visible_form_generator( $location );

