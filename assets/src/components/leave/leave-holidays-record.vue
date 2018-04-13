<template>
	<div>
		<div id="hrm-holiday-table" class="metabox-holder hrm-leave-type-records-wrap">
			<table  v-if="isFetchRecord" class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th class="manage-column column-cb">Name</th>
						<th>Start</th>
						<th>End</th>
						<th>Description</th>
					</tr>

				</thead>
				<tbody>
					<tr class="hrm-tr" v-for="record in records">
						
						<td v-if="!record.editMode">
							{{ record.name }}
							<div class="row-actions">
								<span class="edit">
									<a @click.prevent="showHideHolidayUpdateForm('toggle', record)" href="#" aria-label="Edit “Hello world!”">
										Edit
									</a> 
								</span>
								|
								<span class="edit">
									<a @click.prevent="selfDeleteHoliday(record)" href="#" aria-label="Edit “Hello world!”">
										Delete
									</a> 
								</span>
							</div>
						</td>
						<td v-if="!record.editMode">{{ dateFormat(record.from) }}</td>
						<td v-if="!record.editMode">{{ dateFormat(record.to) }}</td>
						<td v-if="!record.editMode">{{ record.description }}</td>

						<td v-if="record.editMode" colspan="4">
							<holiday-edit-form :holiday="record"></holiday-edit-form>
						</td>
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
	
	import EditForm from './holiday-edit-form.vue';
    import Mixin from './mixin'
	
	export default {

		mixins: [Mixin],
		
		data: function() {
			return {
				
			}
		},

		components: {
			'holiday-edit-form': EditForm,
		},

		computed: {
			records () {
				return this.$store.state.leave.holidays;
			}
		},

		created: function() {
			this.getHolidays();
		},
		methods: {
			selfDeleteHoliday (holiday) {
				let formData = {
					id: holiday.id,
					callback () {

					}
				}

				this.deleteHoliday(formData);
			},
			getHolidays: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

	            wp.ajax.send('get_holidays', {
	                data: request_data,
	                beforeSend () {
	                	self.loadingStart('hrm-holiday-table');
	                },
	                success: function(res) {
	                	res.holidays.forEach(function(holiday) {
	                		self.addHolidayMeta(holiday);
	                	});
	                	self.loadingStop('hrm-holiday-table');
	                    self.$store.commit('leave/setHoliday', res.holidays);
	                    self.isFetchRecord = true;
	                },

	                error: function(res) {
	                    
	                }
	            });
			}
		}
	};
</script>