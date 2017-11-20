var HRM_Attendance_Routes_Property = {

	routes: [
	    { 
        	path: '/attendance', 
        	components: { 'hrm-attendace-records': hrm_attendace_records }, 
        	name: 'attendance_records',

        	children: [
                { 
                	path: '/attendance/search/', 
                	components: { 'attendance_search': hrm_attendace_user_search } , 
                	name: 'attendance_search' 
                },
            ]   

    	},

    	{
    		path: '/attendance-configuration', 
        	components: { 'hrm-attendance-configuration': hrm_attendace_configuration }, 
        	name: 'attendance_configuration',
    	}
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
	    'hrm-attendance-configuration': hrm_attendace_configuration,
        'hrm-attendance-header': hrm_attendance_header
	 }

}).$mount('.hrm-attendance-content-wrap');