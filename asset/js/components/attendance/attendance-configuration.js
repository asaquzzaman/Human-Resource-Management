var hrm_attendace_configuration = {
	template: '#tmpl-hrm-attendance-configuration',
	
	mixins: [HRM_Common_Mixin],
	
	data: function() {
		return {
			hrm_is_multi_attendance: false,
			office_start: '',
			office_closed: '',
		}
	},

	computed: {

	},

	created: function() {
		this.$on('hrm_date_picker', this.setDateTime);
	},
	methods: {
		setDateTime: function(date_time) {

			if( date_time.field == 'datetimepicker_from' ) {
				this.office_start = date_time.date_time;
			}

			if( date_time.field == 'datetimepicker_to' ) {
				this.office_closed = date_time.date_time;
			}
		},
		saveConfiguration: function() {
			var request_data = {
					_wpnonce: hrm_ajax_data.nonce,
					hrm_is_multi_attendance: this.hrm_is_multi_attendance,
					office_start: this.office_start,
					office_closed: this.office_closed

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
			console.log( this.hrm_is_multi_attendance, this.office_start, this.office_closed );
		}
	}
};