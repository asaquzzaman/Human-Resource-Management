__webpack_public_path__ = 'http://localhost/thrm/wp-content/plugins/hrm/asset/js/';

import Vue from './vue/vue';
import store from './store';
import router from './router';
import mixin from './mixin';
import directive from './hrm-directive';
import controller from './components/controller.vue';

var wpspear_hrm = {
	el: '#wpspear-hrm',
	store,
	router,
	render: h => h(controller)
}

new Vue(wpspear_hrm);	






