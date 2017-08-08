var Hrm_Leave_Records_Form = {
	template: '#tmpl-hrm-leave-records-form',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {
			employee: '',
			employees: [
				{
					"id": 1,
					"email": "joy.mishu@gmail.com",
					"name": "admin",
					"login_name": "admin",
					"role": "manager",
					"avatar": "<img alt='' src='//www.gravatar.com/avatar/873b98cc2b8493be36707ba58929dfec?s=96&#038;r=g&#038;d=mm' srcset='//www.gravatar.com/avatar/873b98cc2b8493be36707ba58929dfec?s=96&#038;r=g&#038;d=mm 2x' class='avatar avatar-96 photo' height='96' width='96' />",
					"avatar_url": "//www.gravatar.com/avatar/873b98cc2b8493be36707ba58929dfec?s=96&#038;r=g&#038;d=mm",
					"user_url": "<a href=\"http://localhost/test/wp-admin/admin.php?page=cpm_task&user_id=1\" title=\"admin\"><img alt='admin' src='//www.gravatar.com/avatar/873b98cc2b8493be36707ba58929dfec?s=48&#038;r=g&#038;d=mm' srcset='//www.gravatar.com/avatar/873b98cc2b8493be36707ba58929dfec?s=48&#038;r=g&#038;d=mm 2x' class='avatar avatar-48 photo' height='48' width='48' /></a>",
					"title": "admin",
					"img": "//www.gravatar.com/avatar/873b98cc2b8493be36707ba58929dfec?s=96&#038;r=g&#038;d=mm"
				},
				{
					"id": 2,
					"email": "rana@mishubd.com",
					"name": "rana rana",
					"login_name": "rana",
					"role": "co_worker",
					"avatar": "<img alt='' src='//www.gravatar.com/avatar/999568978bef1c88d658ea3eab72e6ad?s=96&#038;r=g&#038;d=mm' srcset='//www.gravatar.com/avatar/999568978bef1c88d658ea3eab72e6ad?s=96&#038;r=g&#038;d=mm 2x' class='avatar avatar-96 photo' height='96' width='96' />",
					"avatar_url": "//www.gravatar.com/avatar/999568978bef1c88d658ea3eab72e6ad?s=96&#038;r=g&#038;d=mm",
					"user_url": "<a href=\"http://localhost/test/wp-admin/admin.php?page=cpm_task&user_id=2\" title=\"rana rana\"><img alt='rana rana' src='//www.gravatar.com/avatar/999568978bef1c88d658ea3eab72e6ad?s=48&#038;r=g&#038;d=mm' srcset='//www.gravatar.com/avatar/999568978bef1c88d658ea3eab72e6ad?s=48&#038;r=g&#038;d=mm 2x' class='avatar avatar-48 photo' height='48' width='48' /></a>",
					"title": "rana rana",
					"img": "//www.gravatar.com/avatar/999568978bef1c88d658ea3eab72e6ad?s=96&#038;r=g&#038;d=mm"
				},
				{
					"id": 3,
					"email": "rocky@mishubd.com",
					"name": "rocky rocky",
					"login_name": "rocky",
					"role": "co_worker",
					"avatar": "<img alt='' src='//www.gravatar.com/avatar/03338b02362ae31dd6b999fdf7770207?s=96&#038;r=g&#038;d=mm' srcset='//www.gravatar.com/avatar/03338b02362ae31dd6b999fdf7770207?s=96&#038;r=g&#038;d=mm 2x' class='avatar avatar-96 photo' height='96' width='96' />",
					"avatar_url": "//www.gravatar.com/avatar/03338b02362ae31dd6b999fdf7770207?s=96&#038;r=g&#038;d=mm",
					"user_url": "<a href=\"http://localhost/test/wp-admin/admin.php?page=cpm_task&user_id=3\" title=\"rocky rocky\"><img alt='rocky rocky' src='//www.gravatar.com/avatar/03338b02362ae31dd6b999fdf7770207?s=48&#038;r=g&#038;d=mm' srcset='//www.gravatar.com/avatar/03338b02362ae31dd6b999fdf7770207?s=48&#038;r=g&#038;d=mm 2x' class='avatar avatar-48 photo' height='48' width='48' /></a>",
					"title": "rocky rocky",
					"img": "//www.gravatar.com/avatar/03338b02362ae31dd6b999fdf7770207?s=96&#038;r=g&#038;d=mm"
				}
			],
			name: '',
			from: '',
			to: '',
			description: '',
			records: []
		}
	},

	computed: {

	},

	created: function() {
		this.$on('hrm_date_picker', this.setDateTime);
		this.getInitialData();
	},
	methods: {
		getInitialData: function() {
			var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
            };

			wp.ajax.send('get_leave_records_init_data', {
                data: request_data,
                
                success: function(res) {
 
                },

                error: function(res) {
 
                }
            });
		},
		setDateTime: function(date) {
			if (date.field == 'datepicker_from') {
				this.from = date.date
			}

			if (date.field == 'datepicker_to') {
				this.to = date.date
			}
		},
		show_hide_new_leave_records_form: function(el) {
			var self = this;

			this.slideUp(el.target, function() {
				self.$store.commit('isNewLeaveRecordsFormVisible', {is_visible: false});
			});
						
		},

		createNewHolidays: function() {
			
		    var request_data = {
                _wpnonce: hrm_ajax_data.nonce,
                name: this.name,
                from: this.from,
                to: this.to,
                description: this.description,
            },
            
            // is_update  = parseInt( this.department_id ) ? true : false,
            
            // target_index = is_update ? this.getIndex(
            //     this.$store.state.departments, this.department_id, 'id'
            // ) : false,

            self = this;

            this.show_spinner = true;

            wp.ajax.send('create_new_holidays', {
                data: request_data,
                
                success: function(res) {
                	self.show_spinner = false;
                    
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.slideUp(jQuery('.hrm-form-cancel'), function() {
                    	self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
                    });

                    
                },

                error: function(res) {
                	self.show_spinner = false;
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		}
	}
};