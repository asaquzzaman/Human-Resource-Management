import Profile from '@components/profile/router';
import Organization from '@components/organization/router';
import employee from '@components/employee/router';
import departments from '@components/departments/router';
import '@components/designation/router';
import '@components/dashboard/router';

import Empty from '@components/common/empty.vue';

HRM_Routers.push({
	path: '/', 
    component:  Empty,
    name: 'hrm_root',

	children: HRMGetRegisterChildrenRoute('hrm_root')
});

var router = new hrm.VueRouter({
	routes: HRM_Routers,
});

export default router;

