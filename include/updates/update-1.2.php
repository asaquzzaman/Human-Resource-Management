<?php

global $wpdb;
$table = $wpdb->prefix . 'hrm_job_category';
$cols = $wpdb->get_col( "DESC " . $table );

if ( ! in_array( 'description', $cols ) ) {
	$wpdb->query( "ALTER TABLE {$table} ADD `description` TEXT NOT NULL AFTER `active`");
}

if ( ! in_array( 'parent', $cols ) ) {
	$wpdb->query( "ALTER TABLE {$table} ADD `parent` INT NOT NULL AFTER `description`");
}