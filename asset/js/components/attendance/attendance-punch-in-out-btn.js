Vue.component('hrm-attendace-punch-in-out-btn',{
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
		this.attendanceInit();
	},
	methods: {
		punchIn: function() {
			var request_data = {
					_wpnonce: HRM_Admin.nonce,
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
					_wpnonce: HRM_Admin.nonce,
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

		attendanceInit: function() {
			var request_data = {
				_wpnonce: HRM_Admin.nonce,
			},
			self  = this;

			wp.ajax.send( 'attendance_init', {
                data: request_data,
                success: function(res) {
      				self.punch_in = res.punch_in;
                },

                error: function(res) {
                	
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
});