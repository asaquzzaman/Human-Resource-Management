HRM_Leave_Holidays_Add_Btn = {
	template: '#tmpl-hrm-leave-type-add-btn',

	methods: {
		showHideNewLeaveTypeForm: function() {
			this.$store.commit('isNewLeaveTypeFormVisible', {is_visible: true});
		}
	}
};