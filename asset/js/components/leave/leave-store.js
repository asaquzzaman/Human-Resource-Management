var HRM_Leave_Store = new Vuex.Store({
	state: {
		header: {},
		is_new_leave_type_form_visible: false,
	},

	mutations: {
		header: function(state, header) {
			state.header = header.header;
		},
		isNewLeaveTypeFormVisible: function(state, is_visible) {
			state.is_new_leave_type_form_visible = is_visible.is_visible;
		},
	}
});