Vue.component('department-table', {
	template: '#tmpl-hrm-department-table',

	created: function() {
		this.getDepartments();
	},

	methods: {
		getDepartments: function() {
			var request_data = {
                _wpnonce: HRM_Admin.nonce,
            },
            self = this;

            wp.ajax.send('get_departments', {
                data: request_data,
                success: function(res) {
                	
                },

                error: function(res) {
                	
                }
            });
		}
	}
});