HRMRegisterModule('group', 'payroll/group');

import Group from './group.vue'

if(hrm_user_can('manage_payroll')) {
    HRMRegisterChildrenRoute ('payroll', 
        [

            {
                path: 'group', 
                component: Group, 
                name: 'group',
                meta: {
                    label: 'Component Group',
                },
                children: [
                    {
                        path: 'pages/:current_page_number', 
                        component: Group,
                        name: 'group_pagination',
                    },
                ]
            }
        ]
    );

}
