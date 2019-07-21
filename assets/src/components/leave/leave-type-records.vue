<template>
	<div>
		<div id="hrm-leave-type-records-wrap" class="metabox-holder hrm-leave-type-records-wrap">
			<table v-if="isFetchRecord" class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th class="manage-column column-cb">Leave Type</th>
						<th>Days</th>
						<th>Start</th>
						<th>End</th>
						<th>Carry to next year</th>
					</tr>

				</thead>
				<tbody>
					<tr v-for="record in records" class="hrm-tr  inline-edit-row inline-edit-row-post inline-edit-post quick-edit-row quick-edit-row-post inline-edit-post inline-editor">
						
						<td v-if="!record.editMode" class="hrm-td">
							<div class="hrm-td-content">
								{{ record.name }}
								
								<div class="row-actions">
									<span class="edit">
										<a @click.prevent="showHideLeaveTypeUpdateForm('toggle', record)" href="#" aria-label="Edit “Hello world!”">
											Edit
										</a> 
									</span>
									|
									<span class="edit">
										<a @click.prevent="selfDeleteLeaveType(record)" href="#" aria-label="Edit “Hello world!”">
											Delete
										</a> 
									</span>
								</div>
							</div>

						</td>
						<td v-if="!record.editMode" class="hrm-td">{{ record.entitlement }}</td>

						<td class="hrm-td" v-if="!record.editMode">
							<span v-if="record.next_year === 1">&#x000AF;&#x000AF;</span>
							<span v-else>{{ dateFormat(record.entitle_from) }}</span>
						</td>

						<td class="hrm-td" v-if="!record.editMode">
							<span v-if="record.next_year === 1">&#x000AF;&#x000AF;</span>
							<span v-else>{{ dateFormat(record.entitle_to) }}</span>
						</td>

						<td v-if="!record.editMode" class="hrm-td">{{ carryStatus(record.next_year) }}</td>

						<td v-if="record.editMode" colspan="5">
							<leave-type-edit-form :id="'hrm-edit-'+record.id" :leaveType="record"></leave-type-edit-form>
						</td>
					</tr>
					<tr v-if="!records.length">
						
						<td colspan="5">No record found!</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>

</template>

<style>
	.hrm-td-editble-wrap .inline-edit-legend {
		margin: 0;
	    padding: 0.2em 0.5em 0;
	    line-height: 2.5;
	    font-weight: 600;
	}
	#hrm-leave-type-records-wrap .hrm-td {
		padding: 8px 10px;
	}

	.hrm-field-wrap {
		padding-left: 6px;
	}
</style>

<script>
	import Edit from './leave-type-edit-form.vue';
    import Mixin from './mixin'
	
	var Hrm_Leave_Type_Records = {

		
		mixins: [Mixin],
		
		data: function() {
			return {
			}
		},

		computed: {
			records () {
				return this.$store.state.leave.leaveTypes;
			}
		},

		components: {
			'leave-type-edit-form': Edit
		},

		created: function() {
			this.getLeaveTypes();
		},
		methods: {
			getLeaveTypes: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

	            wp.ajax.send('get_leave_type', {
	                data: request_data,
	                beforeSend () {
                		self.loadingStart('hrm-leave-type-records-wrap');
                	},
	                success: function(res) {
	                	res.data.forEach(function(type, index) {
	                		self.addLeaveTypeMeta(type);
	                	});
	                    
	                    self.$store.commit('leave/setLeaveTypes', res.data);
	                    self.isFetchRecord = true;
	                    self.loadingStop('hrm-leave-type-records-wrap');
	                },

	                error: function(res) {
	                    
	                }
	            });
			},

			carryStatus (next_year) {
				return parseInt(next_year) ? 'Enable' : 'Disable'; 
			},
			showHideLeaveTypeEditForm (status, type) {
				
			},
			selfDeleteLeaveType (record) {
				var data = {
					id: record.id,
					callback: function () {

					}
				}

				this.deleteLeaveType(data);
			}
		}
	};

	export default Hrm_Leave_Type_Records;
</script>