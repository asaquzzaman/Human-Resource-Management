
HRMRegisterModule('attendance', 'attendance');

import './shift/router';
import './tutorial/router';

import hrm_attendace_records from './attendance-records.vue'
import hrm_attendace_user_search from './attendance-user-search.vue'
import hrm_attendace_configuration from './attendance-configuration.vue'
import Reports from './attendance-report.vue'
import Customize from './attendance-customize.vue'


// let hrm_attendace_records = resolve => {
//     require.ensure(['./attendance-records.vue'], () => {
//         resolve(require('./attendance-records.vue'));
//     });
// }

// let hrm_attendace_user_search = resolve => {
//     require.ensure(['./attendance-user-search.vue'], () => {
//         resolve(require('./attendance-user-search.vue'));
//     });
// }

// let hrm_attendace_configuration = resolve => {
//     require.ensure(['./attendance-configuration.vue'], () => {
//         resolve(require('./attendance-configuration.vue'));
//     });
// }

import Empty from './empty.vue'

var menu = [
    { 
        path: 'attendance', 
        component: Empty, 
        name: 'attendance',
        meta: {
            label: 'Attendance',
            order: 1
        },

        children: HRMGetRegisterChildrenRoute('attendance',
            [
                {
                    path: 'records', 
                    component: hrm_attendace_records, 
                    name: 'attendance_records',
                    meta: {
                        label: 'Attendance',
                    },
                },
                { 
                    path: 'search', 
                    component: hrm_attendace_user_search, 
                    name: 'attendance_search',
                    meta: {
                        label: false,
                    },
                },
            ] 
        )  

    }
];



if(typeof HRM_Shift_Vars == 'undefined') {

    menu[0].children.push(
        {
            path: 'reports', 
            name: 'attendance_reports',
            component: Reports,
            meta: {
                label: 'Reports',
                order: 4
            }
        }
    );

    menu[0].children.push(
        {
            path: 'attendance-customize', 
            name: 'attendance_customize',
            component: Customize,
            meta: {
                label: 'Customize',
                order: 3
            }
        }
    );
}

if ( hrm_user_can('manage_attendance') ) {
    menu[0].children.push(
        {
            path: 'attendance-configuration', 
            component: hrm_attendace_configuration, 
            name: 'attendance_configuration',
            meta: {
                label: 'Configuration',
                order: 5
            }
        }
    );
}

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;
