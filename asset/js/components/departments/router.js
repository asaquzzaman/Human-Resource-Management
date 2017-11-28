
HRMRegisterModule('departments', 'departments');

let departments = resolve => {

    require.ensure(['./departments.vue'], () => {
        resolve(require('./departments.vue'));
    });
}

let pagination = resolve => {

    require.ensure(['./department-pagination.vue'], () => {
        resolve(require('./department-pagination.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [
    	{
            path: '/departments', 
        	component: departments, 
        	name: 'departments',

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


