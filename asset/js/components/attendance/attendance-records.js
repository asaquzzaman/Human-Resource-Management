var hrm_attendace_records = {
	
	template: '#tmpl-hrm-attendance-records',
	mixins: [HRM_Common_Mixin],
	
	components: {
	    'hrm-attendace-punch-in-out-btn': hrm_attendace_punch_in_out_btn,
	    'hrm-attendace-user-search': hrm_attendace_user_search
	},
	
	data: function() {
		return {
			
		}
	},
	created: function() {
		this.getAttendance();
	},
	computed: {
		attendace_records: function() {
			return this.$store.state.attendance;
		}
	},
	methods: {
		getAttendance: function() {
			var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
            },
            self = this;

            wp.ajax.send('get_attendance', {
                data: request_data,
                success: function(res) {
                	
                    self.$store.commit( 'setAttendance', {records: res.attendance} );
                },

                error: function(res) {
                    
                }
            });
		}
	}
};