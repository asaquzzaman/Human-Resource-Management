<template>
	<div id="hrm-list-table">
		<table v-if="isFetchRecord" class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                	<td v-if="manageOrganization()" id="cb" class="manage-column column-cb check-column">
                		<input @change.prevent="deleteAll()" v-model="deleteAllStatus" id="cb-select-all-1" type="checkbox">
                	</td>
                    <th>
                    	Employee Name
                    </th>
                    <th>
                    	Date
                    </th>
                    <th>
                    	Gross
                    </th>
                    <th>
                    	Deduction
                    </th>

                    <th>
                    	Net Pay
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="" v-for="(record, record_index) in records" :key="record_index" v-if="!record.editMode">
                	<th v-if="manageOrganization()" scope="row" class="check-column">			
						<input id="cb-select-7" @change="actionCheckbox()" v-model="deletedId" :value="record.id" type="checkbox">
					</th>
					
                    <td>
                    	<span><a href="#" @click.prevent="salaryDetails(record)">{{ record.employee.data.display_name }}</a></span>
                    	<div class="row-actions">
	                    	<span class="trash"><a @click.prevent="selfDelete(record)" href="#">Delete</a> </span>
	                    </div>
                    </td>
                    <td>
                    	{{ record.month }}
                    </td>
                    <td>
                    	{{ record.info.meta.salaryMeta.incomeTotal }}
                    </td>
                    <td>
                    	(-){{ record.info.meta.salaryMeta.deductionTotal }}
                    </td>
                    <td>
                    	{{ record.info.meta.salaryMeta.employeeGet }}
                    </td>
                </tr>
               

				<tr v-if="!records.length">
					<td colspan="6">
						No result found!
					</td>
				</tr>
            </tbody>
        </table>

        <salary-details v-if="popUpDetails" v-hrm-dialog :salary="salary" title="Salary Details"></salary-details>
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
	import SalaryDetails from './salary-details'

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
				isFetchRecord: false,
				salary: {},
				popUpDetails: false
			}
		},
		
		created () {
			this.getRecords();
		},

		components: {
			'salary-details': SalaryDetails
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
			filterEditField (fields) {
				return fields.filter(function(field) {
					return field.editable ? true : false;
				});
			},
			filterHeader (fields) {
				return fields.filter(function(field) {
					return typeof field.tableHead === 'undefined' 
						? false
						: true;
				});
			},
			printCellData (record, field) {
				if (typeof field.filterPrintData == 'undefined') {
					return record[field.name];
				}

				return field.filterPrintData( record[field.name] );
			},

			recordEditForm (record, status) {
				status = status || 'toggle';
				this.$store.commit( this.nameSpace + '/showHideEditForm', 
					{
						id: record.id,
						status: status
					} 
				);
			},

			selfUpdate (record) {
				
				var self = this,
					data = {};

				data['class']        = self.modelName;
				data['method']       = 'update';
				data['transformers'] = self.modelTransformer;
				data['id']           = record.id;


				self.fields.forEach(function(field) {
					if ( !field.editable ) {
						return;
					}

					if (typeof field.filterEditingData != 'undefined') {
						data[field.name] = field.filterEditingData(record[field.name]);
					} else {
						data[field.name] = record[field.name];
					}
				});
				
				var args = {
					data: data,
					callback () {
						self.canSubmit = true;
						self.loading = false;
					}
				}
				if (!this.editFormValidation(self.fields, args.data)) {
					return false;
				}				
				self.canSubmit = false;
				self.loading = true;
				
				this.updateRecord(args);
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

			salaryDetails (record) {
				this.salary = record;
				this.popUpDetails = true;
			},

			afterCloseDialog (self) {
				self.salary = {};
				self.popUpDetails = false;
			}
		}
		
	}
</script>