
HRMRegisterModule('profile', 'profile');

import './work-experience/router';
import './education/router';
import './skill/router';

import personalInformation from './personal-information.vue'
import jobLocation from './job-location.vue'
import profile from './profile.vue'

// let personalInformation = resolve => {
//     require.ensure(['./personal-information.vue'], () => {
//         resolve(require('./personal-information.vue'));
//     });
// }

// let jobLocation = resolve => {
//     require.ensure(['./job-location.vue'], () => {
//         resolve(require('./job-location.vue'));
//     });
// }

// let profile = resolve => {
//     require.ensure(['./profile.vue'], () => {
//         resolve(require('./profile.vue'));
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

let menu = [
    {
        path: 'employees', 
        component: profile, 
        name: 'profile',
        meta: {
            label: 'Profile',
            order: 6
        },

        children: HRMGetRegisterChildrenRoute( 'profile',
            [
                {
                    path: ':employeeId/general-information', 
                    component: personalInformation, 
                    name: 'employee_general_information',
                    meta: {
                        label: 'General Information',
                        params (self, params) {
                            return HRM_URM_Params(self, params);
                        }
                    }
                },

                {
                    path: ':employeeId/job-location', 
                    component: jobLocation, 
                    name: 'job_location',
                    meta: {
                        label: 'Job Loaction',
                        params (self, params) {
                            return HRM_URM_Params(self, params);
                        }
                    }
                }
            ]
        )
    },
];

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;

