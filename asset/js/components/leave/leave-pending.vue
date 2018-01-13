<template>
	<div class="hrm-leave">
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
					<th>Action</th>

				</thead>
				<tbody>
					<tr class="leave-action-tr" v-for="(pendingLeave, index) in pendingLeaves" :key="index">
						
						<td v-if="!pendingLeave.metaSummeryDisplay">
							<div>
								<div class="hrm-td-content">
									<div class="hrm-image">
										<img :src="pendingLeave.employee.data.avatar_url" height="32" width="32">
									</div>
									<span class="hrm-employee-name">{{ pendingLeave.employee.data.display_name }}</span>
									<div class="hrm-clear"></div>
								</div>
				                <div class="leave-action-wrap">
				                    <div class="leave-action">
				                        <a href="#" @click.prevent="selfEmployeeLeaveSummery(pendingLeave.employee.data.id, pendingLeave.id)" class="pm-todo-edit">
				                            <span class="">Summery</span>
				                        </a>
				                    </div>
				                </div>
			            	</div>

						</td>
						<td v-if="!pendingLeave.metaSummeryDisplay">
							{{ pendingLeave.leave_type.data.name }}
						</td>
						<td v-if="!pendingLeave.metaSummeryDisplay">
							{{ dateFormat(pendingLeave.apply_at.date) }}
						</td>
						<td v-if="!pendingLeave.metaSummeryDisplay">
							1 day
						</td>

						<td v-if="!pendingLeave.metaSummeryDisplay" v-html="pendingLeave.comments">

						</td>

						<td v-if="!pendingLeave.metaSummeryDisplay">
							{{ dateFormat(pendingLeave.start_time) }}
						</td>

						<td v-if="!pendingLeave.metaSummeryDisplay">
							{{ dateFormat(pendingLeave.end_time) }}
						</td>

						<td v-if="!pendingLeave.metaSummeryDisplay">

							
							<button v-if="canManamgeLeave()" @click.prevent="selfUpdateLeaveStatus(pendingLeave, 2)" class="button button-secondary">
								<i class="fa fa-check" aria-hidden="true"></i>
							</button>
							<button v-if="canManamgeLeave()" @click.prevent="selfUpdateLeaveStatus(pendingLeave, 3)" class="button button-secondary">
								<i class="fa fa-ban" aria-hidden="true"></i>
							</button>
							<button class="button button-secondary" @click.prevent="selfLeaveDelete(pendingLeave.id)">
								<i class="fa fa-trash-o" aria-hidden="true"></i>
							</button>
						</td>

						<td colspan="8" v-if="pendingLeave.metaSummeryDisplay">
							<div>

									<table class="wp-list-table widefat fixed striped">
										<thead>
											<th>Leave Type</th>
											<th>Entitlement</th>
											<th>Taken Leave</th>
											<th>Remain</th>
										</thead>
										<tbody>
											<tr v-for="type in pendingLeave.metaSummery">
												
												<td>{{ type.leave_type_name }}</td>
												
												<td v-if="type.id === 1">&#8211;</td>
												<td v-else>{{ pad(type.entitlement) }}</td>
												
												<td>{{ pad(type.count) }}</td>
												
												<td v-if="type.id === 0">&#8211;</td>
												<td v-else>{{ pad(type.entitlement - type.count) }}</td>

											</tr>
											<tr>
												<td><strong>Total</strong></td>
												<td><strong>{{ pad( totalEntitlement( pendingLeave.metaSummery ) ) }}</strong></td>
												<td><strong>{{ pad( totalTakeLeave( pendingLeave.metaSummery ) ) }}</strong></td>
												<td><strong>{{ pad( totalRemainLeave( pendingLeave.metaSummery ) ) }}</strong></td>
											</tr>
										</tbody>
									</table>

									<a href="#" style="margin-top: 10px;" @click.prevent="showHideSummery(pendingLeave, 'pending')" class="button button-secondary">Cancel</a>

								
			            	</div>
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
		mixins: [HRMMixin.leave],

		computed: {

			pendingLeaves () {
				return this.$store.state.leave.pending_leaves;
			}
		},
		created () {
			this.getSelfLeaveRecords();
		},
		methods: {
			total () {
				
			},
			selfEmployeeLeaveSummery (employee_id, row_id) {
				
				var args = {
					data: {
						employee_id: employee_id,
						row_id: row_id,
						type: 'pending'
					},

					callback () {

					}
				}

				this.employeeLeaveSummery(args);
			},
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
	                			section: 1,
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