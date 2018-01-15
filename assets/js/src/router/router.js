// import leave from '@components/leave/router';
// import settings from '@components/settings/router';
// import departments from '@components/departments/router';
// import Attendance from '@components/attendance/router';
import Profile from '@components/profile/router';

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

