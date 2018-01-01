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
      `ip` TINYTEXT NOT NULL,
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
      `config_id` BIGINT(20) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function hrm_department() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_job_category';
    $wpdb->query( "ALTER TABLE $table_name ADD `description` TINYTEXT NOT NULL" );
    $wpdb->query( "ALTER TABLE $table_name ADD `parent` INT NOT NULL" );
}

function hrm_employer_role() {
    remove_role( 'hrm_manager' );
    remove_role( 'hrm_employee' );

    $role_name            = hrm_employee_role_key();
    $display_name         = __( 'HRM Employee', 'hrm' );
    $capabilities['read'] = true;
    add_role( $role_name, $display_name, $capabilities );

    $role_name            = hrm_manager_role_key();
    $display_name         = __( 'HRM Manager', 'hrm' );
    $capabilities['read'] = true;
    add_role( $role_name, $display_name, $capabilities );
}

function hrm_leave_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_leave';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `status` smallint(6) DEFAULT NULL,
      `comments` varchar(256) DEFAULT NULL COMMENT '1 = ''Pending'', 2 = ''Approve'', 3 = ''Cancel''',
      `type` varchar(13) NOT NULL,
      `emp_id` int(7) NOT NULL,
      `start_time` timestamp NULL DEFAULT NULL,
      `end_time` timestamp NULL DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function hrm_leave_type_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_leave_type';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} ( 
        `id` int(11) NOT NULL AUTO_INCREMENT, 
        `leave_type_name` varchar(50) DEFAULT NULL, 
        `entitlement` smallint(6) DEFAULT '0', 
        `entitle_from` timestamp NULL DEFAULT NULL, 
        `entitle_to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', 
        `f_year` int(11) DEFAULT NULL, 
        `carry` int(11) DEFAULT NULL, 
        PRIMARY KEY (`id`) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function hrm_relation() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_relation';
    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `type` varchar(255) DEFAULT NULL,
      `from` int(11) DEFAULT NULL,
      `to` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function hrm_holiday_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_holiday';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `description` text,
      `from` datetime DEFAULT NULL,
      `to` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `f_year` int(11) DEFAULT NULL,
      `length` varchar(10) NOT NULL,
      `index_holiday` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function hrm_personal_education_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_personal_education';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `emp_id` int(11) NOT NULL,
      `education` varchar(255) NOT NULL,
      `institute` varchar(100) DEFAULT NULL,
      `major` varchar(100) DEFAULT NULL,
      `year` timestamp NULL DEFAULT CURRENT_TIMESTAMP(),
      `score` varchar(25) DEFAULT NULL,
      `start_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP(),
      `end_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $table_option['table_name'] = 'hrm_personal_education';
    $table_option['table_format'] = array( '%d', '%s', '%s', '%s', '%s', '%f', '%s', '%s' );
    $table_option['table_option'] = array(
        'emp_id'       => 'emp_id',
        'education'    => 'education',
        'institute'    => 'institute',
        'major'        => 'major',
        'year'         => 'year',
        'score'        => 'score',
        'start_date'   => 'start_date',
        'end_date'     => 'end_date',
    );
    $table_option_name = 'hrm_personal_education';

    hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
}

function hrm_personal_skill_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'hrm_personal_skill';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `emp_id` int(7) NOT NULL DEFAULT '0',
      `skill` varchar(255) NOT NULL,
      `years_of_exp` decimal(2,0) DEFAULT NULL,
      `comments` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $table_option['table_name'] = 'hrm_personal_skill';
    $table_option['table_format'] = array( '%d', '%s', '%s', '%s' );
    $table_option['table_option'] = array(
        'emp_id'       => 'emp_id',
        'skill'     => 'skill',
        'years_of_exp' => 'years_of_exp',
        'comments'     => 'comments',
    );
    $table_option_name = 'hrm_personal_skill';

    hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
}

hrm_personal_education_table();
hrm_holiday_table();
hrm_relation();
hrm_department();
hrm_leave_type_table();
hrm_leave_table();
hrm_employer_role();
hrm_office_time();
hrm_update_job_category_table();
hrm_attendance_table();