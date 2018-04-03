
HRMRegisterModule('payroll', 'payroll');

import Payroll from './payroll.vue'

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'payroll', 
            component: Payroll, 
            name: 'payroll',
            meta: {
                label: 'Payroll',
                order: 10
            },

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: Payroll,
                    name: 'payroll_pagination',
                },
            ]
        }
    ]
);

