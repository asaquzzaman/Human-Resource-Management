<?php
class Hrm_Db {
    function __construct() {
        $this->employer_role();
        $this->organization();
        $this->job();
        $this->qualification();
        $this->configure();
        $this->leave_summary();
        $this->personal();
        //$this->project_info();
        //$this->pim();
        //$this->time();
        //$this->employer();
        
        
        $this->attendance();
        $this->office_time();
        $this->relation();
        $this->create_time_shift_table();
        $this->financial_year();
        $this->designation();
        $this->formula();
        $this->salary_group();
        $this->salary();
    }

    public function salary() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_salary';
        //status 0=inactive, 1=active, 2=deleted
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `month` timestamp NULL DEFAULT NULL,
          `category` varchar(255) DEFAULT NULL COMMENT 'employee, designation',
          `category_id` int(10) unsigned DEFAULT NULL,
          `employee_id` bigint(20) NOT NULL,
          `group_id` int(10) unsigned DEFAULT NULL,
          `salary_components_id` text,
          `all_components_id` text,
          `info` text,
          `type` varchar(255) DEFAULT NULL COMMENT 'monthly, annual',
          `salary` varchar(255) DEFAULT NULL,
          `created_by` int(10) unsigned DEFAULT NULL,
          `updated_by` int(10) unsigned DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public function salary_group() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_salary_group';
        //status 0=inactive, 1=active, 2=deleted
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `income` text COLLATE utf8mb4_unicode_ci,
          `deduction` text COLLATE utf8mb4_unicode_ci,
          `created_by` int(10) unsigned DEFAULT NULL,
          `updated_by` int(10) unsigned DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public function formula() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_formula';
        //status 0=inactive, 1=active, 2=deleted
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `description` text COLLATE utf8mb4_unicode_ci,
          `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `formula` text COLLATE utf8mb4_unicode_ci,
          `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `created_by` int(10) unsigned DEFAULT NULL,
          `updated_by` int(10) unsigned DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public function designation() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_designation';
        //status 0=inactive, 1=active, 2=deleted
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `description` text COLLATE utf8mb4_unicode_ci,
          `department` bigint(20) NOT NULL,
          `created_by` int(10) unsigned DEFAULT NULL,
          `updated_by` int(10) unsigned DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public function financial_year() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_financial_year';
        //status 0=inactive, 1=active, 2=deleted
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `start` timestamp NULL DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public function create_time_shift_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_time_shift';
        //status 0=inactive, 1=active, 2=deleted
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) DEFAULT NULL,
          `status` tinyint(4) DEFAULT NULL, 
          `department` int(11) NOT NULL,
          `punch_start` timestamp NULL DEFAULT NULL,
          `times` text,
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    function relation() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_relation';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `type` varchar(255) DEFAULT NULL,
          `from` int(11) DEFAULT NULL,
          `to` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    function office_time() {
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

    function attendance() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_attendance';

        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `user_id` bigint(20) NOT NULL,
          `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `punch_in` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `punch_out` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `total` int(11) NOT NULL,
          `shift_id` BIGINT(20) NOT NULL,
          `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    function client_partial_payment() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_client_partial_payment';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `client_id` bigint(20) NOT NULL,
          `description` text NOT NULL,
          `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `currency` VARCHAR( 10 ) NOT NULL,
          `project_id` BIGINT NOT NULL,
          `amount` BIGINT NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_option['table_name'] = 'hrm_client_partial_payment';
        $table_option['table_option'] = array(
            'client_id'   => 'client_id',
            'description' => 'description',
            'date'        => 'date',
            'currency'    => 'currency',
            'project_id'  => 'project_id',
            'amount'      => 'amount',
        );

        $table_option_name = 'hrm_client_partial_payment';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function worker_evaluation() {
        $table_option['table_option'] = array(
            'from_date' => 'from_date',
            'to_date'   => 'to_date',
        );
        $table_option_name = 'hrm_rating_record';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function employer() {
        $table_option['table_option'] = array(
            'employer' => 'employer',
        );
        $table_option_name = 'hrm_user_search';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function time() {
        $this->punch_in_out();
        $this->employer_employee_records();
    }

    function employer_employee_records() {
        $table_option['table_option'] = array(
            'from_date' => 'from_date',
            'to_date'   => 'to_date',
            'user_id'   => 'user_id'
        );
        $table_option_name = 'hrm_attendance_record_both';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function punch_in_out() {
       $table_option['table_option'] = array(
            'date'       => 'date',
        );
        $table_option_name = 'hrm_attendance';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function pim() {
      $this->employ_list();
    }

    function employ_list() {
        $table_option['table_option'] = array(
            'user'       => 'user',
            'first_name' => 'first_name',
            'last_name'  => 'last_name',
            'status'     => 'status',
            'mobile'     => 'mobile',
        );
        $table_option_name = 'hrm_employee';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function project_info() {
      $this->project_user_role();
      $this->project_search_table_option();
    }

    function project_search_table_option() {
        $table_option['table_option'] = array(
            'title' => 'title',
        );
        $table_option_name = 'hrm_projects';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function project_user_role() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_user_role';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `ID` bigint(20) NOT NULL AUTO_INCREMENT,
          `project_id` bigint(20) NOT NULL,
          `user_id` bigint(20) NOT NULL,
          `role` varchar(20) NOT NULL,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    function personal() {
        //$this->salary();
        $this->work_exp();
        $this->personal_education();
        $this->personal_skill();
        $this->personal_language();
       // $this->personal_info();
       // $this->personal_job();
    }

    function personal_job() {
        $user_meta_key = array(
            '_job_title'        => 'job_title',
            '_job_category'     => 'job_category',
            '_location'         => 'location',
            '_contract_start'   => 'contract_start',
            '_contract_end'     => 'contract_end',
            '_contract_details' => 'contract_details',
        );

        $table_option_name = 'hrm_personal_job';

        hrm_settings::getInstance()->update_table_option( $table_option_name, $user_meta_key );
    }

    function personal_info() {
        $user_meta_key = array(
            '_gender'         => 'gender',
            '_marital_status' => 'marital_status',
            '_national_code'  => 'national_code',
            '_birthday'       => 'birthday',
            '_street1'        => 'street1',
            '_street2'        => 'street2',
            '_city_code'      => 'city_code',
            '_state'          => 'state',
            '_zip'            => 'zip',
            '_country_code'   => 'country_code',
            '_work_mobile'    => 'work_mobile',
            '_work_email'     => 'work_email'
        );

        $table_option_name = 'hrm_personal_info';

        hrm_settings::getInstance()->update_table_option( $table_option_name, $user_meta_key );
    }

    function personal_language() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_personal_language';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `emp_id` int(7) NOT NULL,
          `language_id` int(11) NOT NULL,
          `fluency` text NOT NULL,
          `competency` text NOT NULL,
          `comments` varchar(100) DEFAULT NULL,
          KEY `lang_id` (`language_id`),
          KEY `id` (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_option['table_name'] = 'hrm_personal_language';
        $table_option['table_format'] = array( '%d', '%d', '%s', '%s', '%s' );
        $table_option['table_option'] = array(
            'emp_id'      => 'emp_id',
            'language_id' => 'language_id',
            'fluency'     => 'fluency',
            'competency'  => 'competency',
            'comments'    => 'comments',
        );
        $table_option_name = 'hrm_personal_language';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function personal_skill() {
      global $wpdb;
      $table_name = $wpdb->prefix . 'hrm_personal_skill';
      $sql = "DROP TABLE IF EXISTS $table_name";
      $wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "hrm_personal_skill" );

      $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `employee_id` int(7) NOT NULL DEFAULT '0',
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

    function personal_education() {

      global $wpdb;
      $table_name = $wpdb->prefix . 'hrm_personal_education';
      $sql = "DROP TABLE IF EXISTS $table_name";
      $wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "hrm_personal_education" );

      $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `employee_id` int(11) NOT NULL,
        `education` varchar(255) NOT NULL,
        `institute` varchar(100) DEFAULT NULL,
        `major` varchar(100) DEFAULT NULL,
        `year` timestamp NULL DEFAULT NULL,
        `score` varchar(25) DEFAULT NULL,
        `start_date` timestamp NULL DEFAULT NULL,
        `end_date` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );

    }

    function work_exp() {
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

    // function salary() {
    //     global $wpdb;
    //     $table_name = $wpdb->prefix . 'hrm_salary';
    //     $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
    //       `id` int(11) NOT NULL AUTO_INCREMENT,
    //       `emp_id` int(11) NOT NULL,
    //       `pay_grade` varchar(50) NOT NULL,
    //       `component` varchar(100) NOT NULL,
    //       `frequency` int(11) NOT NULL,
    //       `currency` varchar(10) NOT NULL,
    //       `amount` float NOT NULL,
    //       `comments` text NOT NULL,
    //       `direct_deposit` varchar(3) NOT NULL,
    //       `account_number` int(11) NOT NULL,
    //       `account_type` int(11) NOT NULL,
    //       `specify` varchar(200) NOT NULL,
    //       `routing` int(11) NOT NULL,
    //       `dipo_amount` int(11) NOT NULL,
    //        `billing_date` TIMESTAMP NOT NULL,
    //       PRIMARY KEY (`id`)
    //     ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

    //     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    //     dbDelta( $sql );
    // }

    function leave_summary() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_leave';
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

        $table_option['table_name'] = 'hrm_leave';
        $table_option['table_format'] = array( '%s', '%s', '%s', '%s', '%s', '%d' );
        $table_option['table_option'] = array(
            'start_time'     => 'from',
            'end_time'       => 'to',
            'comments' => 'comment',
            'type'  => 'type_id',
            'emp_id'         => 'emp_id',
            'status'   => 'status'
        );
        $table_option_name = 'hrm_leave';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function configure() {
        $this->leave_type();
        $this->work_week();
        $this->holiday();
    }

    function work_week() {
        $option['field_dif'] = array( 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday' );
        update_option( 'hrm_work_week', $option );
    }

    function holiday() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_holiday';
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

        $table_option['table_name'] = 'hrm_holiday';
        $table_option['table_format'] = array( '%s', '%s', '%s', '%s', '%s' );
        $table_option['table_option'] = array(
            'name'        => 'name',
            'description' => 'description',
            'from'        => 'from',
            'to'          => 'to',
            'length'      => 'length',
        );
        $table_option_name = 'hrm_holiday';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function leave_type() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_leave_type';
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

        $table_option['table_name'] = 'hrm_leave_type';
        $table_option['table_format'] = array( '%s', '%d', '%s', '%s' );
        $table_option['table_option'] = array(
            'leave_type_name' => 'leave_type',
            'entitlement'     => 'entitlement',
            'entitle_from'    => 'entitle_from',
            'entitle_to'      => 'entitle_to'
        );
        $table_option_name = 'hrm_leave_type';
        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function qualification() {
        $this->skills();
        $this->language();
    }

    function language() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_language';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(120) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_option['table_name'] = 'hrm_language';
        $table_option['table_format'] = array( '%s' );
        $table_option['table_option'] = array(
            'name' => 'language',
        );
        $table_option_name = 'hrm_language';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    // function education() {
    //     global $wpdb;
    //     $table_name = $wpdb->prefix . 'hrm_personal_education';
    //     $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    //       `id` int(11) NOT NULL AUTO_INCREMENT,
    //       `employee_id` int(11) NOT NULL,
    //       `education` varchar(255) NOT NULL,
    //       `institute` varchar(100) DEFAULT NULL,
    //       `major` varchar(100) DEFAULT NULL,
    //       `year` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    //       `score` varchar(25) DEFAULT NULL,
    //       `start_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    //       `end_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    //       PRIMARY KEY (`id`)
    //     ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    //     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    //     dbDelta( $sql );

    // }

    function skills() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_personal_skill';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `employee_id` int(7) NOT NULL DEFAULT '0',
          `skill` varchar(255) NOT NULL,
          `years_of_exp` decimal(2,0) DEFAULT NULL,
          `comments` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    function job() {
        $this->title();
        $this->category();
        $this->pay_grades();
    }

    function category() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_job_category';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(60) DEFAULT NULL,
          `active` varchar(4) NOT NULL,
          `description` TINYTEXT NOT NULL,
          `parent` INT NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_option['table_name'] = 'hrm_job_category';
        $table_option['table_format'] = array( '%s', '%s' );
        $table_option['table_option'] = array(
            'name'   => 'job_category',
            'active' => 'active'
        );
        $table_option_name = 'hrm_job_category';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function pay_grades() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_pay_grade';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(50) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_option['table_name'] = 'hrm_pay_grade';
        $table_option['table_format'] = array( '%s' );
        $table_option['table_option'] = array(
            'name' => 'name',
        );
        $table_option_name = 'hrm_pay_grade';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function title() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_job_title';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` int(13) NOT NULL AUTO_INCREMENT,
          `job_title` varchar(100) NOT NULL,
          `job_description` varchar(400) DEFAULT NULL,
          `note` varchar(400) DEFAULT NULL,
          `is_deleted` tinyint(1) DEFAULT '0',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_option['table_name'] = 'hrm_job_title';
        $table_option['table_format'] = array( '%s', '%s', '%s' );
        $table_option['table_option'] = array(
            'job_title'       => 'job_title',
            'job_description' => 'job_description',
            'note'            => 'note',
        );
        $table_option_name = 'hrm_job_title_option';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function employer_role() {
        Hrm_Admin::getInstance()->employer_role();
    }

    function organization() {
        $this->generl_info();
        $this->location();
        $this->notice();
    }

    function notice() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'hrm_notice';

        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(250) NOT NULL,
          `description` longtext NOT NULL,
          `user_id` int(11) NOT NULL,
          `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_option['table_name'] = 'hrm_notice';
        $table_option['table_format'] = array( '%s', '%s', '%d', '%s' );
        $table_option['table_option'] = array(
            'title'       => 'title',
            'description' => 'description',
            'user_id'     => 'user_id',
            'date'        => 'date'
        );
        $table_option_name = 'hrm_notice';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function location() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'hrm_location';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(110) NOT NULL,
          `country_code` varchar(3) NOT NULL,
          `province` varchar(60) DEFAULT NULL,
          `city` varchar(60) DEFAULT NULL,
          `address` varchar(255) DEFAULT NULL,
          `zip_code` varchar(35) DEFAULT NULL,
          `phone` varchar(35) DEFAULT NULL,
          `fax` varchar(35) DEFAULT NULL,
          `notes` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `country_code` (`country_code`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_option['table_name']   = 'hrm_location';
        $table_option['table_format'] = array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
        $table_option['table_option'] = array(
            'name'         => 'name',
            'country_code' => 'country',
            'province'     => 'province',
            'city'         => 'city',
            'address'      => 'address',
            'zip_code'     => 'zipcode',
            'phone'        => 'phone',
            'fax'          => 'fax',
            'notes'        => 'notes'
        );
        $table_option_name = 'hrm_location_option';

        hrm_Settings::getInstance()->update_table_option( $table_option_name, $table_option );
    }

    function generl_info() {
        $option['field_dif'] = array(
            'organization_name',
            'tax_id',
            'registration_number',
            'phone',
            'fax',
            'addres_street_1',
            'address_street_2',
            'city',
            'state_province',
            'zip',
            'country',
            'note'
        );
        update_option( 'hrm_general_info', $option);
    }

    function update_attendance_table() {
      global $wpdb;

      $table = $wpdb->prefix . 'hrm_attendance';

      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "hrm_attendance MODIFY punch_in TIMESTAMP");
      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "hrm_attendance MODIFY punch_out TIMESTAMP");
    }
}