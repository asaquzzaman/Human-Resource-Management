export default {
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
			    this.$store.commit('leave/showHideleaveForm', status);
			}
		},

        showHideLeaveTypeUpdateForm (status, type) {
            var type   = type || false,
                type   = jQuery.isEmptyObject(type) ? false : type;
            
            if ( type ) {
                if ( status === 'toggle' ) {
                    type.editMode = type.editMode ? false : true;
                } else {
                    type.editMode = status;
                }
            }
        },

        showHideHolidayUpdateForm (status, holiday) {
            var holiday   = holiday || false,
                holiday   = jQuery.isEmptyObject(holiday) ? false : holiday;
            
            if ( holiday ) {
                if ( status === 'toggle' ) {
                    holiday.editMode = holiday.editMode ? false : true;
                } else {
                    holiday.editMode = status;
                }
            }
        },

		getLeaveRecords (args) {
			var self = this;
			var pre_define = {};

			var data = jQuery.extend(true, pre_define, args.data);
			
            var request_data = {
                data: data,
                success (res) {

                    self.$store.commit('leave/getLeaveRecords', res);

                    if (typeof args.callback === 'function') {
                    	args.callback(res);
                    }
                },
            };
            
            self.httpRequest('get_leaves', request_data);
		},

		updateLeave (args) {
			if( this.is_leave_btn_disable ) {
				return false;
			}

			var self = this;


            var form_data = {
                data: args,

                beforSend: function(xhr) {
                	self.show_spinner = true;
                	self.is_leave_btn_disable = true;
                },
                
                success: function(res) {
                	self.show_spinner = false;
                    
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.slideUp(jQuery('.hrm-form-cancel'), function() {
                    	//self.$store.commit('leave/isNewDepartmentForVisible', {is_visible: false});
                    });

                    if (args.callback === 'function') {
                    	args.callback(res);
                    }
                },

                error: function(res) {
                	self.show_spinner = false;
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            };

            this.httpRequest('update_leave', form_data);
		},

		updateLeaveStatus (pendingLeave, status) {
			var self = this;
			
			var request_data = {
				id: pendingLeave.id,
                status: status,
                class: 'Leave',
                method: 'update',
                callback: function(res) {

                }
            };

            self.updateLeave(request_data);
		},

        deleteLeave (args) {
            if ( ! confirm( 'Are you sure' ) ) {
                return;
            }
            var self = this;
       
            var request_data = {
                data: {
                    leave_id: args.data.leave_id,
                },  
                success: function(res) {
                    self.$store.commit('leave/afterDeleteLeave', args.data.leave_id);

                    if (typeof args.callback === 'function') {
                        args.callback();
                    } 
                }
            }
            
            self.httpRequest('delete_leave', request_data);
        },

        updateLeaveType (args) {
            // Exit from this function, If submit button disabled 
            if ( this.submit_disabled ) {
                //return;
            }

            var self = this;
            var pre_define = {};
            var args = jQuery.extend(true, pre_define, args );
            
            // Disable submit button for preventing multiple click
            this.submit_disabled = true;

            // Showing loading option 
            this.show_spinner = true;

            var request_data = {
                data: args.data,
                success (res) {
                    self.show_spinner = false;
                    // Display a success toast, with a title
                    toastr.success(res.data.success);
                    self.addLeaveTypeMeta(res.data);
                    self.submit_disabled = false;

                    if (typeof args.callback === 'function') {
                        args.callback(res.data);
                    }
                },

                error (res) {
                    self.show_spinner = false;
                    
                    // Showing error
                    res.data.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                    self.submit_disabled = false;
                }
            }

            self.httpRequest('create_new_leave_type', request_data);
            
        },

        addLeaveTypeMeta (type) {
            type.editMode = false;
        },

        addHolidayMeta (holiday) {
            holiday.editMode = false;
        },

        deleteLeaveType (args) {
        
            if ( ! confirm( 'Are you sure' ) ) {
                return;
            }
            var self = this;
            var pre_define = {
                    id: false,
                    callback: false
                };

            var args = jQuery.extend(true, pre_define, args );

            var request_data = {
                data: {
                    'id': args.id
                },
                success: function() {

                    self.$store.commit('leave/afterDeleteLeaveType', args.id);
                    
                    if (typeof args.callback === 'function') {
                        args.callback();
                    } 
                },
                error: function(res) {
  
                    self.show_spinner = false;
                    // Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            }
            
            self.httpRequest('delete_leave_type', request_data);
        
        },
        updateHoliday (args) {
            // Exit from this function, If submit button disabled 
            if ( this.submit_disabled ) {
                return;
            }

            var self = this;
            var pre_define = {};
            var args = jQuery.extend(true, pre_define, args );
            
            // Disable submit button for preventing multiple click
            this.submit_disabled = true;

            // Showing loading option 
            this.show_spinner = true;

            var request_data = {
                data: args.data,
                success (res) {
                    self.show_spinner = false;
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    self.addHolidayMeta(res.holiday);
                    self.submit_disabled = false;
                    
                    self.$store.commit('leave/afterUpdateHoliday', res.holiday);

                    if (typeof args.callback === 'function') {
                        args.callback(res.data);
                    }
                },

                error (res) {
                    self.show_spinner = false;
                    
                    // Showing error
                    res.data.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                    self.submit_disabled = false;
                }
            }

            self.httpRequest('create_new_holidays', request_data);
        },

        deleteHoliday (args) {
            if ( ! confirm( 'Are you sure' ) ) {
                return;
            }
            // Exit from this function, If submit button disabled 
            if ( this.submit_disabled ) {
                return;
            }

            let self = this;
            let pre_define = {};
            args = jQuery.extend(true, pre_define, args );
            
            // Disable submit button for preventing multiple click
            this.submit_disabled = true;

            // Showing loading option 
            this.show_spinner = true;

            var request_data = {
                data: {
                    'id': args.id
                },
                success: function(res) {
                    self.$store.commit('leave/afterDeleteHoliday', args.id);
                    if (typeof args.callback === 'function') {
                        args.callback();
                    } 
                },
                error: function(res) {
  
                    self.show_spinner = false;
                    // Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            }
            
            self.httpRequest('delete_holiday', request_data);
        },
        canManamgeLeave () {
            if (hrm_user_can('manage_leave')) {
                return true;
            }

            return false;
        }
	},
};