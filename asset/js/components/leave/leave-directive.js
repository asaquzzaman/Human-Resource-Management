import Vue from './../../vue/vue';

var HRM_Leave_jQuery_Fullcalendar = {
	calendar: function(el, context) {

		var $ = jQuery,
			work_week = this.work_week_convert_numeric( context.work_week ),
			emp_leave_with_type_record = context.emp_leave_with_type_record;

		jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'prev,next'
			},
			
			navLinks: false, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			fixedWeekCount: false, //remove others month days for current month
			showNonCurrentDates: false,
			displayEventTime: false,
			allDay: true,

			dayClick: function(date, jsEvent, view) {  
				var has_leave = HRM_Leave_jQuery_Fullcalendar.has_leave_in_this_day( date, jsEvent, view );
				
 	        	if (has_leave.length) {
					// Display a success toast, with a title
		            toastr.error('Leave alrady exist');
		            return;
				}
				var is_disable_leave_type = context.disable_leave_type;
				if ( is_disable_leave_type === true ) {
					HRM_Leave_jQuery_Fullcalendar.inseret_leave_when_leave_type_is_not_exist(context, date, jsEvent, view);
					return;
				}
				var is_leave_type = HRM_Leave_jQuery_Fullcalendar.leave_type_condition(date, jsEvent, view, context);
				
				if (is_leave_type) {
					HRM_Leave_jQuery_Fullcalendar.inseret_leave_when_leave_type_exist(context, date, jsEvent, view);
				}
				
		    },

		    events: function(start, end, timezone, callback) {

		    	var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	                start: HRM_Leave_jQuery_Fullcalendar.get_date(start._d),
	                end: HRM_Leave_jQuery_Fullcalendar.get_date(end._d)
	            },
	            events = [];

				wp.ajax.send('get_leave_record_events', {
	                data: request_data,
	                
	                success: function(res) {

						events = HRM_Leave_jQuery_Fullcalendar.leave_records_render( res.records );
						var render_weekend = HRM_Leave_jQuery_Fullcalendar.render_weekend(start._d, end._d, res.work_week);
						events = events.concat( render_weekend );

				    	callback(events);
	                },

	                error: function(res) {
	 
	                }
	            });	
		    },

		    eventClick: function(calEvent, jsEvent, view) {


				var is_disable_leave_type = context.disable_leave_type;

				if ( is_disable_leave_type ) {
					HRM_Leave_jQuery_Fullcalendar.remove_event_when_leave_type_is_not_exist(context, calEvent, jsEvent, view);
				} else {
					HRM_Leave_jQuery_Fullcalendar.remove_event_when_leave_type_exist(context, calEvent, jsEvent, view);
				}

		    }
		});
	},

	remove_event_when_leave_type_exist: function(context, calEvent, jsEvent, view) {
		var in_collect = context.calendar_evt_id.indexOf(calEvent._id);
		if ( in_collect == '-1' ) {
			return;
		}

		var slct_lv_type      = context.leave_type,
			lv_types          = context.leave_types,
			get_type          = context.getIndex(lv_types, slct_lv_type.id, 'id'),
			get_type          = lv_types[get_type],
			emp_lv_records    = context.leave_entitlements,
			target            = context.getIndex( emp_lv_records, slct_lv_type.id, 'leave_type_id' ),
			leave_start_date  = moment(calEvent.start._d).format('YYYY-MM-DD'),
			collected_lv_st_d = context.apply_leave_date.indexOf(leave_start_date);
			
			if ( typeof context.leave_entitlements[target] != 'undefined' ) {
				context.leave_entitlements[target].total = context.leave_entitlements[target].total - 1;
			}
			
        jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('removeEvents', calEvent._id);

        context.calendar_evt_id.splice( in_collect, 1 );
        context.apply_leave_date.splice( collected_lv_st_d, 1 );
	},

	remove_event_when_leave_type_is_not_exist: function(context, calEvent, jsEvent, view) {
		var in_collect = context.calendar_evt_id.indexOf(calEvent._id);
		if ( in_collect == '-1' ) {
			return;
		}

		var leave_start_date  = moment(calEvent.start._d).format('YYYY-MM-DD'),
			collected_lv_st_d = context.apply_leave_date.indexOf(leave_start_date);


        jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('removeEvents', calEvent._id);

        context.calendar_evt_id.splice( in_collect, 1 );
        context.apply_leave_date.splice( collected_lv_st_d, 1 );
	},

	inseret_leave_when_leave_type_exist: function(context, date, jsEvent, view) {
		var slct_lv_type    = context.leave_type,
			lv_types        = context.leave_types,
			get_type        = context.getIndex(lv_types, slct_lv_type.id, 'id'),
			get_type        = lv_types[get_type],
			emp_lv_records  = context.leave_entitlements,
			target          = context.getIndex( emp_lv_records, slct_lv_type.id, 'leave_type_id' );

			if ( typeof context.leave_entitlements[target] != 'undefined' ) {
				context.leave_entitlements[target].total = context.leave_entitlements[target].total + 1;
			}

		var newEvent = {
			title: get_type.leave_type_name,
			start: moment(date._d).format('YYYY-MM-DD'), //self.get_date(val.start_time),
			end: moment(date._d).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
			backgroundColor: '#e08989',
			borderColor: '#e08989',
			allDay: true,
		};

		var evt = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar( 'renderEvent', newEvent , true);
		
		if (evt.length) {
			jQuery.each(evt, function(indev, val) {
				var start = moment(val.start._d).format('YYYY-MM-DD');
				context.calendar_evt_id.push(val._id);
				context.apply_leave_date.push(start);
			});
		}
	},

	inseret_leave_when_leave_type_is_not_exist: function(context, date, jsEvent, view) {

		var newEvent = {
			title: 'Extra',
			start: moment(date._d).format('YYYY-MM-DD'), //self.get_date(val.start_time),
			end: moment(date._d).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
			backgroundColor: '#e08989',
			borderColor: '#e08989',
			allDay: true,
		};

		var evt = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar( 'renderEvent', newEvent , true);
		
		if (evt.length) {
			jQuery.each(evt, function(indev, val) {
				var start = moment(val.start._d).format('YYYY-MM-DD');
				context.calendar_evt_id.push(val._id);
				context.apply_leave_date.push(start);
			});
		}
	},

	leave_type_condition: function(date, jsEvent, view, context) {
		var leave_types = context.leave_types,
			emp_lv_records = context.leave_entitlements,
			selected_leave_type = context.leave_type;

		if (selected_leave_type != '') {
			var target = context.getIndex( emp_lv_records, selected_leave_type.id, 'leave_type_id' ),
				get_type          = context.getIndex(leave_types, selected_leave_type.id, 'id'),
				get_type          = leave_types[get_type],
				slct_lv_typ_entit = get_type.entitlement;

			if ( typeof emp_lv_records[target] != 'undefined' ) {
				var emp_entitlement   = emp_lv_records[target].total;
			} else {
				var emp_entitlement   = 0;
			}

			if (slct_lv_typ_entit <= emp_entitlement) {
				alert('Excid entitlement');
				return false;
			}
		} else {
			alert('Please select leave type');
			return false;
		}

		return true;
	},

	render_weekend: function(start, end, work_week) {
		var work_week = HRM_Leave_jQuery_Fullcalendar.work_week_convert_numeric(work_week),
			events = [];

		jQuery.each(work_week, function(key, val) {

    		var days_in_month = HRM_Leave_jQuery_Fullcalendar.weekend_in_month( start, end, val );
    		
    		jQuery.each( days_in_month, function( index, date ) {
    			var new_obj = {
    				title: 'Weekend',
					start: moment(date).format('YYYY-MM-DD'),
					end: moment(date).add(1, 'days').format('YYYY-MM-DD'),
					backgroundColor: '#e08989',
					borderColor: '#e08989',
					allDay: true,
    			}

    			events.push(new_obj);
    		});
    	});

    	return events;
	},

	has_leave_in_this_day: function(date, jsEvent, view) {
		var cell_date = moment(date._d).format('YYYY-MM-DD'),
		    events = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('clientEvents'),
		    has_leave = [];

		jQuery.each(events, function(key, val) {
			var start = moment(val.start._d).format('YYYY-MM-DD'),
				end   = moment(val.end._d).subtract(1, 'days').format('YYYY-MM-DD'); 
			
			
			if ( moment(cell_date).isBetween(start, end, null, '[]') ) {
				has_leave.push(val.title);
			}
		});
			
		return has_leave;
	},

	weekend_in_month: function( start, end, day ) {
		var start = new Date(start),
			end   = new Date(end);
		
		var date  = start;
	    var dates = [];

	    while (date < end) {
	        if (date.getDay() === day ) { 
	        	var setDate = moment(date).format('YYYY-MM-DD'); //HRM_Leave_jQuery_Fullcalendar.get_date(date);
	        	dates.push(setDate);
	        }
	        date.setDate( date.getDate() + 1 );
	    }
	   
	    return dates;
	},

	leave_records_render: function( events ) {
		var evt = [],
			self = HRM_Leave_jQuery_Fullcalendar;

		jQuery.each(events, function(key, val) {

			var obj = {
				title: val.leave_type_id == '0' ? 'Extra' : val.type_name,
				start: moment(val.start_time).format('YYYY-MM-DD'), //self.get_date(val.start_time),
				end: moment(val.end_time).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
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
		var d     = new Date(date);
		return d.getFullYear() +'-'+ ("0" + (d.getMonth() + 1)).slice(-2) +'-'+ ("0" + d.getDate()).slice(-2);
	}
}



// Register a global custom directive called v-cpm-datepicker
Vue.directive('hrm-leave-jquery-fullcalendar', {
    inserted: function (el, binding, vnode) {
        HRM_Leave_jQuery_Fullcalendar.calendar( el, vnode.context );
    }
});