<?php
//search form
$search['title'] = array(
    'label' => __( 'Project Title', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert project title',
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_projects';

echo Hrm_Settings::getInstance()->get_serarch_form( $search, 'Project');

//hidden form
?>
<div id="hrm-projects"></div>
<?php
//hidden form


$limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 2;

$results = Hrm_Admin::getInstance()->get_projects( $limit, $tab, $subtab );

$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;

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

    $body[] = array(
        '<input name="hrm_check['.$project_obj->ID.']" value="'.$project_obj->ID.'" type="checkbox">',
        '<a href="#" class="hrm-editable"  data-action="project_edit"  data-id='.$project_obj->ID.'>'.$project_obj->post_title.'<a>',
        $project_obj->post_content,
        hrm_Admin::getInstance()->get_task_title( $results['posts'], $task_id, $project_obj->ID, $add_permission ),
        //hrm_Admin::getInstance()->get_task_description( $results['posts'], $task_id ),
       // hrm_Admin::getInstance()->get_sub_task_title( $results['posts'], $task_id, $project_obj->ID, $add_permission ),
        //hrm_Admin::getInstance()->get_sub_task_description( $results['posts'], $task_id ),
    );

    $td_attr[] = array(
        'class="check-column"'
    );


    $task_id = '';
}



$table['head'] = array(
    '<input type="checkbox">',
    __('Project Title', 'hrm' ),
    __('Description', 'hrm'),
    __( 'Task Title', 'hrm' ),
   // __( 'Description', 'hrm' ),
   // __( 'Sub task title', 'hrm' ),
   // __('Description', 'hrm' )
);
$table['body'] = isset( $body ) ? $body : array();


$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );

$table['table']      = 'hrm_project_customer';
$table['action']     = 'delete_project';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;


echo Hrm_Settings::getInstance()->table( $table );
//table

//pagination
echo Hrm_Settings::getInstance()->pagination( $results['found_posts'], $limit );
?>
<?php $url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm-projects',
       redirect : '<?php echo $url; ?>',
       class_name : 'Hrm_Admin',
       function_name : 'project_insert_form',
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