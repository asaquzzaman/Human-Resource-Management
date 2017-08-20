var Hrm_Leave_Records_Form = {
	template: '#tmpl-hrm-leave-records-form',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {
			employees: [],
			emp: '',
			apply_to: '',
			leave_type: '',
			leave_types: [],
			administrators: [],
			leave_status: '',
			start_time: '',
			end_time: '',
			leave_comments: '',
			emp_leave_with_type_record: [],
			work_week: [],
			leave_entitlements: [],
			apply_leave_date: [],
			calendar_evt_id: [],
			disable_leave_type: false
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
					self.leave_entitlements     = res.leave_entitlements;
					self.work_week      = res.work_week;
					self.emp = res.current_user;
					self.leave_status = 1;
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

		createNewLeave: function() {
			
		    var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
                leave_status: this.leave_status,
                leave_comments: this.leave_comments,
                leave_type_id: this.leave_type.id,
                emp_id: this.emp.ID,
                time: this.apply_leave_date,
                disable_leave_type: this.disable_leave_type,
                class: 'Leave',
                method: 'create'
            },
            
            // is_update  = parseInt( this.department_id ) ? true : false,
            
            // target_index = is_update ? this.getIndex(
            //     this.$store.state.departments, this.department_id, 'id'
            // ) : false,

            self = this;

            this.show_spinner = true;

            wp.ajax.send('create_new_leave', {
                data: request_data,
                
                success: function(res) {
                	self.show_spinner = false;
                    
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.slideUp(jQuery('.hrm-form-cancel'), function() {
                    	//self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
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
		},

		change_leve_type_statue: function() {
			jQuery.each(this.calendar_evt_id, function(index, event_id) {
				jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('removeEvents', event_id);
			});
			
			this.calendar_evt_id  = [];
        	this.apply_leave_date = [];
		}
	}
};