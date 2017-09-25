<template>
	<div>
		<div class="metabox-holder hrm-leave-type-records-wrap">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th>Name</th>
					<th>Start</th>
					<th>End</th>
					<th>Description</th>

				</thead>
				<tbody>
					<tr v-for="record in records">
						
						<td>{{ record.name }}</td>
						<td>{{ record.from }}</td>
						<td>{{ record.to }}</td>
						<td>{{ record.description }}</td>
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

	export default {

		mixins: [HRM_Mixin],

		//store: HRM_Leave_Store,
		
		data: function() {
			return {
				records: []
			}
		},

		computed: {

		},

		created: function() {
			this.getHolidays();
		},
		methods: {
			getHolidays: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

	            wp.ajax.send('get_holidays', {
	                data: request_data,
	                success: function(res) {
	                	
	                    self.records = res.holidays;
	                },

	                error: function(res) {
	                    
	                }
	            });
			}
		}
	};
</script>