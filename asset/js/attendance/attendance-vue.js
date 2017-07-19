var HRM_Attendance_Routes_Property = {

	routes: [
	   
	]
};

/**
 * Todo list router
 */
var HRM_Attendance_Router = new VueRouter(HRM_Attendance_Routes_Property);

var HRM_Department = new Vue({
	store: HRM_Attendance_Store,

	router: HRM_Attendance_Router,
	
	mixin: [HRM_Common_Mixin],

}).$mount('.hrm-content-wrap');