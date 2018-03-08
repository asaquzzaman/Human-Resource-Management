
HRMRegisterModule('skill', 'profile/skill');

let skill = resolve => {

    require.ensure(['./skill.vue'], () => {
        resolve(require('./skill.vue'));
    });
}

HRMRegisterChildrenRoute ('profile', 
    [
        {
            path: ':employeeId/skill', 
            component: skill, 
            name: 'skill',
            meta: {
                label: 'Skill'
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

