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
			var pre_define = {};

			var data = jQuery.extend(true, pre_define, args.data);
			
            var request_data = {
                data: data,
                success (res) {
                    self.$store.commit('getLeaveRecords', res);

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
                    	//self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
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
                    self.$store.commit('afterDeleteLeave', args.data.leave_id);

                    if (typeof args.callback === 'function') {
                        args.callback();
                    } 
                }
            }
            
            self.httpRequest('delete_leave', request_data);
        },
	},
});