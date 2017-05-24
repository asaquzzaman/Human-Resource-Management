var HRM_Admin_Store = new Vuex.Store({
	state: {
		is_new_department_form_visible: false
	},

	mutations: {
		isNewDepartmentForVisible: function(state, is_visible) {
			state.is_new_department_form_visible = is_visible.is_visible;
		}
	}
});