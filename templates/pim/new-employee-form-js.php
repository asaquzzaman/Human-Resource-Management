<?php
    //Process job title
    $job_title = Hrm_Admin::getInstance()->get_job_titles();

    //Process job category
    $job_category = Hrm_Admin::getInstance()->get_job_categorys();

    //Process job location
    $location  = Hrm_Admin::getInstance()->get_job_locations();
    
    $hidden_form['user_name'] = array(
        'label' =>  __( 'User Name', 'hrm' ),
        'type'  => 'text',
        'value' => '{{employee.user_name}}',
        'placeholder' => __( 'User Name', 'hrm' ),
        'extra' => array(
            'disabled' => '{{employee.data_satatus}}',
            'v-model'  => 'employee.user_name',
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),
    );

    $hidden_form['email'] = array(
        'label'       =>  __( 'E-mail', 'hrm' ),
        'type'        => 'text',  
        'value'       => '{{employee.email}}', 
        'placeholder' => __( 'Email', 'hrm' ),
        'extra' => array(
            'disabled' => '{{employee.data_satatus}}',
            'v-model'  => 'employee.email',
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_email' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            'data-hrm_email_error_msg'=> __( 'Please enter a valid email', 'hrm' ),
        ),
    );

    $hidden_form['employer_id'] = array(
        'value' => '{{employee.ID}}',
        'v-model' => 'employee.ID',
        'type'  => 'hidden',
    );
    

    $hidden_form['first_name'] = array(
        'label' =>  __( 'First Name', 'hrm' ),
        'type'  => 'text',
        'value' => '{{employee.first_name}}',
        'extra' => array(
            'v-model' => 'employee.first_name',
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),
    );
    
    $hidden_form['last_name'] = array(
        'label' =>  __( 'Last Name', 'hrm' ),
        'type'  => 'text',
        'value' => '{{employee.last_name}}',
        'extra' => array(
            'v-model' => 'employee.last_name',
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),
    );
    
   // $new_job_title_url = hrm_job_title();
    $hidden_form['emp_job_title'] = array(
        'label'    => __( 'Job Title', 'hrm' ),
        'type'     => 'select',
        'option'   => $job_title,
        'class'    => 'hrm-job-title-dropdown',
        'selected' => '{{employee.job_title}}',
        'desc'     => sprintf( '<a v-on:click.prevent="showJobTitleForm" class="hrm-form-link" href="#">%s</a>', __( 'Create New', 'hrm' ) ),
        'extra' => array(
            'v-model' => 'employee.job_title',
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),
    );

    $hidden_form['emp_job_category'] = array(
        'label' => __( 'Job Category', 'hrm' ),
        'type' => 'select',
        'option' => $job_category,
        'class'  => 'hrm-job-category-dropdown',
        'selected' => '{{employee.job_category}}',
        'desc' => sprintf( '<a v-on:click.prevent="showJobCategoryForm" class="hrm-form-link" href="#">%s</a>',  __( 'Create New', 'hrm' ) ),
        'extra' => array(
            'v-model' => 'employee.job_category',
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),
    );

    //$location_url = hrm_job_location();
    $hidden_form['emp_location'] = array(
        'label' => __( 'Location', 'hrm' ),
        'type' => 'select',
        'option' => $location,
        'class'  => 'hrm-job-location-dropdown',
        'selected' => '{{employee.job_location}}',
        'desc' => sprintf( '<a v-on:click.prevent="showJobLocationForm" class="hrm-form-link" href="#">%s</a>', __( 'Create New', 'hrm' ) ),
        'extra' => array(
            'v-model' => 'employee.job_location',
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),
    );

    $hidden_form['status'] = array(
        'label' =>  __( 'status', 'hrm' ),
        'type'  => 'select',
        'option' => array(
            'yes' => 'Enable',
            'no' => 'Disable'
        ),
        'extra' => array(
            'v-model' => 'employee.status',
        ),
        'selected' => '{{employee.status}}'
    );
    $hidden_form['mobile'] = array(
        'label' =>  __( 'Mobile Number', 'hrm' ),
        'type'  => 'text',
        'value' => '{{employee.mobile}}',
        'extra' => array(
            'v-model' => 'employee.mobile',
        ),
    );
    $hidden_form['joined_date'] = array(
        'label' =>  __( 'Joined Date', 'hrm' ),
        'type'  => 'text',
        'class' => 'hrm-datepicker',
        'value' => '{{employee.joined_date}}',
        'extra' => array(
            'v-model' => 'employee.joined_date',
        )
    );

    $hidden_form['job_desc'] = array(
        'label' =>  __( 'Description', 'hrm' ),
        'type'  => 'textarea',
        'value' => '{{employee.job_desc}}',
        'extra' => array(
            'v-model' => 'employee.job_desc',
        )
    );


    $hidden_form['action'] = 'new_employer';
    $hidden_form['header'] = 'Employee Information';
   // $hidden_form['url'] = $redirect;
    $hidden_form['cancel_id'] = 'hrm_new_employee_cancel';

    echo hrm_Settings::getInstance()->visible_form_generator( $hidden_form );



