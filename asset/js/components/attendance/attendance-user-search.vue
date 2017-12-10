<template>
	<div class="metabox-holder hrm-attendance-user-serch-wrap">
		<div class="postbox">

			<h2 class="hndle ui-sortable-handle">
				<span>Search</span>
			</h2>

			<div class="inside">
				<div class="main hrm-attendance-user-searach-main">
					<div class="hrm-form-field ">
						<label for="punch_in">
							From
							<em>   </em>
						</label>
						<input type="text" name="punch_in" value="" placeholder="" class="hrm-date-picker-from" id="punch_in" v-hrm-datepicker="" :value="punch_in_date">
						<span class="hrm-clear"></span>
						<span class="description"></span>
					</div>

					<div class="hrm-form-field ">
						<label for="punch_out">
							to
							<em>   </em>
						</label>
						<input type="text" name="punch_out" value="" placeholder="" class="hrm-date-picker-to" id="punch_out" v-hrm-datepicker="" :value="punch_out_date">
						<span class="hrm-clear"></span>
						<span class="description"></span>
					</div>

					<div class="hrm-form-field ">
						<label for="user_id">
							Users
							<em>   </em>
						</label>
						<select class="user_id" name="user_id" id="user_id" v-model="search_user_id" data-placeholder="-- Chose --">
							<option value="-1">-Select-</option>
							<option value="470">mmmmm hhhhhhh</option>
							<option value="469">xxxxx zzzzz</option>
						</select>
						<span class="hrm-clear"></span>
						<span class="description"> </span>
					</div>

					<button @click.prevent="search()" class="button button-primary">Search</button>
					<div class="hrm-clear"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		mixins: [HRMMixin.attendance],
		
		data: function() {
			return {
				//punch_in_date: 'sdgfashjfdgsad',
				//punch_out_date: '',
				//search_user_id: ''
			}
		},

		computed: {
			punch_in_date: function() {
				return this.$store.state.attendance.punch_in_date;
			},

			punch_out_date: function() {
				return this.$store.state.attendance.punch_out_date;
			},

			search_user_id: {
				get: function() {
					this.$store.state.attendance.search_user_id;
				},

				set: function(val) {
					this.$store.commit( 'setSearchUserId', val );
				}
			}
		},

		created: function() {
			this.$on( 'hrm_date_picker', this.setdate );
			this.$store.commit( 'attendance/searchMode', {status: true} );


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
	                	
	                    self.$store.commit( 'attendance/setAttendance', {
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
							punch_in: this.$store.state.attendance.punch_in_date,
							punch_out: this.$store.state.attendance.punch_out_date,
							user_id: this.$store.state.attendance.search_user_id
						}
					});
				} else {
					this.$router.push({ 
						path: '/attendance/search/', 
						query: { 
							punch_in: this.$store.state.attendance.punch_in_date,
							punch_out: this.$store.state.attendance.punch_out_date,
							user_id: this.$store.state.attendance.search_user_id
						}
					});
				}
				
				this.getAttendance();
			},
		}
	}
</script>
<!-- 
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
			return this.$store.state.attendance.punch_in_date;
		},

		punch_out_date: function() {
			return this.$store.state.attendance.punch_out_date;
		},

		search_user_id: {
			get: function() {
				this.$store.state.attendance.search_user_id;
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
						punch_in: this.$store.state.attendance.punch_in_date,
						punch_out: this.$store.state.attendance.punch_out_date,
						user_id: this.$store.state.attendance.search_user_id
					}
				});
			} else {
				this.$router.push({ 
					path: '/attendance/search/', 
					query: { 
						punch_in: this.$store.state.attendance.punch_in_date,
						punch_out: this.$store.state.attendance.punch_out_date,
						user_id: this.$store.state.attendance.search_user_id
					}
				});
			}
			
			this.getAttendance();
		},
	}
}; -->

