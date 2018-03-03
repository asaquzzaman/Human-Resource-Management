
HRMRegisterModule('profile', 'profile');

import './work-experience/router';
import './education/router';
import './skill/router';

let personalInformation = resolve => {
    require.ensure(['./personal-information.vue'], () => {
        resolve(require('./personal-information.vue'));
    });
}

let jobLocation = resolve => {
    require.ensure(['./job-location.vue'], () => {
        resolve(require('./job-location.vue'));
    });
}

let profile = resolve => {
    require.ensure(['./profile.vue'], () => {
        resolve(require('./profile.vue'));
    });
}

let menu = [
    {
        path: 'employees', 
        component: profile, 
        name: 'profile',

        children: HRMGetRegisterChildrenRoute( 'profile',
            [
                {
                    path: ':employeeId/general-information', 
                    component: personalInformation, 
                    name: 'employee_general_information',
                    meta: {
                        label: 'General Information'
                    }
                },

                {
                    path: ':employeeId/job-location', 
                    component: jobLocation, 
                    name: 'job_location',
                    meta: {
                        label: 'Job Loaction'
                    }
                }
            ]
        )
    },
];

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;

