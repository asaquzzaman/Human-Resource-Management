HRMRegisterModule('shift', 'attendance/shift');
import Shift from './shift.vue'

HRMRegisterChildrenRoute ('attendance', 
    [

        {
            path: 'shift', 
            name: 'shift',
            component: Shift,
            meta: {
                label: 'Shift',
                order: 2
            },

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: Shift,
                    name: 'shift_pagination',
                },
            ]
        }
    ]
);
