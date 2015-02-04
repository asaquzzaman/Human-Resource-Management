<div class="hrm-update-notification"></div>
<?php
//search form
$search = array();
$search['education_name'] = array(
    'label' => __( 'Name', 'hrm' ),
    'type'  => 'text',
    'value' => isset( $_POST['education_name'] ) ? $_POST['education_name'] : '',
    'desc'  => 'please insert education name',
);

$search['type'] = array(
    'type'  => 'hidden',
    'value' => '_search'
);

$search['action']       = 'hrm_search';
$search['table_option'] = 'hrm_qualification_education';
echo hrm_Settings::getInstance()->get_serarch_form( $search, 'Education');

//hidden form
?>
<div id="hrm-education"></div>
<?php
//hidden form

$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();
if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
    $post         = $_POST;
    $search_satus = true;
    $results      = Hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
} else {
    $results = Hrm_Settings::getInstance()->hrm_query( 'hrm_education', $limit, $pagenum );
    $search_satus = false;
}

$total             = $results['total_row'];
$add_permission    = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
unset( $results['total_row'] );

foreach ( $results as $key => $value) {
    if ( $delete_permission ) {
        $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
    } else {
        $del_checkbox = '';
    }

    if ( $add_permission ) {
        $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_qualification_education" data-id='.$value->id.'>'.$value->name.'</a>';
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
$del_checkbox        = ( $delete_permission ) ? '<input type="checkbox">' : '';
$table               = array();
$table['head']       = array( $del_checkbox, 'Name', 'Description' );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_qualification_education';
$table['action']     = 'hrm_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;

echo Hrm_Settings::getInstance()->table( $table );
//table

//pagination
echo Hrm_Settings::getInstance()->pagination( $total, $limit, $pagenum );
$file_path = urlencode(__FILE__);
$url       = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm-education',
       redirect : '<?php echo $url; ?>',
       class_name : 'Hrm_Admin',
       function_name : 'education',
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