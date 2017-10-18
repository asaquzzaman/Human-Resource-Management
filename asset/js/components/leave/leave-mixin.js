import Vue from './../../vue/vue';

export default Vue.mixin({
	methods: {
		showHideLeaveRecordsForm (status, leave) {
			var leave   = leave || false,
			    leave   = jQuery.isEmptyObject(leave) ? false : leave;

			if ( leave ) {
			    if ( status === 'toggle' ) {
			        leave.edit_mode = leave.edit_mode ? false : true;
			    } else {
			        leave.edit_mode = status;
			    }
			} else {
			    this.$store.commit('showHideleaveForm', status);
			}
		},

		getLeaveRecords (args) {
			var self = this;
			var pre_define = {
					data: {},
					callback: false
				};

			var args = jQuery.extend(true, pre_define, args );
			
            var request_data = {
                data: args,
                success (res) {
                    self.$store.commit('getLeaveRecords', res.data);

                    if (typeof pre_define === 'function') {
                    	args.callback(res.data);
                    }
                },

                error (res) {
                    
                }
            };

            self.httpRequest('get_leave_records', request_data);
		}
	},
});