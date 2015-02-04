<div class="hrm-update-notification"></div>
<?php
if ( hrm_current_user_role() == 'hrm_employee' ) {
    $employer_id = get_current_user_id();
} else {
    $employer_id = isset( $_REQUEST['employee_id'] ) ? trim( $_REQUEST['employee_id'] ) : '';
}
?>

<div id="hrm-employee-work-experience"></div>
<?php

$results = hrm_Settings::getInstance()->conditional_query_val( 'hrm_work_experience', $field = '*', $compare = array( 'emp_number' => $employer_id ) );
$total = $results['total_row'];

foreach ( $results as $key => $value) {
    if ( $results['total_row'] == 0 || $key === 'total_row' ) {
      continue;
    }
    $body[] = array(
        '<input name="hrm_check['.$value->id.']" value="" type="checkbox">',
        '<a href="#" class="hrm-editable" data-table_option="hrm_work_experience" data-id='.$value->id.'>'.$value->eexp_company.'<a>',
        $value->eexp_jobtit,
        hrm_get_date2mysql( $value->eexp_from_date ),
        hrm_get_date2mysql( $value->eexp_to_date ),
        $value->eexp_comments,
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}

$table = array();
$table['head']       = array( '<input type="checkbox">', __( 'Company', 'hrm'), __( 'Job Title', 'hrm'), __( 'From', 'hrm'), __( 'To', 'hrm'), __( 'Comment', 'hrm') );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_work_experience';
$table['action']     = 'hrm_delete';
$table['tab']        = $tab;
$table['subtab']     = $subtab;

echo hrm_Settings::getInstance()->table( $table );
$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ) . '&employee_id='. $employer_id;
$file_path = urlencode(__FILE__);
?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-employee-work-experience',
           redirect : '<?php echo $url; ?>',
           class_name : 'hrm_Employee',
           function_name : 'work_experience',
           employee_id: "<?php echo $employer_id; ?>",
           page: '<?php echo $page; ?>',
           tab: '<?php echo $tab; ?>',
           subtab: '<?php echo $subtab; ?>',
           req_frm: '<?php echo $file_path; ?>',
           subtab: true
        };
    });
</script>