<template>
	<div>
		<div class="metabox-holder hrm-leave-type-records-wrap">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th>Employee</th>
					<th>Apply Date</th>
					<th>Leave Duration</th>
					<th>Comment</th>
					<th>Start</th>
					<th>End</th>
					<th>Action</th>

				</thead>
				<tbody>
					<tr v-for="pendingLeave in pendingLeaves">
						
						<td>
							<img :src="pendingLeave.employee.data.avatar_url" height="32" width="32">
							{{ pendingLeave.employee.data.display_name }}
						</td>
						<td>
							{{ dateFormat(pendingLeave.apply_at.date) }}
						</td>
						<td>1 day</td>

						<td v-html="pendingLeave.comments">

						</td>

						<td>{{ dateFormat(pendingLeave.start_time) }}</td>

						<td>{{ dateFormat(pendingLeave.end_time) }}</td>

						<td>
							<button @click.prevent="updateLeaveStatus(pendingLeave, 2)" class="button button-secondary">Approve</button>
							<button @click.prevent="selfLeaveDelete(pendingLeave.id)">Delete</button>
						</td>

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
				return this.$store.state.leave.pending_leaves;
			}
		},

		methods: {
			getSelfLeaveRecords () {
				var self = this;

				var records = {
					data: {
						'status': 1
					},
					callback: function(res) {
						self.$store.commit('leave/setPendingLeaves', res.data);
					}
				}

				this.getLeaveRecords(records);
			},

			selfLeaveDelete (id) {
            	var args = {
            		data: {
            			leave_id: id
            		},

            		callback: function() {

            		}
            	}

            	this.deleteLeave(args);
            }
		}
	}
</script>