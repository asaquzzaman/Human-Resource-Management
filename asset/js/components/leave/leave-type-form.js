var Hrm_Leave_Type_Form = {
	template: '#tmpl-hrm-leave-type-form',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {
			entitle_from: '',
			entitle_to: '',
			leave_type: '',
			entitlement: ''
		}
	},

	computed: {

	},

	created: function() {
		this.$on('hrm_date_picker', this.setDateTime);
	},
	methods: {
		setDateTime: function(date) {
			if (date.field == 'datepicker_from') {
				this.entitle_from = date.date
			}

			if (date.field == 'datepicker_to') {
				this.entitle_to = date.date
			}
		},
		show_hide_new_leave_type_form: function(el) {
			var self = this;

			this.slideUp(el.target, function() {
				self.$store.commit('isNewLeaveTypeFormVisible', {is_visible: false});
			});
						
		},

		createNewLeaveType: function() {
		    var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
                entitlement: this.entitlement,
                leave_type: this.leave_type,
                entitle_from: this.entitle_from,
                entitle_to: this.entitle_to,
            },
            
            // is_update  = parseInt( this.department_id ) ? true : false,
            
            // target_index = is_update ? this.getIndex(
            //     this.$store.state.departments, this.department_id, 'id'
            // ) : false,

            self = this;

            this.show_spinner = true;

            wp.ajax.send('create_new_leave_type', {
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
};