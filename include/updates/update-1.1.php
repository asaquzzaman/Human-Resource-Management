<?php

$args = array(
	'role' => 'hrm_employer'
);

$users = get_users( $args );

foreach ( $users as $key => $user ) {
	wp_update_user( array(
		'ID' => $user->ID,
		'role' => 'hrm_employee'
	));

	update_user_meta( $user->ID, '_hrm_user_role', 'hrm_employee' );
}