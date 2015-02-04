<div class="hrm-update-notification"></div>
<?php
$search = array();
$search['name'] = array(
    'label' => __( 'Name', 'hrm' ),
    'type'  => 'text',
    'value' => isset( $_POST['name'] ) ? $_POST['name'] : '',
);

$search['type'] = array(
    'type'  => 'hidden',
    'value' => '_search'
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_pay_grade';
echo Hrm_Settings::getInstance()->get_serarch_form( $search, 'Pay Grade');
?>
<div id="hrm_pay_grade"></div>
<?php

$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();
if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
    $post         = $_POST;
    $search_satus = true;
    $results      = Hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
    $pay_grade = Hrm_Settings::getInstance()->search_query( $limit );

} else {
    $pay_grade = Hrm_Settings::getInstance()->hrm_query( 'hrm_pay_grade', $limit, $pagenum );
    $search_satus = false;
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
$table               = array();
$del_checkbox        = ( $delete_permission ) ? '<input type="checkbox">' : '';
$table['head']       = array( $del_checkbox, __( 'Pay Grades', 'hrm') );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );
$table['action']     = 'hrm_delete';
$table['tab']        = $tab;
$table['subtab']     = $subtab;

echo Hrm_Settings::getInstance()->table( $table );
echo Hrm_Settings::getInstance()->pagination( $total, $limit, $pagenum );
$file_path = urlencode(__FILE__);
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
            page: '<?php echo $page; ?>',
            tab: '<?php echo $tab; ?>',
            subtab: '<?php echo $subtab; ?>',
            req_frm: '<?php echo $file_path; ?>',
            limit: '<?php echo $limit; ?>',
            search_satus: '<?php echo $search_satus; ?>',
            subtab: true
        };
    });
</script>