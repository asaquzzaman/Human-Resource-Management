import '@components/profile/router';
import '@components/organization/router';
import '@components/designation/router';
import '@components/dashboard/router';
import '@components/departments/router';
import '@components/attendance/router';
import '@components/leave/router';
import '@components/settings/router';
import '@components/employee/router';
import '@components/addons/router';

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

