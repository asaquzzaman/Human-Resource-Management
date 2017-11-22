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
            var is_continue = true;

            this.$store.state.departments.forEach(function(department) {

                if ( dept_id.includes(department.id) ) {
                    if ( parseInt(department.number_of_employee) > 0 && is_continue ) {
                        toastr.success('The departments are contain employee you can not remove them');
                        is_continue = false;
                    }
                }
            });

            if (!is_continue) {
                return false;
            }
            
			var request_data = {
                _wpnonce: HRM_Vars.nonce,
                dept_id: dept_id
            },
            self = this; //The departments are contain employee you can not remove them
            
            wp.ajax.send('delete_department', {
                data: request_data,
                success: function(res) {
                	// Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.$store.commit('departmentDelId', {del_dept: []});

                    res.deleted_dept.map(function(deleted_id) {
                    	var index = self.getIndex(self.$store.state.departments, deleted_id, 'id');
                    	
                    	self.$store.commit('afterDeleteDept', {target_del_dept: index, dept_drop_down: res.dept_drop_down});
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