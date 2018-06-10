<template>
	<div id="hrm-list-table">
		<table v-if="isFetchRecord"  class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                	<td v-if="deleteCheckbox" id="cb" class="manage-column column-cb check-column">
                		<input @change.prevent="deleteAll()" v-model="deleteAllStatus" id="cb-select-all-1" type="checkbox">
                	</td>
                    <th v-for="(header, header_index) in headers" :key="header_index">
                    	{{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
            	
                <tr class="" v-for="(record, record_index) in records" :key="record_index" v-if="!record.editMode">
                	<th v-if="deleteCheckbox" scope="row" class="check-column">			
						<input id="cb-select-7" @change="actionCheckbox()" v-model="deletedId" :value="record.id" type="checkbox">
					</th>
					
                    <td>
                    	{{ record.name }}

                    	<div class="row-actions">
                    		<span class="edit"><a @click.prevent="recordEditForm(record)" href="#">Edit</a> | </span>
	                    	<span class="trash"><a @click.prevent="selfDelete(record)" href="#">Delete</a> </span>
	                    </div>
                    </td>
                    <td>
                    	{{ getWorkTime(record) }}
                    </td>
                    <td>
                    	{{ getBreakTime(record) }}
                    </td>
                    <td>
                    	{{ getNetTime(record) }}
                    </td>
                    <td>
                    	{{ record.description }}
                    </td>
                </tr>
                
                <tr v-else :id="'hrm-edit-'+record.id" :data-recordId="record.id" class="inline-edit-row hrm-edit-toggle">
                	<td colspan="5" class="colspanchange">
                		<update-form :shift="record"></update-form>
					</td>
				</tr>

				<tr v-if="!records.length">
					<td colspan="5">
						No result found!
					</td>
				</tr>
            </tbody>
        </table>
	</div>
</template>

<style>
	.alignright {
		float: right;
	}
	.hrm-spinner {
		margin-right: 10px;
		margin-top: 6px;
	}
</style>

<script>
	import Mixin from './mixin'
	import UpdateForm from './new-shift-form.vue'

	export default {
		mixins: [Mixin],	
		props: {
			deleteCheckbox: {
				type: [Boolean],
				default () {
					return true;
				}
			},
			fields: {
				type: [Array],
				default () {
					return []
				}
			}
		},

		data () {
			return {
				canSubmit: true,
				loading: false,
				deleteAllStatus: false,
				deletedId: [],
				headers: [
					{
						label: 'Name',
					},
					{
						label: 'Work Time',
					},
					{
						label: 'Break Time',
					}, 
					{
						label: 'Net Time',
					}, 
					{
						label: 'Department',
					}
				],
			}
		},
		
		created () {
			this.getRecords();
		},

		components: {
			'update-form': UpdateForm
		},

		computed: {
			records () {
				return this.$store.state[this.nameSpace].records;
			}
		},

		watch: {
			deletedId () {
				this.$store.commit(this.nameSpace + '/setDeletedId', this.deletedId);
			},
			'$route' (to, from) {
				this.getRecords();
			}
		},
		methods: {
			recordEditForm (record, status) {
				status = status || 'toggle';
				this.$store.commit( this.nameSpace+'/showHideEditForm', 
					{
						id: record.id,
						status: status
					} 
				);
			},

			selfUpdate (record) {
				var self = this;
				record['class'] = 'Work_Experience';
				record['method'] = 'update';
				record['transformers'] = 'Work_Experiance_Transformer';

				var args = {
					data: record,
					callback () {
						self.canSubmit = true;
						self.loading = false;
					}
				}

				if (!this.editFormValidation(self.fields, record)) {
					return false;
				}
				
				self.canSubmit = false;
				self.loading = true;

				this.updateRecord(args);
			},

			deleteAll () {
				if (this.deleteAllStatus) {
                    var deleted_id = [];

                    this.$store.state[this.nameSpace].records.map(function(record) {
                        deleted_id.push(record.id);
                    });

                    this.deletedId = deleted_id;

                } else {
                    this.deletedId = [];
                }
			},

			actionCheckbox () {
				let records = this.$store.state[this.nameSpace].records;
				
				if ( records.length == this.deletedId.length ) {
					this.deleteAllStatus = true;
				} else {
					this.deleteAllStatus = false;
				}
			},

			selfDelete (record) {
				var self = this;
				this.recordDelete([record.id], function() {
					var hasRecords = self.$store.state[self.nameSpace].records.length;
					var page = self.$route.params.current_page_number;
					if (!hasRecords && page > 1) {
						self.$router.push({
							params: {
								current_page_number: page - 1
							},
							query: self.$route.query
						});
					}
					
					if (
						!hasRecords 
							&& 
						typeof self.pagination != 'undefined'
							&&
						self.pagination.total_pages > 1
					) {
						self.getRecords();
					}
				})
			},

			getWorkTime(record) {
				var time = new Date(this.currentDate()+','+record.work_duration);
				
				// let being = hrm.Moment(record.shift_being).format('k:m');
				// let end = hrm.Moment(record.shift_end).format('k:m');

				// let shiftDuration = this.shiftDuration(being, end);

				let text = time.getHours() + ' (hours) ' + time.getMinutes() + ' (minutes)';
				
				if(record.break_deduct == 1) {
					text = text + ' - Deduct with break time';
				} else {
					text = text + ' - Without break time';
				}

				return text;

				// this.shift_duration_hour = shiftDuration.hours;
				// this.shift_duration_minute = shiftDuration.minutes;
			},

			getBreakTime (record) {
				let being = hrm.Moment(record.break_being).format('k:m');
				let end = hrm.Moment(record.break_end).format('k:m');

				let breakDuration = this.breakDuration(being, end);

				let text = breakDuration.hours + ' (hours) ' + breakDuration.minutes + ' (minutes)';

				return text;
			},

			getNetTime (record) {
				let being = hrm.Moment(record.break_being).format('k:m');
				let end = hrm.Moment(record.break_end).format('k:m');
				let breakDuration = this.breakDuration(being, end);

				let workTime = new Date(this.currentDate()+','+record.work_duration);
				let breakTime = new Date(this.currentDate()+','+breakDuration.hours+':'+breakDuration.minutes);

				let net_time = hrm.Moment(workTime).add(breakDuration.hours, 'hours').add(breakDuration.minutes, 'minutes');

				return net_time.hours() + ' (hours) ' + net_time.minutes() + ' (minutes)';
			}
		}
		
	}
</script>