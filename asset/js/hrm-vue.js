
// Global multiselect
Vue.component('hrm-multiselect', VueMultiselect.default);
console.log(HRM_Router);
var HRM_Vue = new Vue({
	store: new Vuex.Store(HRM_Store),

	router: new VueRouter(HRM_Router),
	
	mixin: [HRM_Mixin],
	
	components: {
		'hrm-leave': ( typeof Hrm_Leave != 'undefined' ) ? Hrm_Leave : '',
		'hrm-attendance': ( typeof hrm_attendance != 'undefined' ) ? hrm_attendance : '',	
	}

//hrm-content-wrap class should be wraper for all pages
}).$mount('.hrm-content-wrap');

