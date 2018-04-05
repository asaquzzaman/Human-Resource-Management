HRMRegisterModule('formula', 'payroll/formula');

import formula from './formula.vue'

HRMRegisterChildrenRoute ('payroll', 
    [

        {
            path: 'salary-components', 
            component: formula, 
            name: 'salary_components',
            meta: {
                label: 'Salary Components',
            }
        }
    ]
);

