export default {
	data () {
		return {
			nameSpace: 'shift',
			modelName: 'Shift',
            modelTransformer: 'Shift_Transformer',
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
	            	class: this.modelName,
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

	        this.httpRequest('hrm_delete_record', form_data);
		},

		updateRecord (args) {
			var self = this;

			var form_data = {
                data: args.data,

                beforeSend () {
                	self.loadingStart(
                		'hrm-edit-form-'+args.data.id, 
                		{animationClass: 'preloader-update-animation'}
                	);
                },

                success: function(res) {
                	self.recordMeta(res.data);

                	self.$store.commit( self.nameSpace + '/updateRecord', res.data );
                	self.loadingStop('hrm-edit-form-'+res.data.id);

                	if (typeof args.callback === 'function') {
                        args.callback(true, res);
                    } 
                    
                },

                error: function(res) {
                	
                	// Showing error
                    res.error.map( function( value, index ) {
                        hrm.toastr.error(value);
                    });

                    if (typeof args.callback === 'function') {
                        args.callback(false, res);
                    } 
                }
            };

            this.httpRequest('hrm_update_record', form_data);
		},

		addNewRecord (args) {
			var self = this;

			var form_data = {
                data: args.data,

                beforeSend () {
                	// self.loadingStart(
                	// 	'hrm-hidden-form', 
                	// 	{animationClass: 'preloader-update-animation'}
                	// );
                },

                success: function(res) {
                	self.recordMeta(res.data);
                	self.$store.commit( self.nameSpace + '/setRecord', res.data );
                	self.$store.commit( self.nameSpace + '/updatePaginationAfterNewRecord' );

                	self.loadingStop('hrm-hidden-form');

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

            this.httpRequest('hrm_insert_shift', form_data);
		},

		getRecords (args) {
			var self = this;
			args = args || {};
			this.$route.query['page'] = this.$route.params.current_page_number;
			
			var form_data = {
	            data: this.$route.query,

	            beforeSend () {
	            	self.loadingStart('hrm-list-table');
	            },

	            success: function(res) {
	            	res.data.forEach(function(record) {
                		self.recordMeta(record);
                	});

	            	self.$store.commit(self.nameSpace + '/setRecords', res.data);
	            	self.$store.commit( self.nameSpace + '/setPagination', res.meta.pagination );
	            	self.loadingStop('hrm-list-table');
	            	self.isFetchRecord = true;
	            	
	            	if (typeof args.callback != 'undefined') {
	                    callback(true, res);
	                } 
	                
	            },

	            error: function(res) {
	            	self.show_spinner = false;
	            	// Showing error
	                res.error.map( function( value, index ) {
	                    hrm.toastr.error(value);
	                });

	                if (typeof args.callback === 'function') {
	                    callback(false, res);
	                } 
	            }
	        };

	        this.httpRequest('hrm_shift_filter', form_data);
		},

		recordMeta (record) {
			record.editMode = false;
		},

		filter (callback) {

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
        },

        getDurationHourMinute (shift_being,  shift_end) {
            
            var isValidBeing = hrm.Moment(shift_being, "k:m", true).isValid();
            var isValidEnd = hrm.Moment(shift_end, "k:m", true).isValid();
            
            if(!isValidBeing || !isValidEnd) {
                return false;
            }

            var being = new Date(this.currentDate()+','+shift_being);
            var end   = new Date(this.currentDate()+','+shift_end);

            //Is end less than being
            var isafter = moment(end).isAfter(being);

            //If end less than being
            if(!isafter) {
                var end24 = new Date(this.currentDate()+','+'24:00');
                    end24 = hrm.Moment(end24);
                
                var diff24 = end24.diff(being);
                var d24 = hrm.Moment.duration(diff24);

                var totalTime = hrm.Moment(end).add(d24.hours(), 'hours').add(d24.minutes(), 'minutes');
                
                return {
                    hours: totalTime.hours(),
                    minutes: totalTime.minutes()
                }
            }
            
            being = hrm.Moment(being);
            end   = hrm.Moment(end);
            
            var diff = end.diff(being);
            var d = hrm.Moment.duration(diff);
            
            if(parseInt(d.hours()) == 0 && parseInt(d.minutes()) == 0) {
            	return false;
            }

            return {
                hours: Math.abs(d.hours()),
                minutes: Math.abs(d.minutes())
            }
        },

        shiftDuration (shift_being,  shift_end) {
            
            var isValidBeing = hrm.Moment(shift_being, "k:m", true).isValid();
            var isValidEnd = hrm.Moment(shift_end, "k:m", true).isValid();
            
            if(!isValidBeing || !isValidEnd) {
                return false;
            }

            var being = new Date(this.currentDate()+','+shift_being);
            var end   = new Date(this.currentDate()+','+shift_end);
            
            being = hrm.Moment(being);
            end   = hrm.Moment(end);
            
            var diff = end.diff(being);
            var d = hrm.Moment.duration(diff);

            if(parseInt(d.hours()) < 0) {
            	return false;
            }

            if(parseInt(d.minutes()) < 0) {
            	return false;
            }

            if(parseInt(d.hours()) == 0 && parseInt(d.minutes()) == 0) {
            	return false;
            }

            return {
                hours: d.hours(),
                minutes: d.minutes()
            }
        },

        breakDuration (break_being, break_end) {
            var isValidBeing = hrm.Moment(break_being, "k:m", true).isValid();
            var isValidEnd = hrm.Moment(break_end, "k:m", true).isValid();
            
            if(!isValidBeing || !isValidEnd) {
                return false;
            }

            var being = new Date(this.currentDate()+','+break_being);
            var end   = new Date(this.currentDate()+','+break_end);
            
            being = hrm.Moment(being);
            end   = hrm.Moment(end);
            
            var diff = end.diff(being);
            var d = hrm.Moment.duration(diff);

            if(d.hours() < 0) {
            	return false;
            }

            if(d.minutes() < 0) {
            	return false;
            }

            if(d.hours() == 0 && d.minutes() == 0) {
            	return false;
            }

            return {
                hours: d.hours(),
                minutes: d.minutes()
            }
        },

    	workDurationValidation (shift_being, shift_end, work_hours, work_minutes) {
			var shiftDuration = this.getDurationHourMinute(shift_being, shift_end);
			
			work_hours = parseInt(work_hours) ? work_hours : 0;
			work_minutes = parseInt(work_minutes) ? work_minutes : 0; 

			if(!shiftDuration) {
				return {
					status: false,
					error: 'Time duration is not valid'
				};
			}
			
			var shift_time = shiftDuration.hours+':'+shiftDuration.minutes;
			var work_time = work_hours+':'+work_minutes;

			var isValidWordTime = hrm.Moment(work_time, "k:m", true).isValid();

			if(!isValidWordTime) {
				return {
					status: false,
					error: 'Work duration is not valid'
				};
			}

			var being = new Date(this.currentDate()+','+work_time);
            var end   = new Date(this.currentDate()+','+shift_time);
            
            being = hrm.Moment(being);
            end   = hrm.Moment(end);
            
            var diff = end.diff(being);
            var d = hrm.Moment.duration(diff);
            
            if(d.hours() < 0) {
            	return {
					status: false,
					error: 'Work duration is not valid'
				};
            }

            if(d.minutes() < 0) {
            	return {
					status: false,
					error: 'Work duration is not valid'
				};
            }

            return {
            	status: true
            }
		},
	}	
}