export default {
	methods: {
		showHideExperianceForm (status, experiance) {
			var experiance   = experiance || false,
			    experiance   = jQuery.isEmptyObject(experiance) ? false : experiance;

			if ( experiance ) {
			    if ( status === 'toggle' ) {
			        experiance.editMode = experiance.editMode ? false : true;
			    } else {
			        experiance.editMode = status;
			    }
			} else {

			    this.$store.commit('profile/showHideExperianceForm', status);
			}
		},

		recordDelete (deletedId) {
			var form_data = {
	            data: {
	            	delete: deletedId,
	            	class: 'Work_Experience',
					method: 'delete'

	            },

	            success: function(res) {
	            	if (typeof args.callback === 'function') {
	                    args.callback(true, res);
	                } 
	                
	            },

	            error: function(res) {
	            	self.show_spinner = false;
	            	// Showing error
	                res.error.map( function( value, index ) {
	                    hrm.toastr.error(value);
	                });
	            }
	        };

	        this.httpRequest('hrm_delete_record', form_data);
		}
	}	
}