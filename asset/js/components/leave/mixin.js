export default {
	methods: {
        employeeLeaveSummery (args) {
            var self = this;
            var pre_define = {};

            var data = jQuery.extend(true, pre_define, args.data);

            var request_data = {
                data: { employee_id: data.employee_id },
                success (res) {

                    self.$store.commit('leave/afterEmployeeLeaveSummery', 
                        {
                            res: res,
                            row_id: data.row_id,
                            type: data.type
                        }
                    );

                    if (typeof args.callback === 'function') {
                        args.callback(res);
                    }
                },
            };
            
            self.httpRequest('get_employee_leave_summery', request_data);
        },
        processRoles (role_object) {
            var roles = [];
            jQuery.each(role_object, function(id, name) {
                roles.push({
                    id: id,
                    name: name
                });
            });

            return roles;
        },
        processLeaveTypes (settings, roles) {
            settings.leave_types = settings.leave_types || [];

            var leave_types = [];

            jQuery.each(roles, function(id, name) {
                if ( settings.leave_types.indexOf(id) !== -1 ) {
                    leave_types.push({
                        id: id,
                        name: name
                    });
                }
            });

            return leave_types;
        },
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
                    res.data.forEach( function(leave) {
                        self.setLeaveRecoredsMeta(leave);
                    });
                    
                    self.$store.commit('leave/getLeaveRecords', res);

                    if (typeof args.callback === 'function') {
                    	args.callback(res);
                    }
                },
            };
            
            self.httpRequest('get_leaves', request_data);
		},

        setLeaveRecoredsMeta (leave) {
            leave.metaSummery = [];
            leave.metaSummeryDisplay = false;
        },

		updateLeave (args) {
			if( this.is_leave_btn_disable ) {
				return false;
			}

			var self = this;

            var form_data = {
                data: args.data,

                beforSend: function(xhr) {
                	self.show_spinner = true;
                	self.is_leave_btn_disable = true;
                },
                
                success: function(res) {
                	self.show_spinner = false;
                    // Display a success toast, with a title
                    //toastr.success(res.success);
            
                    if (typeof args.callback === 'function') {
                    	args.callback(res.data);
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
			
			var args = {
                data: {
                    id: pendingLeave.id,
                    status: status,
                    class: 'Leave',
                    method: 'update',
                },
				
                callback: function(res) {

                }
            };

            self.updateLeave(args);
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
                    toastr.success(res.success);
                    self.addLeaveTypeMeta(res.leave_type.data);
                    self.submit_disabled = false;

                    self.$store.commit('leave/afterUpdateLeaveType', res.leave_type.data);

                    if (typeof args.callback === 'function') {
                        args.callback(res);
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
        },

        totalEntitlement(types) {
            let total = this.totalSummery(types);

            return total.entitlement
        },

        totalTakeLeave(types) {
            let total = this.totalSummery(types);

            return total.taken_leave;
        },

        totalRemainLeave(types) {
            let total = this.totalSummery(types);

            return total.remain_leave;
        },

        totalSummery (types) {
            var total_extra = 0;

            var total = {
                entitlement: 0,
                taken_leave: 0,
                remain_leave: 0
            };

            types.forEach(function(type, index) {
                total.entitlement = parseInt(type.entitlement) + total.entitlement;
                total.taken_leave = parseInt(type.count) + total.taken_leave;

                if ( type.id === 1) {
                    total_extra = total_extra + parseInt(type.count);
                }
            });

            total.remain_leave = (total.entitlement - total.taken_leave) + total_extra;

            return total;
        },

        showHideSummery (showHideSummery, type, status) {
            status = status || 'toggle';
            this.$store.commit('leave/showHideSummery', 
                {
                    id: showHideSummery.id,
                    status: status,
                    type: type
                }
            );
        },

        getEmployeeDropDown (args) {
            var self = this;
            var request_data = {
                data: {},
                success: function(res) {
                    self.$store.commit('leave/setEmployeeDropDown', res);
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
            
            this.httpRequest('get_employee_dropdown', request_data);
        }   
	},
};




