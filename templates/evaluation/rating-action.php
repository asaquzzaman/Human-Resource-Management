<?php

$search['from_date'] = array(
	'label' => __( 'From Date', 'hrm' ),
	'class' => 'hrm-datepicker-from',
	'type'  => 'text',
	'desc'  => __( 'Choose Date', 'hrm' ),
);

$search['to_date'] = array(
    'label' => __( 'To Date', 'hrm' ),
    'class' => 'hrm-datepicker-to',
    'type'  => 'text',
    'desc'  => __( 'Choose Date', 'hrm' ),
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_rating_record';
echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'Employee and employer rating record', 'hrm' ) );

if ( isset( $_GET['from_date'] ) && isset( $_GET['to_date'] ) ) {
    if ( strtotime( $_GET['from_date'] ) > strtotime( $_GET['to_date'] ) ) {
        return;
    }
}

$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 10;
$offset = ( $pagenum - 1 ) * $limit;

$args = array(
    'post_type'      => 'hrm_task',
    'post_status'    => array( 'publish', 'future' ),
    'posts_per_page' => $limit,
    'offset'         => $offset
);

if ( isset( $_GET['from_date'] ) && isset( $_GET['to_date'] ) ) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];

    $args['meta_query'] = array(
        array(
            'key' => '_rating_date',
            'value' => strtotime($from_date),
            'compare' => '>='
        ),

        array(
            'key' => '_rating_date',
            'value' => strtotime($to_date),
            'compare' => '<='
        ),
    );

/*    $args['date_query'] = array(
        array(
            'year' => date( 'Y', strtotime( $from_date ) ),
            'compare'   => '>=',
        ),
        array(
            'year' => date( 'Y', strtotime( $to_date ) ),
            'compare'   => '<=',
        ),
        array(
            'month' => date( 'm', strtotime( $from_date ) ),
            'compare'   => '>=',
        ),
        array(
            'month' => date( 'm', strtotime( $to_date ) ),
            'compare'   => '<=',
        ),
        array(
            'day' => date( 'd', strtotime( $from_date ) ),
            'compare'   => '>=',
        ),
        array(
            'day' => date( 'd', strtotime( $to_date ) ),
            'compare'   => '<=',
        ),
    );*/
} else {
    $args['meta_query'] = array(
        'relation' => 'AND',
         array(
            'key' => '_rating_date',
            'value' => strtotime( date( 'Y-m-01', time() ) ),
            'compare' => '>='
        ),

        array(
            'key' => '_rating_date',
            'value' => strtotime( date( 'Y-m-d', time() ) ),
            'compare' => '<='
        ),
    );
}

$query = new WP_Query($args);

//echo '<pre>'; print_r( $query ); echo '</pre>'; die();
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
$table['table_attr']    = array( 'class' => 'widefat' );
$table['tab']           = $tab;
$table['subtab']        = $subtab;
$table['add_btn_name']  = false;
$table['delete_button'] = false;

echo Hrm_Settings::getInstance()->table( $table );

echo Hrm_Settings::getInstance()->pagination( $total_pagination, $limit );