<template>
	<div class="hrm-attendance">
		<hrm-attendance-header></hrm-attendance-header>
	
		<hrm-attendace-punch-in-out-btn v-if="isFetchRecord"></hrm-attendace-punch-in-out-btn>

		<div v-if="shiftDetails" class="metabox-holder hrm-punch-in-out-wrap">
			<div class="postbox">

				<h2 class="hndle ui-sortable-handle">
					<span>{{ shiftDetails.name }} Shift Details</span>
				</h2>

				<div class="inside">
					<div class="individual-shift-details-wrap" v-for="(time, tindex) in shiftDetails.times">
						<div class="number-count">
							<span>{{ number_suffix(parseInt(tindex)+1) }}</span>
						</div>
						<div class="start-time">
							<b>Start</b> <span class="block">{{time.begin}}</span>
						</div>
						<div class="end-time">
							<b>End</b> <span class="block">{{time.end}}</span>
						</div>
						<div v-if="hasBreakTime(time.breaks)" class="break-time-wrap">
							<div class="break-time">Break Time</div>
							<div>
								<div v-if="hasChildBreak(brak)" v-for="(brak, index) in time.breaks">
									<div v-if="index == 0"><b>From</b> {{ brak.breakBegin }} <b>to</b> {{ brak.breakEnd }}</div>
									<div v-if="index > 0"><b>And</b> {{ brak.breakBegin }} <b>to</b> {{ brak.breakEnd }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="metabox-holder hrm-attendance-records-wrap">
			<div class="hrm-records-text">
				<div class="hrm-attendance-records-text-wrap">
					<h2>Attendace Records</h2>
				</div>

				<div class="hrm-clear"></div>
			</div>
			<hrm-attendace-user-search></hrm-attendace-user-search>
			<div id="hrm-list-table">
				<table v-if="isFetchRecord" class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>In Time</th>
							<th>Out Time</th>
							<th>Duration</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="attendace in attendace_records">
							
							<td>{{ attendace.date }}</td>
							<td>{{ punchFormat( attendace.punch_in ) }}</td>
							<td>{{ punchFormat(attendace.punch_out) }}</td>
							<td>{{ attendace.second_to_time }}</td>
						</tr>
						<!-- <tr v-if="attendace_records.length">
							<td><strong>Total Duration</strong></td>
							<td>&#8211 &#8211</td>
							<td>&#8211 &#8211</td>
							<td><strong>{{ totalOfficeTime }}</strong></td>
						</tr> -->
						<tr v-if="!attendace_records.length">
							
							<td colspan="4">No record found!</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</template>

<style lang="less">
	.hrm-attendance {
		.inside {
			margin-top: 20px;
		}
		.individual-shift-details-wrap {
			display: flex;
			&:not(:first-child) {
				margin-top: 10px;
			}
			.number-count {
				border: 1px solid #ccc;
			    border-radius: 30px;
			    height: 30px;
			    width: 30px;
			    text-align: center;
			    line-height: 28px;
			    margin-top: -6px;
			    background: #ddd;
			    margin-right: 10px;
			    font-weight: 600;
			}
			.break-time-wrap {
				display: flex;
				.break-time {
					margin-right: 15px;
				}
			}
			.start-time {
				width: 90px;
			}
			.end-time {
				margin-left: 8px;
				width: 90px;
			}
			.block {
				border: 1px solid #eee;
			    padding: 1px 5px;
			    background: #f4f4f4;
			}
		}
	}
</style>

<script>
	import hrm_attendace_punch_in_out_btn from './attendance-punch-in-out-btn.vue';
	import hrm_attendace_user_search from './attendance-user-search.vue';
	import hrm_attendance_header from './attendance-header.vue';
	import Mixin from './mixin'

	export default {

		mixins: [Mixin],
		
		components: {
		    'hrm-attendace-punch-in-out-btn': hrm_attendace_punch_in_out_btn,
		    'hrm-attendace-user-search': hrm_attendace_user_search,
		    'hrm-attendance-header': hrm_attendance_header,
		},
		
		data: function() {
			return {
				isFetchRecord: false
			}
		},

		created: function() {
			this.attendanceInit();
			this.getAttendance();
		},

		computed: {
			totalOfficeTime: function() {
				return this.$store.state.attendance.totalOfficeTime;
			},
			attendace_records: function() {
				return this.$store.state.attendance.attendance.data;
			},
			punchInFormatedDate: function() {
				let date = this.$store.state.attendance.punch_in_formated_date;

				return date ? date : this.firstDay();
			},
			punchOutFormatedDate: function() {
				let date = this.$store.state.attendance.punch_out_formated_date;
				return date ? date : this.lastDay();
			},

			shiftDetails () {
				var details = this.$store.state.attendance.shiftDetails;

				if(jQuery.isEmptyObject(details) || !details) {
					return false;
				}

				return details;
			}
		},
		methods: {
			punchFormat (dateTime) {
				dateTime = new Date(dateTime);
				let date = hrm.Moment(dateTime).format('MMM D, kk:mm');

				if( date == 'Invalid date' ) {
					return '00:00'
				}

				return date;
			},

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

			firstDay () {

				var date = new Date(), 
					y = date.getFullYear(), 
					m = date.getMonth();

				var firstDay = new Date(y, m, 1);

	            date = hrm.Moment(firstDay).format('YYYY-MM-DD');
	            
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

			lastDay () {
				var date = new Date(), 
					y = date.getFullYear(), 
					m = date.getMonth();

				var lastDay = new Date(y, m + 1, 0);

	            date = hrm.Moment(lastDay).format('YYYY-MM-DD');
	            
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
			hasBreakTime (breasks) {
				if(!breasks.length) {
					return false;
				}

				if(breasks[0].breakBegin == '' || breasks[0].breakEnd == '' ) {
					return false;
				}

				return true;
			},

			hasChildBreak (breakChild) {
				if(breakChild.breakBegin == '' || breakChild.breakEnd == '' ) {
					return false;
				}

				return true;
			}
		}	
	}
</script>
