export default {
	data () {
		return {
			nameSpace: 'profile'
		}
	},
	methods: {
		showHideNewRecordForm (status, experiance) {
			var experiance   = experiance || false,
			    experiance   = jQuery.isEmptyObject(experiance) ? false : experiance;

			if ( experiance ) {
			    if ( status === 'toggle' ) {
			        experiance.editMode = experiance.editMode ? false : true;
			    } else {
			        experiance.editMode = status;
			    }
			} else {

			    this.$store.commit(this.nameSpace+'/showHideNewRecordForm', status);
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
		},

		addNewRecord (args) {
			var self = this;

			var form_data = {
                data: args.data,

                success: function(res) {
                	self.$store.commit( self.nameSpace + '/setRecord', res.data );

                	if (typeof args.callback === 'function') {
                        args.callback(true, res);
                    } 
                    
                    hrm.Toastr.success(res.message);
                },

                error: function(res) {

                	// Showing error
                    res.error.map( function( value, index ) {
                        hrm.Toastr.error(value);
                    });

                    if (typeof args.callback === 'function') {
                        args.callback(false, res);
                    } 
                }
            };

            this.httpRequest('hrm_insert_record', form_data);
		},

		getRecords () {
			var self = this;

			var postData = {
				'class': 'Work_Experience',
				'method': 'gets',
				'transformers': 'Work_Experiance_Transformer'
			};
			
            var request_data = {
                data: postData,
                success: function(res) {
                	res.data.forEach(function(record) {
                		self.recordMeta(record);
                	});
                    
                    self.$store.commit( self.nameSpace + '/setRecords', res.data );
                }
            };

            self.httpRequest('hrm_get_records', request_data);
		},

		recordMeta (record) {
			record.editMode = false;
		},
	}	
}