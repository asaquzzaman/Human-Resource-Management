
var HRM_Store_Properties = new Vuex.Store(HRM_Store);

/**
 * Todo list router
 */
var HRM_Router_Properties = new VueRouter(HRM_Router);

var HRM_Vue = new Vue({
	store: HRM_Store_Properties,

	router: HRM_Router_Properties,
	
	mixin: [HRM_Mixin],
	
	components: {
		'hrm-attendance': hrm_attendance,	
	}

//hrm-content-wrap class should be wraper for all pages
}).$mount('.hrm-content-wrap');

