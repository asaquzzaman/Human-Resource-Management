export default {
	methods: {
		getPersonalInfo (args) {
			var self = this;
			
            var request_data = {
                data: {
                    employee_id: args.employee_id
                },
                beforeSend () {
                    self.loadingStart('hrm-general-info');
                },
                success: function(res) {
                	self.$store.commit('profile/setPersonalInfo', res);
                    self.loadingStop('hrm-general-info');
                    self.isFetchRecord = true;

                	if (typeof args.callback === 'function') {
                        args.callback(res);
                    } 
                }
            };

            self.httpRequest('hrm_get_personal_info', request_data);
		},

        getJobLocation (args) {
            var self = this;
            
            var request_data = {
                data: {
                    employee_id: args.employee_id
                },
                beforeSend () {
                    self.loadingStart('hrm-location-wrap');
                },
                success: function(res) {
                    self.$store.commit('profile/setJobLocation', res.data);
                    self.loadingStop('hrm-location-wrap');
                    self.isFetchRecord = true;

                    if (typeof args.callback === 'function') {
                        args.callback(res);
                    } 
                }
            };

            self.httpRequest('hrm_get_employee_job_location', request_data);
        }
	}
}