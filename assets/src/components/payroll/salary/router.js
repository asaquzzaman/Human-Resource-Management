HRMRegisterModule('salary', 'payroll/salary');

import Salary from './salary.vue'

HRMRegisterChildrenRoute ('payroll', 
    [

        {
            path: 'salary', 
            component: Salary, 
            name: 'salary',
            meta: {
                label: 'Salary',
            }
        },

        {
            path: 'salary/employees/:employee_id', 
            component: Salary, 
            name: 'salary_update',
        }
    ]
);

