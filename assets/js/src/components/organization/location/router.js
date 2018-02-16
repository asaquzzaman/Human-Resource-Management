HRMRegisterModule('location', 'organization/location');

let location = resolve => {

    require.ensure(['./location.vue'], () => {
        resolve(require('./location.vue'));
    });
}

HRMRegisterChildrenRoute ('organization', 
    [

        {
            path: 'location', 
            component: location, 
            name: 'location',
            meta: {
                label: 'Location',
            },

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

