<div class="hrm-update-notification"></div>

<div id="hrm-leave-type"></div>

<?php
$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();
if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
    $post         = $_POST;
    $search_satus = true;
    $results      = Hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
} else {
    $results = Hrm_Settings::getInstance()->hrm_query( 'hrm_leave_type', $limit, $pagenum );
    $search_satus = false;
}

$total = $results['total_row'];
unset( $results['total_row'] );

$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;

foreach ( $results as $key => $value) {
    if ( $add_permission ) {
        $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_leave_type" data-id='.$value->id.'>'.$value->leave_type_name.'<a>';
    } else {
        $name_id = $value->leave_type_name;
    }

    if ( $delete_permission ) {
        $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
    } else {
        $del_checkbox = '';
    }
    $body[] = array(
        $del_checkbox,
        $name_id
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}
$table = array();
$del_checkbox        = ( $delete_permission ) ? '<input type="checkbox">' : '';
$table['head']       = array( $del_checkbox, 'Leave Type' );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : '';
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_leave_type';
$table['action']     = 'hrm_delete';
$table['tab']        = $tab;
$table['subtab']     = $subtab;


echo hrm_Settings::getInstance()->table( $table );
//table

//pagination
echo hrm_Settings::getInstance()->pagination( $total, $limit, $pagenum );
$url       = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
$file_path = urlencode(__FILE__);
?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-leave-type',
           class_name : 'hrm_Leave',
           redirect : '<?php echo $url; ?>',
           function_name : 'leave_type_form',
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