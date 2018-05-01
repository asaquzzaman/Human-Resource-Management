
HRMRegisterModule('designation', 'designation');

import designation from './designation.vue'


// let designation = resolve => {

//     require.ensure(['./designation.vue'], () => {
//         resolve(require('./designation.vue'));
//     });
// }

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'designation', 
            component: designation, 
            name: 'designation',
            meta: {
                label: 'Designation',
                order: 4
            },

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: designation,
                    name: 'designation_pagination',
                },
            ]
        }
    ]
);

