<template>
	<div>
		<div class="metabox-holder hrm-leave-type-records-wrap">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<th>Employee</th>
					<th>Action</th>

				</thead>
				<tbody>
					<tr v-for="pendingLeave in pendingLeaves">
						
						<td>
							<img :src="pendingLeave.employee.data.avatar_url" height="32" width="32">
							{{ pendingLeave.employee.data.display_name }}
						</td>

						<td>
							<button @click.prevent="updateLeaveStatus(pendingLeave, 2)" class="button button-secondary">Approve</button>
							<button @click.prevent="updateLeaveStatus(pendingLeave, 3)" class="button secondary">Cancel</button>
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

		computed: {
			pendingLeaves () {
				return this.$store.state.pending_leaves;
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
						self.$store.commit('setPendingLeaves', res.data);
					}
				}

				this.getLeaveRecords(records);
			},
		}
	}
</script>