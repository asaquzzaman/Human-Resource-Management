HRMRegisterModule('general', 'organization/general');

import general from './general-information.vue'


// let general = resolve => {

//     require.ensure(['./general-information.vue'], () => {
//         resolve(require('./general-information.vue'));
//     });
// }

HRMRegisterChildrenRoute ('organization', 
    [

        {
            path: 'general-information', 
            component: general, 
            name: 'general_information',
            meta: {
                label: 'General Information',
            }
        }
    ]
);

