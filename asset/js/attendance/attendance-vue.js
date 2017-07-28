var HRM_Attendance_Routes_Property = {

	routes: [
	    { 
        	path: '/', 
        	components: { 'attendance_records': hrm_attendace_records }, 
        	name: 'attendance_records',

        	children: [
                { 
                	path: '/search/', 
                	components: { 'attendance_search': hrm_attendace_user_search } , 
                	name: 'attendance_search' 
                },
            ]   

    	},
	]
};

/**
 * Todo list router
 */
var HRM_Attendance_Router = new VueRouter(HRM_Attendance_Routes_Property);

var HRM_Attendance = new Vue({
	store: HRM_Attendance_Store,

	router: HRM_Attendance_Router,
	
	mixin: [HRM_Common_Mixin],
	
	components: {
	    'hrm-attendace-records': hrm_attendace_records,
	 }

}).$mount('.hrm-content-wrap');