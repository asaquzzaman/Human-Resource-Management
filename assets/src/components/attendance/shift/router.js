HRMRegisterModule('shift', 'attendance/shift');
import Shift from './shift.vue'

let menu = [

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

if ( hrm_user_can('manage_attendance') ) {  
    HRMRegisterChildrenRoute ('attendance', menu);
}
