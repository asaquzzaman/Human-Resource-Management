<template>
	<div class="hrm-attendance">
		<hrm-attendance-header></hrm-attendance-header>
		<hrm-attendace-punch-in-out-btn></hrm-attendace-punch-in-out-btn>

		<div class="metabox-holder hrm-attendance-records-wrap">
			<div class="hrm-records-text">
				<div class="hrm-attendance-records-text-wrap">
					<h2>Attendace Records</h2>
				</div>
				<div  class="hrm-records-from">
					<h2>From</h2>

					<span><i aria-hidden="true" class="fa fa-calendar"></i>{{ punchInFormatedDate }}</span>
				</div>
				<div class="hrm-records-to">
					<h2>To</h2>
					<span><i aria-hidden="true" class="fa fa-calendar"></i>{{ punchOutFormatedDate }}</span>
				</div>
				<div class="hrm-clear"></div>
			</div>
			<hrm-attendace-user-search></hrm-attendace-user-search>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th>Date</th>
					<th>In Time</th>
					<th>Out Time</th>
					<th>Duration</th>

				</thead>
				<tbody>
					<tr v-for="attendace in attendace_records">
						
						<td>{{ attendace.date }}</td>
						<td>{{ attendace.punch_in }}</td>
						<td v-html="attendace.punch_out"></td>
						<td v-html="attendace.total"></td>
					</tr>
					<tr v-if="attendace_records.length">
						<td><strong>Total Duration</strong></td>
						<td>&#8211 &#8211</td>
						<td>&#8211 &#8211</td>
						<td><strong>{{ totalOfficeTime }}</strong></td>
					</tr>
					<tr v-if="!attendace_records.length">
						
						<td colspan="4">No record found!</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</template>

<script>
	import hrm_attendace_punch_in_out_btn from './attendance-punch-in-out-btn.vue';
	import hrm_attendace_user_search from './attendance-user-search.vue';
	import hrm_attendance_header from './attendance-header.vue';

	export default {

		mixins: [HRMMixin.attendance],
		
		components: {
		    'hrm-attendace-punch-in-out-btn': hrm_attendace_punch_in_out_btn,
		    'hrm-attendace-user-search': hrm_attendace_user_search,
		    'hrm-attendance-header': hrm_attendance_header,
		},
		
		data: function() {
			return {
				
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
				return this.$store.state.attendance.attendance;
			},
			punchInFormatedDate: function() {
				let date = this.$store.state.attendance.punch_in_formated_date;

				return date ? date : this.firstDay();
			},
			punchOutFormatedDate: function() {
				let date = this.$store.state.attendance.punch_out_formated_date;
				return date ? date : this.lastDay();
			}
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

			firstDay () {

				var date = new Date(), 
					y = date.getFullYear(), 
					m = date.getMonth();

				var firstDay = new Date(y, m, 1);

	            date = moment(firstDay).format('YYYY-MM-DD');
	            
	            var format = 'MMMM DD YYYY';
	            
	            if ( HRM_Vars.wp_date_format == 'Y-m-d' ) {
	                format = 'YYYY-MM-DD';
	            
	            } else if ( HRM_Vars.wp_date_format == 'm/d/Y' ) {
	                format = 'MM/DD/YYYY';
	            
	            } else if ( HRM_Vars.wp_date_format == 'd/m/Y' ) {
	                format = 'DD/MM/YYYY';
	            } 

	            return moment( date ).format(format);
			},

			lastDay () {
				var date = new Date(), 
					y = date.getFullYear(), 
					m = date.getMonth();

				var lastDay = new Date(y, m + 1, 0);

	            date = moment(lastDay).format('YYYY-MM-DD');
	            
	            var format = 'MMMM DD YYYY';
	            
	            if ( HRM_Vars.wp_date_format == 'Y-m-d' ) {
	                format = 'YYYY-MM-DD';
	            
	            } else if ( HRM_Vars.wp_date_format == 'm/d/Y' ) {
	                format = 'MM/DD/YYYY';
	            
	            } else if ( HRM_Vars.wp_date_format == 'd/m/Y' ) {
	                format = 'DD/MM/YYYY';
	            } 

	            return moment( date ).format(format);
			}
		}	
	}
</script>
