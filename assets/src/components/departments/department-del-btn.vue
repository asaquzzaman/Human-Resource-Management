<template>
    <div v-if="manageDepartment()" class="hrm-department-del-btn-wrap hrm-tbl-action-btn-sibling">
        <a @click.prevent="departmentGroupDelete()" v-if="type == 'group'" href="#" class="button hrm-button-secondary">Delete</a>
        <a @click.prevent="departmentDelete()" v-if="type == 'single'" href="#" class="hrm-delete">Delete</a>
    </div>
</template>
<script>
    import Mixin from './mixin'
    
    export default {
    	props: ['type', 'department_id'],

    	mixins: [Mixin],

    	methods: {
    		departmentGroupDelete: function() {
    			this.deleteDepartment(this.$store.state.departments.del_dept);
    		},

    		departmentDelete: function() {

    			this.deleteDepartment([this.department_id]);
    		},

    		deleteDepartment: function(dept_id) {
                var is_continue = true;

                this.$store.state.departments.departments.forEach(function(department) {

                    if ( dept_id.includes(department.id) ) {
                        if ( parseInt(department.number_of_employee) > 0 && is_continue ) {
                            hrm.Toastr.success('The departments are contain employee you can not remove them');
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
                        hrm.Toastr.success(res.success);
                        
                        self.$store.commit('departments/departmentDelId', {del_dept: []});

                        res.deleted_dept.map(function(deleted_id) {
                        	var index = self.getIndex(self.$store.state.departments.departments, deleted_id, 'id');
                        	
                        	self.$store.commit('departments/afterDeleteDept', {target_del_dept: index, dept_drop_down: res.dept_drop_down});
                        });
                        
                    },

                    error: function(res) {
                    	// Showing error
                        res.error.map( function( value, index ) {
                            hrm.Toastr.error(value);
                        });
                    }
                });
    		}
    	}

    }
</script>

