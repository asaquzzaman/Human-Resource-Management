export default {
	methods: {
		getAttendance: function() {

			var request_data = {
                _wpnonce: HRM_Vars.nonce,
                search: this.$route.query,
            },
            
            self = this;

            wp.ajax.send('get_attendance', {
                data: request_data,
                beforeSend () {
                    self.loadingStart('hrm-list-table');
                },
                success: function(res) {
                	
                    self.$store.commit( 'attendance/setAttendance', {
                    	records: res.attendance, 
                    	punch_in_formated_date: res.punch_in_formated_date,
                    	punch_out_formated_date: res.punch_out_formated_date,
                    	punch_in_date: res.punch_in_date,
                    	punch_out_date: res.punch_out_date,
                        totalOfficeTime: res.total_time

                    } );
                    self.loadingStop('hrm-list-table');
                    self.isFetchRecord = true;
                },

                error: function(res) {
                    
                }
            });
		},
	}
}