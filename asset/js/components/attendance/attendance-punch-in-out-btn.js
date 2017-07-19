Vue.component('hrm-attendace-punch-in-out-btn',{
	template: '#tmpl-hrm-attendance-punch-in-out-btn',
	mixins: [HRM_Common_Mixin],
	data: function() {
		return {
			punch_in: 'enable'
		}
	},
	created: function() {
		this.attendanceInit();
	},
	methods: {
		punchIn: function() {
			var request_data = {
				_wpnonce: HRM_Admin.nonce,
			}

			wp.ajax.send('punch_in', {
                data: request_data,
                success: function(res) {
                	// Display a success toast, with a title
                    toastr.success(res.success);
                    
                    
                    
                },

                error: function(res) {
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

			wp.ajax.send('attendance_init', {
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