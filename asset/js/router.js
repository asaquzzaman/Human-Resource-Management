import Vue from './vue/vue';
import Router from './vue/vue-router';

import leave from './components/leave/leave-router';


Vue.use(Router);


var router = new Router({
	routes: HRM_Routes,
});

export default router;

