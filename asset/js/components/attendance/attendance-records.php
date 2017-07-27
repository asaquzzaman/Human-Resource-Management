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

				<span><i aria-hidden="true" class="fa fa-calendar"></i><?php echo date( 'F j, Y', strtotime( date('Y-m-01') ) ) ?></span>
			</div>
			<div class="hrm-records-to">
				<h2><?php _e( 'To', 'hrm' ); ?></h2>
				<span><i aria-hidden="true" class="fa fa-calendar"></i><?php echo date( 'F j, Y', strtotime( current_time( 'mysql' ) ) ) ?></span>
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
			</tbody>
		</table>

	</div>
</div>