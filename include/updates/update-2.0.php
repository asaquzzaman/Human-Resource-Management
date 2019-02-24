<?php

function hrm_work_experiance_tb_update() {
    global $wpdb;
    $table = $wpdb->prefix . 'hrm_work_experience';

    $wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "hrm_work_experience" );
}

function hrm_create_workexperiance_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_work_experience';
    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `employee_id` int(11) NOT NULL,
        `title` varchar(255) NOT NULL DEFAULT '0',
        `start` timestamp NULL DEFAULT NULL,
		`end` timestamp NULL DEFAULT NULL,
		`description` tinytext,
		`created_at` timestamp NULL DEFAULT NULL,
		`updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}


hrm_work_experiance_tb_update();
hrm_create_workexperiance_table();