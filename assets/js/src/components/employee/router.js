
HRMRegisterModule('employee', 'employee');

let employee = resolve => {

    require.ensure(['./employee.vue'], () => {
        resolve(require('./employee.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'employee', 
            component: employee, 
            name: 'employee',

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: employee,
                    name: 'employee_pagination',
                },
            ]
        }
    ]
);

