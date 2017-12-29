<template>
	<div>
		<div class="metabox-holder hrm-leave-type-records-wrap">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th>Employee</th>
					<th>Leave Type</th>
					<th>Apply Date</th>
					<th>Leave Duration</th>
					<th>Comment</th>
					<th>Start</th>
					<th>End</th>
					<!-- <th>Action</th> -->

				</thead>
				<tbody>
					<tr v-for="pendingLeave in pendingLeaves">
						
						<td>
							<img :src="pendingLeave.employee.data.avatar_url" height="32" width="32">
							{{ pendingLeave.employee.data.display_name }}
						</td>
						<td>
							{{ pendingLeave.leave_type.data.name }}
						</td>

						<td>
							{{ dateFormat(pendingLeave.apply_at.date) }}
						</td>
						<td>1 day</td>

						<td v-html="pendingLeave.comments">

						</td>

						<td>{{ dateFormat(pendingLeave.start_time) }}</td>

						<td>{{ dateFormat(pendingLeave.end_time) }}</td>

						<!-- <td>
							<button @click.prevent="updateLeaveStatus(pendingLeave, 2)" class="button button-secondary">Approve</button>
							<button @click.prevent="updateLeaveStatus(pendingLeave, 3)" class="button secondary">Cancel</button>
						</td> -->

					</tr>


					<tr v-if="!pendingLeaves.length">
						
						<td colspan="6">No record found!</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</template>

<script>
	export default {
		beforeRouteEnter (to, from, next) {
			next (vm => {
				vm.getSelfLeaveRecords();
			});
		},
		mixins: [HRMMixin.leave],
		computed: {
			pendingLeaves () {
				return this.$store.state.leave.approvedLeaves;
			}
		},

		methods: {
			getSelfLeaveRecords () {
				var self = this;

				var records = {
					data: {
						'status': 2
					},
					callback: function(res) {
						self.$store.commit('leave/setApprovalLeaves', res.data);
					}
				}

				this.getLeaveRecords(records);
			},
		}
	}
</script>