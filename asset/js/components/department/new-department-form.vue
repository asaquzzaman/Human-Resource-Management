<template>
    <div  id="hrm-hidden-form-warp" class="postbox">
        <div class="hrm-search-head">
            <h3><?php _e( 'Department', 'hrm' ); ?></h3>
        </div>
        <form id="hrm-hidden-form" action="" @submit.prevent="createNewDepartment()">
            <div id="hrm-form-field">

                <div class="hrm-form-field ">
                    <label for="title">
                        <?php _e( 'Title', 'hrm' ); ?><em>*</em>
                    </label>
                    <input type="text" required="required" v-model="title" name="title" value="" placeholder="" class="title" id="title"  data-hrm_validation="1" data-hrm_required="1" data-hrm_required_error_msg="This field is required"  />
                    <span class="hrm-clear"></span>
                    <span class="description"></span>
                </div>

                <div class="hrm-form-field ">
                    <label for="description">
                        <?php _e( 'Description', 'hrm' ); ?><em></em>
                    </label>
                    <textarea name="description" v-model="description" class="hrm-admin-notice-field" id="description"></textarea>
                    <span class="hrm-clear"></span>
                    <span class="description"></span>
                </div>

                <div class="hrm-form-field ">
                    <label for="status"><?php _e( 'Parent', 'hrm' ); ?><em>   </em></label>
                    
                    <select v-model="parent" class="status" name="status" id="status" data-placeholder="-- Chose --">
                        <option value="-1"><?php _e( '-Select-', 'hrm' ); ?></option>
                        <option v-for="department in deptDropDown" :value="department.id"><span v-html="department.hierarchical_free_pad"></span>{{ department.name }}</option>
                    </select>
                    <span class="hrm-clear"></span>
                    <span class="description"><?php _e( 'Choose Parent Department', 'hrm' ); ?></span>
                </div>

                
                <div  class="hrm-form-field ">
                    <label for="status"><?php _e( 'Status', 'hrm' ); ?><em>   </em></label>
                    <select v-model="status" class="status" name="status" id="status" data-placeholder="-- Chose --">
                        <option value="1"><?php _e( 'Enable', 'hrm' ); ?></option>
                        <option value="0"><?php _e( 'Desable', 'hrm' ); ?></option>
                    </select>
                    <span class="hrm-clear"></span>
                    <span class="description"><?php _e( 'Choose department status', 'hrm' ); ?></span>
                </div>
                
            </div>

            <div class="hrm-action-wrap">
                <input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="Submit">

                <a @click.prevent="showHideNewDepartmentForm($event)" target="_blank" href="#" class="button hrm-form-cancel"><?php _e( 'Cancel', 'hrm' ); ?></a>
                <div class="hrm-spinner" v-if="show_spinner"><?php _e( 'Saving....', 'hrm' ); ?></div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {

        mixins: [HRM_Common_Mixin],

        data: function() {
            return {
                title: '',
                description: '',
                status: '1',
                parent: '-1',
                department_id: false,
                show_spinner: false,
            }
        },

        created: function() {
            this.defaultFormValu(this.$store.state.department_id);

            if ( !this.$store.state.departments.length ) {
                this.getDepartments();
            }
        },

        watch: {
            '$store.state.department_id': function(department_id) {
                this.defaultFormValu(department_id);
            }
        },

        computed: {
            departments: function() {
                return this.$store.state.departments;
            },

            deptDropDown: function() {
                return this.$store.state.dept_drop_down;  
            }
        },

        methods: {
            defaultFormValu: function(department_id) {
                if (!department_id) {
                    return;
                }

                var dept_index = this.getIndex(this.$store.state.departments, department_id, 'id' ),
                    department = this.$store.state.departments[dept_index];

                //console.log(department);

                this.department_id = department_id;
                this.title         = department.name;
                this.description   = department.description;
                this.status        = department.active;
                this.parent        = !parseInt(department.parent) ? '-1' : department.parent;
            },

            getDepartments: function() {
                var request_data = {
                    _wpnonce: HRM_Vars.nonce,
                },
                self = this;

                wp.ajax.send('get_departments', {
                    data: request_data,
                    success: function(res) {
                        self.$store.commit( 'setDepartments', { departments: res.departments} );
                    },

                    error: function(res) {
                        
                    }
                });
            },
            showHideNewDepartmentForm: function(el) {
                var self = this;

                this.slideUp(el.target, function() {
                    self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
                });
                            
            },

            createNewDepartment: function() {
                var request_data = {
                    _wpnonce: HRM_Vars.nonce,
                    title: this.title,
                    description: this.description,
                    status: this.status,
                    parent: this.parent,
                    dept_id: this.department_id,
                    page_number: this.$route.params.page_number
                },
                is_update  = parseInt( this.department_id ) ? true : false,
                
                target_index = is_update ? this.getIndex(
                    this.$store.state.departments, this.department_id, 'id'
                ) : false,

                self = this;

                this.show_spinner = true;

                wp.ajax.send('create_new_department', {
                    data: request_data,
                    
                    success: function(res) {
                        self.show_spinner = false;
                        
                        // Display a success toast, with a title
                        toastr.success(res.success);
                        
                        self.slideUp(jQuery('.hrm-form-cancel'), function() {
                            self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
                        });

                        self.$store.commit('updateDepartment', {
                            is_update: is_update, 
                            dept_id: self.department_id,
                            target_index: target_index,
                            departments: res.departments,
                            dept_drop_down: res.dept_drop_down
                        });
                    },

                    error: function(res) {
                        self.show_spinner = false;
                        // Showing error
                        res.error.map( function( value, index ) {
                            toastr.error(value);
                        });
                    }
                });
            }
        }
    }
</script>

<!-- Vue.component('new-department-form', {
	template: '#tmpl-hrm-new-department-form',

	mixins: [HRM_Common_Mixin],

	data: function() {
		return {
			title: '',
			description: '',
			status: '1',
			parent: '-1',
            department_id: false,
			show_spinner: false,
		}
    },

    created: function() {
        this.defaultFormValu(this.$store.state.department_id);

        if ( !this.$store.state.departments.length ) {
            this.getDepartments();
        }
    },

    watch: {
        '$store.state.department_id': function(department_id) {
            this.defaultFormValu(department_id);
        }
    },

    computed: {
        departments: function() {
            return this.$store.state.departments;
        },

        deptDropDown: function() {
            return this.$store.state.dept_drop_down;  
        }
    },

	methods: {
        defaultFormValu: function(department_id) {
            if (!department_id) {
                return;
            }

            var dept_index = this.getIndex(this.$store.state.departments, department_id, 'id' ),
                department = this.$store.state.departments[dept_index];

            //console.log(department);

            this.department_id = department_id;
            this.title         = department.name;
            this.description   = department.description;
            this.status        = department.active;
            this.parent        = !parseInt(department.parent) ? '-1' : department.parent;
        },

        getDepartments: function() {
            var request_data = {
                _wpnonce: HRM_Vars.nonce,
            },
            self = this;

            wp.ajax.send('get_departments', {
                data: request_data,
                success: function(res) {
                    self.$store.commit( 'setDepartments', { departments: res.departments} );
                },

                error: function(res) {
                    
                }
            });
        },
		showHideNewDepartmentForm: function(el) {
			var self = this;

			this.slideUp(el.target, function() {
				self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
			});
						
		},

		createNewDepartment: function() {
		    var request_data = {
                _wpnonce: HRM_Vars.nonce,
                title: this.title,
                description: this.description,
                status: this.status,
                parent: this.parent,
                dept_id: this.department_id,
                page_number: this.$route.params.page_number
            },
            is_update  = parseInt( this.department_id ) ? true : false,
            
            target_index = is_update ? this.getIndex(
                this.$store.state.departments, this.department_id, 'id'
            ) : false,

            self = this;

            this.show_spinner = true;

            wp.ajax.send('create_new_department', {
                data: request_data,
                
                success: function(res) {
                	self.show_spinner = false;
                    
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.slideUp(jQuery('.hrm-form-cancel'), function() {
                    	self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
                    });

                    self.$store.commit('updateDepartment', {
                        is_update: is_update, 
                        dept_id: self.department_id,
                        target_index: target_index,
                        departments: res.departments,
                        dept_drop_down: res.dept_drop_down
                    });
                },

                error: function(res) {
                	self.show_spinner = false;
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		}
	}
}); -->