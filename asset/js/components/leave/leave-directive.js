var HRM_Leave_jQuery_Fullcalendar = {
	calendar: function(el, vnode_context) {
		var $ = jQuery(),
			work_week = this.work_week_convert_numeric( vnode_context.work_week ),
			holidays = vnode_context.holidays;


		jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar(
			{
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
   				var cell_date = new Date(date._d),
   					cell_day  = cell_date.getDay();
		        

		        if ( work_week.indexOf(cell_day) != '-1'  ) {
		        	cell.css({
		        		'background-color': '#e08989',
		        		'text-align': 'center'
		        	});

		        	jQuery(cell).html('Holiday');
		        }

		        console.log(holidays); 
		    },
			events: [
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2017-08-28'
				}
			]
		}
		);

		
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
	}
}





// Register a global custom directive called v-cpm-datepicker
Vue.directive('hrm-leave-jquery-fullcalendar', {
    update: function (el, binding, vnode) {
        HRM_Leave_jQuery_Fullcalendar.calendar( el, vnode.context );
    }
});