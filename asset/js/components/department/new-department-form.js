Vue.component('new-department-form', {
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
                _wpnonce: HRM_Admin.nonce,
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
                _wpnonce: HRM_Admin.nonce,
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
});