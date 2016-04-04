<div class="hrm-update-notification"></div>
<?php
if ( isset( $_REQUEST['employee_id'] ) && $_REQUEST['employee_id'] ) {
    $employer_id = intval( $_REQUEST['employee_id'] );
} else {
    $employer_id = get_current_user_id();
}

$user = wp_get_current_user();
$role = reset( $user->roles );

?>
<div id="hrm_personal_salary"></div>
<?php

$results     = hrm_Settings::getInstance()->conditional_query_val( 'hrm_salary', '*', array( 'emp_id' => $employer_id ) );
$pary_grades = hrm_Settings::getInstance()->hrm_query( 'hrm_pay_grade' );
unset( $results['total_row'] );
unset( $pary_grades['total_row'] );
$pay_grade_label = array();
foreach ( $pary_grades as $key => $pary_grade ) {
    $pay_grade_label[$pary_grade->id] = $pary_grade->name;
}

foreach ( $results as $key => $value) {

    $date = hrm_get_date2mysql( $value->billing_date );
    $deposit = empty( $value->direct_deposit ) ? __( 'No', 'hrm' ) : ucfirst( $value->direct_deposit );
    if ( $deposit != 'No') {


        $deposit = '<a class="hrm-deposit-check" href="#" data-id="'.$value->id.'"> '. __( "Show Details", "hrm" ) .' </a>';

        ?>

        <div id="hrm-visible-form-warp" title="<?php _e( 'Direct Deposit Details', 'hrm' ); ?>" class="hrm-deposit-dialog hrm-deposit-wrap-<?php echo $value->id; ?>" style="display: none;">
            <p><strong><?php _e( 'Account Number', 'hrm' ); ?></strong><?php echo $value->account_number; ?></p>
            <p><strong><?php _e( 'Account Type', 'hrm' ); ?></strong><?php echo hrm_Employee::getInstance()->account_type( $value->account_type ); ?></p>
            <p><strong><?php _e( 'Routing Number', 'hrm' ); ?></strong><?php echo $value->routing; ?></p>
            <p><strong><?php _e( 'Deposit Amount', 'hrm' ); ?></strong><?php echo $value->dipo_amount; ?></p>
        </div>

        <?php
    }

    $nameid = '';
    $body[] = array(
        $nameid,
        $date,
        $pay_grade_label[$value->pay_grade],
        $value->component,
        hrm_Employee::getInstance()->pay_frequency( $value->frequency ),
        $value->currency,
        $value->amount,
        $value->comments,
        $deposit,
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}
$input_field =  '';
$table = array();
$table['head'] = array(
    $input_field,
    __( 'Date', 'hrm'),
    __( 'Pay Grade', 'hrm'),
    __( 'Salary Component', 'hrm'),
    __( 'Pay Frequency', 'hrm'),
    __( 'Currency', 'hrm'),
    __( 'Amount', 'hrm'),
    __( 'Comments', 'hrm'),
    __( 'Direct Deposit Details', 'hrm'),
);
$table['body']          = isset( $body ) ? $body : array();
$table['td_attr']       = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']       = array( 'class="check-column"' );
$table['table_attr']    = array( 'class' => 'widefat' );
$table['table']         = 'hrm_salary';
$table['action']        = 'hrm_delete';
$table['tab']           = $tab;
$table['subtab']        = $subtab;
$table['page']          = $page;
$table['add_btn_name']  = false;
$table['delete_button'] = false;

if ( $page == 'hrm_employee') {
    $table['add_button']    = false;
    $table['delete_button'] = false;
}


echo hrm_Settings::getInstance()->table( $table );

$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ) . '&employee_id='. $employer_id;
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
           employee_id: "<?php echo $employer_id; ?>",
           page: '<?php echo $page; ?>',
           tab: '<?php echo $tab; ?>',
           subtab: '<?php echo $subtab; ?>',
           req_frm: '<?php echo $file_path; ?>',
           is_admin : '<?php echo $hrm_is_admin; ?>'
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