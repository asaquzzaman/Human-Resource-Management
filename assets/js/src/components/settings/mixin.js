
export default {
	methods: {
		updateSettings (args) {
			var request = {
				data: args.data,
				success (res) {
					if (typeof args.callback === 'function') {
						args.callback(res);
					}
				}
			};
			
			this.httpRequest('update_settings', request);
		},

		getSettings (key, pre_define ) {
			
            var pre_define  = pre_define || false,
                settings  = HRM_Vars.settings;

            if ( !HRM_Vars.settings[key] ) {
                return pre_define;
            }

            return HRM_Vars.settings[key];
        }
	}
};