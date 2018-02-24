export default {
	data () {
		return {
			nameSpace: 'employee',
			modelName: '',
			modelTransformer: ''
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

		recordDelete (deletedId, callback) {
			var self = this;

			var form_data = {
	            data: {
	            	delete: deletedId,
	            	class: self.modelName,
					method: 'delete'
	            },

	            success: function(res) {
	            	
	            	self.$store.commit(self.nameSpace + '/afterDelete', deletedId);
	            	if (typeof callback === 'function') {
	                    callback.call(self, deletedId);
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

		updateRecord (args) {
			var self = this;

			var form_data = {
                data: args.data,

                success: function(res) {
                	self.recordMeta(res.data);

                	self.$store.commit( self.nameSpace + '/updateRecord', res.data );

                	if (typeof args.callback === 'function') {
                        args.callback.call(self, true, res);
                    } 
                    
                },

                error: function(res) {
                	
                	// Showing error
                    res.error.map( function( value, index ) {
                        hrm.toastr.error(value);
                    });

                    if (typeof args.callback === 'function') {
                        args.callback.call(self, false, res);
                    } 
                }
            };

            this.httpRequest('hrm_insert_employee', form_data);
		},

		addNewRecord (args) {
			var self = this;

			var form_data = {
                data: args.data,

                success: function(res) {
                	self.$store.commit( self.nameSpace + '/setRecord', res.data );
                	self.$store.commit( self.nameSpace + '/updatePaginationAfterNewRecord' );

                	if (typeof args.callback === 'function') {
                        args.callback.call(self, true, res);
                    } 
                    
                    hrm.Toastr.success(res.message);
                },

                error: function(res) {

                	// Showing error
                    res.error.map( function( value, index ) {
                        hrm.Toastr.error(value);
                    });

                    if (typeof args.callback === 'function') {
                        args.callback.call(self, false, res);
                    } 
                }
            };

            this.httpRequest('hrm_insert_employee', form_data);
		},

		getRecords (args) {
			var self = this;

			if (self.$route.query.filter == 'active') {
				self.filter(args);
			} else {
				self.fetchRecords(args);
			}
		},

		fetchRecords () {
			var self = this;

			var postData = {
				'page': typeof this.$route.params.current_page_number == 'undefined'
					? '1'
					: this.$route.params.current_page_number
			};
			
            var request_data = {
                data: postData,
                success: function(res) {
                	res.data.forEach(function(record) {
                		self.recordMeta(record);
                	});
                    
                    self.$store.commit( self.nameSpace + '/setRecords', res.data );
                    self.$store.commit( self.nameSpace + '/setPagination', res.meta.pagination );
                }
            };

            self.httpRequest('hrm_get_employees', request_data);
		},

		recordMeta (record) {
			record['editMode'] = false;
		},

		filter (callback) {
			var self = this;
			this.$route.query['page'] = this.$route.params.current_page_number;

			var form_data = {
	            data: this.$route.query,

	            success: function(res) {
	            	res.data.forEach(function(record) {
                		self.recordMeta(record);
                	});

	            	self.$store.commit(self.nameSpace + '/setRecords', res.data);
	            	self.$store.commit( self.nameSpace + '/setPagination', res.meta.pagination );

	            	if (typeof callback === 'function') {
	                    callback.call(self, true, res);
	                } 
	                
	            },

	            error: function(res) {
	            	self.show_spinner = false;
	            	// Showing error
	                res.error.map( function( value, index ) {
	                    hrm.toastr.error(value);
	                });

	                if (typeof args.callback === 'function') {
	                    callback.call(self, false, res);
	                } 
	            }
	        };

	        this.httpRequest('hrm_experiance_filter', form_data);
		},

		getDesignations (args) {
			var self = this;

			var postData = {
				'class': 'Designation',
				'method': 'gets',
				'transformers': 'designation_Transformer',
				'per_page': '1000'
			};
			
            var request_data = {
                data: postData,
                success: function(res) {
                	if(typeof args.callback != 'undefined' ) {
                		args.callback(res);
                	}
                }
            };

            self.httpRequest('hrm_get_records', request_data);
		},

		getLocations (args) {
			var self = this;

			var postData = {
				'class': 'Location',
				'method': 'gets',
				'transformers': 'Location_Transformer',
				'per_page': '1000'
			};
			
            var request_data = {
                data: postData,
                success: function(res) {
                	if(typeof args.callback != 'undefined' ) {
                		args.callback(res);
                	}
                }
            };

            self.httpRequest('hrm_get_records', request_data);
		},
	}		
}