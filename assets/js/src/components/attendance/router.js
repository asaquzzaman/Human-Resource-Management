
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

let menu = [
    { 
        path: 'attendance', 
        component: hrm_attendace_records, 
        name: 'attendance_records',
        meta: {
            label: 'Attendance',
        },

        children: [
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
    menu.push(
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
