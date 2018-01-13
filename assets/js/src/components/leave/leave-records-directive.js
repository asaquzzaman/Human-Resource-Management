import Vue from './../../vue/vue';

var HRM_Employee_Leave_Recors = {
	vnode: {},
	eventCallback: '',

	init (el, binding, vnode) {
		var self = this;
		this.vnode = vnode;

		jQuery('.hrm-employee-leave-records').fullCalendar(self.getCalendarProperty());
	},

	getCalendarProperty () {
		return {
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'listYear,prev,next'
			},
			defaultView: 'listYear',
			height: 400,
			navLinks: false, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			fixedWeekCount: false, //remove others month days for current month
			showNonCurrentDates: false,
			displayEventTime: false,
			allDay: true,
			events: this.getLeaveRecords,
			resourceGroupField: 'building',

			resources: [

				{ id: 'b', building: '564 Pacific', title: 'Auditorium V' },
				{ id: 'b', building: '564 Pacific', title: 'Auditorium W' },
				{ id: 'c', building: '564 Pacific', title: 'Auditorium X' },
				{ id: 'c', building: '564 Pacific', title: 'Auditorium Y' },
				{ id: 'c', building: '564 Pacific', title: 'Auditorium Z' }

			]
		}
	},

	getLeaveRecords (start, end, timezone, callback) {
		var self = HRM_Employee_Leave_Recors;

        self.vnode.context.getLeaveRecords({
			'emp_id': HRM_Vars.current_user.data.ID,
			'callback': self.setEvents
		});

		self.eventCallback = callback;
	},

	setEvents (res) {
		var self = HRM_Employee_Leave_Recors;
		var events = [];

		jQuery.each(res.data, function(key, val) {
			
			var obj = {
				id: val.id,
				title: val.type == '0' ? 'Extra' : val.leave_type.name,
				start: moment(val.start_time).format('YYYY-MM-DD'), 
				end: moment(val.end_time).add(1, 'days').format('YYYY-MM-DD'), 
				backgroundColor: '#e08989',
				borderColor: '#e08989',
				allDay: true,
			};

			events.push(obj);
		});

		self.eventCallback([
			{ id: '1', resourceId: 'b', start: '2017-10-01', end: '2017-10-31', title: 'event 1' },
			{ id: '2', resourceId: 'c', start: '2017-11-01', end: '2017-11-31', title: 'event 2' },
		]);
	}
}





// Register a global custom directive called v-cpm-datepicker
Vue.directive('employee-leave-records', {
    inserted (el, binding, vnode) {
        HRM_Employee_Leave_Recors.init( el, binding, vnode );
    }
});