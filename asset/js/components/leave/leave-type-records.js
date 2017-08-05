var Hrm_Leave_Type_Records = {
	template: '#tmpl-hrm-leave-type-records',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {
			records: []
		}
	},

	computed: {

	},

	created: function() {
		this.getLeaveTypes();
	},
	methods: {
		getLeaveTypes: function() {
			var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
            },
            self = this;

            wp.ajax.send('get_leave_type', {
                data: request_data,
                success: function(res) {
                	
                    self.records = res.leave_types;
                },

                error: function(res) {
                    
                }
            });
		}
	}
};