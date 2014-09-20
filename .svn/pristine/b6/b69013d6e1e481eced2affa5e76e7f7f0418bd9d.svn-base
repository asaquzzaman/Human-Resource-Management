<?php
//search form
$search['skill_name'] = array(
    'label' => __( 'Skill', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert skills name',
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_qualification_skills';
echo Hrm_Settings::getInstance()->get_serarch_form( $search, 'Skills');
?>
<div id="hrm-skills"></div>

<?php

$limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 2;
if( isset( $_GET['type'] ) && ( $_GET['type'] == '_search' ) ) {

    $results = Hrm_Settings::getInstance()->search_query( $limit );


} else {
    $results = Hrm_Settings::getInstance()->hrm_query( 'hrm_skill', $limit );
}

$total = $results['total_row'];
unset( $results['total_row'] );
$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
foreach ( $results as $key => $value) {
    if ( $delete_permission ) {
        $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
    } else {
        $del_checkbox = '';
    }

    if ( $add_permission ) {
        $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_qualification_skills" data-id='.$value->id.'>'.$value->name.'<a>';
    } else {
        $name_id = $value->name;
    }
    $body[] = array(
        $del_checkbox,
        $name_id,
        $value->description,
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}
$del_checkbox        = ( $delete_permission ) ? '<input type="checkbox">' : '';
$table['head']       = array( $del_checkbox, 'Name', 'Description' );
$table['body']       = isset( $body ) ? $body : array();


$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );

$table['table']      = 'hrm_qualification_skills';
$table['action']     = 'hrm_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;

echo Hrm_Settings::getInstance()->table( $table );
//table

//pagination
echo Hrm_Settings::getInstance()->pagination( $total, $limit );

?>
<?php $url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm-skills',
       redirect : '<?php echo $url; ?>',
       class_name : 'Hrm_Admin',
       function_name : 'skills',
    };
});
</script>