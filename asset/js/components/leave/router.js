HRMRegisterModule('leave', 'leave');

const Hrm_Leave_Records = resolve => {

    require.ensure(['./leave-records.vue'], () => {
        resolve(require('./leave-records.vue'));
    });
}

const Hrm_Leave_Configuration = resolve => {

    require.ensure(['./leave-configuration.vue'], () => {
        resolve(require('./leave-configuration.vue'));
    });
}
const Hrm_Leave_Type = resolve => {

    require.ensure(['./leave-type.vue'], () => {
        resolve(require('./leave-type.vue'));
    });
}
const Hrm_Leave_Work_Week = resolve => {

    require.ensure(['./leave-work-week.vue'], () => {
        resolve(require('./leave-work-week.vue'));
    });
}
const Hrm_Leave_Holidays = resolve => {

    require.ensure(['./leave-holidays.vue'], () => {
        resolve(require('./leave-holidays.vue'));
    });
}

const Hrm_Leave_form_settings = resolve => {

    require.ensure(['./leave-form-settings.vue'], () => {
        resolve(require('./leave-form-settings.vue'));
    });
}

const Hrm_Leave_Requests = resolve => {

    require.ensure(['./leave-requests.vue'], () => {
        resolve(require('./leave-requests.vue'));
    });
}

const Hrm_Leave_Pending = resolve => {

    require.ensure(['./leave-pending.vue'], () => {
        resolve(require('./leave-pending.vue'));
    });
}

const Hrm_Leave_Cancel = resolve => {

    require.ensure(['./leave-cancel.vue'], () => {
        resolve(require('./leave-cancel.vue'));
    });
}

const Hrm_Leave_Approve = resolve => {

    require.ensure(['./leave-approve.vue'], () => {
        resolve(require('./leave-approve.vue'));
    });
}


HRMRegisterChildrenRoute ('hrm_root', 
    [
        { 
            path: 'leave', 
            component:  Hrm_Leave_Records,
            name: 'leave_records',
        },

        {
            path: 'leave-configuration', 
            component: Hrm_Leave_Configuration, 
            name: 'leave_configuration',

            children: [
                {
                    path: 'type', 
                    component: Hrm_Leave_Type, 
                    name: 'leave_type',
                },

                {
                    path: 'work-week', 
                    component: Hrm_Leave_Work_Week, 
                    name: 'leave_week',
                },

                {
                    path: 'holidays', 
                    component: Hrm_Leave_Holidays, 
                    name: 'leave_holidays',
                },

                {
                    path: 'form', 
                    component: Hrm_Leave_form_settings, 
                    name: 'leave_form_settings',
                }
            ]
        },

        {
            path: 'leave-requests', 
            component: Hrm_Leave_Requests, 
            name: 'leave_requests',

            children: [
                {
                    path: 'pending', 
                    component: Hrm_Leave_Pending, 
                    name: 'leave_pending',
                },

                {
                    path: 'approve', 
                    component: Hrm_Leave_Approve, 
                    name: 'leave_approve',
                },

                {
                    path: 'cancel', 
                    component: Hrm_Leave_Cancel, 
                    name: 'leave_cancel',
                }
            ]
        }
    ]
);






// var configuration = {
//     path: '/leave-configuration', 
//     components: { 'hrm-leave-configuration': Hrm_Leave_Configuration }, 
//     name: 'leave_configuration',

//     children: [
//         {
//             path: '/leave-configuration/type', 
//             components: { 'hrm-leave-type': Hrm_Leave_Type }, 
//             name: 'leave_type',
//         },

//         {
//             path: '/leave-configuration/work-week', 
//             components: { 'hrm-leave-work-week': Hrm_Leave_Work_Week }, 
//             name: 'leave_week',
//         },

//         {
//             path: '/leave-configuration/holidays', 
//             components: { 'hrm-leave-holidays': Hrm_Leave_Holidays }, 
//             name: 'leave_holidays',
//         },

//         {
//             path: '/leave-configuration/form', 
//             components: { 'hrm-leave-form-settings': Hrm_Leave_form_settings }, 
//             name: 'leave_form_settings',
//         }
//     ]
// }



// var requested = {
//     path: '/leave-requests', 
//     components: { 'hrm-leave-requests': Hrm_Leave_Requests }, 
//     name: 'leave_requests',

//     children: [
//         {
//             path: '/leave-requests/pending', 
//             components: { 'hrm-leave-pending': Hrm_Leave_Pending }, 
//             name: 'leave_pending',
//         },

//         {
//             path: '/leave-requests/approve', 
//             components: { 'hrm-leave-approve': Hrm_Leave_Approve }, 
//             name: 'leave_approve',
//         },

//         {
//             path: '/leave-requests/cancel', 
//             components: { 'hrm-leave-cancel': Hrm_Leave_Cancel }, 
//             name: 'leave_cancel',
//         }
//     ]
// }


// export {leave,configuration,requested};
