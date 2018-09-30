
HRMRegisterModule('tutotial', 'payroll/tutorial');

import Tutorial from './tutorial.vue'


HRMRegisterChildrenRoute ('payroll', 
    [

        {
            path: 'tutorial', 
            component: Tutorial, 
            name: 'payroll_tutorial',
            meta: {
                label: 'Tutorial',
                order: 10
            }
        },
    ]
);




