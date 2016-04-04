<div class="hrm-update-notification"></div>
<?php
if ( isset( $_REQUEST['employee_id'] ) && $_REQUEST['employee_id'] ) {
    $employer_id = intval( $_REQUEST['employee_id'] );
} else {
    $employer_id = get_current_user_id();
}
?>
<div id="hrm_personal_language"></div>

<?php

$results = hrm_Settings::getInstance()->conditional_query_val( 'hrm_personal_language', '*', array( 'emp_id' => $employer_id ) );

$language_labels = hrm_Settings::getInstance()->hrm_query( 'hrm_language' );
unset( $language_labels['total_row'] );

foreach ( $language_labels as $key => $language_label ) {
	$label[$language_label->id] = $language_label->name;
}

foreach ( $results as $key => $value) {

    if ( $results['total_row'] == 0 || $key === 'total_row' ) {
        continue;
    }

    if ( !isset( $label[$value->language_id] ) ) {
        continue;
    }

    $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$value->id.']" value="" type="checkbox">';
    $delete_text  = '<a href="#" class="hrm-delete" data-id='.$value->id.'>'.__( 'Delete', 'hrm' ).'</a>';
    $td_attr[][0] = 'class="hrm-table-checkbox"';

    $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable hrm-title" data-table_option="hrm_personal_language" data-id='.$value->id.'>'.$label[$value->language_id].'</a>
    <div class="hrm-title-action"><a href="#" class="hrm-editable hrm-edit" data-table_option="hrm_personal_language" data-id='.$value->id.'>'.__( 'Edit', 'hrm' ).'</a>'
    .$delete_text. '</div></div>';

    $body[] = array(
        $del_checkbox,
        $name_id,
        hrm_Employee::getInstance()->fluency( $value->fluency ),
        hrm_Employee::getInstance()->competency( $value->competency ),
        $value->comments,
    );
}

$table = array();
$table['head']       = array( '<input class="hrm-all-checked" type="checkbox">', __( 'Language', 'hrm'), __( 'Fluency', 'hrm'), __( 'Competency', 'hrm'), __( 'Comments', 'hrm') );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_personal_language';
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
           add_form_apppend_wrap : 'hrm_personal_language',
           class_name : 'hrm_Employee',
           redirect : '<?php echo $url; ?>',
           function_name : 'personal_language',
           language: '<?php echo json_encode( $label); ?>',
           employee_id: "<?php echo $employer_id; ?>",
           page: '<?php echo $page; ?>',
           tab: '<?php echo $tab; ?>',
           subtab: '<?php echo $subtab; ?>',
           req_frm: '<?php echo $file_path; ?>',
           is_admin : '<?php echo $hrm_is_admin; ?>'
        };
    });
</script>