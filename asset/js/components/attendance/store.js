export default {
	state: {
		attendance: [],
		search_mode: false,
		punch_in_date: '',
		punch_out_date: '',
		search_user_id: '-1',
		punch_in_status: 'disable',
		punch_in_formated_date: '',
		punch_out_formated_date: '',
		hrm_is_multi_attendance: 0,
		office_start: '',
		office_closed: '',
		office_start_with_date_time: '',
		office_closed_with_date_time: '',
		allow_ip: '',
		employessDropDown: []
	},

	mutations: {
		setInitVal: function(state, res) {
			state.punch_out_date               = res.punch_out_date;
			state.punch_in_date                = res.punch_in_date;
			//state.search_user_id               = res.search_user_id;
			state.punch_in_status              = res.punch_in;
			state.punch_in_formated_date       = res.punch_in_formated_date;
			state.punch_out_formated_date      = res.punch_out_formated_date;
			state.hrm_is_multi_attendance      = res.hrm_is_multi_attendance;
			state.office_start                 = res.office_start;
			state.office_closed                = res.office_closed;
			state.office_start_with_date_time  = res.office_start_with_date_time;
			state.office_closed_with_date_time = res.office_closed_with_date_time;
			state.employessDropDown            = res.employees_dropdown;
			state.allow_ip                     = res.allow_ip;
		},
		setAttendance: function(state, records) {
			state.attendance = records.records; 

			if ( typeof records.punch_in_formated_date != 'undefined' ) {
				state.punch_in_formated_date  = records.punch_in_formated_date; 
				state.punch_out_formated_date = records.punch_out_formated_date; 
				state.punch_in_date           = records.punch_in_date,
				state.punch_out_date          = records.punch_out_date
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
		},
		office_start: function( state, date_time ) {
			state.office_start_with_date_time = date_time.date_time
		},
		office_closed: function( state, date_time ) {
			state.office_closed_with_date_time = date_time.date_time
		},
		setMultiAttendance: function(state, multi) {
			state.hrm_is_multi_attendance = multi;
		},
		punch_in: function(state, status) {
			state.punch_in_status = status.status;
		},
	}
};