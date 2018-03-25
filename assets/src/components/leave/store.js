let HRM_Leave_Store = {
	state: {
		header: {},
		is_new_leave_type_form_visible: false,
		is_new_holiday_form_visible: false,
		is_new_leave_records_form_visible: false,
		is_leave_form_active: false,
		leave_records: [],
		leave_meta: {},
		current_emp_current_month_leaves: [],
		pending_leaves: [],
		departmentDropDown: [],
		holidays: [],
		leaveTypes: [],
		approvedLeaves: [],
		cancelLeaves: [],
		employeeDropDown: [],
		getIndex: function ( itemList, id, slug) {
            var index = false;

            itemList.forEach(function(item, key) {
                if (item[slug] == id) {
                    index = key;
                }
            });

            return index;
        },
        slideUp (callBack) {
        	jQuery('.hrm-toggle').slideUp(400, function() {
        		callBack();
        	});
        },
        slideDwon () {
        	var node = jQuery('.hrm-toggle');
	        node.css({
	            display: 'none'
	        });
			node.slideDown(400);
	    },
	    editSlideUp (id, callBack) {
        	jQuery('#hrm-edit-'+id)
        		.find('form')
        		.slideUp(400, function() {
        			callBack();
        		}
        	);
        },
        editSlideDwon (id) {
        	var node = jQuery('#hrm-edit-'+id);

	        node.find('form').css({
	            display: 'none'
	        });

			node.find('form').slideDown(400);
	    }
	},

	mutations: {
		afterUpdateLeaveType (state, type) {
			let index = state.getIndex( state.leaveTypes, type.id, 'id' );
			
			state.editSlideUp(type.id, function() {
				state.leaveTypes.splice(index, 1, type);
			});
			
		},
		afterEmployeeLeaveSummery(state, data) {
			if (data.type == 'pending') {
				let index = state.getIndex( state.pending_leaves, data.row_id, 'id' );
				state.pending_leaves[index].metaSummery = data.res;
				state.pending_leaves[index].metaSummeryDisplay = true;
				
				// hrm.Vue.nextTick(function() {
				// 	state.slideDwon();
				// });
			}
		},
		showHideSummery (state, data) {
			var status = data.status;

			if (data.type == 'pending') {
				let index = state.getIndex( state.pending_leaves, data.id, 'id' );

				if (data.status === 'toggle') {
					status = state.pending_leaves[index].metaSummeryDisplay ? false : true;
            	} 

            	if (status === false) {
            		state.pending_leaves[index].metaSummeryDisplay = status;
					// state.slideUp(function() {
					// 	state.pending_leaves[index].metaSummeryDisplay = status;
					// });
				} else {
					state.pending_leaves[index].metaSummeryDisplay = status;
					// hrm.Vue.nextTick(function() {
					// 	state.slideDwon();
					// });
				}
				
				// if ( data.status == 'toggle' ) {
				// 	state.pending_leaves[index].metaSummeryDisplay = 
				// 		state.pending_leaves[index].metaSummeryDisplay
				// 		? false : true;
				// } else {
				// 	state.pending_leaves[index].metaSummeryDisplay = status;
				// }
				
			}
		},
		setCancelLeaves (state, calcelLeaves) {
			state.cancelLeaves = calcelLeaves;
		},
		setApprovalLeaves (state, approvedLeaves) {
			state.approvedLeaves = approvedLeaves;
		},
		header (state, header) {
			state.header = header.header;
		},
		isNewLeaveTypeFormVisible (state, is_visible) {
			state.is_new_leave_type_form_visible = is_visible.is_visible;
		},
		isNewLeaveRecordsFormVisible ( state, is_visible ) {
			state.is_new_leave_records_form_visible = is_visible.is_visible;
		},

		isNewHolidayFormVisible ( state, is_visible ) {
			state.is_new_holiday_form_visible = is_visible.is_visible;
		},

		showHideleaveForm  (state, status) {
			if (status === 'toggle') {
				status = state.is_leave_form_active ? false : true;
            } 

        	if (status === false) {
				state.slideUp(function() {
					state.is_leave_form_active = status;
				});
			} else {
				state.is_leave_form_active = status;
				hrm.Vue.nextTick(function() {
					state.slideDwon();
				});
			} 

			// if ( status === 'toggle' ) {
   //              state.is_leave_form_active = state.is_leave_form_active ? false : true;
   //          } else {
   //              state.is_leave_form_active = status;
   //          }
		},

		getLeaveRecords (state, leave_records) {
			state.leave_records = leave_records.data;
			state.leave_meta = leave_records.meta;
		},

		setPendingLeaves (state, pending_leaves) {
			state.pending_leaves = pending_leaves;
		},

		afterDeleteLeave (state, id) {
			var index = state.getIndex(state.leave_records, id, 'id');
			state.leave_records.splice( index, 1 );
		},
		setDepartment (state, dropDown) {
			state.departmentDropDown = dropDown;
		},
		setHoliday (state, holidays) {
			state.holidays = holidays;
		},
		updateHolidays (state, holidays) {
			state.holidays.push(holidays);
		},
		afterUpdateHoliday (state, holiday) {
			var index = state.getIndex(state.holidays, holiday.id, 'id');
			state.holidays.splice( index, 1, holiday );
		},
		afterDeleteHoliday (state, id) {
			var index = state.getIndex(state.holidays, id, 'id');
			state.holidays.splice( index, 1 );
		},
		setLeaveTypes (state, leaveTypes) {
			state.leaveTypes = leaveTypes;
		},
		setNewLeaveType (state, leaveType) {
			state.leaveTypes.push(leaveType);
		},

		afterDeleteLeaveType (state, id) {
			var index = state.getIndex(state.leaveTypes, id, 'id');
			state.leaveTypes.splice( index, 1 );
		},
		afterUpdateStatus (state, data) {
			
			if ( data.section == 1 ) {
				let index = state.getIndex(state.pending_leaves, data.record.id, 'id');
				state.pending_leaves.splice(index, 1);
			
			} else if ( data.section == 2 ) {
				let index = state.getIndex(state.approvedLeaves, data.record.id, 'id');
				state.approvedLeaves.splice(index, 1);
			
			} else if ( data.section == 3 ) {
				let index = state.getIndex(state.cancelLeaves, data.record.id, 'id');
				state.cancelLeaves.splice(index, 1);
			}

			if ( data.record.status == 1 ) {
				state.pending_leaves.push(data.record);
			
			} else if ( data.record.status == 2 ) {
				state.approvedLeaves.push(data.record);
			
			} else if ( data.record.status == 3 ) {
				state.cancelLeaves.push(data.record);
			}
		},

		afterCreateNewLeave (state, leaves) {
			leaves.forEach(function(leave) {
				state.leave_records.push(leave.data);
			});
		},
		setEmployeeDropDown (state, employees) {
			state.employeeDropDown = employees;
		}
	}
};


export default HRM_Leave_Store;