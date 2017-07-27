Vue.directive('hrm-slide-down', {
	inserted: function(el) {
		var node = jQuery(el);

		if (node.is(':visible')) {
			node.slideUp(400);
		} else {
			node.slideDown(400);
		}
		
	},
});

var HRM_Common_Mixin = {
	methods: {
		slideUp: function(target_el, callback) {
			var node = jQuery(target_el).closest('.hrm-slide-up');

			node.slideUp(400, function() {
				callback();
			});
		},

		/**
	     * Get index from array object element
	     * 
	     * @param   array 
	     * @param   id    
	     * 
	     * @return  int      
	     */
	    getIndex: function ( array,  id, slug) {
	        var target = false;

	        array.map(function(content, index) {
	            if ( content[slug] == id ) {
	                target = index;
	            }
	        });

	        return target;
	    },

	    getDepartments: function() {
	    	
			var request_data = {
                _wpnonce: HRM_Admin.nonce,
                page_number: this.$route.params.page_number
            },
            self = this;

            wp.ajax.send('get_departments', {
                data: request_data,
                success: function(res) {
                    self.$store.commit( 'setDepartments', { 
                    	departments: res.departments, 
                    	'total_dept': res.total_dept,
                    	'dept_drop_down': res.dept_drop_down
                    });
                },

                error: function(res) {
                	
                }
            });
		},
	},
}

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
               
            }
        });
    },
}


// Register a global custom directive called v-cpm-datepicker
Vue.directive('hrm-datepicker', {
    inserted: function (el, binding, vnode) {
        HRM_Admin.datepicker( el, vnode.context );
    }
});
