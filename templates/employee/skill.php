<div class="hrm-update-notification"></div>
<?php
if ( hrm_current_user_role() == 'hrm_employee' ) {
    $employer_id = get_current_user_id();
} else {
    $employer_id = isset( $_REQUEST['employee_id'] ) ? trim( $_REQUEST['employee_id'] ) : '';
}
?>

<div id="hrm_personal_skill"></div>

<?php

$results = hrm_Settings::getInstance()->conditional_query_val( 'hrm_personal_skill', $field = '*', $compare = array( 'emp_id' => $employer_id ) );

$skill_labels = hrm_Settings::getInstance()->hrm_query( 'hrm_skill' );
unset( $skill_labels['total_row'] );

foreach ( $skill_labels as $key => $skill_label ) {
	$label[$skill_label->id] = $skill_label->name;
}

foreach ( $results as $key => $value) {

    if ( $results['total_row'] == 0 || $key === 'total_row' ) {
      continue;
    }

    if ( !isset( $label[$value->skill_id] ) ) {
        continue;
    }

    $body[] = array(
        '<input name="hrm_check['.$value->id.']" value="" type="checkbox">',
        '<a href="#" class="hrm-editable" data-table_option="hrm_personal_skill"  data-id='.$value->id.'>'.$label[$value->skill_id].'<a>',
        $value->years_of_exp,
        $value->comments,

    );

    $td_attr[] = array(
        'class="check-column"'
    );
}

$table = array();
$table['head']       = array( '<input type="checkbox">', __( 'Skill', 'hrm'), __( 'Year of experiance', 'hrm'), __( 'Comment', 'hrm') );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_personal_skill';
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
           add_form_apppend_wrap : 'hrm_personal_skill',
           class_name : 'hrm_Employee',
           redirect : '<?php echo $url; ?>',
           function_name : 'personal_skill',
           skill: '<?php echo json_encode( $label); ?>',
           employee_id: "<?php echo $employer_id; ?>",
           page: '<?php echo $page; ?>',
           tab: '<?php echo $tab; ?>',
           subtab: '<?php echo $subtab; ?>',
           req_frm: '<?php echo $file_path; ?>',
           subtab: true
        };
    });
</script>