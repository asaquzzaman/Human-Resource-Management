
HRMRegisterModule('education', 'profile/education');

let education = resolve => {
    require.ensure(['./education.vue'], () => {
        resolve(require('./education.vue'));
    });
}

HRMRegisterChildrenRoute ('profile', 
    [
        {
            path: 'education', 
            component: education, 
            name: 'education',
            meta: {
                label: 'Education'
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

