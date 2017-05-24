Vue.component('department-add-btn', {
	template: '#tmpl-hrm-department-add-btn',

	methods: {
		showHideNewDepartmentForm: function() {
			this.$store.commit('isNewDepartmentForVisible', {is_visible: true});
		}
	}
});