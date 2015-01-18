<?php

    $table_option['table_name'] = 'skill';
    $table_option['table_format'] = array( '%s', '%s');
    $table_option['table_option'] = array(
        'name' => 'skill_name',
		'description' => 'skill_desc',
    );
    $table_option_name = 'hrm_qualification_skills';

    Hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );


//search form
$search['skill_name'] = array(
    'label' => __( 'Skill', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert skills name',
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_qualification_skills';
Hrm_Settings::getInstance()->get_serarch_form( $search, 'Skills');
?>
<div id="hrm-skills"></div>

<?php

$limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 10;
if( isset( $_GET['type'] ) && ( $_GET['type'] == '_search' ) ) {

    $results = Hrm_Settings::getInstance()->search_query( $limit );


} else {
    $results = Hrm_Settings::getInstance()->hrm_query( 'skill', $limit );
}

$total = $results['total_row'];
unset( $results['total_row'] );

foreach ( $results as $key => $value) {
    $body[] = array(
        '<input name="hrm_check['.$value->id.']" value="" type="checkbox">',
        '<a href="#" class="hrm-editable" data-table_option="hrm_qualification_skills" data-id='.$value->id.'>'.$value->name.'<a>',
        $value->description,
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}

$table['head'] = array( '<input type="checkbox">', 'Name', 'Description' );
$table['body'] = $body;


$table['td_attr'] = $td_attr;
$table['th_attr'] = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );

$table['table'] = 'hrm_qualification_skills';
$table['action'] = 'hrm_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab'] = $tab;
$table['subtab'] = $subtab;

Hrm_Settings::getInstance()->table( $table );
//table

//pagination
echo Hrm_Settings::getInstance()->pagination( $total, $limit );

?>

<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm-skills',
       class_name : 'Hrm_Admin',
       function_name : 'skills',
    };
});
</script>