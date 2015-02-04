<?php
function hrm_page() {
    $path = dirname(__FILE__) . '/../templates';

    $hrm_management = hrm_management_page();

	$page[$hrm_management]['organization'] = array(
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

    $page[$hrm_management]['admin'] = array(
        'id'        => 'hrm-admin',
        'title'     => __( 'Designation', 'hrm' ),
        'file_slug' => 'admin/admin',
        'file_path' => $path . '/admin/admin.php',

        'submenu' => array(
            'admin_role' => array(
                'title'     => __( 'Employer Role', 'hrm' ),
                'file_slug' => 'admin/admin-role',
                'file_path' => $path . '/admin/admin-role.php',
            ),
            'admin_list' => array(
                'title'     => __( 'Employer lists', 'hrm' ),
                'file_slug' => 'admin/admin-lists',
                'file_path' => $path . '/admin/admin-lists.php',
                'role' => array(
                    'employer_status' => __( 'Can manage employer status', 'hrm' ),
                ),
            ),
        ),

    );

    $page[$hrm_management]['job'] = array(
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

    $page[$hrm_management]['qualification'] = array(
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

    $page[$hrm_management]['project_info'] = array(
        'id'        => 'hrm-project-info',
        'title'     => __( 'Project info', 'hrm' ),
        'file_slug' => 'admin/project-info',
        'file_path' => $path . '/admin/project-info.php',
        'submenu' => array(
            'projects' => array(
                'title'     => __( 'Project', 'hrm' ),
                'file_slug' => 'admin/projects',
                'file_path' => $path . '/admin/projects.php',
                'role' => array(
                    'assign_project' => __( 'View only assign project', 'hrm' ),
                )
            ),
        ),

    );

    $hrm_pim = hrm_pim_page();

    $page[$hrm_pim]['employee_list'] = array(
        'id'        => 'hrm-employee-list',
        'title'     => __( 'Employee List', 'hrm' ),
        'file_slug' => 'pim/employee-list',
        'file_path' => $path . '/pim/employee-list.php',

    );

    $page[$hrm_pim]['personal'] = array(
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
            'salary' => array(
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
            'education' => array(
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
            'language' => array(
                'class'     => 'hrm-personal-language',
                'title'     => __( 'Languages', 'hrm' ),
                'file_slug' => 'employee/language',
                'file_path' => $path . '/employee/language.php',
            ),
        ),
    );

    $page[$hrm_pim]['organization_info'] = array(
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

    $hrm_file = hrm_file_page();

    $page[$hrm_file]['share'] = array(
        'follow_access_role' => false,
        'nested_tab'         => true,
        'id'                 => 'hrm-file-share',
        'title'              => __( 'Share', 'hrm' ),
        'file_slug'          => 'file/share',
        'file_path'          => $path . '/file/share.php',
        //'submenu'            => false,
    );

    $page[$hrm_file]['inbox'] = array(
        'follow_access_role' => false,
        'nested_tab'         => true,
        'id'                 => 'hrm-file-inbox',
        'title'              => __( 'Inbox', 'hrm' ),
        'file_slug'          => 'file/inbox',
        'file_path'          => $path . '/file/inbox.php',
        //'submenu'            => false,
    );

    $page[$hrm_pim]['my_task'] = array(
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

    $page[$hrm_pim]['leave'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'         => 'hrm-employee-leave',
        'title'      => __( 'Leave', 'hrm' ),
        'file_slug' => 'employee/leave',
        'file_path'  => $path . '/employee/leave.php',
        'submenu' => array(
            'assign' => array(
                'id'        => 'hrm-leave-assign',
                'title'     => __( 'Assigin', 'hrm' ),
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

    $hrm_leave = hrm_leave_page();

    $page[$hrm_leave]['configure'] = array(
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

    $page[$hrm_leave]['leave_summary'] = array(
        'id'        => 'hrm-employee-leave_summary',
        'title'     => __( 'Leave Summary', 'hrm' ),
        'file_slug' => 'leave/leave-summary',
        'file_path' => $path . '/leave/leave-summary.php',
        'role' => array(
            'action' => __( 'Can manage leave action', 'hrm' ),
        )
    );

    $hrm_time = hrm_time_page();

    $page[$hrm_time]['attendance'] = array(
        'id'        => 'hrm-employee-attendance',
        'title'     => __( 'Attendance', 'hrm' ),
        'file_slug' => 'time/attendance',
        'file_path' => $path . '/time/attendance.php',
        'submenu' => array(
            'employee_employer_records' => array(
                'id'        => 'hrm-time-my-records',
                'title'     => __( 'Employee/Employer', 'hrm' ),
                'file_slug' => 'time/employee-employer',
                'file_path' => $path . '/time/employee-employer.php',
            ),
            'punch' => array(
                'id'        => 'hrm-time-punch',
                'title'     => __( 'Punch In/Out', 'hrm' ),
                'file_slug' => 'time/punch',
                'file_path' => $path . '/time/punch.php',
                'role' => array(
                    'edit' => __( 'Edit', 'hrm' ),
                )
            ),

            'config' => array(
                'id'        => 'hrm-time-config',
                'title'     => __( 'Configuration', 'hrm' ),
                'file_slug' => 'time/config',
                'file_path' => $path . '/time/config.php',
            ),
        ),
    );

    $hrm_evaluation = hrm_evaluation_page();

    $page[$hrm_evaluation]['evaluation'] = array(
        'id' => 'hrm-workier-evaluation',
        'title' => __( 'Evaluation', 'hrm' ),
        'file_slug' => 'evaluation/evaluation',
        'file_path' => $path . '/evaluation/evaluation.php',
        'submenu' => array(
            'rating_task' => array(
                'id'        => 'hrm-evaluation-records',
                'title'     => __( 'Rating For Task', 'hrm' ),
                'file_slug' => 'evaluation/rating-task',
                'file_path' => $path . '/evaluation/rating-task.php',
            ),
            'rating_action' => array(
                'id'        => 'hrm-evaluation-action',
                'title'     => __( 'Employee/Employer Rating', 'hrm' ),
                'file_slug' => 'evaluation/rating-action',
                'file_path' => $path . '/evaluation/rating-action.php',
            ),
        ),
    );

    $page = apply_filters( 'hrm_employee_memu', $page );

    if( ! empty( $page ) && is_array( $page ) ) {
        return $page;
    }

    return array();
}

function hrm_management_page() {
    return 'hrm_management';
}

function hrm_pim_page() {
    return 'hrm_pim';
}

function hrm_leave_page() {
    return 'hrm_leave';
}

function hrm_time_page() {
    return 'hrm_time';
}

function hrm_evaluation_page() {
    return 'hrm_evaluation';
}
function hrm_file_page() {
    return 'hrm_file';
}

