
HRMRegisterModule('education', 'profile/education');

import education from './education.vue'

// let education = resolve => {
//     require.ensure(['./education.vue'], () => {
//         resolve(require('./education.vue'));
//     });
// }

function HRM_URM_Params (self, params) {
    let employeeId = self.$route.params.employeeId 
        ? self.$route.params.employeeId 
        : HRM_Vars.current_user.data.ID
    
    return {
        employeeId: employeeId
    }
}

HRMRegisterChildrenRoute ('profile', 
    [
        {
            path: ':employeeId/education', 
            component: education, 
            name: 'education',
            meta: {
                label: 'Education',
                params (self, params) {
                    return HRM_URM_Params(self, params);
                }
            },

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: education,
                    name: 'education_pagination',
                },
            ]
        }
    ]
);

