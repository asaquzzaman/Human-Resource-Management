Vue.component('department-edit-btn', {
	template: '#tmpl-hrm-department-edit-btn',
	props: ['department_id'],

	mixins: [HRM_Mixin],

	methods: {
		departmentEdit: function() {
			this.$store.commit('department_edit_id', {department_id: this.department_id});
			this.$store.commit('isNewDepartmentForVisible', {is_visible: true});
		}
	}
});