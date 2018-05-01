HRMRegisterModule('notice', 'organization/notice');

import notice from './notice.vue'

// let notice = resolve => {

//     require.ensure(['./notice.vue'], () => {
//         resolve(require('./notice.vue'));
//     });
// }

HRMRegisterChildrenRoute ('organization', 
    [

        {
            path: 'notice', 
            component: notice, 
            name: 'notice',
            meta: {
                label: 'Notice',
            },

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: notice,
                    name: 'notice_pagination',
                },
            ]
        }
    ]
);

