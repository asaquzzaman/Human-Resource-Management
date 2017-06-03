Vue.component('department-del-btn', {
	template: '#tmpl-hrm-department-del-btn',
	props: ['type', 'department_id'],

	mixins: [HRM_Common_Mixin],

	methods: {
		departmentGroupDelete: function() {
			this.deleteDepartment(this.$store.state.del_dept);
		},

		departmentDelete: function() {

			this.deleteDepartment([this.department_id]);
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
                	// Display a success toast, with a title
                    toastr.success(res.success);
                    console.log(res);
                    self.$store.commit('departmentDelId', {del_dept: []});

                    res.deleted_dept.map(function(deleted_id) {
                    	var index = self.getIndex(self.$store.state.departments, deleted_id, 'id');
                    	console.log(index);
                    	self.$store.commit('afterDeleteDept', {target_del_dept: index});
                    });
                    
                },

                error: function(res) {
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		}
	}
});