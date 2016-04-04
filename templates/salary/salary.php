<div id="hrm-salary-wrap">
    <div class="hrm-update-notification"></div>
    <?php
    if ( ( isset( $_GET['action_search'] ) && $_GET['action_search'] ) )  {
        $search_status = true;
        $search_post = get_user_meta( get_current_user_id(), '_hrm_search_data', true );
    } else if ( isset( $_POST['action_search'] ) ) {
        $search_status = true;
        $search_post = $_POST;
    } else if ( isset( $_POST['search_status'] ) && $_POST['search_status'] ) {
        $search_status = true;
        $search_post = get_user_meta( get_current_user_id(), '_hrm_search_data', true );
    } else {
        $search_status = false;
    }
    $users = get_users();

    foreach ( $users as $key => $user ) {
        $user_info[$user->ID] = $user->display_name;
    }

    $user_info = isset( $user_info ) ? $user_info : array();

    $search['emp_id'] = array(
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

    $search['month'] = array(
        'label'    => __( 'Month', 'hrm' ),
        'required' => 'required',
        /*'extra' => array(
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),*/
        'class'  => 'hrm-chosen',
        'type'   => 'select',
        'option' => hrm_Settings::getInstance()->month(),
        'selected' => $search_status ? $search_post['month'] : ''
    );

    $search['year'] = array(
        'label'    => __( 'Year', 'hrm' ),
        'required' => 'required',
        /*'extra' => array(
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),*/
        'class'  => 'hrm-chosen',
        'type'   => 'select',
        'option' => hrm_Settings::getInstance()->year(),
        'selected' => $search_status ? $search_post['year'] : ''
    );

    $search['visibility']   = $search_status ? true : false;
    $search['action']       = 'hrm_search';
    $search['table_option'] = 'hrm_rating_record';
    echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'Employee and employer rating record', 'hrm' ) );

    ?>
    <div id="hrm_personal_salary"></div>
    <?php

    $pagenum     = hrm_pagenum();
    $limit       = hrm_result_limit();
    $pary_grades = hrm_Settings::getInstance()->hrm_query( 'hrm_pay_grade' );

    if ( !$search_status ) {
        $results     = hrm_Settings::getInstance()->conditional_query_val( 'hrm_salary', '*', array( 'emp_id' => get_current_user_id() ), $row = false, $limit, $pagenum );
    } else {
       $results     = Hrm_Employee::getInstance()->salary_search_query( $search_post, $limit, $pagenum );
       update_user_meta( get_current_user_id(), '_hrm_search_data',
            array( 'table_option' => 'hrm_salary', 'emp_id' => $search_post['emp_id'], 'month' => $search_post['month'], 'year' => $search_post['year'] ) );
    }

    $total = $results['total_row'];
    unset( $results['total_row'] );
    unset( $pary_grades['total_row'] );

    $add_permission = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;
    $pay_grade_label = array();
    foreach ( $pary_grades as $key => $pary_grade ) {
        $pay_grade_label[$pary_grade->id] = $pary_grade->name;
    }

    foreach ( $results as $key => $value) {


        if ( $delete_permission ) {
            $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$value->id.']" value="" type="checkbox">';
            $delete_text  = '<a href="#" class="hrm-delete" data-id='.$value->id.'>'.__( 'Delete', 'hrm' ).'</a>';
        } else {
            $del_checkbox = '';
            $delete_text  = '';
        }

         if ( $add_permission ) {
            $date = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable hrm-title" data-table_option="hrm_salary" data-id='.$value->id.'>'.hrm_get_date2mysql( $value->billing_date ).'</a>
            <div class="hrm-title-action"><a href="#" class="hrm-editable hrm-edit" data-table_option="hrm_salary" data-id='.$value->id.'>'.__( 'Edit', 'hrm' ).'</a>'
            .$delete_text. '</div></div>';
        } else {
            $date = hrm_get_date2mysql( $value->billing_date );
        }

        $deposit = empty( $value->direct_deposit ) ? __( 'No', 'hrm' ) : ucfirst( $value->direct_deposit );
        if ( $deposit != 'No') {


            $deposit = '<a class="hrm-popup-desc" href="#" data-task_id="'.$value->id.'"> '. __( "Show Details", "hrm" ) .' </a>';

            ?>

            <div id="hrm-popup-desc-wrap-<?php echo $value->id; ?>" title="<?php _e( 'Direct Deposit Details', 'hrm' ); ?>" class="hrm-deposit-dialog" style="display: none;">
                <table class="widefat">
                    <tr>
                        <th><?php _e( 'Account Number', 'hrm' ); ?></th>
                        <td><?php echo $value->account_number; ?></td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Account Type', 'hrm' ); ?></th>
                        <td><?php echo hrm_Employee::getInstance()->account_type( $value->account_type ); ?></td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Routing Number', 'hrm' ); ?></th>
                        <td><?php echo $value->routing; ?></td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Deposit Amount', 'hrm' ); ?></th>
                        <td><?php echo $value->dipo_amount; ?></td>
                    </tr>
                </table>
                <!-- <p><strong><?php _e( 'Account Number', 'hrm' ); ?></strong><?php echo $value->account_number; ?></p>
                <p><strong><?php _e( 'Account Type', 'hrm' ); ?></strong><?php echo hrm_Employee::getInstance()->account_type( $value->account_type ); ?></p>
                <p><strong><?php _e( 'Routing Number', 'hrm' ); ?></strong><?php echo $value->routing; ?></p>
                <p><strong><?php _e( 'Deposit Amount', 'hrm' ); ?></strong><?php echo $value->dipo_amount; ?></p> -->
            </div>

            <?php
        }

        if ( $delete_permission ) {
            $body[] = array(
                $del_checkbox,
                $date,
                $pay_grade_label[$value->pay_grade],
                $value->component,
                hrm_Employee::getInstance()->pay_frequency( $value->frequency ),
                $value->currency,
                $value->amount,
                $value->comments,
                $deposit,
            );
        } else {
            $body[] = array(
                $date,
                $pay_grade_label[$value->pay_grade],
                $value->component,
                hrm_Employee::getInstance()->pay_frequency( $value->frequency ),
                $value->currency,
                $value->amount,
                $value->comments,
                $deposit,
            );
        }
    }

    $table = array();

    if ( $delete_permission ) {
        $table['head'] = array(
            '<input class="hrm-all-checked" type="checkbox">',
            __( 'Date', 'hrm'),
            __( 'Pay Grade', 'hrm'),
            __( 'Salary Component', 'hrm'),
            __( 'Pay Frequency', 'hrm'),
            __( 'Currency', 'hrm'),
            __( 'Amount', 'hrm'),
            __( 'Comments', 'hrm'),
            __( 'Direct Deposit Details', 'hrm'),
        );
    } else {
        $table['head'] = array(
            __( 'Date', 'hrm'),
            __( 'Pay Grade', 'hrm'),
            __( 'Salary Component', 'hrm'),
            __( 'Pay Frequency', 'hrm'),
            __( 'Currency', 'hrm'),
            __( 'Amount', 'hrm'),
            __( 'Comments', 'hrm'),
            __( 'Direct Deposit Details', 'hrm'),
        );
    }

    $table['body']         = isset( $body ) ? $body : array();
    $table['td_attr']      = isset( $td_attr ) ? $td_attr : array();
    $table['table_attr']   = array( 'class' => 'widefat' );
    $table['table']        = 'hrm_salary';
    $table['action']       = 'hrm_delete';
    $table['tab']          = $tab;
    $table['subtab']       = $subtab;
    $table['page']         = $page;
    $table['add_btn_name'] = __( 'Add', 'hrm' );
    $table['data_table']   = false;
    $table['search_mode']  = true;
    $table['search']       = __( 'Search Mode', 'hrm' );




    echo hrm_Settings::getInstance()->table( $table );
    echo hrm_Settings::getInstance()->pagination( $total, $limit, $pagenum );
    $url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
    $file_path = urlencode(__FILE__);
    global $hrm_is_admin;
    ?>
    <script type="text/javascript">
        jQuery(function($) {
            hrm_dataAttr = {
               add_form_generator_action : 'add_form',
               add_form_apppend_wrap : 'hrm_personal_salary',
               class_name : 'hrm_Employee',
               function_name : 'salary',
               redirect : '<?php echo $url; ?>',
               pay_grade_js: '<?php echo json_encode( $pay_grade_label ); ?>',
               page: '<?php echo $page; ?>',
               tab: '<?php echo $tab; ?>',
               subtab: '<?php echo $subtab; ?>',
               req_frm: '<?php echo $file_path; ?>',
               search_status: '<?php echo $search_status; ?>',
               is_admin: '<?php echo $hrm_is_admin; ?>',
            };
        });
    </script>

    <script type="text/javascript">
        jQuery(function($) {
            $( ".hrm-deposit-dialog" ).dialog({
                autoOpen: false,
                modal: true,
                dialogClass: 'hrm-ui-dialog',
                width: 485,
                height: 425,
                position:['middle', 100],
                zIndex: 9999,

            });
        });
    </script>
</div>