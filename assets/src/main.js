__webpack_public_path__ = HRM_Vars.hrm_url+ '/assets/js/';

import store from '@store/store';
import router from '@router/router';
import Mixin from '@helpers/mixin';
import Directive from '@directives/directives';
import Components from '@helpers/common-components';
import HRM from './App.vue';
import MenuFix from '@helpers/menu-fix';

window.hrmBus =  new hrm.Vue();

var wpspear_hrm = {
	el: '#wpspear-hrm',
	store,
	router,
	render: h => h(HRM)
}

new hrm.Vue(wpspear_hrm);	


// fix the admin menu for the slug "vue-app"
MenuFix('hr_management');





