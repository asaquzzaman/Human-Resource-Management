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
						
						<td>{{ record.leave_type.name }}</td>
						<td>1</td>
						<td>{{ dateFormat(record.start_time) }}</td>
						<td>{{ dateFormat(record.end_time) }}</td>
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
		computed: {
			records () {
				return this.$store.state.leave_records;
			}
		},

		created () {
			this.getLeaveRecords({
				'emp_id': HRM_Vars.current_user.data.ID
			});
		},
	}
</script>