var HRM_Attendance_Store = new Vuex.Store({
	state: {
		attendance: []
	},

	mutations: {
		setAttendance: function(state, records) {
			state.attendance = records.records;
		}
	}
});