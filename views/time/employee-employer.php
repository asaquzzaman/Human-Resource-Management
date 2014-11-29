<?php

$employers = Hrm_Admin::getInstance()->get_employer( '-1' );
$employees = hrm_Employeelist::getInstance()->get_employee( '-1' );

$employers = $employers->get_results();
$employees = $employees->get_results();
$users = array_merge($employers, $employees);

$option_value = array();
foreach( $users as $user ) {
	$option_value[$user->ID] = $user->display_name;
}

$search['user_id'] = array(
	'label'    => __( 'Employer/Employee Name', 'hrm' ),
	'class'    => 'hrm-chosen',
	'type'     => 'select',
	'option'   => $option_value,
	'selected' => '',
	'desc'     => __( 'Type employer/employee name', 'hrm' ),
	'extra' => array(
		'data-placeholder' => __( "Choose employer/employee name", 'hrm' ),
    ),
);

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
$search['table_option'] = 'hrm_attendance_record_both';
echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'Attendance Records for Employer/Employee', 'hrm' ) );
?>

<div id="hrm-attendance"></div>

<?php
$user_id = isset( $_GET['user_id'] ) ? $_GET['user_id'] : false;
if ( !$user_id ) {
	return;
}

if ( isset( $_GET['from_date'] ) && isset( $_GET['to_date'] ) ) {
    if ( strtotime( $_GET['from_date'] ) > strtotime( $_GET['to_date'] ) ) {
        return;
    }
}

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
$post_date = false;
if ( isset( $_GET['from_date'] ) && isset( $_GET['to_date'] ) ) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];

    $args['date_query'] = array(
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
    );
} else {
    if ( isset( $_GET['from_date'] ) && !isset( $_GET['to_date'] ) ) {
        $post_date = $_GET['from_date'];
    }

    if ( !isset( $_GET['from_date'] ) && isset( $_GET['to_date'] ) ) {
        $post_date = $_GET['from_date'];
    }

    if ( $post_date ) {
        $args['date_query'] = array(
            'year' => date( 'Y', strtotime($post_date) ),
            'month' => date( 'm', strtotime($post_date) ),
            'day' => date( 'd', strtotime($post_date) ),
        );
    }
}



$query = new WP_Query($args);
$total_pagination = $query->found_posts;
$posts = $query->posts;

	$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
    $puch_status = get_user_meta( $user_id, '_puch_in_status', true );


    $total_duration = 0;
    foreach ( $posts as $key => $post ) {
        if ( $add_permission ) {
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


    $body[] = array(
        '',
        '',
        '',
        '<strong>' . __( 'Total', 'hrm' ) . '</strong>',
        $total_time
    );

	$del_checkbox = ( $delete_permission ) ? '<input type="checkbox">' : '';

    $table['head'] = array(

    	__( 'Punch In', 'hrm' ),
    	__( 'Punch In Note', 'hrm' ),
    	__( 'Punch Out', 'hrm' ),
    	__( 'Punch Out Note', 'hrm' ),
    	__( 'Duration (Hours)', 'hrm' ),
    );
    $table['body']       = isset( $body ) ? $body : array();


    $table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
    $table['th_attr']    = array( 'class="check-column"' );
    $table['table_attr'] = array( 'class' => 'widefat' );

    $table['table']      = '';
    $table['action']     = 'hrm_create_punch_in';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['add_btn_name'] = ( $puch_status === '1' ) ? __( 'Punch Out', 'hrm' ) : __( 'Punch In', 'hrm' );
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