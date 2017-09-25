<template>
	<div>
		<div class="metabox-holder hrm-leave-type-records-wrap">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th>Leave Type</th>
					<th>Days</th>
					<th>Start</th>
					<th>End</th>

				</thead>
				<tbody>
					<tr v-for="record in records">
						
						<td>{{ record.leave_type_name }}</td>
						<td>{{ record.entitlement }}</td>
						<td>{{ record.entitle_from }}</td>
						<td>{{ record.entitle_to }}</td>
					</tr>
					<tr v-if="!records.length">
						
						<td colspan="4">No record found!</td>
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