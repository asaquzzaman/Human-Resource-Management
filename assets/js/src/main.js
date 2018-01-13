__webpack_public_path__ = HRM_Vars.hrm_url+ '/asset/js/';

import Store from '@store/store';
import Router from '@router/router';
import Mixin from '@helpers/mixin';
import Directive from '@directives/directives';
import Components from '@helpers/common-components';
import HRM from './App.vue';

var wpspear_hrm = {
	el: '#wpspear-hrm',
	Store,
	Router,
	render: h => h(HRM)
}

new hrm.Vue(wpspear_hrm);	









