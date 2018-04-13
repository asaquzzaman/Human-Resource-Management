
HRMRegisterModule('employee', 'employee');

import employee from './employee.vue'


// let employee = resolve => {

//     require.ensure(['./employee.vue'], () => {
//         resolve(require('./employee.vue'));
//     });
// }

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'employee', 
            component: employee, 
            name: 'employee',
            meta: {
                label: 'Employees',
                order: 5
            },

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

