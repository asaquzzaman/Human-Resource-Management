Vue.component('department-del-btn', {
	template: '#tmpl-hrm-department-del-btn',
	props: ['type', 'department_id'],

	mixins: [HRM_Common_Mixin],

	methods: {
		showHideNewDepartmentForm: function() {
			
		}
	}
});