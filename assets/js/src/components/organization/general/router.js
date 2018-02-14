
let organization = resolve => {

    require.ensure(['./organization.vue'], () => {
        resolve(require('./organization.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'organization', 
            component: organization, 
            name: 'organization',

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: organization,
                    name: 'organization_pagination',
                },
            ]
        }
    ]
);

