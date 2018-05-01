<template>
	<div>
		<h1 class="wp-heading-inline">Salary Component Group</h1>
		<a @click.prevent="showHideNewRecordForm('toggle')" class="page-title-action">Add New</a>

		<payroll-menu></payroll-menu>
		<div id="hrm-group-loading">
			<div v-if="isFetchFormula">
				<add-new-record-form class="hrm-toggle" v-if="isNewRecordFormActive" :fields="fields"></add-new-record-form>

			    <div class="hrm-tbl-action-wrap">
					<div class="hrm-table-action hrm-bulk-wrap">
						<label for="bulk-action-selector-top" class="screen-reader-text">
							Select bulk action
						</label>
						<select v-model="bulkAction" name="action" id="bulk-action-selector-top">
							<option value="-1">Bulk Actions</option>
							<option value="delete">Delete</option>
						</select>
						<a href="#" @click.prevent="selfBulkAction()" class="button hrm-button-secondary button-secondary">Apply</a>
					</div>

					<div class="hrm-table-action hrm-filter-wrap">
						<div class="alignleft actions">
							<form @submit.prevent="recordSearch()">
								<input v-model="search.name" placeholder="Title" type="text">
								<!-- <hrm-date-picker placeholder="From" v-model="search.from"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
								<hrm-date-picker placeholder="To" v-model="search.to" class="pm-datepickter-from" dependency="pm-datepickter-to"></hrm-date-picker> -->
								<input type="submit" class="button hrm-button-secondary button-secondary" value="Filter">
							</form>
						</div>

					</div>
					<div class="hrm-clear"></div>
				</div>
				
			    <hrm-table :fields="fields"></hrm-table>

			    <hrm-pagination 
		            :total_pages="pagination.total_pages" 
		            component_name='group_pagination'>
		            
		        </hrm-pagination> 
	    	</div>
	    </div>

	</div>
</template>

<style>
	.hrm-bulk-wrap, .hrm-filter-wrap {
		float: left;
	}
	.hrm-tbl-action-wrap {
		margin-top: 20px;
	}
</style>

<script>
	import Mixins from '@components/payroll/group/mixin'
	import PayrollMixin from '@components/payroll/mixin'
	import Table from './group-table.vue';
	import Form from './new-group-form.vue';

	export default {
		data () {

			return {
				isFetchFormula: false,
				search: {
					filter: 'active',
					name: this.$route.query.name,
					from: this.$route.query.from,
					to: this.$route.query.to
				},
				bulkAction: -1,
				fields: [
					{
						type: 'text',
						model: '',
						label: 'Name',
						name: 'name',
						required: true,
						tableHead: 'Name',
						tbRowAction: true,
						editable: true,
					},
		{
			type: 'multiSelect',
			model: '',
			options: [],
			label: 'Income Components',
			optionLabel: 'description',
			placeholder: 'Select Components',
			name: 'income',
			tableHead: 'Income Components',
			trackBy: 'id',
			editable: true,
			required: true,
			//Filter submited new data
			filterSubmited (val) {
				var ids = [];
				val.forEach(function(obj) {
					ids.push(obj.id);
				});
				return ids;
			},

			//Table print data
			filterPrintData (val) {
				if (!val) {
					return '&#8211 &#8211';
				}
				return val.id;
			},

			// Filter edit form field data
			filterComputedGet (val, self) {
				var formulas = [];
				var soter = self.$store.state.formula.records;
				val.forEach(function(id) {
					var index = self.getIndex( soter, id, 'id' );

					if (index !== false) {
						formulas.push( soter[index] );
					} 
				})
				
				return formulas;
			},

			// Filter edit form field data
			filterComputedSet (val, self) {
				var formulas = [];
				
				val.forEach(function(obj) {
					formulas.push( obj.id );
					
				})
				
				return formulas;
			},
			
			//Filter edit submited data
			// filterEditingData (val) {
			// 	console.log(val);
			// 	if (val) {
			// 		var ids = [];
			// 		val.forEach(function(obj) {
			// 			ids.push(obj.id);
			// 		});
			// 		return ids;
			// 	}
			// }
		},
		{
			type: 'multiSelect',
			model: '',
			options: [],
			label: 'Deduction Components',
			optionLabel: 'description',
			placeholder: 'Select Components',
			name: 'deduction',
			tableHead: 'Deduction Components',
			trackBy: 'id',
			editable: true,
			required: true,
			//Filter submited new data
			filterSubmited (val) {
				var ids = [];
				val.forEach(function(obj) {
					ids.push(obj.id);
				});
				return ids;
			},

			//Table print data
			filterPrintData (val) {
				if (!val) {
					return '&#8211 &#8211';
				}
				return val.id;
			},

			// Filter edit form field data
			filterComputedGet (val, self) {
				var formulas = [];
				var soter = self.$store.state.formula.records;
				val.forEach(function(id) {
					var index = self.getIndex( soter, id, 'id' );

					if (index !== false) {
						formulas.push( soter[index] );
					} 
				})
				
				return formulas;
			},

			// Filter edit form field data
			filterComputedSet (val, self) {
				var formulas = [];
				
				val.forEach(function(obj) {
					formulas.push( obj.id );
					
				})
				
				return formulas;
			},
			
			//Filter edit submited data
			// filterEditingData (val) {
			// 	if (val) {
			// 		var ids = [];
			// 		val.forEach(function(obj) {
			// 			ids.push(obj.id);
			// 		});
			// 		return ids;
			// 	}
			// }
		},

				]
			}
		},
		mixins: [Mixins, PayrollMixin],
		
		created () {
			
			var self = this;

			this.getFormulas({
				callback (res) {
					var index = self.getIndex(self.fields, 'income', 'name');
					self.fields[index].options = self.incomeFormulas;

					var index = self.getIndex(self.fields, 'deduction', 'name');
					self.fields[index].options = self.deductionFormulas;

					self.isFetchFormula = true;
				}
			});
		},

		computed: {
			isNewRecordFormActive () {
				return this.$store.state[this.nameSpace].isNewRecordFormActive;
			},

            total_experiance_page () {
                return 10;
            },

            pagination () {
            	return this.$store.state[this.nameSpace].pagination;
            },
		},
		components: {
			'hrm-table': Table,
			'add-new-record-form': Form
		},

		methods: {

			selfBulkAction () {
				var self = this;
				switch( this.bulkAction) {
					case 'delete':
						this.recordDelete(self.$store.state[self.nameSpace].deletedId, function() {
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
							if (!hasRecords && self.pagination.total_pages > 1) {
								self.getSalaryGroupRecords();
							}
						});
						break;

					default:

						break;
				}
			},

			recordSearch () {
				this.$router.push({query: this.search});
				this.getSalaryGroupRecords();
			},

			getIncomeComponents () {
				return this.incomeFormulas;
			},
			getDeductionComponents () {
				return this.deductionFormulas;
			}
		}
	}
</script>