<?php

$search['from_date'] = array(
	'label' => __( 'From Date', 'hrm' ),
	'class' => 'hrm-datepicker-from',
	'type'  => 'text',
	'desc'  => __( 'Choose Date', 'hrm' ),
    'value' => isset( $_POST['from_date'] ) ? hrm_get_date2mysql( $_POST['from_date'] ) : '',
    'extra' => array(
        'data-hrm_validation' => true,
        'data-hrm_required' => true,
        'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
    ),
);

$search['to_date'] = array(
    'label' => __( 'To Date', 'hrm' ),
    'class' => 'hrm-datepicker-to',
    'type'  => 'text',
    'desc'  => __( 'Choose Date', 'hrm' ),
    'value' => isset( $_POST['to_date'] ) ? hrm_get_date2mysql( $_POST['to_date'] ) : '',
    'extra' => array(
        'data-hrm_validation' => true,
        'data-hrm_required' => true,
        'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
    ),
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_rating_record';
echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'Employee and employer rating record', 'hrm' ) );

$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();

if( isset( $_POST['action'] ) && $_POST['action'] == 'hrm_search' ) {
    $post = $_POST;
    $search_satus = true;
    $query  = Hrm_Evaluation::getInstance()->search_rating_record( $post, $limit, $pagenum );

} else {
    $query  = Hrm_Evaluation::getInstance()->rating_recored( $limit, $pagenum );
    $search_satus = false;
}


$total_pagination = $query->found_posts;
$posts = $query->posts;

$rating_users = array();

foreach ($posts as $key => $post) {
    $rating_user_id = get_post_meta( $post->ID, '_assigned', true );
    $rating_value = get_post_meta( $post->ID, '_rating_value', true );

    if ( array_key_exists( $rating_user_id, $rating_users) ) {
        $rating_users[$rating_user_id] = $rating_users[$rating_user_id]+$rating_value;
    } else {
        $rating_users[$rating_user_id] = $rating_value;
    }
}

arsort( $rating_users );

foreach ( $rating_users as $user_id => $ragin_value ) {
    /*if ( $add_permission ) {
        $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_job_title_option" data-id='.$value->id.'>'.$value->job_title.'<a>';
    } else {
        $name_id = $value->job_title;
    }*/

    /*if ( $delete_permission ) {
        $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
    } else {
        $del_checkbox = '';
    }*/

    $user = get_user_by( 'id', $user_id );

    $body[] = array(
        $user->display_name,
        number_format_i18n($ragin_value)
    );

    $td_attr[] = array(
        'style="width:50%"'
    );
}


$table['head']          = array( __( 'Display Name', 'hrm' ), __( 'Total Score', 'hrm' ) );
$table['body']          = isset( $body ) ? $body : array();
$table['td_attr']       = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']       = array( 'style="width:50%"' );
$table['table_attr']    = array( 'class' => 'widefat' );
$table['table']         = 'hrm_job_title_option';
$table['action']        = 'hrm_delete';
$table['tab']           = $tab;
$table['subtab']        = $subtab;
$table['add_btn_name']  = false;
$table['delete_button'] = false;

echo Hrm_Settings::getInstance()->table( $table );

echo Hrm_Settings::getInstance()->pagination( $total_pagination, $limit, $pagenum );
$file_path = urlencode(__FILE__);
?>

<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       page: '<?php echo $page; ?>',
       tab: '<?php echo $tab; ?>',
       subtab: '<?php echo $subtab; ?>',
       req_frm: '<?php echo $file_path; ?>',
       limit: '<?php echo $limit; ?>',
       search_satus: '<?php echo $search_satus; ?>'
    };
});
</script>