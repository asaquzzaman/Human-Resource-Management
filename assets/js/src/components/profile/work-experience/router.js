
HRMRegisterModule('workExperience', 'profile/work-experience');

let workExperience = resolve => {

    require.ensure(['./work-experience.vue'], () => {
        resolve(require('./work-experience.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'work-experience', 
            component: workExperience, 
            name: 'work_experience',

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

