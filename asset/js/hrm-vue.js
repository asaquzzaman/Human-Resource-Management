
var HRM_Store_Properties = new Vuex.Store(HRM_Store);

/**
 * Todo list router
 */
var HRM_Router_Properties = new VueRouter(HRM_Router);

// Global multiselect
Vue.component('hrm-multiselect', VueMultiselect.default);

var HRM_Vue = new Vue({
	store: HRM_Store_Properties,

	router: HRM_Router_Properties,
	
	mixin: [HRM_Mixin],
	
	components: {
		'hrm-leave': ( typeof Hrm_Leave != 'undefined' ) ? Hrm_Leave : '',
		'hrm-attendance': ( typeof hrm_attendance != 'undefined' ) ? hrm_attendance : '',	
	}

//hrm-content-wrap class should be wraper for all pages
}).$mount('.hrm-content-wrap');

