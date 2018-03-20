
HRMRegisterModule('workExperience', 'profile/work-experience');

let workExperience = resolve => {
    require.ensure(['./work-experience.vue'], () => {
        resolve(require('./work-experience.vue'));
    });
}

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
            path: ':employeeId/work-experience', 
            component: workExperience, 
            name: 'work_experience',
            meta: {
                label: 'Work Experience',
                params (self, params) {
                    return HRM_URM_Params(self, params);
                }
            },

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: workExperience,
                    name: 'work_experiance_pagination',
                },
            ]
        }
    ]
);

