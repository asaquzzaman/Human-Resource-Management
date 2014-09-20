<?php

class Hrm_Employee {

    function __construct() {
        add_filter( 'hrm_employer_memu', array( $this, 'pim_to_employer' ) );
    }

    function pim_to_employer( $page = null ) {
        if ( isset( $_GET['page'] ) && $_GET['page'] == 'hrm_employer' ) {
            unset( $page['hrm_pim']['employee_list'] );
            $page['hrm_employer'] = $page['hrm_pim'];
            $page['hrm_employer']['personal']['follow_access_role'] = false;
            $page['hrm_employer']['organization_info']['follow_access_role'] = false;
            $page['hrm_employer']['my_task']['follow_access_role'] = false;
            $page['hrm_employer']['leave']['follow_access_role'] = false;
            unset( $page['hrm_pim'] );
        }

        return $page;
    }

    function current_user_task( $user_id, $subtab ) {
        global $wpdb;

        if ( isset( $subtab ) && $subtab == 'outstanding_task' ) {

            $query1 = "AND tcomp.meta_key = '_completed' AND tcomp.meta_value = '0'";
            $query2 = "AND tend.meta_value != '' AND STR_TO_DATE( tend.meta_value, '%Y-%m-%d') < STR_TO_DATE( NOW(), '%Y-%m-%d')";
        } else if ( isset( $subtab ) && $subtab == 'completed_task' ) {

            $query1 = "AND tcomp.meta_key = '_completed' AND tcomp.meta_value = '1'";
            $query2 = '';
        } else {
            $query1 = "AND tcomp.meta_key = '_completed' AND tcomp.meta_value = '0'";
            $query2 = "AND ( tend.meta_value = '' OR STR_TO_DATE( tend.meta_value, '%Y-%m-%d') >= STR_TO_DATE( NOW(), '%Y-%m-%d') ) ";
        }

        $sql = "SELECT t.post_title as t_t, t.ID as tID, tpm.meta_value as tassign, tend.meta_value as tend,
                p.post_title as p_t, p.ID as pID
                FROM $wpdb->posts as t
                LEFT JOIN $wpdb->posts as p ON p.ID = t.post_parent
                LEFT JOIN $wpdb->postmeta as tpm ON tpm.post_id = t.ID
                LEFT JOIN $wpdb->postmeta as tend ON tend.post_id = t.ID
                LEFT JOIN $wpdb->postmeta as tcomp ON tcomp.post_id = t.ID
                WHERE
                t.post_type = 'hrm_task' AND t.post_status = 'publish'
                AND p.post_type = 'hrm_project' AND p.post_status = 'publish'
                AND tpm.meta_key = '_assigned' AND tpm.meta_value = $user_id
                $query1
                AND tend.meta_key = '_end_date' $query2";

        $results = $wpdb->get_results($sql, ARRAY_A );

        $retrun = array();
        foreach ( $results as $key => $result ) {
            if ( array_key_exists( $result['pID'], $retrun ) ) {
                $retrun[$result['pID']][] = $result;
            } else {
                $retrun[$result['pID']][] = $result;
                $retrun[$result['pID']]['p_title'] = $result['p_t'];
            }
        }

        return $retrun;

    }

	public static function getInstance() {
		static $_instance;
		if( ! $_instance ) {
			$_instance = new hrm_Employee();
		}

		return $_instance;
	}

    function delete_employee( $users_id = array() ) {
        $delte_user = false;
        foreach ( $users_id as $user_id ) {
            $delte_user = wp_delete_user( $user_id );
        }

        return $delte_user;
    }

    function edit_my_info( $postdata, $table_options ) {
        $id = $postdata['user_id'];
        $user_id = false;

        foreach ( $table_options as $db_field => $form_field ) {
            if ( ! isset( $postdata[$form_field] ) ) {
                continue;
            }
            $user_id = update_user_meta( $id, $db_field, esc_attr( $postdata[$form_field] ) );
        }

        if ( $user_id ) {
            return $user_id;
        } else {
            return false;
        }

    }


    function get_employee( $employee_id, $table ) {
    	$table_option['table_name'] = '';
    	$table_option = get_option( $table );
    	global $wpdb;
    	$table = $wpdb->prefix . $table_option['table_name'];
    	return $wpdb->get_row( "SELECT * FROM $table WHERE id = $employee_id" );
    }

    function education( $field_data = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        if ( $field_data !== null ) {
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $_POST['selfData']['id'] ) ? $_POST['selfData']['id'] : '',
            );
        }

        $hidden_form['emp_id'] = array(
            'type' => 'hidden',
            'value' => isset( $_POST['hrm_dataAttr']['emp_id'] ) ? $_POST['hrm_dataAttr']['emp_id'] : '',
        );

        $hidden_form['education_id'] = array(
            'label' => __( 'Level', 'hrm' ),
            'type' => 'select',
            'option' => json_decode( stripcslashes( $_POST['hrm_dataAttr']['education'] ) ),
            'selected' => isset( $field_data['education_id'] ) ? $field_data['education_id'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['institute'] = array(
            'label' =>  __( 'Institute', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_data['institute'] ) ?  $field_data['institute'] : '',
        );

        $hidden_form['major'] = array(
            'label' =>  __( 'Major/Specialization', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_data['major'] ) ?  $field_data['major'] : '',
        );

        $hidden_form['year'] = array(
            'label' =>  __( 'Year', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-datepicker',
            'value' => isset( $field_data['year'] ) ? hrm_date2mysql( $field_data['year'] ) : '',
        );

        $hidden_form['score'] = array(
            'label' =>  __( 'GPA/Score', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_data['score'] ) ? $field_data['score'] : '',
        );

        $hidden_form['start_date'] = array(
            'label' =>  __( 'Start Date', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-datepicker',
            'value' => isset( $field_data['start_date'] ) ? hrm_date2mysql( $field_data['start_date'] ) : '',
        );

        $hidden_form['end_date'] = array(
            'label' =>  __( 'End Date', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-datepicker',
            'value' => isset( $field_data['end_date'] ) ? hrm_date2mysql( $field_data['end_date'] ) : '',
        );


        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_personal_education';
        $hidden_form['header'] = __('Add Education', 'hrm');
        $hidden_form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function work_experience( $field_data = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_data !== null ) {
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_data['id'] ) ? $field_data['id'] : '',
            );
        }

        $hidden_form['emp_id'] = array(
            'type' => 'hidden',
            'value' => isset( $_POST['hrm_dataAttr']['emp_id'] ) ? $_POST['hrm_dataAttr']['emp_id'] : '',
        );

        $hidden_form['company_name'] = array(
            'label' =>  __( 'Company Name', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_data['company_name'] ) ? $field_data['company_name'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['job_title'] = array(
            'label' =>  __( 'Job Title', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_data['job_title'] ) ? $field_data['job_title'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['form'] = array(
            'label' =>  __( 'From', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-datepicker',
            'value' => isset( $field_data['form'] ) ? hrm_date2mysql( $field_data['form'] ) : '',
        );

        $hidden_form['to'] = array(
            'label' =>  __( 'To', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-datepicker',
            'value' => isset( $field_data['to'] ) ? hrm_date2mysql( $field_data['to'] ) : '',
        );

        $hidden_form['description'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $field_data['description'] ) ? $field_data['description'] : '',
        );

        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_work_experience';
        $hidden_form['header'] = __('Add Work Experience', 'hrm');
        $hidden_form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function personal_skill( $field_data = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_data !== null ) {
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_data['id'] ) ? $field_data['id'] : '',
            );
        }

        $hidden_form['emp_id'] = array(
            'type' => 'hidden',
            'value' => isset( $_POST['hrm_dataAttr']['emp_id'] ) ? $_POST['hrm_dataAttr']['emp_id'] : '',
        );

        $hidden_form['skill_id'] = array(
            'label' => __( 'Level', 'hrm' ),
            'type' => 'select',
            'option' => json_decode( stripcslashes( $_POST['hrm_dataAttr']['skill'] ) ),
            'selected' => isset( $field_data['skill_id'] ) ? $field_data['skill_id'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['years_of_exp'] = array(
            'label' =>  __( 'Years of experiance', 'hrm' ),
            'class' => 'hrm-datepicker',
            'type' => 'text',
            'value' => isset( $field_data['years_of_exp'] ) ?  $field_data['years_of_exp'] : '',
        );

        $hidden_form['comments'] = array(
            'label' =>  __( 'Comments', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_data['comments'] ) ?  $field_data['comments'] : '',
        );

        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_personal_skill';
        $hidden_form['header'] = __('Add Education', 'hrm');
        $hidden_form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function personal_language( $field_data = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_data !== null ) {
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_data['id'] ) ? $field_data['id'] : '',
            );
        }

        $hidden_form['emp_id'] = array(
            'type' => 'hidden',
            'value' => isset( $_POST['hrm_dataAttr']['emp_id'] ) ? $_POST['hrm_dataAttr']['emp_id'] : '',
        );

        $hidden_form['language_id'] = array(
            'label' => __( 'Language', 'hrm' ),
            'type' => 'select',
            'option' => json_decode( stripcslashes( $_POST['hrm_dataAttr']['language'] ) ),
            'selected' => isset( $field_data['language_id'] ) ? $field_data['language_id'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );


        $hidden_form['fluency'] = array(
            'label' => __( 'Fluency', 'hrm' ),
            'type' => 'select',
            'option' => $this->fluency(),
            'selected' => isset( $field_data['fluency'] ) ? $this->fluency( $field_data['fluency'] ) : ''
        );

        $hidden_form['competency'] = array(
            'label' => __( 'Competency', 'hrm' ),
            'type' => 'select',
            'option' => $this->competency(),
            'selected' => isset( $field_data['competency'] ) ? $this->competency( $field_data['competency'] ) : '',

        );

        $hidden_form['comments'] = array(
            'label' => __( 'Comments', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $field_data['comments'] ) ? $field_data['comments'] : '',
        );


        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_personal_language';
        $hidden_form['header'] = __('Add Education', 'hrm');
        $hidden_form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function competency( $competency_code = null ) {
        $competency = array(
            '0' => __( 'Poor', 'hrm' ),
            '1' => __( 'Basic', 'hrm' ),
            '2' => __( 'Good', 'hrm' ),
            '3' => __( 'Mother Tongue', 'hrm' )
        );
        if ( $competency_code === null ) {
            return $competency;
        } else {
            return $competency[$competency_code];
        }
    }

    function fluency( $fluency_code = null ) {
        $fluency = array(
            '0' => __( 'Writing', 'hrm' ),
            '1' => __( 'Reading', 'hrm' ),
            '2' => __( 'Speaking', 'hrm' )
        );

        if ( $fluency_code === null ) {
            return $fluency;
        } else {
            return $fluency[$fluency_code];
        }
    }

    function salary( $field_value = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_value !== null ) {

            $field['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }

        $field['emp_id'] = array(
            'type' => 'hidden',
            'value' => isset( $_POST['hrm_dataAttr']['emp_id'] ) ? $_POST['hrm_dataAttr']['emp_id'] : '',
        );

        $field['pay_grade'] = array(
            'label' => __( 'Pay Grade', 'hrm' ),
            'type' => 'select',
            'option' => json_decode( stripcslashes( $_POST['hrm_dataAttr']['pay_grade'] ) ),
            'selected' => isset( $field_value->pay_grade ) ? $field_value->pay_grade : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $field['component'] = array(
            'label' => __( 'Salary Component', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_value['component'] ) ? $field_value['component'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $field['frequency'] = array(
            'label' => __( 'Pay Frequency', 'hrm' ),
            'type' => 'select',
            'option' => $this->pay_frequency(),
            'selected' => isset( $field_value['frequency'] ) ? $field_value['frequency'] : ''
        );

        $field['currency'] = array(
            'label' => __( 'Currency', 'hrm' ),
            'type' => 'select',
            'option' => hrm_Settings::getInstance()->get_currency_list(),
            'selected' => isset( $field_value['currency'] ) ? $field_value['currency'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );



        $field['amount'] = array(
            'label' => __( 'Amount', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_value['amount'] ) ? $field_value['amount'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $field['comments'] = array(
            'label' => __( 'Comments', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $field_value['comments'] ) ? $field_value['comments'] : ''
        );

        $field['direct_deposit'] = array(
            'label' => __( 'Deposit', 'hrm' ),
            'type' => 'checkbox',
            'fields' => array(
                array(
                    'label' => __( 'Add Direct Deposit Details ', 'hrm' ),
                    'class' => 'hrm-direct-deposit-handelar',
                    'value' => 'yes',
                    'checked'=> isset( $field_value['direct_deposit'] ) ? $field_value['direct_deposit'] : '',
                    'extra' => array(
                        'data-direct_deposit' => 'checked',
                    ),
                )
            ),
        );


        $field['account_number'] = array(
            'label' => __( 'Account Number', 'hrm' ),
            'class' => 'hrm-direct-deposit-part',
            'type' => 'text',
            'value' => isset( $field_value['account_number'] ) ? $field_value['account_number'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_dependency' => 'direct_deposit',
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $field['account_type'] = array(
            'label' => __( 'Account Type', 'hrm' ),
            'type' => 'select',
            'class' => 'hrm-direct-deposit-part',
            'option' => $this->account_type(),
            'selected' => isset( $field_value['account_type'] ) ? $field_value['account_type'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_dependency' => 'direct_deposit',
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $field['routing'] = array(
            'label' => __( 'Routing Number', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-direct-deposit-part',
            'value' => isset( $field_value['routing'] ) ? $field_value['routing'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_dependency' => 'direct_deposit',
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $field['dipo_amount'] = array(
            'label' => __( 'Amount', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-direct-deposit-part',
            'value' => isset( $field_value['dipo_amount'] ) ? $field_value['dipo_amount'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_dependency' => 'direct_deposit',
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $field['header'] = 'Salary';
        $field['action'] = 'ajax_referer_insert';
        $field['table_option'] = 'hrm_salary';
        $field['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $field );

        $return_value = array(
            'append_data' => ob_get_clean(),
            'personal_salary' => true
        );

        return $return_value;
    }

    function pay_frequency( $frequency = null ) {
        $frequencys = array(
            '0' => __( 'Bi Weekly', 'hrm' ),
            '1' => __( 'Hourly', 'hrm' ),
            '2' => __( 'Monthly', 'hrm' ),
            '3' => __( 'Monthly on first pay of month.', 'hrm' ),
            '4' => __( 'Semi Monthly', 'hrm' ),
            '5' => __( 'Weekly', 'hrm' ),
        );
        if ( $frequency === null ) {
            return $frequencys;
        } else {
            return $frequencys[$frequency];
        }
    }

    function account_type( $account_type = null ) {
        $account_types = array(
            '0' => __( 'Savings', 'hrm' ),
            '1' => __( 'Checking', 'hrm' ),
            '2' => __( 'Other', 'hrm' ),
        );
        if ( $account_type === null ) {
            return $account_types;
        } else {
            return $account_types[$account_type];
        }
    }
}

