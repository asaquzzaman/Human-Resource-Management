/**
 * Required jQuery methods 
 * 
 * @type Object
 */
var HRM_Admin = {
    init: function() {
        this.datepicker();
    },

    datepicker: function( el, vnodeContext ) {

        jQuery( '.hrm-date-field').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+5',
            onSelect: function(dateText) {
                vnodeContext.$emit( 'hrm_date_picker', { field: 'datepicker', date: dateText } );
            }
        });

        jQuery( ".hrm-date-picker-from" ).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
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
            onClose: function( selectedDate ) {
                jQuery( ".hrm-date-picker-from" ).datepicker( "option", "maxDate", selectedDate );
            },
            onSelect: function(dateText) {
                vnodeContext.$emit( 'hrm_date_picker', { field: 'datepicker_to', date: dateText } );
            }
        });

        jQuery( ".hrm-date-time-picker-from" ).datetimepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                jQuery( ".hrm-date-time-picker-to" ).datetimepicker( "option", "minDate", selectedDate );
            },
            onSelect: function(dateText) {
                vnodeContext.$emit( 'hrm_date_picker', { field: 'datetimepicker_from', date_time: dateText } );
            }
        });

        jQuery( ".hrm-date-time-picker-to" ).datetimepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onClose: function( selectedDate ) {
                jQuery( ".hrm-date-time-picker-from" ).datetimepicker( "option", "maxDate", selectedDate );
            },
            onSelect: function(dateText) {
               vnodeContext.$emit( 'hrm_date_picker', { field: 'datetimepicker_to', date_time: dateText } );
            }
        });
    },
}


// Register a global custom directive called v-cpm-datepicker
hrm.Vue.directive('hrm-datepicker', {
    inserted: function (el, binding, vnode) {
        HRM_Admin.datepicker( el, vnode.context );
    }
});


hrm.Vue.directive('hrm-slide-down', {
	inserted: function(el) {
		var node = jQuery(el);

		if (node.is(':visible')) {
			node.slideUp(400);
		} else {
			node.slideDown(400);
		}
		
	},
});
