<template>
	<div>
		<hrm-attendance-header></hrm-attendance-header>
		<div class="metabox-holder hrm-punch-in-out-wrap">
			<div class="postbox">

				<h2 class="hndle ui-sortable-handle">
					<span>Attendance Configuration</span>
				</h2>

				<div class="inside">
					<div class="hrm-attendance-configuration" id="hrm-hidden-form">
						<div class="hrm-form-field ">
							<label for="">
								Enabale multiple attendance
								<em></em>
							</label>
							<span class="hrm-checkbox-wrap">
								<input type="checkbox" value="yes" id="hrm-multi-attendance-checkbox" v-model="hrm_is_multi_attendance">
								<label class="hrm-radio" for="hrm-multi-attendance-checkbox">Enable</label>
							</span>
							<span class="hrm-clear"></span>
							<span class="description">Enable multiple attendance for per day</span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-office-start-date-field">
								Office start time
								<em>   </em>
							</label>
							<input type="text" v-hrm-datepicker="" :value="office_start_with_date_time" class="hrm-date-time-picker-from" id="hrm-office-start-date-field">
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-office-closed-date-field">
								Office closing time
								<em>   </em>
							</label>
							<input type="text" v-hrm-datepicker="" :value="office_closed_with_date_time" class="hrm-date-time-picker-to" id="hrm-office-closed-date-field">
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for=" ">
								Allow IP
								<em>   </em>
							</label>
							<textarea type="textarea" value="" placeholder="IP seperated by pipe &quot;|&quot;" v-model="allow_ip"></textarea>
							<span class="hrm-clear"></span>
							<span class="description">Employee can puch in/out only from this IP</span>
						</div>

						<input @click.prevent="saveConfiguration()" type="submit" class="button hrm-submit-button button-primary" name="requst" value="Save changes">
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import hrm_attendance_header from './attendance-header.vue';

	export default {
		mixins: [HRMMixin.attendance],
	
		data: function() {
			return {
				
			}
		},

		components: {
		    'hrm-attendance-header': hrm_attendance_header,
		},

		computed: {
			office_start_with_date_time: function() {
				return this.$store.state.attendance.office_start_with_date_time;
			},

			office_closed_with_date_time: function() {
				return this.$store.state.attendance.office_closed_with_date_time;
			},
			hrm_is_multi_attendance: {
				get: function() {
					return this.$store.state.attendance.hrm_is_multi_attendance;
				},

				set: function(val) {
					this.$store.commit('attendance/setMultiAttendance', val);
				}
			},

			allow_ip: {
				get: function() {
					return this.$store.state.attendance.allow_ip;
				},
				
				set: function(val) {
					this.$store.commit('attendance/setAllowIP', val);
				}
			}
		},

		created: function() {
			
			this.attendanceInit();
			this.$on('hrm_date_picker', this.setDateTime);
		},
		methods: {
			attendanceInit: function() {
				var request_data = {
					_wpnonce: HRM_Vars.nonce,
				},
				self  = this;

				wp.ajax.send( 'attendance_init', {
	                data: request_data,
	                success: function(res) {
	      				self.$store.commit( 'attendance/setInitVal', res );
	                },

	                error: function(res) {
	                	
	                }
	            });
			},
			setDateTime: function(date_time) {

				if( date_time.field == 'datetimepicker_from' ) {
					//this.office_start = date_time.date_time;
					this.$store.commit( 'office_start', date_time );
				}

				if( date_time.field == 'datetimepicker_to' ) {
					//this.office_closed = date_time.date_time;
					this.$store.commit( 'office_closed', date_time );
				}
			},
			saveConfiguration: function() {
				var request_data = {
						_wpnonce: HRM_Vars.nonce,
						hrm_is_multi_attendance: this.hrm_is_multi_attendance,
						office_start: this.$store.state.attendance.office_start_with_date_time,
						office_closed: this.$store.state.attendance.office_closed_with_date_time,
						allow_ip: this.$store.state.attendance.allow_ip

					},
					self = this;
				
				this.punch_in = 'disable';
				
				wp.ajax.send('attendance_configuration', {
	                data: request_data,
	                success: function(res) {
	                	// Display a success toast, with a title
	                    toastr.success(res.success);
	                    
	                    self.$store.commit( 'attendance/setAttendance', {records: res.attendance} );
	                },

	                error: function(res) {
	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        toastr.error(value);
	                    });
	                }
	            });
			}
		}
	}
</script>

