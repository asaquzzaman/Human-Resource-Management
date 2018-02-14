
let location = resolve => {

    require.ensure(['./location.vue'], () => {
        resolve(require('./location.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'location', 
            component: location, 
            name: 'location',

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: location,
                    name: 'location_pagination',
                },
            ]
        }
    ]
);

