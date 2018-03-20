
HRMRegisterModule('attendance', 'attendance');

let hrm_attendace_records = resolve => {
    require.ensure(['./attendance-records.vue'], () => {
        resolve(require('./attendance-records.vue'));
    });
}

let hrm_attendace_user_search = resolve => {
    require.ensure(['./attendance-user-search.vue'], () => {
        resolve(require('./attendance-user-search.vue'));
    });
}

let hrm_attendace_configuration = resolve => {
    require.ensure(['./attendance-configuration.vue'], () => {
        resolve(require('./attendance-configuration.vue'));
    });
}

import Empty from './empty.vue'

let menu = [
    { 
        path: 'attendance', 
        component: Empty, 
        name: 'attendance',
        meta: {
            label: 'Attendance',
            order: 7
        },

        children: [
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

    }
];

if ( hrm_user_can('manage_attendance') ) {
    menu[0].children.push(
        {
            path: 'attendance-configuration', 
            component: hrm_attendace_configuration, 
            name: 'attendance_configuration',
            meta: {
                label: 'Configuration',
            }
        }
    );
}

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;
