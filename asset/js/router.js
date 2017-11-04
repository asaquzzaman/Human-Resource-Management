import Vue from './vue/vue';
import Router from './vue/vue-router';

import {leave,configuration,requested} from './components/leave/leave-router';
import settings from './components/settings/router';

HRM_Routes.push(leave);
HRM_Routes.push(configuration);
HRM_Routes.push(requested);
HRM_Routes.push(settings);

Vue.use(Router);

var router = new Router({
	routes: HRM_Routes,
});

export default router;

