<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'admin' );

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}

if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {
    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}


if ( ( isset( $_GET['action_search'] ) && $_GET['action_search'] ) )  {
    $search_status = true;
    $search_post = get_user_meta( get_current_user_id(), '_hrm_search_data', true );
} else if ( isset( $_POST['action_search'] ) ) {
    $search_status = true;
    $search_post = $_POST;
} else if ( isset( $_POST['search_status'] ) && $_POST['search_status'] ) {
    $search_status = true;
    $search_post = get_user_meta( get_current_user_id(), '_hrm_search_data', true );
} else {
    $search_status = false;
}
$users = get_users();
$user_info['-1'] = __( 'All', 'hrm' );
foreach ( $users as $key => $user ) {
    $user_info[$user->ID] = $user->display_name;
}

$user_info = isset( $user_info ) ? $user_info : array();

$search['emp_id'] = array(
    'label'    => __( 'Employee Name', 'hrm' ),
    'required' => 'required',
    /*'extra' => array(
        'data-hrm_validation' => true,
        'data-hrm_required' => true,
        'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
    ),*/
    'class'  => 'hrm-chosen',
    'type'   => 'select',
    'option' => $user_info,
    'selected' => $search_status ? $search_post['emp_id'] : ''
);

$search['from_date'] = array(
	'label' => __( 'From Date', 'hrm' ),
	'class' => 'hrm-datepicker-from',
	'type'  => 'text',
	'desc'  => __( 'Choose Date', 'hrm' ),
    'value' => $search_status ? $search_post['from_date'] : '',
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
    'value' => $search_status ? $search_post['to_date'] : '',
    'extra' => array(
        'data-hrm_validation' => true,
        'data-hrm_required' => true,
        'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
    ),
);
$search['visibility']   = $search_status ? true : false;
$search['action']       = 'hrm_search';
$search['table_option'] = 'hrm_rating_record';
echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'Employee and employer rating record', 'hrm' ) );

$pagenum     = 1;//hrm_pagenum();
$limit       = hrm_result_limit();

if( $search_status ) {
    $query  = Hrm_Evaluation::getInstance()->search_rating_record( $search_post, -1, $pagenum );
    update_user_meta( get_current_user_id(), '_hrm_search_data',
            array( 'emp_id' => $search_post['emp_id'], 'from_date' => $search_post['from_date'], 'to_date' => $search_post['to_date'] ) );
} else {
    $query  = Hrm_Evaluation::getInstance()->rating_recored( -1, $pagenum );
    update_user_meta( get_current_user_id(), '_hrm_search_data', false );
}



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
$total_pagination = count( $rating_users );
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
$table['page']          = $page;
$table['add_btn_name']  = false;
$table['delete_button'] = false;
$table['data_table']    = true;
$table['search_mode']   = true;
$table['search']        = __( 'Search Mode', 'hrm' );
$table['pagination']    = false;

echo Hrm_Settings::getInstance()->table( $table );

//echo Hrm_Settings::getInstance()->pagination( $total_pagination, $limit, $pagenum );
$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
$file_path = urlencode(__FILE__);
global $hrm_is_admin;
?>

<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       page: '<?php echo $page; ?>',
       tab: '<?php echo $tab; ?>',
       subtab: '<?php echo $subtab; ?>',
       req_frm: '<?php echo $file_path; ?>',
       redirect : '<?php echo $url; ?>',
       limit: '<?php echo $limit; ?>',
       search_status: '<?php echo $search_status; ?>'
       is_admin : '<?php echo $hrm_is_admin; ?>'
    };
});
</script>