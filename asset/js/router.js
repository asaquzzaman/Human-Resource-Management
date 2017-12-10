import Vue from './vue/vue';
import Router from './vue/vue-router';

import leave from './components/leave/router';
import settings from './components/settings/router';
import departments from './components/departments/router';
import Attendance from './components/attendance/router';

import Empty from './components/common/empty.vue';

// HRM_Routers.push(leave);
// HRM_Routers.push(configuration);
// HRM_Routers.push(requested);
//HRM_Routers.push(settings);

HRM_Routers.push({
	path: '/', 
    component:  Empty,
    name: 'hrm_root',

	children: HRMGetRegisterChildrenRoute('hrm_root')
});

Vue.use(Router);

var router = new Router({
	routes: HRM_Routers,
});

export default router;

