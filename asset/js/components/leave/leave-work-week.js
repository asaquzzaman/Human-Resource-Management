var Hrm_Leave_Work_Week = {
	template: '#tmpl-hrm-leave-work-week',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
		data: function() {
		return {
			saturday: 'full',
			sunday: 'full',
			monday: 'full',
			tuesday: 'full',
			wednesday: 'full',
			thursday: 'full',
			friday: 'full'
			
		}
	},

	computed: {

	},

	created: function() {
		this.getWorkWeek();
	},
	methods: {
		getWorkWeek: function() {
			var request_data = {
                _wpnonce: HRM_Vars.nonce,
            },
            self = this;

			wp.ajax.send('get_work_week', {
                data: request_data,
                
                success: function(res) {
                    // Display a success toast, with a title
                    //toastr.success(res.success);
                    
					self.saturday  = res.work_week.saturday;
					self.sunday    = res.work_week.sunday;
					self.monday    = res.work_week.monday;
					self.tuesday   = res.work_week.tuesday;
					self.wednesday = res.work_week.wednesday;
					self.thursday  = res.work_week.thursday;
					self.friday    =  res.work_week.friday;
				
                },

                error: function(res) {
                	self.show_spinner = false;
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		},
		saveWorkWeek: function() {
			
		    var request_data = {
                _wpnonce: HRM_Vars.nonce,
                saturday: this.saturday,
				sunday: this.sunday,
				monday: this.monday,
				tuesday: this.tuesday,
				wednesday: this.wednesday,
				thursday: this.thursday,
				friday: this.friday
            };
            

            wp.ajax.send('save_work_week', {
                data: request_data,
                
                success: function(res) {
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    
                },

                error: function(res) {
                	self.show_spinner = false;
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		}
	}
};