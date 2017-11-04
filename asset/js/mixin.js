import Vue from './vue/vue';

export default Vue.mixin({
	methods: {
		httpRequest (hook, property) {
			var before = function( xhr ) {
			    xhr.setRequestHeader("Authorization_name", btoa('asaquzzaman')); //btoa js encoding base64_encode
			    xhr.setRequestHeader("Authorization_password", btoa(12345678)); //atob js decode base64_decode
			};

			property.beforeSend = typeof property.beforeSend === 'undefined' ? before : property.beforeSend;
			property.data._wpnonce = HRM_Vars.nonce;

			wp.ajax.send(hook, property);
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
		/**
         * WP settings date format convert to moment date format with time zone
         * 
         * @param  string date 
         * 
         * @return string      
         */
        dateFormat: function( date ) {
            if ( !date ) {
                return;
            }

            moment.tz.add(HRM_Vars.time_zones);
            moment.tz.link(HRM_Vars.time_links);

            date = new Date(date);
            date = moment(date).format('YYYY-MM-DD');
            
            var format = 'MMMM DD YYYY';
            
            if ( HRM_Vars.wp_date_format == 'Y-m-d' ) {
                format = 'YYYY-MM-DD';
            
            } else if ( HRM_Vars.wp_date_format == 'm/d/Y' ) {
                format = 'MM/DD/YYYY';
            
            } else if ( HRM_Vars.wp_date_format == 'd/m/Y' ) {
                format = 'DD/MM/YYYY';
            } 

            return moment.tz( date, HRM_Vars.wp_time_zone ).format(format);
        },
		onOff (key, status) {
			var status = status || 'no';

			if (status === 'no') {
				this[key] = this[key] ? false : true;
			} else {
				this[key] = status;
			}
			this.leave_type = '';
			this.change_leve_type_statue();
		},

		loadingStart (id, args) {
            var pre_define = {
                // loading text
                text: '', 

                // from 0 to 100 
                percent: '', 

                // duration in ms
                duration: '', 

                // z-index property
                zIndex: '', 

                // sets relative position to preloader's parent
                setRelative: false 

            };
            var args = jQuery.extend(true, pre_define, args);

            jQuery('#'+id).preloader(args);
        },

        loadingStop (id) {
            jQuery('#'+id).preloader('remove');
        },
	},
});
