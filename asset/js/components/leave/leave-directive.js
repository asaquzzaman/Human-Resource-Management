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
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			dayClick: function(date, jsEvent, view) {

		       
				//console.log( date, jsEvent, view );
		    },
		    viewRender: function(view, element) {
        		//console.log(view.start,view.end);
   			},
   			dayRender: function (date, cell) {
   				return;
   				var self = HRM_Leave_jQuery_Fullcalendar,
   					cell_date = new Date(date._d),
   					cell_day  = cell_date.getDay(),
   					cell_time = self.get_time(date._d);

   				jQuery.each(emp_leave_with_type_record, function(key, val) {
   					var start_time = self.get_time(val.start_time),
   						end_time   = self.get_time(val.end_time);
   					
   					if ( start_time <= cell_time && end_time >= cell_time ) {

   						cell.css({
			        		'background-color': '#e08989',
			        		'text-align': 'center'
			        	});
   						
			        	jQuery(cell).append(val.type_name);
   					}
   				});

		        if ( work_week.indexOf(cell_day) != '-1'  ) {
		        	cell.css({
		        		'background-color': '#e08989',
		        		'text-align': 'center'
		        	});

		        	jQuery(cell).append('Holiday');
		        }

		    },

		    events: function(start, end, timezone, callback) {
		    	var events = HRM_Leave_jQuery_Fullcalendar.events_render( emp_leave_with_type_record );

		    	jQuery.each(work_week, function(key, val) {
		    		var days_in_month = HRM_Leave_jQuery_Fullcalendar.weekend_in_month( start._d, end._d, val );

		    		jQuery.each( days_in_month, function( index, date ) {
		    			var new_obj = {
		    				title: 'Weekend',
							start: date,
							end: date,
							backgroundColor: '#e08989',
							borderColor: '#e08989'
		    			}

		    			events.push(new_obj);
		    		});
		    	});

		    	callback(events);
		    	
		    }//HRM_Leave_jQuery_Fullcalendar.events_render( emp_leave_with_type_record, work_week ),
		});
	},

	weekend_in_month: function( start, end, day ) {
		var start = new Date(start),
			end   = new Date(end);
		
		var date  = start;
	    var dates = [];

	    while (date < end) {
	        if (date.getDay() === day ) { 
	        	var setDate = HRM_Leave_jQuery_Fullcalendar.get_date(date);
	        	dates.push(setDate);
	        }
	        date.setDate( date.getDate() + 1 );
	    }
	   
	    return dates;
	},

	events_render: function( events ) {
		var evt = [],
			self = HRM_Leave_jQuery_Fullcalendar;

		jQuery.each(events, function(key, val) {
			var date = new Date(val.end_time);
				end_date = date.setDate(date.getDate() + 1);
			
			var obj = {
				title: val.type_name,
				start: self.get_date(val.start_time),
				end: self.get_date(end_date),
				backgroundColor: '#e08989',
				borderColor: '#e08989'
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