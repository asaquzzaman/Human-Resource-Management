<div class="hrm-update-notification"></div>

<div id="hrm-projects"></div>
<?php

$results           = Hrm_Admin::getInstance()->get_projects( $tab, $subtab );
$add_permission    = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;

foreach ( $results['posts'] as $key => $project_obj ) {
    if ( $project_obj->post_type != 'hrm_project' ) {
        continue;
    }
    $task_id = array();
    foreach ( $results['posts'] as $key => $obj ) {
        if ( $obj->post_type == 'hrm_task' && $obj->post_parent == $project_obj->ID ) {
            $task_id[] = $obj->ID;
        }
    }

    if ( $delete_permission ) {
        $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$project_obj->ID.']" value="'.$project_obj->ID.'" type="checkbox">';
        $delete_text  = '<a href="#" class="hrm-delete" data-id='.$project_obj->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
        $td_attr[][0] = 'class="hrm-table-checkbox"';
    } else {
        $del_checkbox = '';
        $delete_text  = '';
    }

    if ( $add_permission ) {
        $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable"  data-action="project_edit"  data-id='.$project_obj->ID.'><strong>'.$project_obj->post_title.'</strong></a>
        <div class="hrm-title-action"><a href="#" class="hrm-editable hrm-edit" data-action="project_edit" data-id='.$project_obj->ID.'>'.__( 'Edit', 'hrm' ).'</a>'
        .$delete_text. '</div></div>';
    } else {
        $name_id = $project_obj->post_title;
    }

    $currency_symbol = get_post_meta( $project_obj->ID, '_currency_symbol', true );
    $total_budget    = get_post_meta( $project_obj->ID, '_budget', true );
    $budget_utilize  = get_post_meta( $project_obj->ID, '_project_budget_utilize', true );
    $budget_remain   = $total_budget - $budget_utilize;



    if ( $delete_permission ) {
        $body[] = array(
            $del_checkbox,
            $name_id .
            '<div style="margin-top: 5px; color: #000;">'.
            __( '<strong>Total budget:</strong> ' . $currency_symbol . $total_budget, 'hrm' ).
            '</div><div style="color: #000;">'.
            __( '<strong>Budget utilize:</strong> ' . $currency_symbol . $budget_utilize, 'hrm' ) .
            '</div><div style="color: #000;">'.
            __( '<strong>Budget remain:</strong> ' . $currency_symbol . $budget_remain, 'hrm' ).
            '</div>'
            ,
            $project_obj->post_content,
            Hrm_Admin::getInstance()->get_task_title( $results['posts'], $task_id, $project_obj->ID, $add_permission, $currency_symbol ),
        );
    } else {
        $body[] = array(
            $name_id .
            '<div style="color: #000;">'.
            __( '<strong>Total budget:</strong> ' . $currency_symbol . $total_budget, 'hrm' ).
            '</div><div style="color: #000;">'.
            __( '<strong>Budget utilize:</strong> ' . $currency_symbol . $budget_utilize, 'hrm' ) .
            '</div><div style="color: #000;">'.
            __( '<strong>Budget remain:</strong> ' . $currency_symbol . $budget_remain, 'hrm' ).
            '</div>'
            ,
            $project_obj->post_content,
            Hrm_Admin::getInstance()->get_task_title( $results['posts'], $task_id, $project_obj->ID, $add_permission, $currency_symbol ),
        );
    }

    $task_id = '';
}

$table['body'] = isset( $body ) ? $body : array();

if ( $delete_permission ) {
    $table['head'] = array(
        '<input class="hrm-all-checked" type="checkbox">',
        __('Project Title', 'hrm' ),
        __('Description', 'hrm'),
        __( 'Task Title', 'hrm' ),
    );
} else {
    $table['head'] = array(
        __('Project Title', 'hrm' ),
        __('Description', 'hrm'),
        __( 'Task Title', 'hrm' ),
       // __( 'Description', 'hrm' ),
       // __( 'Sub task title', 'hrm' ),
       // __('Description', 'hrm' )
    );
}

$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();

$table['table_attr'] = array( 'class' => 'widefat' );

$table['table']      = 'hrm_project_customer';
$table['action']     = 'delete_project';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;
$table['page']       = $page;


echo Hrm_Settings::getInstance()->table( $table );

$file_path = urlencode(__FILE__);

$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
global $hrm_is_admin;
?>

<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm-projects',
       redirect : '<?php echo $url; ?>',
       class_name : 'Hrm_Admin',
       function_name : 'project_insert_form',
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
            zIndex: 99999,

        });
    });


</script>

