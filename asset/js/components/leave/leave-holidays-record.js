var Hrm_Leave_Holidays_Record = {
	template: '#tmpl-hrm-leave-holidays-record',
	
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
		this.getHolidays();
	},
	methods: {
		getHolidays: function() {
			var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
            },
            self = this;

            wp.ajax.send('get_holidays', {
                data: request_data,
                success: function(res) {
                	
                    self.records = res.holidays;
                },

                error: function(res) {
                    
                }
            });
		}
	}
};