<?php

	//search form
	$search['date'] = array(
		'label' => __( 'Date', 'hrm' ),
		'class' => 'hrm-datepicker',
		'type'  => 'text',
		'desc'  => __( 'Choose Date', 'hrm' ),
	);
    $search['action'] = 'hrm_search';
    $search['table_option'] = 'hrm_attendance';
	echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'Attendance Records', 'hrm' ) );
	//search form
?>
<?php
$post_date = isset( $_GET['date'] ) ? $_GET['date'] : false;
$user_id = get_current_user_id();

$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 10;
$offset = ( $pagenum - 1 ) * $limit;

$args = array(
    'post_type'      => 'hrm_punch',
    'post_status'    => 'publish',
    'author'         => $user_id,
    'posts_per_page' => $limit,
    'offset'         => $offset
);

if ( $post_date ) {
    $args['date_query'] = array(
        'year' => date( 'Y', strtotime($post_date) ),
        'month' => date( 'm', strtotime($post_date) ),
        'day' => date( 'd', strtotime($post_date) ),
    );
}

$query = new WP_Query($args);

$posts = $query->posts;
$total_pagination = $query->found_posts;
?>
<div id="hrm-attendance"></div>

<?php

	$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
   // $puch_status = get_user_meta( $user_id, '_puch_in_status', true );

    $total_duration = 0;
    foreach ( $posts as $key => $post ) {
        if ( $add_permission && hrm_user_can_access( $tab, $subtab, 'punch_edit', true )  ) {
            $name_id = '<a href="#" class="hrm-time-editable"  data-post_id='.$post->ID.'>'.hrm_get_punch_in_time($post->post_date).'<a>';
        } else {
            $name_id = hrm_get_punch_in_time($post->post_date);
        }

        if ( $delete_permission ) {
            $del_checkbox = '<input name="hrm_check['.$post->ID.']"$post="" type="checkbox">';
        } else {
            $del_checkbox = '';
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

        $body[] = array(
            $del_checkbox,
            $name_id,
            $post->post_content,
            !empty( $punch_out_time ) ? hrm_get_punch_in_time( $punch_out_time, false ) : '',
            $puch_out_note,
            isset( $duration ) ? $duration : '',
        );

        $td_attr[] = array(
            'class="check-column"'
        );
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
            '<strong>' . __( 'Total', 'hrm' ) . '</strong>',
            $total_time
        );
    }

	$del_checkbox = ( $delete_permission ) ? '<input type="checkbox">' : '';

    $table['head'] = array(
        $del_checkbox,
    	__( 'Punch In', 'hrm' ),
    	__( 'Punch In Note', 'hrm' ),
    	__( 'Punch Out', 'hrm' ),
    	__( 'Punch Out Note', 'hrm' ),
    	__( 'Duration (Hours)', 'hrm' ),
    );
    $table['body']       = isset( $body ) ? $body : array();

     $arg = array(
            'post_type' => 'hrm_punch',
            'post_status'=> 'publish',
            'author' => get_current_user_id(),
            'meta_query' => array(
                array(
                    'key' => '_puch_in_status',
                    'value' => '1',
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

    $table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
    $table['th_attr']    = array( 'class="check-column"' );
    $table['table_attr'] = array( 'class' => 'widefat' );

    $table['table']      = '';
    $table['action']     = 'hrm_post_delete';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['add_btn_name'] = $punch_status;
    $table['tab']        = $tab;
    $table['subtab']     = $subtab;

    echo Hrm_Settings::getInstance()->table( $table );


echo Hrm_Settings::getInstance()->pagination( $total_pagination, $limit );
?>
<?php $url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-attendance',
           class_name : 'Hrm_Time',
           redirect : '<?php echo $url; ?>',
           function_name : 'punch_in_out_form',
        };
    });
</script>