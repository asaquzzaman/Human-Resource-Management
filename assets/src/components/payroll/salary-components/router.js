HRMRegisterModule('salaryComponents', 'payroll/salary-components');

import salaryComponents from './salary-components.vue'

HRMRegisterChildrenRoute ('payroll', 
    [

        {
            path: 'salary-components', 
            component: salaryComponents, 
            name: 'salary_components',
            meta: {
                label: 'Salary Components',
            }
        }
    ]
);

