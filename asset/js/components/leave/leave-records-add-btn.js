HRM_Leave_Records_Add_Btn = {
	template: '#tmpl-hrm-leave-records-add-btn',

	methods: {
		showHideLeaveRecordsForm: function() {
			this.$store.commit('isNewLeaveRecordsFormVisible', {is_visible: true});
		}
	}
};