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