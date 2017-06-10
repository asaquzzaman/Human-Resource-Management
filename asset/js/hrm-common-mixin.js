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
                    self.$store.commit( 'setDepartments', { departments: res.departments, 'total_dept': res.total_dept} );
                },

                error: function(res) {
                	
                }
            });
		},
	},
}