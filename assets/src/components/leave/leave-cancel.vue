<template>
	<div class="hrm-leave">
		<div class="metabox-holder hrm-leave-type-records-wrap">
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th class="manage-column column-cb">Employee</th>
						<th>Leave Type</th>
						<th>Apply Date</th>
						<th>Leave Duration</th>
						<th>Comment</th>
						<th>Start</th>
						<th>End</th>
						<th>Action</th>
					</tr>

				</thead>
				<tbody>
					<tr v-for="pendingLeave in pendingLeaves">
						
						<td>

							<div>
								<div class="hrm-td-content">
									<div class="hrm-image">
										<img :src="pendingLeave.employee.data.avatar_url" height="32" width="32">
									</div>
									<span class="hrm-employee-name">{{ pendingLeave.employee.data.display_name }}</span>
									<div class="hrm-clear"></div>
								</div>
			            	</div>

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

						<td>
							<button v-if="canManamgeLeave()" @click.prevent="selfUpdateLeaveStatus(pendingLeave, 1)" class="button button-secondary">
								<i class="fas fa-undo" aria-hidden="true"></i>
							</button>
							<button class="button button-secondary" v-if="canManamgeLeave()" @click.prevent="selfLeaveDelete(pendingLeave.id)">
								<i class="fas fa-trash" aria-hidden="true"></i>
							</button>
							<div v-if="!canManamgeLeave()">Not available</div>
						</td>

					</tr>

					
					<tr v-if="!pendingLeaves.length">
						
						<td colspan="7">No record found!</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</template>

<style>
	.hrm-image, .hrm-employee-name {
		float: left;
	}
	.hrm-employee-name  {
		width: 60%;
    	margin-left: 5px;
    	margin-top: -3px;
    	word-wrap: break-word;

	}
	.hrm-td-content, .leave-action-wrap {
		display: block;
	}
	.leave-action-wrap {
		height: 5px;
		margin-top: 5px;
		margin-bottom: 10px;
	}
	.hrm-employee-name {
		font-weight: 600;
	}
	.leave-action {
		font-size: 12px;
		display: none;
	}
	.leave-action-tr:hover .leave-action {
		display: block;
	}
</style>

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
				return this.$store.state.leave.cancelLeaves;
			}
		},

		methods: {
			getSelfLeaveRecords () {
				var self = this;

				var records = {
					data: {
						'status': 3
					},
					callback: function(res) {
						self.$store.commit('leave/setCancelLeaves', res.data);
					}
				}

				this.getLeaveRecords(records);
			},

			selfUpdateLeaveStatus (pendingLeave, status) {
				var self = this;
				
				var args = {
					data: {
						id: pendingLeave.id,
		                status: status,
		                class: 'Leave',
		                method: 'update',
					},
	                callback: function(res) {
	                	self.$store.commit('leave/afterUpdateStatus', 
	                		{
	                			section: 3,
	                			record: res
	                		}
	                	);
	                }
	            };

	            self.updateLeave(args);
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