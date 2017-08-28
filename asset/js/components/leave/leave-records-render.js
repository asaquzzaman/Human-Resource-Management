var HRM_Leave_Records_Render = {
	template: "tmpl-hrm-leave-records-render",

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
		this.getLeaveRecords();
	},
	methods: {
		getLeaveRecords: function() {
			var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
            },
            self = this;

            wp.ajax.send('get_leave_records', {
                data: request_data,
                success: function(res) {
                	
                    self.records = res.leave_types;
                },

                error: function(res) {
                    
                }
            });
		}
	}
}