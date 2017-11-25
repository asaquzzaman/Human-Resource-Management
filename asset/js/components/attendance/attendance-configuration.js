var hrm_attendace_configuration = {
	template: '#tmpl-hrm-attendance-configuration',
	
	mixins: [HRM_Common_Mixin],
	
	data: function() {
		return {
			
		}
	},

	computed: {
		office_start_with_date_time: function() {
			return this.$store.state.office_start_with_date_time;
		},

		office_closed_with_date_time: function() {
			return this.$store.state.office_closed_with_date_time;
		},
		hrm_is_multi_attendance: {
			get: function() {
				return this.$store.state.hrm_is_multi_attendance;
			},

			set: function(val) {
				this.$store.commit('setMultiAttendance', val);
			}
		},

		allow_ip: {
			get: function() {
				return this.$store.state.allow_ip;
			},
			
			set: function(val) {
				this.$store.commit('setAllowIP', val);
			}
		}
	},

	created: function() {
		
		this.attendanceInit();
		this.$on('hrm_date_picker', this.setDateTime);
	},
	methods: {
		attendanceInit: function() {
			var request_data = {
				_wpnonce: HRM_Vars.nonce,
			},
			self  = this;

			wp.ajax.send( 'attendance_init', {
                data: request_data,
                success: function(res) {
      				self.$store.commit( 'setInitVal', res );
                },

                error: function(res) {
                	
                }
            });
		},
		setDateTime: function(date_time) {

			if( date_time.field == 'datetimepicker_from' ) {
				//this.office_start = date_time.date_time;
				this.$store.commit( 'office_start', date_time );
			}

			if( date_time.field == 'datetimepicker_to' ) {
				//this.office_closed = date_time.date_time;
				this.$store.commit( 'office_closed', date_time );
			}
		},
		saveConfiguration: function() {
			var request_data = {
					_wpnonce: HRM_Vars.nonce,
					hrm_is_multi_attendance: this.hrm_is_multi_attendance,
					office_start: this.$store.state.office_start_with_date_time,
					office_closed: this.$store.state.office_closed_with_date_time,
					allow_ip: this.$store.state.allow_ip

				},
				self = this;
			
			this.punch_in = 'disable';
			
			wp.ajax.send('attendance_configuration', {
                data: request_data,
                success: function(res) {
                	// Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.$store.commit( 'setAttendance', {records: res.attendance} );
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
};