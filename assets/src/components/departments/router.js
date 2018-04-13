
HRMRegisterModule('departments', 'departments');

import departments from './departments.vue'
import pagination from './department-pagination.vue'


// let departments = resolve => {

//     require.ensure(['./departments.vue'], () => {
//         resolve(require('./departments.vue'));
//     });
// }

// let pagination = resolve => {

//     require.ensure(['./department-pagination.vue'], () => {
//         resolve(require('./department-pagination.vue'));
//     });
// }

HRMRegisterChildrenRoute ('hrm_root', 
    [
    	{
            path: 'departments', 
        	component: departments, 
        	name: 'departments',
            meta: {
                label: 'Department',
                order: 3
            },

            children: [
                { 
                    path: 'page/:page_number', 
                    component: pagination, 
                    name: 'department_pagination' 
                },
            ]
        }
    ]
);


