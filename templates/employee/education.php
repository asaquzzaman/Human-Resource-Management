<div class="hrm-update-notification"></div>
<?php
if ( isset( $_REQUEST['employee_id'] ) && $_REQUEST['employee_id'] ) {
    $employer_id = intval( $_REQUEST['employee_id'] );
} else {
    $employer_id = get_current_user_id();
}
?>
<div id="hrm_personal_education"></div>

<?php

$results = hrm_Settings::getInstance()->conditional_query_val( 'hrm_personal_education', $field = '*', $compare = array( 'emp_id' => $employer_id ) );
$education_id = isset( $results['education_id'] ) ? $results['education_id'] : array();
$education_id = wp_list_pluck( $education_id, 'education_id' );

$compare = array(
  'id' => $education_id
);
$edu_labels = hrm_Settings::getInstance()->hrm_query( 'hrm_education' );

unset( $edu_labels['total_row'] );

$label = array();
foreach ( $edu_labels as $key => $edu_label ) {
  $label[$edu_label->id] = $edu_label->name;
}



foreach ( $results as $key => $value) {

    if ( $results['total_row'] == 0 || $key === 'total_row' ) {
      continue;
    }

    if ( !isset( $label[$value->education_id] ) ) {
        continue;
    }

    $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$value->id.']" value="" type="checkbox">';
    $delete_text  = '<a href="#" class="hrm-delete" data-id='.$value->id.'>'.__( 'Delete', 'hrm' ).'</a>';
    $td_attr[][0] = 'class="hrm-table-checkbox"';

    $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable hrm-title" data-table_option="hrm_personal_education" data-id='.$value->id.'>'.$label[$value->education_id].'</a>
    <div class="hrm-title-action"><a href="#" class="hrm-editable hrm-edit" data-table_option="hrm_personal_education" data-emp_id="'.$value->emp_id.'" data-id='.$value->id.'>'.__( 'Edit', 'hrm' ).'</a>'
    .$delete_text. '</div></div>';

    $body[] = array(
        $del_checkbox,
        $name_id,
        $value->institute,
        $value->major,
        hrm_get_date2mysql( $value->year ),
        $value->score,
        hrm_get_date2mysql( $value->start_date ),
        hrm_get_date2mysql( $value->end_date ),
    );
}

$table               = array();
$table['head']       = array( '<input class="hrm-all-checked" type="checkbox">', __( 'Level', 'hrm'), __( 'Institute', 'hrm'), __( 'Major/Specialization', 'hrm'), __( 'Year', 'hrm'), __( 'GPA/Score', 'hrm'), __( 'Start Date', 'hrm'), __( 'End Date', 'hrm') );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_personal_education';
$table['action']     = 'hrm_delete';
$table['tab']        = $tab;
$table['subtab']     = $subtab;
$table['page']       = $page;

echo hrm_Settings::getInstance()->table( $table );
$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ) . '&employee_id='. $employer_id;
$file_path = urlencode(__FILE__);
global $hrm_is_admin;
?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
            add_form_generator_action : 'add_form',
            add_form_apppend_wrap : 'hrm_personal_education',
            class_name : 'hrm_Employee',
            function_name : 'education',
            redirect : '<?php echo $url; ?>',
            education: '<?php echo json_encode( $label); ?>',
            employee_id: "<?php echo $employer_id; ?>",
            page: '<?php echo $page; ?>',
            tab: '<?php echo $tab; ?>',
            subtab: '<?php echo $subtab; ?>',
            req_frm: '<?php echo $file_path; ?>',
            is_admin : '<?php echo $hrm_is_admin; ?>'
        };
    });
</script>