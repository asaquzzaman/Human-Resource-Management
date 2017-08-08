var Hrm_Leave_Holidays_Form = {
	template: '#tmpl-hrm-leave-holidays-form',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {
			name: '',
			from: '',
			to: '',
			description: '',
			records: []
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
				this.from = date.date
			}

			if (date.field == 'datepicker_to') {
				this.to = date.date
			}
		},
		show_hide_new_leave_type_form: function(el) {
			var self = this;

			this.slideUp(el.target, function() {
				self.$store.commit('isNewLeaveTypeFormVisible', {is_visible: false});
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