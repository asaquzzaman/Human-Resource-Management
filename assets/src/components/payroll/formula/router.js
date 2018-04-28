HRMRegisterModule('formula', 'payroll/formula');

import formula from './formula.vue'

if(hrm_user_can('manage_payroll')) {
    HRMRegisterChildrenRoute ('payroll', 
        [

            {
                path: 'salary-components', 
                component: formula, 
                name: 'salary_components',
                meta: {
                    label: 'Salary Components',
                    order: 2
                }
            }
        ]
    );
}
