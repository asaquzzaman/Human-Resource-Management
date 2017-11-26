<template>
	<div>
		<div class="hrm-attendance" id="hrm-subtab-wrap">
			<hrm-attendance-header></hrm-attendance-header>
			<router-view name="hrm-attendace-records"></router-view>
			<router-view name="hrm-attendance-configuration"></router-view> 
		</div>
	</div>

</template>

<script>
	export default {
		mixins: [HRM_Common_Mixin],

		store: HRM_Attendance_Store,
		
		data: function() {
			return {
				//punch_in_date: 'sdgfashjfdgsad',
				//punch_out_date: '',
				//search_user_id: ''
			}
		},

		components: {
			'hrm-attendace-punch-in-out-btn': hrm_attendace_punch_in_out_btn,
	 	    'hrm-attendace-records': hrm_attendace_records,
	 	    'hrm-attendance-configuration': hrm_attendace_configuration,
	      	'hrm-attendance-header': hrm_attendance_header,
	      	'hrm-attendace-user-search': hrm_attendace_user_search
		},

		computed: {

		},
		
		methods: {

		}	
	}
</script>

<!-- var hrm_attendance = {
	template: '#tmpl-hrm-attendance',
	
	mixins: [HRM_Common_Mixin],

	store: HRM_Attendance_Store,
	
	data: function() {
		return {
			//punch_in_date: 'sdgfashjfdgsad',
			//punch_out_date: '',
			//search_user_id: ''
		}
	},

	components: {
		'hrm-attendace-punch-in-out-btn': hrm_attendace_punch_in_out_btn,
 	    'hrm-attendace-records': hrm_attendace_records,
 	    'hrm-attendance-configuration': hrm_attendace_configuration,
      	'hrm-attendance-header': hrm_attendance_header,
      	'hrm-attendace-user-search': hrm_attendace_user_search
	},

	computed: {

	},
	
	methods: {

	}
};


// var HRM_Attendance_Routes_Property = {

// 	routes: [
// 	    { 
//         	path: '/attendance', 
//         	components: { 'hrm-attendace-records': hrm_attendace_records }, 
//         	name: 'attendance_records',

//         	children: [
//                 { 
//                 	path: '/attendance/search/', 
//                 	components: { 'attendance_search': hrm_attendace_user_search } , 
//                 	name: 'attendance_search' 
//                 },
//             ]   

//     	},

//     	{
//     		path: '/attendance/configuration', 
//         	components: { 'hrm-attendance-configuration': hrm_attendace_configuration }, 
//         	name: 'attendance_configuration',
//     	}
// 	]
// };

// /**
//  * Todo list router
//  */
// var HRM_Attendance_Router = new VueRouter(HRM_Attendance_Routes_Property);

// var HRM_Attendance = new Vue({
// 	store: HRM_Attendance_Store,

// 	router: HRM_Attendance_Router,
	
// 	mixin: [HRM_Common_Mixin],
	
// 	components: {
// 	    'hrm-attendace-records': hrm_attendace_records,
// 	    'hrm-attendance-configuration': hrm_attendace_configuration,
//      'hrm-attendance-header': hrm_attendance_header
// 	 }

// }).$mount('.hrm-content-wrap'); -->

