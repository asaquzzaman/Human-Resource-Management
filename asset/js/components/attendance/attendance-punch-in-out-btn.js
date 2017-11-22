var hrm_attendace_punch_in_out_btn = {
	template: '#tmpl-hrm-attendance-punch-in-out-btn',
	mixins: [HRM_Common_Mixin],
	data: function() {
		return {
			press_punch_in_btn: false,
			press_punch_our_btn: false,
			punch_out_disable: false,
			punch_id: 0,
		}
	},
	created: function() {
		//this.punch_in = this.$store.state.punch_in_status;
	},
	methods: {
		punchIn: function() {

			//for preventing multipule submit
			if ( this.press_punch_in_btn ) {
				return false;
			}

			//for preventing multipule submit
			this.press_punch_in_btn = true;

			var request_data = {
					_wpnonce: HRM_Vars.nonce,
				},
				self = this;
			
			wp.ajax.send('punch_in', {
                data: request_data,
                success: function(res) {
                	// Display a success toast, with a title
                    toastr.success(res.success);
                    //self.punch_id = res.punch_id;
                    //self.punch_id = res.punch_in_status;

                    self.$store.commit( 'setAttendance', {records: res.attendance} );
                    self.$store.commit( 'punch_in', { status: 'disable' } );

                    //for preventing multipule submit
                    self.press_punch_in_btn = false;
                },

                error: function(res) {
                	//for preventing multipule submit
                    self.press_punch_in_btn = false;
                	
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		},

		punchOut: function() {
			//for preventing multipule submit
			if ( this.press_punch_our_btn ) {
				return false;
			}

			//for preventing multipule submit
			this.press_punch_our_btn = true;

			var request_data = {
					_wpnonce: HRM_Vars.nonce,
				},
				self = this;

			self.punch_out_disable = true;
			
			wp.ajax.send('punch_out', {
                data: request_data,
                success: function(res) {
                	// Display a success toast, with a title
                    toastr.success(res.success);
					self.punch_out_disable = false;

					self.$store.commit( 'setAttendance', {records: res.attendance} );
                    self.$store.commit( 'punch_in', { status: res.punch_in_status } );

                    //for preventing multipule submit
					self.press_punch_our_btn = false;
                },

                error: function(res) {
                	self.punch_out_disable = false;
                	//for preventing multipule submit
					self.press_punch_our_btn = false;

                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		},

		isDisabled: function() {
			if ( this.$store.state.punch_in_status == 'enable' ) {
				return false;
			}

			return true;
		}
	}
};