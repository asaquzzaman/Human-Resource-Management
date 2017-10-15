import Vue from './vue/vue';

export default Vue.mixin({
	methods: {
		httpRequest (property) {
			var before = function( xhr ) {
			    xhr.setRequestHeader("Authorization_name", btoa('asaquzzaman')); //btoa js encoding base64_encode
			    xhr.setRequestHeader("Authorization_password", btoa(12345678)); //atob js decode base64_decode
			};

			property.beforeSend = typeof property.beforeSend === 'undefined' ? before : property.beforeSend;

			jQuery.ajax(property);
		},
		slideUp (target_el, callback) {
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
	    getIndex  ( array,  id, slug) {
	        var target = false;

	        array.map(function(content, index) {
	            if ( content[slug] == id ) {
	                target = index;
	            }
	        });

	        return target;
	    },

	    getDepartments () {
	    	
			var request_data = {
                _wpnonce: HRM_Vars.nonce,
                page_number: this.$route.params.page_number
            },
            self = this;

            wp.ajax.send('get_departments', {
                data: request_data,
                success (res) {
                    self.$store.commit( 'setDepartments', { 
                    	departments: res.departments, 
                    	'total_dept': res.total_dept,
                    	'dept_drop_down': res.dept_drop_down
                    });
                },

                error (res) {
                	
                }
            });
		},
		onOff (key, status) {
			var status = status || 'no';

			if (status === 'no') {
				this[key] = this[key] ? false : true;
			} else {
				this[key] = status;
			}
		}
	},
});
