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

		getDashboardAttendance (args) {
			var self = this;
			args = args || {};

			var form_data = {
	            data: {},
	            success: function(res) {
	            	if (typeof args.callback != 'undefined') {
	            		args.callback(res);
	            	}
	            },
	        };

	        this.httpRequest('hrm_get_dashboard_attendance', form_data);
		},

		getDashboardLeaves (args) {
			var self = this;
			args = args || {};

			var form_data = {
	            data: {},
	            success: function(res) {
	            	if (typeof args.callback != 'undefined') {
	            		args.callback(res);
	            	}
	            },
	        };

	        this.httpRequest('hrm_get_dashboard_leaves', form_data);
		},

		getDashboardNotices (args) {
			var self = this;
			args = args || {};

			var form_data = {
	            data: {},
	            success: function(res) {
	            	if (typeof args.callback != 'undefined') {
	            		args.callback(res);
	            	}
	            },
	        };

	        //this.httpRequest('hrm_get_dashboard_notices', form_data);
		},

		getDashboardBirthdays (args) {
			var self = this;
			args = args || {};

			var form_data = {
	            data: {},
	            success: function(res) {
	            	if (typeof args.callback != 'undefined') {
	            		args.callback(res);
	            	}
	            },
	        };

	        this.httpRequest('hrm_get_dashboard_birthdays', form_data);
		}
	}
}