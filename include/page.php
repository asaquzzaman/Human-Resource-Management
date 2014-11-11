<?php

function hrm_page() {
    $path = dirname(__FILE__) . '/../views';

	$page['hrm_management']['organization'] = array(
        'id'        => 'hrm-organization',
        'title'     => __( 'Organization', 'hrm' ),
        'file_path' => $path . '/admin/organization.php',

        'submenu' => array(
            'general_info' => array(
                'id'        => 'hrm-organization-sub-genral_info',
                'title'     => __( 'General Information', 'hrm' ),
                'file_path' => $path . '/admin/general_info.php',
            ),

            'location' => array(
                'id'        => 'hrm-organization-sub-location',
                'title'     => __( 'Location', 'hrm' ),
                'file_path' => $path . '/admin/location.php',
            ),
            'notice' => array(
                'id'        => 'hrm-organization-notice',
                'title'     => __( 'Notice', 'hrm' ),
                'file_path' => $path . '/admin/notice.php',
            ),
        ),
    );

    $page['hrm_management']['admin'] = array(
        'id'        => 'hrm-admin',
        'title'     => __( 'Employer', 'hrm' ),
        'file_path' => $path . '/admin/admin.php',
        
        'submenu' => array(
            'admin_role' => array(
                'title'     => __( 'Employer Role', 'hrm' ),
                'file_path' => $path . '/admin/admin-role.php',
            ),
            'admin_list' => array(
                'title'     => __( 'Employer lists', 'hrm' ),
                'file_path' => $path . '/admin/admin-lists.php',
                'role' => array(
                    'employer_status' => __( 'Can manage employer status', 'hrm' ),
                ),
            ),
        ),

    );

    $page['hrm_management']['job'] = array(
        'id'        => 'hrm-job',
        'title'     => __( 'job', 'hrm' ),
        'file_path' => $path . '/admin/job.php',

        'submenu' => array(
            'job_title' => array(
                'id'        => 'hrm-job-title',
                'title'     => __( 'Job Title', 'hrm' ),
                'file_path' => $path . '/admin/job_title.php',
            ),

            'job_categories' => array(
                'id'        => 'hrm-job-categories',
                'title'     => __( 'Job Categories', 'hrm' ),
                'file_path' => $path . '/admin/job-categories.php',
            ),
            'pay_grade' => array(
                'id'        => 'hrm-pay-grade',
                'title'     => __( 'Pay Grades', 'hrm' ),
                'file_path' => $path . '/admin/pay-grade.php',
            ),
        ),
    );

    $page['hrm_management']['qualification'] = array(
        'id'        => 'hrm-qualification',
        'title'     => __( 'Qualification', 'hrm' ),
        'file_path' => $path . '/admin/qualification.php',
        'submenu' => array(
            'skills' => array(
                'title'     => __( 'Skills', 'hrm' ),
                'file_path' => $path . '/admin/skills.php',
            ),
            'education' => array(
                'title'     => __( 'Education', 'hrm' ),
                'file_path' => $path . '/admin/education.php',
            ),
            'language' => array(
                'title'     => __( 'Language', 'hrm' ),
                'file_path' => $path . '/admin/language.php',
            ),
        ),

    );

    $page['hrm_management']['project_info'] = array(
        'id'        => 'hrm-project-info',
        'title'     => __( 'Project info', 'hrm' ),
        'file_path' => $path . '/admin/project-info.php',
        'submenu' => array(
            'projects' => array(
                'title'     => __( 'Project', 'hrm' ),
                'file_path' => $path . '/admin/projects.php',
                'role' => array(
                    'assign_project' => __( 'View only assign project', 'hrm' ),
                )
            ),
        ),

    );

   $page = apply_filters( 'hrm_admin_menu', $page );

    $page['hrm_pim']['employee_list'] = array(
        'id'        => 'hrm-employee-list',
        'title'     => __( 'Employee List', 'hrm' ),
        'file_path' => $path . '/pim/employee-list.php',

    );

    $page['hrm_pim']['personal'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'        => 'hrm-employee-personal',
        'title'     => __( 'Personal', 'hrm' ),
        'file_path' => $path . '/employee/personal.php',
        'submenu'   => array(
            'personal_info' => array(
                'id'        => 'hrm-personal-info',
                'title'     => __( 'Personal Information', 'hrm' ),
                'file_path' => $path . '/employee/personal-info.php',
            ),
            'jobs' => array(
                'id'        => 'hrm-personal-job',
                'title'     => __( 'job', 'hrm' ),
                'file_path' => $path . '/employee/job.php',
            ),
            'salary' => array(
                'id'        => 'hrm-personal-salary',
                'title'     => __( 'Salary', 'hrm' ),
                'file_path' => $path . '/employee/salary.php',
            ),
            'work_experiennce' => array(
                'id'        => 'hrm-personal-work-experience',
                'title'     => __( 'Work Experience', 'hrm' ),
                'file_path' => $path . '/employee/work-experience.php',
            ),
            'education' => array(
                'id'        => 'hrm-personal-education',
                'title'     => __( 'Education', 'hrm' ),
                'file_path' => $path . '/employee/education.php',
            ),
            'skill' => array(
                'id'        => 'hrm-personal-skill',
                'title'     => __( 'Skills', 'hrm' ),
                'file_path' => $path . '/employee/skill.php',
            ),
            'language' => array(
                'class'     => 'hrm-personal-language',
                'title'     => __( 'Languages', 'hrm' ),
                'file_path' => $path . '/employee/language.php',
            ),
        ),
    );

    $page['hrm_pim']['organization_info'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'        => 'hrm-employee-organization',
        'title'     => __( 'Pim Organization', 'hrm' ),
        'file_path' => $path . '/employee/organization.php',
        'submenu'   => array(
            'pim_general_info' => array(
                'id'        => 'hrm-general-info',
                'title'     => __( 'General Information', 'hrm' ),
                'file_path' => $path . '/employee/general-info.php',
            ),
            'pim_location' => array(
                'id'        => 'hrm-location',
                'title'     => __( 'Location', 'hrm' ),
                'file_path' => $path . '/employee/location.php',
            ),
            'pim_notice' => array(
                'id'        => 'hrm-location',
                'title'     => __( 'Notice', 'hrm' ),
                'file_path' => $path . '/employee/notice.php',
            ),
        ),
    );

    $page['hrm_pim']['my_task'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'        => 'hrm-employee-my-task',
        'title'     => __( 'My task', 'hrm' ),
        'file_path' => $path . '/employee/my-task.php',
        'submenu' => array(
            'current_task' => array(
                'id' => 'hrm-current-task',
                'title' => __( 'Current Task', 'hrm' ),
                'file_path' => $path . '/employee/current-task.php',
            ),
            'outstanding_task' => array(
                'id' => 'hrm-outstanding-task',
                'title' => __( 'Outstanding Task', 'hrm' ),
                'file_path' => $path . '/employee/outstanding-task.php',
            ),
            'completed_task' => array(
                'id' => 'hrm-completed-task',
                'title' => __( 'Completed Task', 'hrm' ),
                'file_path' => $path . '/employee/completed-task.php',
            ),
        ),
    );

    $page['hrm_pim']['leave'] = array(
        //'follow_access_role' => false,
        'nested_tab' => true,
        'id'        => 'hrm-employee-leave',
        'title'     => __( 'Leave', 'hrm' ),
        'file_path' => $path . '/employee/leave.php',
        'submenu' => array(
            'assign' => array(
                'id' => 'hrm-leave-assign',
                'title' => __( 'Assigin', 'hrm' ),
                'file_path' => $path . '/employee/assign.php',
            ),
            'work_in_week' => array(
                'id' => 'hrm-work-in-week',
                'title' => __( 'Work Week', 'hrm' ),
                'file_path' => $path . '/employee/work-week.php',
            ),
            'holiday' => array(
                'id' => 'hrm-holiday',
                'title' => __( 'Holiday', 'hrm' ),
                'file_path' => $path . '/employee/holiday.php',
            ),
        ),
    );

    $page = apply_filters( 'hrm_employee_memu', $page );

    $page['hrm_leave']['configure'] = array(
            'id' => 'hrm-employee-configure',
            'title' => __( 'Configure', 'hrm' ),
            'file_path' => $path . '/leave/configure.php',
            'submenu' => array(
                'leave_type' => array(
                    'id' => 'hrm-leave-type',
                    'title' => __( 'Leave Type', 'hrm' ),
                    'file_path' => $path . '/leave/leave-type.php',
                ),
                'leave_week' => array(
                    'id' => 'hrm-leave-week',
                    'title' => __( 'Work Week', 'hrm' ),
                    'file_path' => $path . '/leave/leave-week.php',
                ),
                'leave_holidays' => array(
                    'id' => 'hrm-leave-holidays',
                    'title' => __( 'Holidays', 'hrm' ),
                    'file_path' => $path . '/leave/leave-holidays.php',
                ),
            ),
        );

    $page['hrm_leave']['leave_summary'] = array(
        'id' => 'hrm-employee-leave_summary',
        'title' => __( 'Leave Summary', 'hrm' ),
        'file_path' => $path . '/leave/leave-summary.php',
        'role' => array(
            'action' => __( 'Can manage leave action', 'hrm' ),
        )
    );



    if( ! empty( $page ) && is_array( $page ) ) {
        return $page;
    }

    return array();
}