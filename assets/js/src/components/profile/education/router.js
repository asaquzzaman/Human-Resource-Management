
HRMRegisterModule('education', 'profile/education');

let education = resolve => {

    require.ensure(['./education.vue'], () => {
        resolve(require('./education.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'education', 
            component: education, 
            name: 'education',

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

