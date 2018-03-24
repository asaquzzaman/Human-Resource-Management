var leaveCalendar;

var HRM_Leave_Apply_Calendar = {
	calendar: function(el, context) {

		var $ = jQuery,
			work_week = this.work_week_convert_numeric( context.work_week ),
			emp_leave_with_type_record = context.emp_leave_with_type_record,
			el = $(el);

		leaveCalendar = new hrm.Fullcalendar.Calendar(el, {
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'prev,next'
			},
			height: 400,
			navLinks: false, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			fixedWeekCount: false, //remove others month days for current month
			showNonCurrentDates: false,
			displayEventTime: false,
			allDay: true,

			dayClick: function(date, jsEvent, view) {  
				var emp_id = HRM_Leave_Apply_Calendar.getContentEmpId(context);

	            if (!emp_id) {
	            	// Display a success toast, with a title
		            hrm.Toastr.error('Please select employee');
		            return;
	            }

				var has_leave = HRM_Leave_Apply_Calendar.has_leave_in_this_day( date, jsEvent, view, context );
				
 	        	if (has_leave) {
					// Display a success toast, with a title
		            hrm.Toastr.error('Leave alrady exist');
		            return;
				}
				var is_disable_leave_type = context.disable_leave_type;

				if ( is_disable_leave_type === true ) {
					HRM_Leave_Apply_Calendar.inseret_leave_when_leave_type_is_not_exist(context, date, jsEvent, view);
					return;
				}

				if (!context.leave_type) {
					hrm.Toastr.error('Please select leave type');
					return false;
				}

				var has_entitlement = HRM_Leave_Apply_Calendar.has_entitlement(date, jsEvent, view, context);

				if (!has_entitlement) {
					hrm.Toastr.error('Leave entitlement exist');
					return false;
				}
				
				
				HRM_Leave_Apply_Calendar.inseret_leave_when_leave_type_exist(context, date, jsEvent, view);
				
		    },

		    events: function(start, end, timezone, callback) {

	            var emp_id = HRM_Leave_Apply_Calendar.getContentEmpId(context);

	            if (!emp_id) {
	            	return [];
	            }

	           	var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	                start: HRM_Leave_Apply_Calendar.get_date(start._d),
	                end: HRM_Leave_Apply_Calendar.get_date(end._d),
	                emp_id: emp_id

	            };

            	wp.ajax.send('get_leave_record_events', {
	                data: request_data,

	               	beforeSend () {
	               		context.loadingStart(
	               			'hrm-leave-records-form',
	               			{animationClass: 'preloader-update-animation'}
	               		);
		    		},
	                
	                success: function(res) {
						var events  = HRM_Leave_Apply_Calendar.leave_records_render( res.records.data, context );
						var weekend = HRM_Leave_Apply_Calendar.render_weekend(start._d, end._d, res.work_week);
						var holidays = HRM_Leave_Apply_Calendar.render_holidays(start._d, end._d, res.holidays);
						events      = events.concat( weekend, holidays );
						context.apply_emp_lev_records = res.records;
						
						context.loadingStop('hrm-leave-records-form');

				    	callback(events);
	                },
	            });	
	
		    },

		    eventClick: function(calEvent, jsEvent, view) {
				var is_disable_leave_type = context.disable_leave_type;

				if ( is_disable_leave_type ) {
					HRM_Leave_Apply_Calendar.remove_event_when_leave_type_is_not_exist(context, calEvent, jsEvent, view);
				} else {
					HRM_Leave_Apply_Calendar.remove_event_when_leave_type_exist(context, calEvent, jsEvent, view);
				}

		    }
		});

		context.leaveCalendar = leaveCalendar;
		
		leaveCalendar.render();
	},

	remove_event_when_leave_type_exist: function(context, calEvent, jsEvent, view) {
		var in_collect = context.calendar_evt_id.indexOf(calEvent._id);

		if ( in_collect == '-1' ) {
			return;
		}

		var	leave_start_date  = hrm.Moment(calEvent.start._d).format('YYYY-MM-DD'),
			collected_lv_st_d = context.apply_leave_date.indexOf(leave_start_date);
		
        leaveCalendar.removeEvents(calEvent._id);

        context.calendar_evt_id.splice( in_collect, 1 );
        context.apply_leave_date.splice( collected_lv_st_d, 1 );
	},

	remove_event_when_leave_type_is_not_exist: function(context, calEvent, jsEvent, view) {
		var in_collect = context.calendar_evt_id.indexOf(calEvent._id);
		if ( in_collect == '-1' ) {
			return;
		}

		var leave_start_date  = hrm.Moment(calEvent.start._d).format('YYYY-MM-DD'),
			collected_lv_st_d = context.apply_leave_date.indexOf(leave_start_date);


        leaveCalendar.removeEvents(calEvent._id);
        
        context.calendar_evt_id.splice( in_collect, 1 );
        context.apply_leave_date.splice( collected_lv_st_d, 1 );
	},

	inseret_leave_when_leave_type_exist: function(context, date, jsEvent, view) {
		var lv_records 	= context.apply_emp_lev_records,
			selected_leave_type = context.leave_type,
			index = context.getIndex(lv_records.meta.types, selected_leave_type.id, 'id'),
			lv_type = lv_records.meta.types[index];

		var newEvent = {
			title: lv_type.leave_type_name,
			start: hrm.Moment(date._d).format('YYYY-MM-DD'), //self.get_date(val.start_time),
			end: hrm.Moment(date._d).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
			backgroundColor: '#e08989',
			borderColor: '#e08989',
			allDay: true,
		};

		var evt = leaveCalendar.renderEvent(newEvent, true);

		if (evt.length) {
			jQuery.each(evt, function(indev, val) {
				var start = hrm.Moment(val.start._d).format('YYYY-MM-DD');
				context.calendar_evt_id.push(val._id);
				context.apply_leave_date.push(start);
			});
		}
	},

	inseret_leave_when_leave_type_is_not_exist: function(context, date, jsEvent, view) {

		var newEvent = {
			title: 'Extra',
			start: hrm.Moment(date._d).format('YYYY-MM-DD'), //self.get_date(val.start_time),
			end: hrm.Moment(date._d).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
			backgroundColor: '#e08989',
			borderColor: '#e08989',
			allDay: true,
		};

		var evt = leaveCalendar.renderEvent( newEvent , true);
		
		if (evt.length) {
			jQuery.each(evt, function(indev, val) {
				var start = hrm.Moment(val.start._d).format('YYYY-MM-DD');
				context.calendar_evt_id.push(val._id);
				context.apply_leave_date.push(start);
			});
		}
	},

	has_entitlement: function(date, jsEvent, view, context) {
		var lv_records 	= context.apply_emp_lev_records,
			selected_leave_type = context.leave_type,
			index = context.getIndex(lv_records.meta.types, selected_leave_type.id, 'id'),
			lv_type = lv_records.meta.types[index],
			count = context.apply_leave_date.length + lv_type.count;

		if (lv_type.entitlement > count) {
			return true;
		}

		return false;
	},

	render_weekend: function(start, end, work_week) {
		var work_week = HRM_Leave_Apply_Calendar.work_week_convert_numeric(work_week),
			events = [];

		jQuery.each(work_week, function(key, val) {

    		var days_in_month = HRM_Leave_Apply_Calendar.weekend_in_month( start, end, val );
    		
    		jQuery.each( days_in_month, function( index, date ) {
    			var new_obj = {
    				title: 'Weekend',
					start: hrm.Moment(date).format('YYYY-MM-DD'),
					end: hrm.Moment(date).add(1, 'days').format('YYYY-MM-DD'),
					backgroundColor: '#e08989',
					borderColor: '#e08989',
					allDay: true,
    			}

    			events.push(new_obj);
    		});
    	});

    	return events;
	},

	render_holidays: function(start, end, holidays) {

		var events = [];

		jQuery.each(holidays, function(key, holiday) {
			var new_obj = {
				title: holiday.name + ' (Holidays)',
				start: hrm.Moment(holiday.from).format('YYYY-MM-DD'),
				end: hrm.Moment(holiday.to).add(1, 'days').format('YYYY-MM-DD'),
				backgroundColor: '#e08989',
				borderColor: '#e08989',
				allDay: true,
			}

			events.push(new_obj);
    	});

    	return events;
	},

	has_leave_in_this_day: function(date, jsEvent, view, context) {
		var cell_date = hrm.Moment(date._d).format('YYYY-MM-DD'),
		    events    = leaveCalendar.clientEvents(),
		    has_leave = [];

		jQuery.each(events, function(key, val) {
			var start = hrm.Moment(val.start._d).format('YYYY-MM-DD'),
				end   = hrm.Moment(val.end._d).subtract(1, 'days').format('YYYY-MM-DD'); 
			
			
			if ( hrm.Moment(cell_date).isBetween(start, end, null, '[]') ) {
				has_leave.push(val.title);
			}
		});

		return has_leave.length ? true : false;
	},

	weekend_in_month: function( start, end, day ) {
		var start = new Date(start),
			end   = new Date(end);
		
		var date  = start;
	    var dates = [];

	    while (date < end) {
	        if (date.getDay() === day ) { 
	        	var setDate = hrm.Moment(date).format('YYYY-MM-DD'); //HRM_Leave_Apply_Calendar.get_date(date);
	        	dates.push(setDate);
	        }
	        date.setDate( date.getDate() + 1 );
	    }
	   
	    return dates;
	},

	leave_records_render: function( events, context ) {
		var evt = [];

		jQuery.each(events, function(key, val) {

			var obj = {
				id: val.id,
				title: val.type == '0' ? 'Extra' : val.leave_type.data.name,
				start: hrm.Moment(val.start_time).format('YYYY-MM-DD'), //self.get_date(val.start_time),
				end: hrm.Moment(val.end_time).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
				backgroundColor: '#e08989',
				borderColor: '#e08989',
				allDay: true,
			};

			evt.push(obj);
		});
		
		return evt;
	},

	work_week_convert_numeric: function(work_week) {
		var non_working_days = [];

		jQuery.each( work_week, function(key, val) {
			if ( key == 'sunday' && val == 'non' ) {
				non_working_days.push(0);
			}

			if ( key == 'moday' && val == 'non' ) {
				non_working_days.push(1);
			}

			if ( key == 'tuesday' && val == 'non' ) {
				non_working_days.push(2);
			}

			if ( key == 'wednesday' && val == 'non' ) {
				non_working_days.push(3);
			}

			if ( key == 'thursday' && val == 'non' ) {
				non_working_days.push(4);
			}

			if ( key == 'friday' && val == 'non' ) {
				non_working_days.push(5);
			}

			if ( key == 'saturday' && val == 'non' ) {
				non_working_days.push(6);
			}
		});

		return non_working_days;
	},

	get_time: function(date) {
		var d     = new Date(date),
			str_d = d.getFullYear() +'-'+ d.getMonth() +'-'+ d.getDate(),
			dd    = new Date(str_d)

		return dd.getTime();
	},

	get_date: function(date) {
		var d = new Date(date);
		return d.getFullYear() +'-'+ ("0" + (d.getMonth() + 1)).slice(-2) +'-'+ ("0" + d.getDate()).slice(-2);
	},

	getContentEmpId (context) {
		if ( context.leave_proxy &&  !context.selectedEmployee) {
    		return false;
        } 

        if (context.leave_proxy &&  context.selectedEmployee) {

        	var emp_id = context.selectedEmployee.ID;
        } else {
        	var emp_id = HRM_Vars.current_user.data.ID;
        }

        return emp_id;
	},

	holidayDatePicker (el, vnodeContext) {

	    jQuery( ".hrm-date-picker-from" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            minDate: HRM_Vars.financial_start,
            maxDate: HRM_Vars.financial_end,
            onClose: function( selectedDate ) {
                jQuery( ".hrm-date-picker-to" ).datepicker( "option", "minDate", selectedDate );
            },
            onSelect: function(dateText) {
                vnodeContext.$emit( 'hrm_date_picker', { field: 'datepicker_from', date: dateText, self: this } );
            }
        });

        jQuery( ".hrm-date-picker-to" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            minDate: HRM_Vars.financial_start,
            maxDate: HRM_Vars.financial_end,
            onClose: function( selectedDate ) {
                jQuery( ".hrm-date-picker-from" ).datepicker( "option", "maxDate", selectedDate );
            },
            onSelect: function(dateText) {
                vnodeContext.$emit( 'hrm_date_picker', { field: 'datepicker_to', date: dateText } );
            }
        });
    }
}

// Register a global custom directive called v-cpm-datepicker
hrm.Vue.directive('hrm-holiday-datepicker', {
    inserted: function (el, binding, vnode) {
        HRM_Leave_Apply_Calendar.holidayDatePicker( el, vnode.context );
    }
});


// Register a global custom directive called v-cpm-datepicker
hrm.Vue.directive('hrm-leave-jquery-fullcalendar', {
    inserted: function (el, binding, vnode) {
        HRM_Leave_Apply_Calendar.calendar( el, vnode.context );
    }
});