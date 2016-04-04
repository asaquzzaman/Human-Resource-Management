<?php
function hrm_page( $exclude = true ) {

    $path                  = dirname(__FILE__) . '/../templates';
    $page                  = array();

    $hrm_management        = hrm_admin_page();
    $page[$hrm_management] = hrm_admin_page_items( $path, $hrm_management, $exclude );

    $hrm_pim               = hrm_pim_page();
    $page[$hrm_pim]        = hrm_pim_page_items( $path, $hrm_pim, $exclude );

    $hrm_file              = hrm_file_page();
    $page[$hrm_file]       = hrm_file_page_items( $path, $hrm_file, $exclude );

    $hrm_leave             = hrm_leave_page();
    $page[$hrm_leave]      = hrm_leave_page_items( $path, $hrm_leave, $exclude );

    $hrm_time              = hrm_time_page();
    $page[$hrm_time]       = hrm_time_page_items( $path, $hrm_time, $exclude );

    $hrm_evaluation        = hrm_evaluation_page();
    $page[$hrm_evaluation] = hrm_evaluation_page_items( $path, $hrm_evaluation, $exclude );

    $hrm_client            = hrm_client_page();
    $page[$hrm_client]     = hrm_client_page_items( $path, $hrm_client, $exclude );


    $permission            = hrm_permission_page();
    $page[$permission]     = hrm_permission_page_items( $path, $permission, $exclude );


    $hrm_project           = hrm_project_page();
    $page[$hrm_project]    = hrm_project_page_items( $path, $hrm_project, $exclude );

    $hrm_salary            = hrm_salary_page();
    $page[$hrm_salary]     = hrm_salary_page_items( $path, $hrm_salary, $exclude );

    $employee              = hrm_employee_page();
    $page[$employee]       = hrm_employee_page_items( $path, $employee, $page[$hrm_pim], $exclude );

    return apply_filters( 'hrm_menu_items', $page, $exclude );
}

function hrm_employee_page_items( $path, $employee, $hrm_pim, $exclude ) {
    $emp = array();

    $emp['personal']          = $hrm_pim['personal'];
    $emp['organization_info'] = $hrm_pim['organization_info'];
    $emp['my_task']           = $hrm_pim['my_task'];
    $emp['leave']             = $hrm_pim['leave'];

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $emp;
    }

    return apply_filters( 'hrm_employee_page_items', $emp, $path, $employee, $hrm_pim );
}

function hrm_salary_page_items( $path, $hrm_salary, $exclude ) {
    $salary = array();
    $salary['salary'] = array(
        'id'        => 'hrm-personal-salary',
        'title'     => __( 'Salary', 'hrm' ),
        'file_slug' => 'salary/salary',
        'file_path' => $path . '/salary/salary.php',
    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $salary;
    }

    return apply_filters( 'hrm_salary_page_items', $salary, $path, $hrm_salary );
}

function hrm_project_page_items( $path, $hrm_project, $exclude ) {
    $project = array();

    $project['project_info'] = array(
        'id'        => 'hrm-project-info',
        'title'     => __( 'Project', 'hrm' ),
        'file_slug' => 'projects/projects',
        'file_path' => $path . '/projects/projects.php',
        /*'submenu' => array(
            'projects' => array(
                'title'     => __( 'Project', 'hrm' ),
                'file_slug' => 'projects/projects',
                'file_path' => $path . '/projects/projects.php',
                'role' => array(
                    'assign_project' => __( 'View only assign project', 'hrm' ),
                )
            ),
        ),*/

    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $project;
    }

    return apply_filters( 'hrm_project_page_items', $project, $path, $hrm_project ); 
}

function hrm_permission_page_items( $path, $permission ) {
    $access = array();

    $access['manage'] = array(
        'id'        => 'hrm-permission',
        'title'     => __( 'Role', 'hrm' ),
        'file_slug' => 'permission/manage',
        'file_path' => $path . '/permission/manage.php',
    );

    $access['page'] = array(
        'id'        => 'hrm-permission',
        'title'     => __( 'Main Menu', 'hrm' ),
        'file_slug' => 'permission/main-menu',
        'file_path' => $path . '/permission/main-menu.php',
    );

    $access['permission'] = array(
        'id'        => 'hrm-permission',
        'title'     => __( 'Tab/Subtab', 'hrm' ),
        'file_slug' => 'permission/permission',
        'file_path' => $path . '/permission/permission.php',
    );

    if ( hrm_current_user_role() == 'administrator' ) {
        return $access;    
    }

    return apply_filters( 'hrm_permission_page_items', $access, $path, $permission );
}

function hrm_client_page_items( $path, $hrm_client, $exclude ) {
    $client = array();

    $client['list'] = array(
        'id'        => 'hrm-client-list',
        'title'     => __( 'List', 'hrm' ),
        'file_slug' => 'client/client-list',
        'file_path' => $path . '/client/client-list.php',
    );

    $client['payment-history'] = array(
        'id'        => 'hrm-client-payment-history',
        'title'     => __( 'Payment History', 'hrm' ),
        'file_slug' => 'client/payment-history',
        'file_path' => $path . '/client/payment-history.php',
    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $client;    
    }

    return apply_filters( 'hrm_client_page_items', $client, $path, $hrm_client );
}

function hrm_evaluation_page_items( $path, $hrm_evaluation, $exclude ) {
    $evaluation = array();

    $evaluation['rating_task'] = array(
        'id'        => 'hrm-evaluation-records',
        'title'     => __( 'Rating For Task', 'hrm' ),
        'file_slug' => 'evaluation/rating-task',
        'file_path' => $path . '/evaluation/rating-task.php',
    );
    $evaluation['rating_action'] = array(
        'id'        => 'hrm-evaluation-action',
        'title'     => __( 'Employee/Employer Rating', 'hrm' ),
        'file_slug' => 'evaluation/rating-action',
        'file_path' => $path . '/evaluation/rating-action.php',
    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $evaluation;
    }

    return apply_filters( 'hrm_evaluation_page_items', $evaluation, $path, $hrm_evaluation );
}

function hrm_time_page_items( $path, $hrm_time, $exclude ) {
    $time = array();
    $time['punch'] = array(
        'id'        => 'hrm-time-punch',
        'title'     => __( 'My Punch In/Out', 'hrm' ),
        'file_slug' => 'time/punch',
        'file_path' => $path . '/time/punch.php',
        'role'      => array(
            'edit' => __( 'Edit', 'hrm' ),
        )
    );

    $time['employee_employer_records'] = array(
        'id'        => 'hrm-time-my-records',
        'title'     => __( 'Employee Punch In/Out History', 'hrm' ),
        'file_slug' => 'time/employee-employer',
        'file_path' => $path . '/time/employee-employer.php',
    );
    $time['config'] = array(
        'id'        => 'hrm-time-config',
        'title'     => __( 'Configuration', 'hrm' ),
        'file_slug' => 'time/config',
        'file_path' => $path . '/time/config.php',
    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $time;   
    }

    return apply_filters( 'hrm_time_page_items', $time, $path, $hrm_time );
}

function hrm_leave_page_items( $path, $hrm_leave ) {

    $leave = array();
    $leave['configure'] = array(
        'id'        => 'hrm-employee-configure',
        'title'     => __( 'Configure', 'hrm' ),
        'file_slug' => 'leave/configure',
        'file_path' => $path . '/leave/configure.php',
        'submenu' => array(
            'leave_type' => array(
                'id'        => 'hrm-leave-type',
                'title'     => __( 'Leave Type', 'hrm' ),
                'file_slug' => 'leave/leave-type',
                'file_path' => $path . '/leave/leave-type.php',
            ),
            'leave_week' => array(
                'id'        => 'hrm-leave-week',
                'title'     => __( 'Work Week', 'hrm' ),
                'file_slug' => 'leave/leave-week',
                'file_path' => $path . '/leave/leave-week.php',
            ),
            'leave_holidays' => array(
                'id'        => 'hrm-leave-holidays',
                'title'     => __( 'Holidays', 'hrm' ),
                'file_slug' => 'leave/leave-holidays',
                'file_path' => $path . '/leave/leave-holidays.php',
            ),
        ),
    );

    $leave['leave_summary'] = array(
        'id'        => 'hrm-employee-leave_summary',
        'title'     => __( 'Leave Summary', 'hrm' ),
        'file_slug' => 'leave/leave-summary',
        'file_path' => $path . '/leave/leave-summary.php',
        'role' => array(
            'leave_summary_action' => __( 'Can manage leave action', 'hrm' ),
        )
    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $leave;
    }
    
    return apply_filters( 'hrm_leave_page_items', $leave, $path, $hrm_leave );
}

function hrm_file_page_items( $path, $hrm_file, $exclude ) {

    $file = array();
    $file['share'] = array(
        'follow_access_role' => false,
        'nested_tab'         => true,
        'id'                 => 'hrm-file-share',
        'title'              => __( 'Share', 'hrm' ),
        'file_slug'          => 'file/share',
        'file_path'          => $path . '/file/share.php',
        //'submenu'            => false,
    );

    $file['inbox'] = array(
        'follow_access_role' => false,
        'nested_tab'         => true,
        'id'                 => 'hrm-file-inbox',
        'title'              => __( 'Inbox', 'hrm' ),
        'file_slug'          => 'file/inbox',
        'file_path'          => $path . '/file/inbox.php',
        //'submenu'            => false,
    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $file;
    }

    return apply_filters( 'hrm_file_page_items', $file, $path, $hrm_file );
}

function hrm_pim_page_items( $path, $hrm_pim, $exclude ) {

    $pim = array();

    $pim['employee_list'] = array(
        'id'        => 'hrm-employee-list',
        'title'     => __( 'Employee List', 'hrm' ),
        'file_slug' => 'pim/employee-list',
        'file_path' => $path . '/pim/employee-list.php',

    );

    $pim['personal'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'        => 'hrm-employee-personal',
        'title'     => __( 'Personal', 'hrm' ),
        'file_slug' => 'employee/personal',
        'file_path' => $path . '/employee/personal.php',
        'submenu'   => array(
            'personal_info' => array(
                'id'        => 'hrm-personal-info',
                'title'     => __( 'Personal Information', 'hrm' ),
                'file_slug' => 'employee/personal-info',
                'file_path' => $path . '/employee/personal-info.php',
            ),
            'jobs' => array(
                'id'        => 'hrm-personal-job',
                'title'     => __( 'job', 'hrm' ),
                'file_slug' => 'employee/job',
                'file_path' => $path . '/employee/job.php',
            ),
            'ind_salary' => array(
                'id'        => 'hrm-personal-salary',
                'title'     => __( 'Salary', 'hrm' ),
                'file_slug' => 'employee/salary',
                'file_path' => $path . '/employee/salary.php',
            ),
            'work_experiennce' => array(
                'id'        => 'hrm-personal-work-experience',
                'title'     => __( 'Work Experience', 'hrm' ),
                'file_slug' => 'employee/work-experience',
                'file_path' => $path . '/employee/work-experience.php',
            ),
            'ind_education' => array(
                'id'        => 'hrm-personal-education',
                'title'     => __( 'Education', 'hrm' ),
                'file_slug' => 'employee/education',
                'file_path' => $path . '/employee/education.php',
            ),
            'skill' => array(
                'id'        => 'hrm-personal-skill',
                'title'     => __( 'Skills', 'hrm' ),
                'file_slug' => 'employee/skill',
                'file_path' => $path . '/employee/skill.php',
            ),
            'ind_language' => array(
                'class'     => 'hrm-personal-language',
                'title'     => __( 'Languages', 'hrm' ),
                'file_slug' => 'employee/language',
                'file_path' => $path . '/employee/language.php',
            ),
        ),
    );

    $pim['organization_info'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'        => 'hrm-employee-organization',
        'title'     => __( 'Pim Organization', 'hrm' ),
        'file_slug' => 'employee/organization',
        'file_path' => $path . '/employee/organization.php',
        'submenu'   => array(
            'pim_general_info' => array(
                'id'        => 'hrm-general-info',
                'title'     => __( 'General Information', 'hrm' ),
                'file_slug' => 'employee/general-info',
                'file_path' => $path . '/employee/general-info.php',
            ),
            'pim_location' => array(
                'id'        => 'hrm-location',
                'title'     => __( 'Location', 'hrm' ),
                'file_slug' => 'employee/location',
                'file_path' => $path . '/employee/location.php',
            ),
            'pim_notice' => array(
                'id'        => 'hrm-location',
                'title'     => __( 'Notice', 'hrm' ),
                'file_slug' => 'employee/notice',
                'file_path' => $path . '/employee/notice.php',
            ),
        ),
    );

    $pim['my_task'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'         => 'hrm-employee-my-task',
        'title'      => __( 'My task', 'hrm' ),
        'file_slug' => 'employee/my-task',
        'file_path'  => $path . '/employee/my-task.php',
        'submenu' => array(
            'current_task' => array(
                'id'        => 'hrm-current-task',
                'title'     => __( 'Current Task', 'hrm' ),
                'file_slug' => 'employee/current-task',
                'file_path' => $path . '/employee/current-task.php',
            ),
            'outstanding_task' => array(
                'id'        => 'hrm-outstanding-task',
                'title'     => __( 'Outstanding Task', 'hrm' ),
                'file_slug' => 'employee/outstanding-task',
                'file_path' => $path . '/employee/outstanding-task.php',
            ),
            'completed_task' => array(
                'id'        => 'hrm-completed-task',
                'title'     => __( 'Completed Task', 'hrm' ),
                'file_slug' => 'employee/completed-task',
                'file_path' => $path . '/employee/completed-task.php',
            ),
        ),
    );

    $pim['leave'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'         => 'hrm-employee-leave',
        'title'      => __( 'Leave', 'hrm' ),
        'file_slug' => 'employee/leave',
        'file_path'  => $path . '/employee/leave.php',
        'submenu' => array(
            'assign' => array(
                'id'        => 'hrm-leave-assign',
                'title'     => __( 'Apply', 'hrm' ),
                'file_slug' => 'employee/assign',
                'file_path' => $path . '/employee/assign.php',
            ),
            'work_in_week' => array(
                'id'        => 'hrm-work-in-week',
                'title'     => __( 'Work Week', 'hrm' ),
                'file_slug' => 'employee/work-week',
                'file_path' => $path . '/employee/work-week.php',
            ),
            'holiday' => array(
                'id'        => 'hrm-holiday',
                'title'     => __( 'Holiday', 'hrm' ),
                'file_slug' => 'employee/holiday',
                'file_path' => $path . '/employee/holiday.php',
            ),
        ),
    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $pim;
    }

    return apply_filters( 'hrm_pim_page_items', $pim, $path, $hrm_pim );
}

function hrm_admin_page_items( $path, $hrm_management, $exclude ) {
    $admin = array();

    $admin['organization'] = array(
        'id'        => 'hrm-organization',
        'title'     => __( 'Organization', 'hrm' ),
        'file_slug' => 'admin/organization',
        'file_path' => $path . '/admin/organization.php',

        'submenu' => array(
            'general_info' => array(
                'id'        => 'hrm-organization-sub-genral_info',
                'title'     => __( 'General Information', 'hrm' ),
                'file_slug' => 'admin/general_info',
                'file_path' => $path . '/admin/general_info.php',
            ),

            'location' => array(
                'id'        => 'hrm-organization-sub-location',
                'title'     => __( 'Location', 'hrm' ),
                'file_slug' => 'admin/location',
                'file_path' => $path . '/admin/location.php',
            ),
            'notice' => array(
                'id'        => 'hrm-organization-notice',
                'title'     => __( 'Notice', 'hrm' ),
                'file_slug' => 'admin/notice',
                'file_path' => $path . '/admin/notice.php',
            ),
        ),
    );

    $admin['job'] = array(
        'id'        => 'hrm-job',
        'title'     => __( 'job', 'hrm' ),
        'file_slug' => 'admin/job',
        'file_path' => $path . '/admin/job.php',

        'submenu' => array(
            'job_title' => array(
                'id'        => 'hrm-job-title',
                'title'     => __( 'Job Title', 'hrm' ),
                'file_slug' => 'admin/job_title',
                'file_path' => $path . '/admin/job_title.php',
            ),

            'job_categories' => array(
                'id'        => 'hrm-job-categories',
                'title'     => __( 'Job Categories', 'hrm' ),
                'file_slug' => 'admin/job-categories',
                'file_path' => $path . '/admin/job-categories.php',
            ),
            'pay_grade' => array(
                'id'        => 'hrm-pay-grade',
                'title'     => __( 'Pay Grades', 'hrm' ),
                'file_slug' => 'admin/pay-grade',
                'file_path' => $path . '/admin/pay-grade.php',
            ),
        ),
    );

    $admin['qualification'] = array(
        'id'        => 'hrm-qualification',
        'title'     => __( 'Qualification', 'hrm' ),
        'file_slug' => 'admin/qualification',
        'file_path' => $path . '/admin/qualification.php',
        'submenu' => array(
            'skills' => array(
                'title'     => __( 'Skills', 'hrm' ),
                'file_slug' => 'admin/skills',
                'file_path' => $path . '/admin/skills.php',
            ),
            'education' => array(
                'title'     => __( 'Education', 'hrm' ),
                'file_slug' => 'admin/education',
                'file_path' => $path . '/admin/education.php',
            ),
            'language' => array(
                'title'     => __( 'Language', 'hrm' ),
                'file_slug' => 'admin/language',
                'file_path' => $path . '/admin/language.php',
            ),
        ),

    );

    if ( $exclude === false || hrm_current_user_role() == 'administrator' ) {
        return $admin;
    }

    return apply_filters( 'hrm_admin_section_items', $admin, $path, $hrm_management );
}

function hrm_admin_page() {
    return apply_filters( 'hrm_admin_page_slug', 'hrm_management' );
}

function hrm_pim_page() {
    return apply_filters( 'hrm_pim_page_slug', 'hrm_pim' );
}

function hrm_leave_page() {
    return apply_filters( 'hrm_leave_page_slug', 'hrm_leave' );
}

function hrm_time_page() {
    return apply_filters( 'hrm_time_page_slug', 'hrm_time' );
}

function hrm_evaluation_page() {
    return apply_filters( 'hrm_evaluation_page_slug', 'hrm_evaluation' );
}
function hrm_file_page() {
    return apply_filters( 'hrm_file_page_slug', 'hrm_file' );
}

function hrm_project_page() {
    return apply_filters( 'hrm_project_page_slug', 'hrm_project' );
}

function hrm_employee_page() {
    return apply_filters( 'hrm_employee_page_slug', 'hrm_employee' );
}

function hrm_salary_page() {
    return apply_filters( 'hrm_salary_page_slug', 'hrm_salary' );
}

function hrm_client_page() {
    return apply_filters( 'hrm_client_page_slug', 'hrm_client' );
}

function hrm_permission_page() {
    return apply_filters( 'hrm_permission_page_slug', 'hrm_permission' );
}

function hrm_updates_page() {
    return apply_filters( 'hrm_update_page_slug', 'hrm_updates' );
}

function hrm_menu_label() {
    $labels = array(
        hrm_admin_page()      => __( 'Admin', 'hrm' ),
        hrm_pim_page()        => __( 'Employee', 'hrm' ),
        hrm_leave_page()      => __( 'Leave', 'hrm' ),
        hrm_time_page()       => __( 'Attendance', 'hrm' ),
        hrm_evaluation_page() => __( 'Evaluation', 'hrm' ),
        hrm_file_page()       => __( 'File', 'hrm' ),
        hrm_project_page()    => __( 'Project', 'hrm' ),
        hrm_employee_page()   => __( 'My INFO', 'hrm' ),
        hrm_salary_page()     => __( 'Salary', 'hrm' ),
        hrm_client_page()     => __( 'Client', 'hrm' ),
        hrm_permission_page() => __( 'Permission', 'hrm' )
    );

    return apply_filters( 'hrm_menu_lable', $labels );
}

