HRMRegisterModule('revision', 'payroll/revision');

import Revision from './revision.vue'

HRMRegisterChildrenRoute ('payroll', 
    [

        {
            path: 'revision', 
            component: Revision, 
            name: 'revision',
            meta: {
                label: 'Revision',
                order: 4
            },
            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: Revision,
                    name: 'revision_pagination',
                },
            ]
        }
    ]
);

