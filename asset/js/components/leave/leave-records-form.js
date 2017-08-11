var Hrm_Leave_Records_Form = {
	template: '#tmpl-hrm-leave-records-form',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {
			employees: [],
			emp_id: '',
			apply_to: '',
			leave_type_id: '',
			leave_types: [],
			administrators: [],
			leave_status: '',
			start_time: '',
			end_time: '',
			leave_comments: '',
			emp_leave_with_type_record: [],
			work_week: []
		}
	},

	computed: {

	},

	created: function() {
		this.$on('hrm_date_picker', this.setDateTime);
		this.getInitialData();
	},
	methods: {
		getInitialData: function() {
			var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
            },
            self = this;

			wp.ajax.send('get_leave_records_init_data', {
                data: request_data,
                
                success: function(res) {
					self.leave_types    = res.leave_types;
					self.employees      = res.employess;
					self.administrators = res.apply_to;
					self.emp_leave_with_type_record  = res.emp_leave_with_type_record;
					//self.holiday_name_index       = res.holiday_name_index;
					self.work_week      = res.work_week;
                },

                error: function(res) {
 
                }
            });
		},
		setDateTime: function(date) {
			if (date.field == 'datepicker_from') {
				this.from = date.date
			}

			if (date.field == 'datepicker_to') {
				this.to = date.date
			}
		},
		show_hide_new_leave_records_form: function(el) {
			var self = this;

			this.slideUp(el.target, function() {
				self.$store.commit('isNewLeaveRecordsFormVisible', {is_visible: false});
			});
						
		},

		createNewHolidays: function() {
			
		    var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
                name: this.name,
                from: this.from,
                to: this.to,
                description: this.description,
            },
            
            // is_update  = parseInt( this.department_id ) ? true : false,
            
            // target_index = is_update ? this.getIndex(
            //     this.$store.state.departments, this.department_id, 'id'
            // ) : false,

            self = this;

            this.show_spinner = true;

            wp.ajax.send('create_new_holidays', {
                data: request_data,
                
                success: function(res) {
                	self.show_spinner = false;
                    
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.slideUp(jQuery('.hrm-form-cancel'), function() {
                    	self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
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