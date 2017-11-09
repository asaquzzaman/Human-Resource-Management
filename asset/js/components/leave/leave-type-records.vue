<template>
	<div>
		<div class="metabox-holder hrm-leave-type-records-wrap">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th>Leave Type</th>
					<th>Days</th>
					<th>Start</th>
					<th>End</th>
					<th>Carry to next year</th>

				</thead>
				<tbody>
					<tr v-for="record in records">
						
						<td>{{ record.name }}</td>
						<td>{{ record.entitlement }}</td>

						<td v-if="record.next_year === 1">&#x000AF;&#x000AF;</td>
						<td v-else>{{ dateFormat(record.entitle_from) }}</td>

						<td v-if="record.next_year === 1">&#x000AF;&#x000AF;</td>
						<td v-else>{{ dateFormat(record.entitle_to) }}</td>

						<td>{{ carryStatus(record.next_year) }}</td>
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
	import HRM_Mixin from './../../mixin';
	import HRM_Leave_Store from './leave-store';
	
	var Hrm_Leave_Type_Records = {

		
		mixins: [HRM_Mixin],

		store: HRM_Leave_Store,
		
		data: function() {
			return {
				records: []
			}
		},

		computed: {

		},

		created: function() {
			this.getLeaveTypes();
		},
		methods: {
			getLeaveTypes: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

	            wp.ajax.send('get_leave_type', {
	                data: request_data,
	                success: function(res) {
	                    self.records = res.data;
	                },

	                error: function(res) {
	                    
	                }
	            });
			},

			carryStatus (next_year) {
				return parseInt(next_year) ? 'Enable' : 'Disable'; 
			}
		}
	};

	export default Hrm_Leave_Type_Records;
</script>