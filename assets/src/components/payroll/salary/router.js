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
        }
    ]
);

