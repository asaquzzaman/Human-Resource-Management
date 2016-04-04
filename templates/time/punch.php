<div id="hrm-subtab-wrap">
<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'time' );

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}

if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {
    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}
?>
<div class="hrm-update-notification"></div>
<?php
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
$search['from_date'] = array(
    'label' => __( 'From Date', 'hrm' ),
    'class' => 'hrm-datepicker-from',
    'value' => $search_status ? $search_post['from_date'] : '',
    'type'  => 'text',
    'desc'  => __( 'Choose Date', 'hrm' ),
);

$search['to_date'] = array(
    'label' => __( 'To Date', 'hrm' ),
    'class' => 'hrm-datepicker-to',
    'value' => $search_status ? $search_post['to_date'] : '',
    'type'  => 'text',
    'desc'  => __( 'Choose Date', 'hrm' ),
);

$search['visibility']   = $search_status ? true : false;
$search['action']       = 'hrm_search';
$search['table_option'] = 'hrm_attendance';
echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'Attendance Records', 'hrm' ) );
	//search form
?>
<?php

$user_id = get_current_user_id();

$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();
if( $search_status ) {
    $query = Hrm_Time::getInstance()->get_individual_punch( $limit, $pagenum, $search_post );
    update_user_meta( get_current_user_id(), '_hrm_search_data',
            array( 'from_date' => $search_post['from_date'], 'to_date' => $search_post['to_date'] ) );
} else {
    $query = Hrm_Time::getInstance()->get_individual_punch( $limit, $pagenum );
    update_user_meta( get_current_user_id(), '_hrm_search_data', false );
}

$posts = $query->posts;
$total_pagination = $query->found_posts;
?>
<div id="hrm-attendance" class="hrm-time-attendance"></div>

<?php

	$add_permission = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;

    $total_duration = 0;
    foreach ( $posts as $key => $post ) {

        if ( $delete_permission && hrm_user_can_access( $page, $tab, $subtab, 'punch_edit', true ) ) {
            $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$post->ID.']" value="" type="checkbox">';
            $delete_text  = '<a href="#" class="hrm-delete" data-id='.$post->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
            $td_attr[][0] = 'class="hrm-table-checkbox"';
        } else {
            $del_checkbox = '';
            $delete_text  = '';
        }

        if ( $add_permission ) {
            $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-time-editable hrm-title"  data-post_id='.$post->ID.'>'.hrm_get_punch_in_time($post->post_date).'</a>
            <div class="hrm-title-action"><a href="#" class="hrm-time-editable hrm-edit"  data-post_id='.$post->ID.'>'.__( 'Edit', 'hrm' ).'</a>'
            .$delete_text. '</div></div>';
        } else {
            $name_id = hrm_get_punch_in_time($post->post_date);
        }

        $punch_out_time = get_post_meta( $post->ID, '_puch_out_time', true );
        $puch_out_note = get_post_meta( $post->ID, '_puch_out_note', true );

        if ( !empty( $punch_out_time ) ) {

            $total_duration = $total_duration + ( $punch_out_time - strtotime( $post->post_date ) );

            $punch_out = date( "Y-m-d H:i:s", $punch_out_time );

            $punch_out = new DateTime( $punch_out );
            $punch_in = new DateTime( $post->post_date );

            $interval = date_diff( $punch_out, $punch_in );
            $duration = $interval->format('%H:%I:%S');
        }

        if ( $delete_permission ) {
            $body[] = array(
                $del_checkbox,
                $name_id,
                $post->post_content,
                !empty( $punch_out_time ) ? hrm_get_punch_in_time( $punch_out_time, false ) : '',
                $puch_out_note,
                isset( $duration ) ? $duration : '',
            );
        } else {
            $body[] = array(
                $name_id,
                $post->post_content,
                !empty( $punch_out_time ) ? hrm_get_punch_in_time( $punch_out_time, false ) : '',
                $puch_out_note,
                isset( $duration ) ? $duration : '',
            );
        }
    }
    $total = hrm_second_to_time($total_duration);
    $total_time = $total['hour'] .':'. $total['minute'] .':'. $total['second'];

    if ( $delete_permission ) {
        $body[] = array(
            '',
            '',
            '',
            '',
            '<strong>' . __( 'Total', 'hrm' ) . '</strong>',
            $total_time
        );
    } else {
        $body[] = array(
            '',
            '',
            '',
            '',
            '<strong>' . __( 'Total', 'hrm' ) . '</strong>',
            $total_time
        );
    }

    $arg = array(
        'post_type'   => 'hrm_punch',
        'post_status' => 'publish',
        'author'      => get_current_user_id(),
        'meta_query' => array(
            array(
                'key'     => '_puch_in_status',
                'value'   => '1',
                'compear' => '='
            ),
        )
    );

    $query = new WP_Query( $arg );

    if ( !isset( $query->posts[0] ) ) {
        $punch_status = __( 'Punch In', 'hrm' );
    } else {
        $punch_status = __( 'Punch Out', 'hrm' );
    }

    $table = array();

    if ( $delete_permission ) {
        $table['head'] = array(
            '<input class="hrm-all-checked" type="checkbox">',
            __( 'Punch In', 'hrm' ),
            __( 'Punch In Note', 'hrm' ),
            __( 'Punch Out', 'hrm' ),
            __( 'Punch Out Note', 'hrm' ),
            __( 'Duration (Hours)', 'hrm' ),
        );
    } else {
        $table['head'] = array(
            __( 'Punch In', 'hrm' ),
            __( 'Punch In Note', 'hrm' ),
            __( 'Punch Out', 'hrm' ),
            __( 'Punch Out Note', 'hrm' ),
            __( 'Duration (Hours)', 'hrm' ),
        );
    }

    $table['body']         = isset( $body ) ? $body : array();
    $table['td_attr']      = isset( $td_attr ) ? $td_attr : array();
    $table['table_attr']   = array( 'class' => 'widefat' );
    $table['data_table']   = false;
    $table['search_mode']  = true;
    $table['table']        = '';
    $table['action']       = 'hrm_post_delete';
    $table['table_attr']   = array( 'class' => 'widefat' );
    $table['add_btn_name'] = $punch_status;
    $table['tab']          = $tab;
    $table['subtab']       = $subtab;
    $table['page']         = $page;
    $table['search']       = __( 'Search Mode', 'hrm' );

    echo Hrm_Settings::getInstance()->table( $table );


echo Hrm_Settings::getInstance()->pagination( $total_pagination, $limit, $pagenum );
$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
$file_path = urlencode(__FILE__);
global $hrm_is_admin;
?>
</div>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-attendance',
           class_name : 'Hrm_Time',
           redirect : '<?php echo $url; ?>',
           function_name : 'punch_in_out_form',
           user_id_js : '<?php echo $user_id; ?>',
           page: '<?php echo $page; ?>',
           tab: '<?php echo $tab; ?>',
           subtab: '<?php echo $subtab; ?>',
           req_frm: '<?php echo $file_path; ?>',
           limit: '<?php echo $limit; ?>',
           search_status: '<?php echo $search_status; ?>',
           is_admin: '<?php echo $hrm_is_admin; ?>',
        };
    });
</script>