var hrm_attendace_user_search = {
	template: '#tmpl-hrm-attendance-user-search',
	
	mixins: [HRM_Common_Mixin],
	
	data: function() {
		return {
			//punch_in_date: 'sdgfashjfdgsad',
			//punch_out_date: '',
			//search_user_id: ''
		}
	},

	computed: {
		punch_in_date: function() {
			return this.$store.state.punch_in_date;
		},

		punch_out_date: function() {
			return this.$store.state.punch_out_date;
		},

		search_user_id: {
			get: function() {
				this.$store.state.search_user_id;
			},

			set: function(val) {
				this.$store.commit( 'setSearchUserId', val );
			}
		}
	},

	created: function() {
		this.$on( 'hrm_date_picker', this.setdate );
		this.$store.commit( 'searchMode', {status: true} );


		this.getAttendance();
	},
	methods: {
		getAttendance: function() {

			var request_data = {
                _wpnonce: HRM_Vars.nonce,
                search: this.$route.query,
            },
            
            self = this;

            wp.ajax.send('get_attendance', {
                data: request_data,
                success: function(res) {
                	
                    self.$store.commit( 'setAttendance', {
                    	records: res.attendance, 
                    	punch_in_formated_date: res.punch_in_formated_date,
                    	punch_out_formated_date: res.punch_out_formated_date,
                    	punch_in_date: res.punch_in_date,
                    	punch_out_date: res.punch_out_date

                    } );
                },

                error: function(res) {
                    
                }
            });
		},
		setdate: function(date) {

			if ( date.field == 'datepicker_from' ) {
				this.$store.commit( 'setPunchInDate', { date: date } );
			}

			if ( date.field == 'datepicker_to' ) {
				this.$store.commit( 'setPunchOutDate', { date: date } );
			}
		},
		search: function() {
			if( this.$route.name == 'attendance_search') {
				this.$router.push({ 
					query: { 
						punch_in: this.$store.state.punch_in_date,
						punch_out: this.$store.state.punch_out_date,
						user_id: this.$store.state.search_user_id
					}
				});
			} else {
				this.$router.push({ 
					path: '/attendance/search/', 
					query: { 
						punch_in: this.$store.state.punch_in_date,
						punch_out: this.$store.state.punch_out_date,
						user_id: this.$store.state.search_user_id
					}
				});
			}
			
			this.getAttendance();
		},
	}
};