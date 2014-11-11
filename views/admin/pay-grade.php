<?php
    $search['name'] = array(
        'label' => __( 'Name', 'hrm' ),
        'type' => 'text',
    );

    $search['action'] = 'hrm_search';
    $search['table_option'] = 'hrm_job_title_option';
    echo Hrm_Settings::getInstance()->get_serarch_form( $search, 'Pay Grade');
    //search form
?>
<div id="hrm_pay_grade"></div>
<?php

    $limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 10;
    if( isset( $_GET['type'] ) && ( $_GET['type'] == '_search' ) ) {
        $pay_grade = Hrm_Settings::getInstance()->search_query( $limit );

    } else {
        $pay_grade = Hrm_Settings::getInstance()->hrm_query( 'hrm_pay_grade', $limit );
    }
if( isset( $pay_grade['total_row'] ) ) {
        $total = $pay_grade['total_row'];
        unset( $pay_grade['total_row'] );
    } else {
        $total = 0;
    };
$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
foreach ( $pay_grade as $key => $value) {
    if ( $delete_permission ) {
        $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
    } else {
        $del_checkbox = '';
    }

    if ( $add_permission ) {
        $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_pay_grade"  data-id='.$value->id.'>'.$value->name.'<a>';
    } else {
        $name_id = $value->name;
    }

    $body[] = array(
        $del_checkbox,
        $name_id
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}
$del_checkbox = ( $delete_permission ) ? '<input type="checkbox">' : '';

$table['head'] = array( $del_checkbox, __( 'Pay Grades', 'hrm') );
$table['body'] = isset( $body ) ? $body : array();


$table['td_attr'] = isset( $td_attr ) ? $td_attr : array();
$table['th_attr'] = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );
$table['action'] = 'hrm_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab'] = $tab;
$table['subtab'] = $subtab;

echo Hrm_Settings::getInstance()->table( $table );
echo Hrm_Settings::getInstance()->pagination( $total, $limit );
?>
<?php $url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm_pay_grade',
           class_name : 'Hrm_Admin',
           redirect : '<?php echo $url; ?>',
           function_name : 'pay_grade',
        };
    });
</script>