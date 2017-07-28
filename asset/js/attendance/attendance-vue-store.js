var HRM_Attendance_Store = new Vuex.Store({
	state: {
		attendance: [],
		search_mode: false,
		punch_in_date: '',
		punch_out_date: '',
		search_user_id: '',
		punch_in_status: true,
		punch_in_formated_date: '',
		punch_out_formated_date: ''
	},

	mutations: {
		setInitVal: function(state, res) {
			state.punch_out_date  = res.punch_out_date;
			state.punch_in_date   = res.punch_in_date;
			state.search_user_id  = res.search_user_id;
			state.punch_in_statue = res.punch_in;
			state.punch_in_formated_date = res.punch_in_formated_date;
			state.punch_out_formated_date = res.punch_out_formated_date;
		},
		setAttendance: function(state, records) {
			state.attendance = records.records; 

			if ( typeof records.punch_in_formated_date != 'undefined' ) {
				state.punch_in_formated_date = records.punch_in_formated_date; 
				state.punch_out_formated_date = records.punch_out_formated_date; 
				state.punch_in_date = records.punch_in_date,
				state.punch_out_date = records.punch_out_date
			}
			
		},

		searchMode: function(state, search) {
			state.search_mode = search.status;
		},
		setPunchInDate: function( state, date ) {
			state.punch_in_date = date.date.date;
		},
		setPunchOutDate: function( state, date ) {
			state.punch_out_date = date.date.date;
		},
		setSearchUserId: function(state, user_id) {
			state.search_user_id = user_id;
		}
	}
});