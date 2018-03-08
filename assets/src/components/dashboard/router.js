
HRMRegisterModule('dashboard', 'dashboard');

let dashboard = resolve => {

    require.ensure(['./dashboard.vue'], () => {
        resolve(require('./dashboard.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'dashboard', 
            component: dashboard, 
            name: 'dashboard',
        }
    ]
);

