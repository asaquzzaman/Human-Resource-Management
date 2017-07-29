<?php

function hrm_office_time() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_office_time';
    
    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
      `id` bigint(20) NOT NULL AUTO_INCREMENT,
      `start` datetime NOT NULL,
      `end` datetime NOT NULL,
      `is_multi` INT(3) NOT NULL,
      `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function hrm_update_job_category_table() {

	global $wpdb;
	$table = $wpdb->prefix . 'hrm_job_category';
	$cols = $wpdb->get_col( "DESC " . $table );

	if ( ! in_array( 'description', $cols ) ) {
		$wpdb->query( "ALTER TABLE {$table} ADD `description` TEXT NOT NULL AFTER `active`");
	}

	if ( ! in_array( 'parent', $cols ) ) {
		$wpdb->query( "ALTER TABLE {$table} ADD `parent` INT NOT NULL AFTER `description`");
	}
}



function hrm_attendance_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_attendance';

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
      `id` bigint(20) NOT NULL AUTO_INCREMENT,
      `user_id` bigint(20) NOT NULL,
      `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `punch_in` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `punch_out` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `total` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

hrm_office_time();
hrm_update_job_category_table();
hrm_attendance_table();