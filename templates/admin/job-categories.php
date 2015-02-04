<div class="hrm-update-notification"></div>
<?php
$field = array();
$field['job_category'] = array(
    'label' => __( 'Category Name', 'hrm' ),
    'type'  => 'text',
    'value' => isset( $_POST['job_category'] ) ? $_POST['job_category'] : '',
    'desc'  => 'please insert category name',
);

$field['type'] = array(
    'type' => 'hidden',
    'value' => '_search'
);

$field['action'] = 'hrm_search';
$field['table_option'] = 'hrm_job_category';


echo Hrm_Settings::getInstance()->get_serarch_form( $field, 'Job Category');
?>

<div id="hrm-admin-job-category"></div>
<?php

//hidden form or insert form


//table
$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();
if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
    $post = $_POST;
    $results = hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
    $search_satus = true;

} else {
    $results = hrm_Settings::getInstance()->hrm_query( 'hrm_job_category', $limit, $pagenum );
    $search_satus = false;
}

    if( isset( $results['total_row'] ) ) {
        $total = $results['total_row'];
        unset( $results['total_row'] );
    } else {
        $total = 0;
    };

$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;

foreach ( $results as $key => $value) {
	$active = ( $value->active == 'yes' ) ? 'Enable' : 'Disable';
    if ( $delete_permission ) {
        $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
    } else {
        $del_checkbox = '';
    }

    if ( $add_permission ) {
        $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_job_category" data-id='.$value->id.'>'.$value->name.'<a>';
    } else {
        $name_id = $value->name;
    }

    $body[] = array(
        $del_checkbox,
        $name_id,
        $active,
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}
$del_checkbox        = ( $delete_permission ) ? '<input type="checkbox">' : '';
$table               = array();
$table['head']       = array( $del_checkbox, 'Job Category', 'Activity' );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_job_category';
$table['action']     = 'hrm_delete';
$table['tab']        = $tab;
$table['subtab']     = $subtab;

echo Hrm_Settings::getInstance()->table( $table );
echo Hrm_Settings::getInstance()->pagination( $total, $limit, $pagenum );
$file_path = urlencode(__FILE__);
?>
<?php $url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
            add_form_generator_action : 'add_form',
            add_form_apppend_wrap : 'hrm-admin-job-category',
            class_name : 'Hrm_Admin',
            redirect : '<?php echo $url; ?>',
            function_name : 'job_category_insert_form',
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