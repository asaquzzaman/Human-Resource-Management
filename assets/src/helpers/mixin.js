export default hrm.Vue.mixin({
	methods: {
        registerStore (module_name, store) {
            if (typeof store === 'undefined') {
                return false;
            }
            
            var self = this;
            if( typeof store !== 'undefined' ) {
                var mutations = store.mutations || {}; //self.$options.mutations;
                var state = store.state || {}; //self.$options.state;
            }
            
            // register a module `myModule`

            self.$store.registerModule(module_name, {
                namespaced: true,
                state,
                mutations,
            });
        },
		httpRequest (hook, property) {
			var before = function( xhr ) {
			    xhr.setRequestHeader("Authorization_name", btoa('asaquzzaman')); //btoa js encoding base64_encode
			    xhr.setRequestHeader("Authorization_password", btoa(12345678)); //atob js decode base64_decode
			};
            
			property.beforeSend = typeof property.beforeSend === 'undefined' ? before : property.beforeSend;
			property.data['_wpnonce'] = HRM_Vars.nonce;

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
	    getIndex (array,  id, slug) {
	        var target = false;

	        array.forEach(function(content, index) {
	            if ( content[slug] == id ) {
	                target = index;
	            }
	        });

	        return target;
	    },

	    getDepartments (args) {
	    	var self = this;
            var pre_define = {
                _wpnonce: HRM_Vars.nonce,
                page_number: typeof this.$route.params.page_number !== 'undefined' 
                    ? this.$route.params.page_number
                    : 1
            };

            var request_data  = jQuery.extend(true, pre_define, args.data);

            wp.ajax.send('get_departments', {
                data: request_data,
                success (res) {
                    self.$store.commit( 'departments/setDepartments', { 
                        departments: res.departments, 
                        'total_dept': res.total_dept,
                        'dept_drop_down': res.dept_drop_down
                    });
                    
                    if ( typeof args.callback === 'function') {
                        args.callback(res);
                    }
                },

                error (res) {
                	
                }
            });
		},
        dateTimeFormat(date) {
            if ( typeof date === 'undefined' ) {
                date = hrm.Moment().format();
            }

            date = new Date(date);

            return hrm.Moment( date ).format('kk:mm');
        },
                /**
         * WP settings date format convert to pm.Moment date format with time zone
         * 
         * @param  string date 
         * 
         * @return string      
         */
        shortDateFormat ( date ) {
            if ( date == '' ) {
                return;
            }      

            date = new Date(date);
            date = hrm.Moment(date).format('YYYY-MM-DD');
            if(date == 'Invalid date') {
                return '';
            }
            var format = 'DD MMM';

            return hrm.Moment( date ).format( String( format ) );
        },
		/**
         * WP settings date format convert to hrm.Moment date format with time zone
         * 
         * @param  string date 
         * 
         * @return string      
         */
        dateFormat: function( date ) {
            if ( typeof date === 'undefined' ) {
                date = hrm.Moment().format();
            }
            
           // hrm.Moment.tz.add(HRM_Vars.time_zones);
           // hrm.Moment.tz.link(HRM_Vars.time_links);

            date = new Date(date);
            date = hrm.Moment(date).format('YYYY-MM-DD');
            
            var format = 'MMMM DD YYYY';
            
            if ( HRM_Vars.wp_date_format == 'Y-m-d' ) {
                format = 'YYYY-MM-DD';
            
            } else if ( HRM_Vars.wp_date_format == 'm/d/Y' ) {
                format = 'MM/DD/YYYY';
            
            } else if ( HRM_Vars.wp_date_format == 'd/m/Y' ) {
                format = 'DD/MM/YYYY';
            } 

            return hrm.Moment( date ).format(format);
        },

        currentDate () {
            return this.dateFormat();
        },

        pad(d) {
            if ( typeof d === 'undefined' ) {
                return d;
            }
            return (d < 10) ? '0' + d.toString() : d.toString();
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
                zIndex: '9999', 

                // sets relative position to preloader's parent
                setRelative: false,

                animationClass: 'preloader-animation'

            };
            var args = jQuery.extend(true, pre_define, args);
            
            hrm.Vue.nextTick(function() {
                jQuery('#'+id).css({
                    position: 'relative'
                });
                jQuery('#'+id).preloader(args);
            });
            
        },

        loadingStop (id) {
            jQuery('#'+id).preloader('remove');
        },

        dataURLtoFile (dataurl, filename) {
            var arr = dataurl.split(','), 
                mime  = arr[0].match(/:(.*?);/)[1],
                bstr  = atob(arr[1]), 
                n     = bstr.length, 
                u8arr = new Uint8Array(n);
                
            while(n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {type:mime});
        },

        manageOrganization() {
            return hrm_user_can('manage_organization');
        },

        getEmployeeId () {

            if (typeof this.$route.params.employeeId == 'undefined') {
                return parseInt(HRM_Vars.current_user.ID);
            }
            
            return parseInt(this.$route.params.employeeId);
        },

        newRecordEffect (selector) {
            selector.css({ display: 'none' });
            selector.addClass('new-records');
            selector.fadeIn(1000);

            setTimeout(function() {
                selector.removeClass('new-records');
            }, 3000);
        },

        updateRecordEffect (selector) {
            //selector.css({ display: 'none' });
            selector.addClass('new-records');
            //selector.fadeIn(1000);

            setTimeout(function() {
                selector.removeClass('new-records');
            }, 3000);
            
        },

        formValidation (fields, postData) {
            var isFormValidate = true;

            fields.forEach(function(val) {
                if(
                    val.required === true
                        &&
                    !postData[val.name]
                ) {
                    hrm.Toastr.error(val.label + ' is required!');
                    isFormValidate = false;
                }
            });

            return isFormValidate;
        },

        editFormValidation (fields, postData) {
            var isFormValidate = true;

            fields.forEach(function(val) {
                if(
                    val.editable !== false
                        &&
                    val.required === true
                        &&
                    !postData[val.name]
                ) {
                    hrm.Toastr.error(val.label + ' is required!');
                    isFormValidate = false;
                }
            });

            return isFormValidate;
        }
	},
});
