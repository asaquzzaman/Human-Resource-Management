Vue.component('department-del-btn', {
	template: '#tmpl-hrm-department-del-btn',
	props: ['type', 'department_id'],

	mixins: [HRM_Common_Mixin],

	methods: {
		departmentGroupDelete: function() {
			this.deleteDepartment(this.$store.state.del_dept);
		},

		departmentDelete: function() {
			this.deleteDepartment(this.$store.state.del_dept);
		},

		deleteDepartment: function(dept_id) {
			var request_data = {
                _wpnonce: HRM_Admin.nonce,
                dept_id: dept_id
            },
            self = this;

            wp.ajax.send('delete_department', {
                data: request_data,
                success: function(res) {
                    self.$store.commit('departmentDelId', {del_dept: []});
                },

                error: function(res) {
                	
                }
            });
		}
	}
});