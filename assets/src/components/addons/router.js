
HRMRegisterModule('addons', 'addons');

import addons from './addons.vue'


// let addons = resolve => {

//     require.ensure(['./addons.vue'], () => {
//         resolve(require('./addons.vue'));
//     });
// }

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'addons', 
            component: addons, 
            name: 'addons',
        }
    ]
);

