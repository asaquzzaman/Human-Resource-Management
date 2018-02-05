
HRMRegisterModule('skill', 'profile/skill');

let skill = resolve => {

    require.ensure(['./skill.vue'], () => {
        resolve(require('./skill.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'skill', 
            component: skill, 
            name: 'skill',

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

