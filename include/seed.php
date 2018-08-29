<?php


function hrm_attendance( $email, $start, $last ) {
	global $wpdb;

	$user = get_user_by( 'email', $email );
	$id   = $user ? $user->id : false;

	if ( !$id ) {
		return;
	}

	$table = $wpdb->prefix . 'hrm_attendance';

	for ( $today=$start; $today<=$last; $today ) {
		
		$start = hrm_generate_random_date_time( $today );
		$end   = hrm_generate_random_date_time( $today );

		if ( $start >= $end ) continue;

		$data = array(
			'user_id'   => $id,
			'date'      => current_time( 'mysql' ),
			'punch_in'  => date( 'Y-m-d H:i:s', $start ),
			'punch_out' => date( 'Y-m-d H:i:s', $end ),
			'total'     => $end - $start,
			'shift_id'  => 1
        );

        $wpdb->insert( $table, $data );

        $today=date( 'Y-m-d H:i:s', strtotime( $today . "+1 day" ) );

	}
}
//hrm_attendance( 'mishu@wpspear.com', '2018-08-17 08:00:00', '2018-08-30 08:00:00' );

function hrm_generate_random_date_time( $today ) {
	$current_date = date('Y-m-d H:i:s', strtotime( $today ) );
	$current_plus_one = date('Y-m-d H:i:s', strtotime( $today . ' +1day' ) );

	$unix_start = strtotime( $current_date );
	$unix_end   = strtotime( $current_plus_one );
	$diff       = $unix_end - $unix_start;
	$rndtime    = $unix_start + mt_rand( 0, $diff );
	
	return $rndtime; //strtotime() fromat
}