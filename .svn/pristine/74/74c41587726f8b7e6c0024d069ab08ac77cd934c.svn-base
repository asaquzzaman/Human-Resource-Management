<div class="hrm-error-notification"></div>
<?php
if ( hrm_current_user_role() == 'hrm_employer' ) {
    $employer_id = get_current_user_id();
} else {
    $employer_id = isset( $_GET['employee_id'] ) ? trim( $_GET['employee_id'] ) : '';
}
?>
<div id="hrm_personal_salary"></div>
<?php


$results = hrm_Settings::getInstance()->conditional_query_val( 'hrm_salary', $field = '*', $compare = array( 'emp_id' => $employer_id ) );

$pary_grades = hrm_Settings::getInstance()->hrm_query( 'hrm_pay_grade' );
unset( $pary_grades['total_row'] );


foreach ( $pary_grades as $key => $pary_grade ) {
    $pay_grade_label[$pary_grade->id] = $pary_grade->name;
}

foreach ( $results as $key => $value) {
    if ( $results['total_row'] == 0 || $key === 'total_row' ) {
      continue;
    }

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

    $nameid = ( $page == 'hrm_pim' ) ? '<input name="hrm_check['.$value->id.']" value="" type="checkbox">' : '';
    $body[] = array(
        $nameid,
        '<a href="#" class="hrm-editable" data-table_option="hrm_salary"  data-id='.$value->id.'>'.$pay_grade_label[$value->pay_grade].'<a>',
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
$input_field = ( $page == 'hrm_pim' ) ? '<input type="checkbox">' : '';
$table['head'] = array(
    $input_field,
    __( 'Pay Grade', 'hrm'),
    __( 'Salary Component', 'hrm'),
    __( 'Pay Frequency', 'hrm'),
    __( 'Currency', 'hrm'),
    __( 'Amount', 'hrm'),
    __( 'Comments', 'hrm'),
    __( 'Direct Deposit Details', 'hrm'),
);
$table['body'] = isset( $body ) ? $body : array();


$table['td_attr'] = isset( $td_attr ) ? $td_attr : array();
$table['th_attr'] = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );

$table['table'] = 'hrm_qualification_languages';
$table['action'] = 'hrm_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab'] = $tab;
$table['subtab'] = $subtab;
if ( $page == 'hrm_employer') {
    $table['add_buttion'] = false;
    $table['delete_buttion'] = false;
}


echo hrm_Settings::getInstance()->table( $table );

?>
<?php $url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ) . '&employee_id='. $employer_id; ?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm_personal_salary',
           class_name : 'hrm_Employee',
           function_name : 'salary',
           redirect : '<?php echo $url; ?>',
           pay_grade: '<?php echo json_encode( $pay_grade_label ); ?>',
           emp_id: "<?php echo $employer_id; ?>"
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