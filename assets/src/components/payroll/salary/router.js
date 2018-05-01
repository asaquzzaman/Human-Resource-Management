
HRMRegisterModule('salary', 'payroll/salary');

import Salary from './salary.vue'

if(hrm_user_can('manage_payroll')) {
    HRMRegisterChildrenRoute ('payroll', 
        [

            {
                path: 'salary', 
                component: Salary, 
                name: 'salary',
                meta: {
                    label: 'Salary',
                    order: 1
                }
            },

            {
                path: 'salary/employees/:employee_id', 
                component: Salary, 
                name: 'salary_update',
            }
        ]
    );
}



