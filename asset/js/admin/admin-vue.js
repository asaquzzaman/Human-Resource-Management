// var HRM_Admin_Routes_Property = {

// 	routes: [
// 	    // Pagination
// 	    { path: '/page/:page_number', components:{ HRM_Dept_Pagination: HRM_Department_pagination }, name: 'hrm-pagination' },

// 	]
// };

// /**
//  * Todo list router
//  */
// var HRM_Admin_Router = new VueRouter(HRM_Admin_Routes_Property);

// var HRM_Department = new Vue({
// 	store: HRM_Admin_Store,

// 	router: HRM_Admin_Router,
	
// 	mixin: [HRM_Common_Mixin],

// 	computed: {
// 		is_new_department_form_visible: function() {
// 			return this.$store.state.is_new_department_form_visible;
// 		}
// 	},

// }).$mount('.hrm-content-wrap');