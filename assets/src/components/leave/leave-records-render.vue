 <template>
	<div>
		<div class="metabox-holder">

			<hrm-leave-search></hrm-leave-search>
			<div id="hrm-leave-record-wrap">
				<div v-if="isFetchRecord">

					<div v-if="!records.length" class="notice notice-success">
						<p>No leave record found</p>
					</div>

					<div v-if="records.length" class="postbox">
						<h2 class="hndle ui-sortable-handle">
							<span>Summery</span>
						</h2>
						<div class="inside metabox-holder hrm-leave-type-records-wrap">
							<table class="wp-list-table widefat fixed striped">
								<thead>
									<tr>
										<th class="manage-column column-cb">Leave Type</th>
										<th>Entitlement</th>
										<th>Taken Leave</th>
										<th>Remain</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="type in meta.types">
										
										<td>{{ type.leave_type_name }}</td>
										
										<td v-if="type.id === 1">&#8211;</td>
										<td v-else>{{ pad(type.entitlement) }}</td>
										
										<td>{{ pad(type.count) }}</td>
										
										<td v-if="type.id === 0">&#8211;</td>
										<td v-else>{{ pad(type.entitlement - type.count) }}</td>

									</tr>
									<tr>
										<td><strong>Total</strong></td>
										<td><strong>{{ pad(total.entitlement) }}</strong></td>
										<td><strong>{{ pad(total.taken_leave) }}</strong></td>
										<td><strong>{{ pad(total.remain_leave) }}</strong></td>
									</tr>
								</tbody>
							</table>

						</div>
					</div>
					
					<div class="postbox" v-for="record in records">
						<h2 class="hndle ui-sortable-handle">
							<span>{{ selfDateFormat(record.date) }}</span>
						</h2>
						<div class="inside metabox-holder hrm-leave-type-records-wrap">

							<table class="wp-list-table widefat fixed striped">
								<thead>
									<tr>
										<th class="manage-column column-cb">Leave Type</th>
										<th>Duration</th>
										<th>Start</th>
										<th>End</th>
										<th>Status</th>
										<th>Action</th>
									</tr>

								</thead>
								<tbody>
									<tr :data-recordID="leave.id" v-for="leave in record.activities">
										
										<td>{{ leave.leave_type.data.name }}</td>
										<td>1</td>
										<td>{{ dateFormat(leave.start_time) }}</td>
										<td>{{ dateFormat(leave.end_time) }}</td>
										<td>{{ status[leave.status] }}</td>
										<td>
											<button class="hrm-button-secondary" @click.prevent="selfLeaveDelete(leave.id)" v-if="leave.status === 1 || leave.status === 3">Delete</button>
											<div v-else>Not available</div>
										</td>
									</tr>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import LeaveSearch from './leave-search.vue';
    import Mixin from './mixin'
	
	export default {
		data() {
			return {
				status: {
					1: 'Pending', 
					2: 'Approve', 
					3: 'Cancel'
				}
			}
		},
		mixins: [Mixin],
		computed: {
			financialStart () {
				return this.$route.query.start_time || HRM_Vars.financial_start;
			},
			financialEnd () {
				return this.$route.query.start_time || HRM_Vars.financial_end;
			},
			records () {
				var self = this;
				var records = this.$store.state.leave.leave_records;
				var records = _.chain(records)
                    .groupBy(self.occurrenceDay)
                    .map(self.groupToDay)
                    .sortBy('month')
                    .value();

                return records;
			},

			meta () {
				return this.$store.state.leave.leave_meta;
			},

			total () {
				if(!this.$store.state.leave.leave_meta.types) {
					return [];
				}

				var types = this.$store.state.leave.leave_meta.types,
					total_extra = 0;

				var total = {
					entitlement: 0,
					taken_leave: 0,
					remain_leave: 0
				};

				types.forEach(function(type, index) {
					total.entitlement = parseInt(type.entitlement) + total.entitlement;
					total.taken_leave = parseInt(type.count) + total.taken_leave;

					if ( type.id === 1) {
						total_extra = total_extra + parseInt(type.count);
					}
				});

				total.remain_leave = (total.entitlement - total.taken_leave) + total_extra;

				return total;
			}
		},

		components: {
			'hrm-leave-search': LeaveSearch
		},

		created () {
			this.getLeaveRecords({
				data: {
					'emp_id': HRM_Vars.current_user.data.ID,
					'query': this.$route.query
				}
			});
		},

		methods: {
			occurrenceDay (occurrence){
                var date = new Date(occurrence.start_time);
                var date = hrm.Moment(date).format('YYYY-MM-DD');

                return hrm.Moment(date).startOf('month').format('YYYY-MM-DD');
            },

            groupToDay(group, day){
                return {
                    date: day,
                    activities: group
                }
            },
            selfDateFormat (date) {
            	return hrm.Moment(date).format('MMMM');
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

<style>
	.hrm-start-date, .hrm-end-date {
		font-size: 11px;
		color: #333;
		font-weight: 800;
	}
	.page-title-action {
		margin-top: 14px;
	    padding: 4px 8px;
	    position: relative;
	    text-decoration: none;
	    border: none;
	    border: 1px solid #ccc;
	    -webkit-border-radius: 2px;
	    border-radius: 2px;
	    background: #f7f7f7;
	    text-shadow: none;
	    font-weight: 600;
	    font-size: 13px;
	    line-height: normal;
	    color: #0073aa;
	    outline: 0;
	    display: inline-block;
	}

	.wrap .page-title-action:hover {
		background: #f7f7f7;
		color: #0073aa;
		border: 1px solid #ccc;
	}

	.ui-sortable-handle {
		border: none !important;
	}
	.postbox .inside {
		margin: 0 !important;
	}
	#wpbody-content .metabox-holder {
		padding-top: 0 !important;
	}
	.metabox-holder {
		margin-top: 8px;
	}
</style>