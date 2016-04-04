<?php

class Hrm_Employee {

    function __construct() {
        //add_filter( 'hrm_employee_memu', array( $this, 'pim_to_employer' ) );
        add_action( 'cpm_after_ajax_upload', array( $this, 'after_ajax_upload' ), 10, 3 );
        add_action( 'hrm_after_new_information', array( $this, 'after_inset_information' ), 10, 2 );
    }

    function after_inset_information( $post, $last_inserted_id ) {
        if ( isset( $post['table_option'] ) && $post['table_option'] == 'hrm_salary' ) {
            $table_option = get_option( $post['table_option'] );
            $employee_id  = $post['emp_id'];
            $to_user      = get_user_by( 'id', $employee_id );
            $to           = $to_user->user_email;
            $sender       = get_current_user_id();
            $subject      = __( 'Salary', 'hrm' );

            $last_recored = Hrm_Settings::getInstance()->conditional_query_val( $table_option['table_name'], '*', array( 'id' => $last_inserted_id ), true );

            $message = $this->get_salary_message_body( $last_recored, $post, $to_user );

            Hrm_Settings::getInstance()->send( $to, $subject, $message, $sender );
        }
    }

    function get_salary_message_body( $last_recored, $post, $to_user ) {
        $employer = wp_get_current_user();
        $pay_grade = json_decode( stripcslashes( $post['pay_grade_js'] ), true );
        $direct_deposit = $last_recored->direct_deposit != 'yes' ? __( 'Nothing', 'hrm' ) : $last_recored->direct_deposit;
        ob_start();
        ?>
        <div style="width: 600px; background: #eee; padding: 5px;">
        <table width="600" style="background: #fff; padding: 10px;">
        <tr>
            <td style="padding: 10px;"><?php sprintf( 'Hello, %s', $to_user->display_name ); ?></td>
        </tr>
        <tr>
            <td style="padding: 10px;"><?php _e( 'Your salaray details', 'hrm' ); ?></td>
        </tr>
        </table>
        <table width="600" style="background: #fff; padding: 10px;">
            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Employer Name', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $employer->display_name; ?></td>
            </tr>
            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Date', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo hrm_get_date2mysql( $last_recored->billing_date ); ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Pay Grade', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $pay_grade[$last_recored->pay_grade]; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Salary Component', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->component; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Pay Frequency', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $this->pay_frequency( $last_recored->frequency ); ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Currency', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->currency; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Amount', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->amount; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Comments', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->comments; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Direct Deposit Details', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $direct_deposit; ?></td>
            </tr>
        <?php
        if ( $last_recored->direct_deposit == 'yes' ) {
            ?>
            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Account Number', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->account_number; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Account Type', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $this->account_type( $last_recored->account_type ); ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Routing Number', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->routing; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Deposit Amount', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->dipo_amount; ?></td>
            </tr>

            <?php
        }
            ?>
        </table>
        </div>
        <?php
        return ob_get_clean();
    }

    function delete_file( $file_id, $force = true, $employee_id ) {
        wp_delete_attachment( $file_id, $force );
        ob_start();
        $this->emp_upload_image($employee_id);
        return ob_get_clean();
    }

     function get_image( $attachment_id ) {
        $file = get_post( $attachment_id );
        if ( $file ) {
            $response = array(
                'id' => $attachment_id,
                'name' => get_the_title( $attachment_id ),
                'url' => wp_get_attachment_url( $attachment_id ),
            );

            if ( wp_attachment_is_image( $attachment_id ) ) {

                $thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
                $response['thumb'] = $thumb[0];
                $response['type'] = 'image';
                return $response;
            }
        }

        return false;
    }

    function emp_upload_image($employee_id) {

        $image_id        = get_user_meta( $employee_id, '_hrm_user_image_id', true );
        $image_attchment = $this->get_image( $image_id );

        ?>
        <div id="hrm-user-image-wrap">
            <?php
            if ( $image_attchment ) {

                $delete = sprintf( '<a href="#" data-id="%d" class="hrm-delete-file">%s</a>', $image_attchment['id'], __( 'Delete', 'hrm' ) );
                $hidden = sprintf( '<input type="hidden" name="hrm_attachment[]" value="%d" />', $image_attchment['id'] );
                $file_url = sprintf( '<a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s" height="160" width="160"/></a>', $image_attchment['url'], $image_attchment['thumb'], esc_attr( $image_attchment['name'] ) );

                echo '<div class="hrm-uploaded-item">' . $file_url . ' ' . $delete . $hidden . '</div>';
            } else {
                echo get_avatar( $employee_id, 160 );
            }
            ?>

        </div>
        <?php
    }

    function after_ajax_upload( $response, $file, $post ) {
        if ( !isset( $post['employee_id'] ) ) {
            return;
        }
        $file_id = $response['file_id'];
        $employee_id = $post['employee_id'];
        update_user_meta( $employee_id, '_hrm_user_image_id', $file_id );
    }

    function pim_to_employer( $page = null ) {
        $current_user = wp_get_current_user();
        $role = reset( $current_user->roles );

        if ( $role == 'hrm_employee' ) {
            unset( $page['hrm_pim']['employee_list'] );
            $page['hrm_employee'] = $page['hrm_pim'];
            $page['hrm_employee']['personal']['follow_access_role'] = false;
            $page['hrm_employee']['organization_info']['follow_access_role'] = false;
            $page['hrm_employee']['my_task']['follow_access_role'] = false;
            $page['hrm_employee']['leave']['follow_access_role'] = false;
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

        foreach ( $users_id as $user_id => $empty ) {
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
            'value' => isset( $_POST['hrm_dataAttr']['employee_id'] ) ? $_POST['hrm_dataAttr']['employee_id'] : '',
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
            'value' => isset( $_POST['hrm_dataAttr']['employee_id'] ) ? $_POST['hrm_dataAttr']['employee_id'] : '',
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
            'class' => 'hrm-des-field',
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
            'value' => isset( $_POST['hrm_dataAttr']['employee_id'] ) ? $_POST['hrm_dataAttr']['employee_id'] : '',
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
            //'class' => 'hrm-datepicker',
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
            'value' => isset( $_POST['hrm_dataAttr']['employee_id'] ) ? $_POST['hrm_dataAttr']['employee_id'] : '',
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

    function salary_search_query( $search_post, $limit, $pagenum ) {

        if ( !isset( $search_post['emp_id'] ) || !$search_post['emp_id'] ) {
            return array( 'total_row' => 0 );
        }

        $emp_id = $search_post['emp_id'];
        $where = "emp_id = $emp_id";

        $year = false;
        $month = false;

        if ( isset( $search_post['year'] ) && $search_post['year'] != '-1' ) {
            $year = $search_post['year'];
        }

        if ( isset( $search_post['month'] ) && $search_post['month'] != '-1' ) {
            $month = $search_post['month'];
        }

        if ( $year && $month ) {

            $custom_start = $year .'-'. $month . '-' . '01';
            $custom_end   = $year .'-'. $month . '-' . '31';

            $start_date   = date( 'Y-m-d H:i:s', strtotime( $custom_start ) );
            $end_date     = date( 'Y-m-d H:i:s', strtotime( $custom_end ) );

            $where        .= " AND billing_date >= '$start_date' AND billing_date <= '$end_date'";
        } else if ( $year && !$month ) {
            $custom_start = $year .'-01-01';
            $custom_end   = $year .'-12-31';

            $start_date   = date( 'Y-m-d H:i:s', strtotime( $custom_start ) );
            $end_date     = date( 'Y-m-d H:i:s', strtotime( $custom_end ) );
            $where        .= " AND billing_date >= '$start_date' AND billing_date <= '$end_date'";
        } else if ( !$year && $month ) {
            $year = date( 'Y' );

            $custom_start = $year . '-' .$month. '-01';
            $custom_end   = $year . '-' .$month. '-31';

            $start_date   = date( 'Y-m-d H:i:s', strtotime( $custom_start ) );
            $end_date     = date( 'Y-m-d H:i:s', strtotime( $custom_end ) );

            $where        .= " AND billing_date >= '$start_date' AND billing_date <= '$end_date'";
        }
        $offset = ( $pagenum - 1 ) * $limit;
        global $wpdb;
        $table                = $wpdb->prefix . 'hrm_salary';
        $sql                  = "SELECT SQL_CALC_FOUND_ROWS * FROM $table WHERE $where ORDER BY id desc LIMIT $offset,$limit";
        $results              = $wpdb->get_results( $sql );
        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );

        return $results;
    }

    function salary( $field_value = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        $search_status = $_POST['hrm_dataAttr']['search_status'] ? $_POST['hrm_dataAttr']['search_status'] : false;
        if ( $field_value !== null ) {

            $field['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }

        $users = get_users();

        foreach ( $users as $key => $user ) {
            $user_info[$user->ID] = $user->display_name;
        }

        $user_info = isset( $user_info ) ? $user_info : array();

        $field['emp_id'] = array(
            'label'    => __( 'Employee Name', 'hrm' ),
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
            'class'  => 'hrm-chosen',
            'type'   => 'select',
            'option' => $user_info,
            'selected' => $search_status ? $search_post['emp_id'] : ''
        );
        $new_pay_grade = hrm_new_pay_grade_url();
        $field['pay_grade'] = array(
            'label'    => __( 'Pay Grade', 'hrm' ),
            'type'     => 'select',
            'option'   => json_decode( stripcslashes( $_POST['hrm_dataAttr']['pay_grade_js'] ) ),
            'selected' => isset( $field_value['pay_grade'] ) ? $field_value['pay_grade'] : '',
            'desc' => sprintf( '<a class="hrm-form-link" href="%s">%s</a>', $new_pay_grade,  __( 'Create New', 'hrm' ) ),
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field['component'] = array(
            'label' => __( 'Salary Component', 'hrm' ),
            'type'  => 'text',
            'value' => isset( $field_value['component'] ) ? $field_value['component'] : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field['billing_date'] = array(
            'label' =>  __( 'Billing Date', 'hrm' ),
            'type'  => 'text',
            'class' => 'hrm-datepicker',
            'value' => isset( $field_value['billing_date'] ) ? hrm_get_date2mysql( $field_value['billing_date'] ) : hrm_get_date2mysql( current_time( 'mysql' ) ),
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field['frequency'] = array(
            'label'    => __( 'Pay Frequency', 'hrm' ),
            'type'     => 'select',
            'option'   => $this->pay_frequency(),
            'selected' => isset( $field_value['frequency'] ) ? $field_value['frequency'] : ''
        );

        $field['currency'] = array(
            'label'    => __( 'Currency', 'hrm' ),
            'type'     => 'select',
            'option'   => hrm_Settings::getInstance()->get_currency_list(),
            'selected' => isset( $field_value['currency'] ) ? $field_value['currency'] : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );



        $field['amount'] = array(
            'label' => __( 'Amount', 'hrm' ),
            'type'  => 'text',
            'value' => isset( $field_value['amount'] ) ? $field_value['amount'] : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field['comments'] = array(
            'label' => __( 'Comments', 'hrm' ),
            'type'  => 'textarea',
            'value' => isset( $field_value['comments'] ) ? $field_value['comments'] : ''
        );

        $field['direct_deposit'] = array(
            'label' => __( 'Deposit', 'hrm' ),
            'type'  => 'checkbox',
            'fields' => array(
                array(
                    'label'   => __( 'Add Direct Deposit Details ', 'hrm' ),
                    'class'   => 'hrm-direct-deposit-handelar',
                    'value'   => 'yes',
                    'checked' => isset( $field_value['direct_deposit'] ) ? $field_value['direct_deposit'] : '',
                    'extra' => array(
                        'data-direct_deposit' => 'checked',
                    ),
                )
            ),
        );


        $field['account_number'] = array(
            'label' => __( 'Account Number', 'hrm' ),
            'class' => 'hrm-direct-deposit-part',
            'type'  => 'text',
            'value' => isset( $field_value['account_number'] ) ? $field_value['account_number'] : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_dependency'         => 'direct_deposit',
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field['account_type'] = array(
            'label'    => __( 'Account Type', 'hrm' ),
            'type'     => 'select',
            'class'    => 'hrm-direct-deposit-part',
            'option'   => $this->account_type(),
            'selected' => isset( $field_value['account_type'] ) ? $field_value['account_type'] : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_dependency'         => 'direct_deposit',
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field['routing'] = array(
            'label' => __( 'Routing Number', 'hrm' ),
            'type'  => 'text',
            'class' => 'hrm-direct-deposit-part',
            'value' => isset( $field_value['routing'] ) ? $field_value['routing'] : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_dependency'         => 'direct_deposit',
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field['dipo_amount'] = array(
            'label' => __( 'Amount', 'hrm' ),
            'type'  => 'text',
            'class' => 'hrm-direct-deposit-part',
            'value' => isset( $field_value['dipo_amount'] ) ? $field_value['dipo_amount'] : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_dependency'         => 'direct_deposit',
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $field['header']       = 'Salary';
        $field['action']       = 'ajax_referer_insert';
        $field['table_option'] = 'hrm_salary';
        $field['url']          = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $field );

        $return_value = array(
            'append_data'     => ob_get_clean(),
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

