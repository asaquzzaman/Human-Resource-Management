HRMRegisterModule('leave', 'leave');

let Hrm_Leave_Records = resolve => {
    require.ensure(['./leave-records.vue'], () => {
        resolve(require('./leave-records.vue'));
    });
}

let Hrm_Leave_Configuration = resolve => {
    require.ensure(['./leave-configuration.vue'], () => {
        resolve(require('./leave-configuration.vue'));
    });
}
let Hrm_Leave_Type = resolve => {
    require.ensure(['./leave-type.vue'], () => {
        resolve(require('./leave-type.vue'));
    });
}
let Hrm_Leave_Work_Week = resolve => {
    require.ensure(['./leave-work-week.vue'], () => {
        resolve(require('./leave-work-week.vue'));
    });
}
let Hrm_Leave_Holidays = resolve => {
    require.ensure(['./leave-holidays.vue'], () => {
        resolve(require('./leave-holidays.vue'));
    });
}

let Hrm_Leave_form_settings = resolve => {
    require.ensure(['./leave-form-settings.vue'], () => {
        resolve(require('./leave-form-settings.vue'));
    });
}

let Hrm_Leave_Requests = resolve => {
    require.ensure(['./leave-requests.vue'], () => {
        resolve(require('./leave-requests.vue'));
    });
}

let Hrm_Leave_Pending = resolve => {
    require.ensure(['./leave-pending.vue'], () => {
        resolve(require('./leave-pending.vue'));
    });
}

let Hrm_Leave_Cancel = resolve => {
    require.ensure(['./leave-cancel.vue'], () => {
        resolve(require('./leave-cancel.vue'));
    });
}

let Hrm_Leave_Approve = resolve => {
    require.ensure(['./leave-approve.vue'], () => {
        resolve(require('./leave-approve.vue'));
    });
}

import Empty from './empty.vue'

let menu = [
    { 
        path: 'leave', 
        component:  Empty,
        name: 'leave',
        meta: {
            label: 'Leave',
            order: 8
        },

        children: [
            {
                path: 'records', 
                component:  Hrm_Leave_Records,
                name: 'leave_records',
                meta: {
                    label: 'Leave',
                    params (self, params) {
                        return HRM_URM_Params(self, params);
                    }
                }
            },

            {
                path: 'leave-request', 
                component: Hrm_Leave_Requests, 
                name: 'leave_request',
                meta: {
                    label: 'Requested Leave',
                    params (self, params) {
                        return HRM_URM_Params(self, params);
                    }
                },

                children: [
                    {
                        path: 'pending', 
                        component: Hrm_Leave_Pending, 
                        name: 'leave_pending',
                        meta: {
                            label: 'Pending'
                        },
                    },

                    {
                        path: 'approve', 
                        component: Hrm_Leave_Approve, 
                        name: 'leave_approve',
                        meta: {
                            label: 'Approve'
                        },
                    },

                    {
                        path: 'cancel', 
                        component: Hrm_Leave_Cancel, 
                        name: 'leave_cancel',
                        meta: {
                            label: 'Cancel'
                        },
                    }
                ]
            }

        ]
    },
    
];

if (hrm_user_can('manage_leave')) {
    menu[0].children.push(
        {
            path: 'leave-configuration', 
            component: Hrm_Leave_Configuration, 
            name: 'leave_configuration',
            meta: {
                label: 'Configuration'
            },

            children: [
                {
                    path: 'type', 
                    component: Hrm_Leave_Type, 
                    name: 'leave_type',
                    meta: {
                        label: 'Type'
                    }
                },

                {
                    path: 'work-week', 
                    component: Hrm_Leave_Work_Week, 
                    name: 'leave_week',
                    meta: {
                        label: 'Work Week'
                    }
                },

                {
                    path: 'holidays', 
                    component: Hrm_Leave_Holidays, 
                    name: 'leave_holidays',
                    meta: {
                        label: 'Holiday'
                    }
                },

                {
                    path: 'form', 
                    component: Hrm_Leave_form_settings, 
                    name: 'leave_form_settings',
                    meta: {
                        label: 'Leave Form'
                    }
                }
            ]
        }
    );
}

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;


