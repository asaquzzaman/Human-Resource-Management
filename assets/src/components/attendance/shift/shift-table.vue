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
                    <td colspan="1">
                    	<div v-for="time in record.times">
                    		<div>Duration: {{ time.begin }} <span v-html="'&ndash;'"></span> {{ time.end }} ({{getDurationHours(time)}}h {{getDurationMinutes(time)}}m)</div>
	                    	<table>
	                    		<tr >
	                    			<td><div>Work Time: {{ getWorkTime(time) }}</div></td>
	                    			<td>
	                    				
				                    	<div>Total Break Time: {{ getTotalBreakTime(time.breaks) }}</div>
				                    	<div v-if="hasBreakTime(time.breaks)">
				                    		<a @click.prevent="breadkDetails(time)" href="#">Break Details</a>
				                    	</div>
				                    	<div v-hrm-break-dialog v-if="time.popup">
					                    	<ul>
					                    		<li v-for="brak in time.breaks">
					                    			<div>Beak Duration: {{ brak.breakBegin }} <span v-html="'&ndash;'"></span> {{ brak.breakEnd }}</div>
					                    			<div>Break Time: {{ getBreakTime(brak) }}</div>
					                    		</li>
					                    		</li>Total Break Time: {{ getTotalBreakTime(time.breaks) }}</li>
					                    	</ul>

					                    	
				                    	</div>
	                    			</td>
	                    			<td>Net Work Time: {{ getNetWorkTime(time) }}</td>
	                    		</tr>
	                    	</table>
                    	</div>
                    </td>

                    <td>
                    	<ul>
                    		<li v-for="dept in hasDepartment(record)">
                    			{{ dept.name }}
                    		</li>
                    	</ul>
                    </td> 
                </tr>
                
                <tr v-else :id="'hrm-edit-'+record.id" :data-recordId="record.id" class="inline-edit-row hrm-edit-toggle">
                	<td colspan="4" class="colspanchange">
                		<update-form :shift="record"></update-form>
					</td>
				</tr>

				<tr v-if="!records.length">
					<td colspan="3">
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
	import PopUp from './directive'
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
						label: 'Work',
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
			hasBreakTime (breakTime) {
				let breakt = this.getTotalBreakTime(breakTime);

				if( breakt == '00:00' ) {
					return false;
				}

				return true;
			},
			hasDepartment (record) {
				if(typeof record.departments != 'undefined') {
					return record.departments.data;
				}

				return [];
			},
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
				record['transformers'] = 'Work_Experience_Transformer';

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
				if(!confirm('Are your sure!')) {
					return false;
				}
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

			getWorkHoursMinutes(record) {
				var hours = 0;
				var minutes = 0;
				record.times.forEach(function(time) {
					hours = hours + parseInt(time.workHours);
					minutes = minutes + parseInt(time.workMinutes);
				});
				hours = hours ? hours : '0';
				minutes = minutes ? minutes : '0';

				return {
					hours: hours,
					minutes: minutes
				}
			},

			getBreakTimeMinutes (record) {
				var hours = 0;
				var minutes = 0;

				record.forEach(function(time) {
					hours = hours + parseInt(time.breakHours);
					minutes = minutes + parseInt(time.breakMinutes);
				});

				return {
					hours: hours,
					minutes: minutes
				}
			},

			getTotalWorkTime(record) {
				let time = this.getWorkHoursMinutes(record);
				
				let netTime = time.hours + ':' + time.minutes;
				let workTime = new Date(this.currentDate()+','+netTime);

				return hrm.Moment(workTime).format('HH:mm');
			},

			getWorkTime (time) {
				let netTime = time.workHours + ':' + time.workMinutes;
				let standard = new Date(this.currentDate()+','+netTime);

				return hrm.Moment(standard).format('HH:mm');
			},

			getTotalBreakTime (record) {
				let time = this.getBreakTimeMinutes(record);
				let fake = new Date(this.currentDate()+', 0:0');
				
				let actualTime = hrm.Moment(fake).add(time.hours, 'hours').add(time.minutes, 'minutes');

				return hrm.Moment(actualTime).format('HH:mm');
			},

			getBreakTime(brak) {
				let netTime = brak.breakHours + ':' + brak.breakMinutes;
				let standard = new Date(this.currentDate()+','+netTime);

				return hrm.Moment(standard).format('HH:mm');
			},

			getNetWorkTime (record) {
				var workTime = record.workHours +':'+ record.workMinutes;
				    workTime = new Date(this.currentDate()+','+workTime);
				
				let breakTime = this.getBreakTimeMinutes(record.breaks);

				let total = hrm.Moment(workTime).subtract(breakTime.hours, 'hours').subtract(breakTime.minutes, 'minutes');

				return hrm.Moment(total).format('HH:mm');

			},

			getDepartments (record) {
				var department = '';
				record.departments.data.forEach(function(dept) {
					department = department + dept.name + ', ';
				});

				return department;
			},

			breadkDetails (time) {
				time.popup = true;
			},

			getDurationHours (record) {
				let hours = this.getDurationHourMinute(record.begin, record.end);
				return hours.hours
			},

			getDurationMinutes (record) {
				let minutes = this.getDurationHourMinute(record.begin, record.end);
				return minutes.minutes
			}
		}
		
	}
</script>