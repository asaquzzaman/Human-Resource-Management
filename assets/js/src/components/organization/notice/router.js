
let notice = resolve => {

    require.ensure(['./notice.vue'], () => {
        resolve(require('./notice.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [

        {
            path: 'notice', 
            component: notice, 
            name: 'notice',

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

