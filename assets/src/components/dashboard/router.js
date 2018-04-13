
HRMRegisterModule('dashboard', 'dashboard');

import dashboard from './dashboard.vue'


// let dashboard = resolve => {

//     require.ensure(['./dashboard.vue'], () => {
//         resolve(require('./dashboard.vue'));
//     });
// }

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'dashboard', 
            component: dashboard, 
            name: 'dashboard',
            meta: {
                label: 'Dashboard',
                order: 1
            }
        }
    ]
);

