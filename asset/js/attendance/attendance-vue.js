var HRM_Attendance_Routes_Property = {

	routes: [
	    { 
        	path: '/', components: { 'attendance_records': hrm_attendace_records }, name: 'punch_in_out',

        	children: [
                { path: 'user/:user/page/:page_number', components: {} , name: 'pagination' },
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