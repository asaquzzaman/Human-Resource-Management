var hrm_attendace_punch_in_out_btn = {
	template: '#tmpl-hrm-attendance-punch-in-out-btn',
	mixins: [HRM_Common_Mixin],
	data: function() {
		return {
			punch_in: 'enable',
			punch_out_disable: false,
			punch_id: 0,
		}
	},
	created: function() {
		this.punch_in = this.$store.state.punch_in_status;
	},
	methods: {
		punchIn: function() {
			var request_data = {
					_wpnonce: hrm_ajax_data.nonce,
				},
				self = this;
			
			this.punch_in = 'disable';

			wp.ajax.send('punch_in', {
                data: request_data,
                success: function(res) {
                	// Display a success toast, with a title
                    toastr.success(res.success);
                    self.punch_id = res.punch_id;
                    self.punch_id = res.punch_in_status;

                    self.$store.commit( 'setAttendance', {records: res.attendance} );
                },

                error: function(res) {
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		},

		punchOut: function() {
			var request_data = {
					_wpnonce: hrm_ajax_data.nonce,
				},
				self = this;

			self.punch_out_disable = true;
			
			wp.ajax.send('punch_out', {
                data: request_data,
                success: function(res) {
                	// Display a success toast, with a title
                    toastr.success(res.success);
					self.punch_in          = res.punch_in_status;
					self.punch_out_disable = false;

					self.$store.commit( 'setAttendance', {records: res.attendance} );
                },

                error: function(res) {
                	self.punch_out_disable = false;
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		},

		isDisabled: function() {
			if ( this.punch_in == 'enable' ) {
				return false;
			}

			return true;
		}
	}
};