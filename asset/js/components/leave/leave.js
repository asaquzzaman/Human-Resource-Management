var Hrm_Leave = {
	template: '#tmpl-hrm-leave',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {

		}
	},

	components: {
      	'hrm-leave-header': Hrm_Leave_Header,
      	'hrm-leave-records': Hrm_Leave_Records,
      	'hrm-leave-configuration': Hrm_Leave_Configuration,
      	'hrm-leave-type': Hrm_Leave_Type,
		'hrm-leave-work-week': Hrm_Leave_Work_Week,
		'hrm-leave-holidays': Hrm_Leave_Holidays
	},

	computed: {

	},

	created: function() {
		if ( this.$route.path == '/' ) {
			this.$router.push({ name: 'leave_records' });
		}
	},
	methods: {

	}
};


// var HRM_leave_Routes_Property = {

// 	routes: [
// 	    { 
//         	path: '/leave', 
//         	components: { 'hrm-attendace-records': hrm_attendace_records }, 
//         	name: 'leave_records',

//         	children: [
//                 { 
//                 	path: '/leave/search/', 
//                 	components: { 'leave_search': hrm_attendace_user_search } , 
//                 	name: 'leave_search' 
//                 },
//             ]   

//     	},

//     	{
//     		path: '/leave/configuration', 
//         	components: { 'hrm-leave-configuration': hrm_attendace_configuration }, 
//         	name: 'leave_configuration',
//     	}
// 	]
// };

// /**
//  * Todo list router
//  */
// var HRM_leave_Router = new VueRouter(HRM_leave_Routes_Property);

// var HRM_leave = new Vue({
// 	store: HRM_leave_Store,

// 	router: HRM_leave_Router,
	
// 	mixin: [HRM_Mixin],
	
// 	components: {
// 	    'hrm-attendace-records': hrm_attendace_records,
// 	    'hrm-leave-configuration': hrm_attendace_configuration,
//      'hrm-leave-header': hrm_leave_header
// 	 }

// }).$mount('.hrm-content-wrap');

