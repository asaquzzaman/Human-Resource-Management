<template>
	<div class="main hrm-attendance-user-searach-main">
		
		<input type="text" placeholder="From" name="punch_in" value=""  class="hrm-date-picker-from" id="punch_in" v-hrm-datepicker="" :value="punch_in_date">

		<input type="text" placeholder="To" name="punch_out" value="" class="hrm-date-picker-to" id="punch_out" v-hrm-datepicker="" :value="punch_out_date">

		<select class="user_id" name="user_id" id="user_id" v-model="search_user_id">
			<option value="-1">-Select Employee-</option>
			<option v-for="(employee, id) in employessDropDown" :value="id">{{ employee }}</option>
			
		</select>
		

		<button @click.prevent="search()" class="button button-secondary">Find</button>
	
	</div>
			
</template>

<script>
	export default {
		mixins: [HRMMixin.attendance],
		
		data: function() {
			return {
				//punch_in_date: 'sdgfashjfdgsad',
				//punch_out_date: '',
				//search_user_id: '-1'
			}
		},

		computed: {
			employessDropDown () {
				return this.$store.state.attendance.employessDropDown;
			},
			punch_in_date: function() {
				return this.$store.state.attendance.punch_in_date;
			},

			punch_out_date: function() {
				return this.$store.state.attendance.punch_out_date;
			},

			search_user_id: {
				get: function() {
					return this.$store.state.attendance.search_user_id;
				},

				set: function(val) {
					this.$store.commit( 'attendance/setSearchUserId', val );
				}
			}
		},

		created: function() {
			this.$on( 'hrm_date_picker', this.setdate );
			this.$store.commit( 'attendance/searchMode', {status: true} );

			this.search();
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
					this.$store.commit( 'attendance/setPunchInDate', { date: date } );
				}

				if ( date.field == 'datepicker_to' ) {
					this.$store.commit( 'attendance/setPunchOutDate', { date: date } );
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

					this.getAttendance();
				} 
				
				
			},
		}
	}
</script>


