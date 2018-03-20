
HRMRegisterModule('skill', 'profile/skill');

let skill = resolve => {

    require.ensure(['./skill.vue'], () => {
        resolve(require('./skill.vue'));
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
            path: ':employeeId/skill', 
            component: skill, 
            name: 'skill',
            meta: {
                label: 'Skill',
                params (self, params) {
                    return HRM_URM_Params(self, params);
                }
            },

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: skill,
                    name: 'skill_pagination',
                },
            ]
        }
    ]
);

