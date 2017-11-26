<template>
	<div>
		<hrm-attendace-punch-in-out-btn></hrm-attendace-punch-in-out-btn>
		<hrm-attendace-user-search></hrm-attendace-user-search>

		<div class="metabox-holder hrm-attendance-records-wrap">
			<div class="hrm-records-text">
				<div class="hrm-attendance-records-text-wrap">
					<h2><?php //_e( 'Attendace Records', 'hrm' ); ?></h2>
				</div>
				<div  class="hrm-records-from">
					<h2><?php _e( 'From', 'hrm' ); ?></h2>

					<span><i aria-hidden="true" class="fa fa-calendar"></i>{{ punchInFormatedDate }}<?php //echo date( 'F j, Y', strtotime( date('Y-m-01') ) ) ?></span>
				</div>
				<div class="hrm-records-to">
					<h2><?php _e( 'To', 'hrm' ); ?></h2>
					<span><i aria-hidden="true" class="fa fa-calendar"></i>{{ punchOutFormatedDate }}<?php //echo date( 'F j, Y', strtotime( current_time( 'mysql' ) ) ) ?></span>
				</div>
				<div class="hrm-clear"></div>
			</div>


			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th><?php _e( 'Date', 'cpm' ); ?></th>
					<th><?php _e( 'In Time', 'cpm' ); ?></th>
					<th><?php _e( 'Out Time', 'cpm' ); ?></th>
					<th><?php _e( 'Duration', 'cpm' ); ?></th>

				</thead>
				<tbody>
					<tr v-for="attendace in attendace_records">
						
						<td>{{ attendace.date }}</td>
						<td>{{ attendace.punch_in }}</td>
						<td v-html="attendace.punch_out"></td>
						<td v-html="attendace.total"></td>
					</tr>
					<tr v-if="!attendace_records.length">
						
						<td colspan="4"><?php _e( 'No record found!', 'hrm' ); ?></td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</template>

<script>
	export default {
		mixins: [HRM_Common_Mixin],
		
		components: {
		    'hrm-attendace-punch-in-out-btn': hrm_attendace_punch_in_out_btn,
		    'hrm-attendace-user-search': hrm_attendace_user_search,
		},
		
		data: function() {
			return {
				
			}
		},
		created: function() {
			this.attendanceInit();
			if( this.$route.name != 'attendance_search') {
				this.getAttendance();
			}
		},
		computed: {
			attendace_records: function() {
				return this.$store.state.attendance;
			},
			punchInFormatedDate: function() {
				return this.$store.state.punch_in_formated_date
			},
			punchOutFormatedDate: function() {
				return this.$store.state.punch_out_formated_date
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
	      				self.$store.commit( 'setInitVal', res );
	                },

	                error: function(res) {
	                	
	                }
	            });
			},
			getAttendance: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

	            wp.ajax.send('get_attendance', {
	                data: request_data,
	                success: function(res) {
	                	
	                    self.$store.commit( 'setAttendance', {records: res.attendance} );
	                },

	                error: function(res) {
	                    
	                }
	            });
			}
		}	
	}
</script>

<!-- var hrm_attendace_records = {
	
	template: '#tmpl-hrm-attendance-records',
	mixins: [HRM_Common_Mixin],
	
	components: {
	    'hrm-attendace-punch-in-out-btn': hrm_attendace_punch_in_out_btn,
	    'hrm-attendace-user-search': hrm_attendace_user_search,
	},
	
	data: function() {
		return {
			
		}
	},
	created: function() {
		this.attendanceInit();
		if( this.$route.name != 'attendance_search') {
			this.getAttendance();
		}
	},
	computed: {
		attendace_records: function() {
			return this.$store.state.attendance;
		},
		punchInFormatedDate: function() {
			return this.$store.state.punch_in_formated_date
		},
		punchOutFormatedDate: function() {
			return this.$store.state.punch_out_formated_date
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
      				self.$store.commit( 'setInitVal', res );
                },

                error: function(res) {
                	
                }
            });
		},
		getAttendance: function() {
			var request_data = {
                _wpnonce: HRM_Vars.nonce,
            },
            self = this;

            wp.ajax.send('get_attendance', {
                data: request_data,
                success: function(res) {
                	
                    self.$store.commit( 'setAttendance', {records: res.attendance} );
                },

                error: function(res) {
                    
                }
            });
		}
	}
}; -->
