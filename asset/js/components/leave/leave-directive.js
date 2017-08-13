var HRM_Leave_jQuery_Fullcalendar = {
	calendar: function(el, vnode_context) {

		var $ = jQuery(),
			work_week = this.work_week_convert_numeric( vnode_context.work_week ),
			emp_leave_with_type_record = vnode_context.emp_leave_with_type_record;

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

				var is_leave_type = HRM_Leave_jQuery_Fullcalendar.leave_type_condition(date, jsEvent, view, vnode_context);
				
		    },
		    viewRender: function(view, element) {
        		//console.log(view.start,view.end);
   			},
   			dayRender: function (date, cell) {

		    },

		    events: function(start, end, timezone, callback) {

		    	var request_data = {
	                _wpnonce: hrm_ajax_data.nonce,
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
		    }
		});
	},

	leave_type_condition: function(date, jsEvent, view, context) {
		var types = context.leave_types,
			entitlements = context.leave_entitlements,
			type = context.leave_type;

		if (type != '') {
			var target = context.getIndex( entitlements, type.id, 'leave_type_id' ),
				emp_get_leave = entitlements[target].total;

				console.log(emp_get_leave);
		}

		
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
				title: val.type_name,
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
    update: function (el, binding, vnode) {
        HRM_Leave_jQuery_Fullcalendar.calendar( el, vnode.context );
    }
});