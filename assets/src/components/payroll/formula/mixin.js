export default {
	data () {
		return {
			nameSpace: 'formula',
			isFetchRecord: false
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
	            	class: 'Formula',
					method: 'delete'
	            },

	            success: function(res) {
	            	
	            	self.$store.commit(self.nameSpace + '/afterDelete', deletedId);
	            	if (typeof callback === 'function') {
	                    callback(deletedId);
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

	        this.httpRequest('hrm_delete_formula', form_data);
		},

		updateRecord (args) {
			var self = this;

			var form_data = {
                data: args.data,

                beforeSend () {
                	self.loadingStart(
                		'hrm-formula-form', 
                		{animationClass: 'preloader-update-animation'}
                	);
                },

                success: function(res) {
                	self.recordMeta(res.data);

                	self.$store.commit( self.nameSpace + '/updateRecord', {
                		id: args.data.id,
                		record: res.data 

                	});
                	self.loadingStop('hrm-formula-form');

                	if (typeof args.callback === 'function') {
                        args.callback(true, res);
                    } 
                },

                error: function(res) {
                	// Showing error
                    res.error.map( function( value, index ) {
                        hrm.Toastr.error(value);
                    });

                    self.loadingStop('hrm-formula-form');

                    if (typeof args.callback === 'function') {
                        args.callback(false, res);
                    } 
                }
            };

            this.httpRequest('hrm_update_formula', form_data);
		},

		addNewRecord (args) {
			var self = this;

			var form_data = {
                data: args.data,

                beforeSend () {
                	self.loadingStart(
                		'hrm-formula-form', 
                		{animationClass: 'preloader-update-animation'}
                	);
                },

                success: function(res) {
                	self.recordMeta(res.data);
                	self.$store.commit( self.nameSpace + '/setRecord', res.data );
                	self.$store.commit( self.nameSpace + '/updatePaginationAfterNewRecord' );

                	self.loadingStop('hrm-formula-form');

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

                    self.loadingStop('hrm-formula-form');

                    if (typeof args.callback === 'function') {
                        args.callback(false, res);
                    } 
                }
            };

            this.httpRequest('hrm_insert_formula', form_data);
		},

		checkFormulaValidity (args) {
			var self = this;

			var form_data = {
                data: args.data,

                beforeSend () {
                	self.loadingStart(
                		'hrm-formula-form', 
                		{animationClass: 'preloader-update-animation'}
                	);
                },

                success: function(res) {
             
                	self.loadingStop('hrm-formula-form');

                    hrm.Toastr.success(res.message);

                	if (typeof args.callback === 'function') {
                        args.callback(true, res);
                    } 
                    
                },

                error: function(res) {

                	// Showing error
                    res.error.map( function( value, index ) {
                        hrm.Toastr.error(value);
                    });

                    self.loadingStop('hrm-formula-form');

                    if (typeof args.callback === 'function') {
                        args.callback(false, res);
                    } 
                }
            };

            this.httpRequest('hrm_check_formula_validity', form_data);
		},

		fetchRecords () {
			var self = this;

			var postData = {
				'class': 'Formula',
				'method': 'gets',
				'transformers': 'Formula_Transformer',
				'page': this.$route.params.current_page_number
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

            self.httpRequest('hrm_get_records', request_data);
		},

		editFormValidation (fields, postData) {
        	var isFormValidate = true;

			fields.forEach(function(val) {
				if(
					val.editable !== false
						&&
					val.required === true
						&&
					!postData[val.name]
				) {
					hrm.Toastr.error(val.label + ' is required!');
					isFormValidate = false;
				}
			});

			return isFormValidate;
        }
	}	
}