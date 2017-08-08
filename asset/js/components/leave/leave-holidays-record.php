<div>
	<div class="metabox-holder hrm-leave-type-records-wrap">
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<th><?php _e( 'Name', 'hrm' ); ?></th>
				<th><?php _e( 'Start', 'hrm' ); ?></th>
				<th><?php _e( 'End', 'hrm' ); ?></th>
				<th><?php _e( 'Description', 'hrm' ); ?></th>

			</thead>
			<tbody>
				<tr v-for="record in records">
					
					<td>{{ record.name }}</td>
					<td>{{ record.from }}</td>
					<td>{{ record.to }}</td>
					<td>{{ record.description }}</td>
				</tr>
				<tr v-if="!records.length">
					
					<td colspan="4"><?php _e( 'No record found!', 'hrm' ); ?></td>
				</tr>
			</tbody>
		</table>

	</div>
</div>