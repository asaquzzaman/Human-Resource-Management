<div class="hrm-update-notification"></div>

    <div id="hrm-leave-holiday"></div>


<?php

$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();
if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
    $post         = $_POST;
    $search_satus = true;
    $results      = Hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
} else {
    $results = Hrm_Settings::getInstance()->hrm_query( 'hrm_holiday', $limit, $pagenum );
    $search_satus = false;
}

$total = $results['total_row'];
unset( $results['total_row'] );
$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
foreach ( $results as $key => $value) {
    $value->length = ( $value->length == 'full' ) ? 'Full Day' : 'Half Day';
    $body[] = array(
        $value->name,
        hrm_get_date2mysql( $value->from ),
        hrm_get_date2mysql( $value->to ),
        $value->description,
        $value->length
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}
$table = array();
$table['head'] = array(
    __('Name', 'hrm' ),
    __('From', 'hrm'),
    __('To', 'hrm'),
    __('Description','hrm'),
    __('Full Day/Half Day','hrm')
);
$table['body'] = isset( $body ) ? $body : '';
$table['td_attr']       = isset( $td_attr ) ? $td_attr : '';
$table['th_attr']       = array( 'class="check-column"' );
$table['table_attr']    = array( 'class' => 'widefat' );
$table['table']         = 'hrm_holiday';
$table['action']        = 'hrm_delete';
$table['tab']           = $tab;
$table['subtab']        = $subtab;
$table['add_btn_name']  = false;
$table['delete_button'] = false;

echo hrm_Settings::getInstance()->table( $table );
//table
echo hrm_Settings::getInstance()->pagination( $total, $limit, $pagenum );
$file_path = urlencode(__FILE__);
$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-leave-holiday',
           class_name : 'hrm_Leave',
           redirect : '<?php echo $url; ?>',
           function_name : 'holiday',
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