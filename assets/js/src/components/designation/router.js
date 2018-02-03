
HRMRegisterModule('designation', 'designation');

let designation = resolve => {

    require.ensure(['./designation.vue'], () => {
        resolve(require('./designation.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'designation', 
            component: designation, 
            name: 'designation',

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: designation,
                    name: 'designation_pagination',
                },
            ]
        }
    ]
);

