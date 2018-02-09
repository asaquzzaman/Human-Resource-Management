export default {
	data () {
		return {
			
		}
	},
	methods: {
		getHeaderBlock (args) {
			var self = this;

			var form_data = {
	            data: {},
	            success: function(res) {
	            	if (typeof args.callback != 'undefined') {
	            		args.callback(res);
	            	}
	            },
	        };

	        this.httpRequest('hrm_get_dashboard_header_block', form_data);
		},

		getDashboardAttendance () {
			var self = this;

			var form_data = {
	            data: {},
	            success: function(res) {
	            	if (typeof args.callback != 'undefined') {
	            		args.callback(res);
	            	}
	            },
	        };

	        this.httpRequest('hrm_get_dashboard_attendance', form_data);
		}
	}
}