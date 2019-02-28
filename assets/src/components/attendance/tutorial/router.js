
HRMRegisterModule('tutotial', 'attendance/tutorial');

import Tutorial from './tutorial.vue'


HRMRegisterChildrenRoute ('attendance', 
    [

        {
            path: 'tutorial', 
            component: Tutorial, 
            name: 'attendance_tutorial',
            meta: {
                label: 'Tutorial',
                order: 10
            }
        },
    ]
);




