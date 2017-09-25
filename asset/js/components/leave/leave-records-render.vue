<template>
	<div>
		<div class="metabox-holder hrm-leave-type-records-wrap">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th><?php _e( 'Leave Type', 'cpm' ); ?></th>
					<th><?php _e( 'Days', 'cpm' ); ?></th>
					<th><?php _e( 'Start', 'cpm' ); ?></th>
					<th><?php _e( 'End', 'cpm' ); ?></th>

				</thead>
				<tbody>
					<tr v-for="record in records">
						
						<td>{{ record.leave_type_name }}</td>
						<td>{{ record.entitlement }}</td>
						<td>{{ record.entitle_from }}</td>
						<td>{{ record.entitle_to }}</td>
					</tr>
					<tr v-if="!records.length">
						
						<td colspan="4"><?php _e( 'No record found!', 'hrm' ); ?></td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</template>

<script>
	export default {

		//store: HRM_Leave_Store,
		
		data: function() {
			return {
				records: []
			}
		},

		computed: {

		},

		created: function() {
			this.getLeaveRecords();
		},
		methods: {
			getLeaveRecords: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

	            wp.ajax.send('get_leave_records', {
	                data: request_data,
	                success: function(res) {
	                	
	                    self.records = res.leave_types;
	                },

	                error: function(res) {
	                    
	                }
	            });
			}
		}
	}
</script>