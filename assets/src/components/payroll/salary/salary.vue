<template>
	<div class="hrm-salary">
		<payroll-menu></payroll-menu>
		<div class="metabox-holder">
			<div id="hrm-hidden-form-warp" class="postbox">
	        
	        	<h2 class="hndle">Salary</h2>

	        	<div class="inside">
	        		<form id="hrm-hidden-form">
	        			<div class="hrm-form-field">
							<label>
								Salary Day
								<em>*</em>
							</label>
	        				<hrm-date-picker v-model="salaryDay" :required="true"  placeholder="From" class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
    						<div class="hrm-clear"></div>
				    		<span class="description"></span>
					    </div>

		       			<div class="hrm-form-field">
							<label>
								Salary Type
								<em>*</em>
							</label>
							<select v-model="salaryType">
								<option value="designation">Designation</option>
								<option value="employee">Employee</option>
							</select>
							<div class="hrm-clear"></div>
				    		<span class="description">Salary will goes to</span>
					    </div>

						<div v-if="salaryType=='employee'" class="hrm-form-field">
							<label>
								Employee
								<em>*</em>
							</label>
							<div class="hrm-multiselect">
								<hrm-multiselect 
						            v-model="selectedEmployees" 
						            :options="employees" 
						            :multiple="false" 
						            :close-on-select="true"
						            :clear-on-select="true"
						            :hide-selected="false"
						            :show-labels="true"
						            placeholder="Employees"
						            select-label=""
						            selected-label="selected"
						            deselect-label=""
						            :taggable="false"
						            label="display_name"
						            :allow-empty="true">

						        </hrm-multiselect>  
					    	</div>
					        <div class="hrm-clear"></div>
				    		<span class="description">Select employee</span>
					    </div>

				       	<div v-if="salaryType=='designation'" class="hrm-form-field">
							<label>
								Designation
								<em>*</em>
							</label>
							<div class="hrm-multiselect">
								<hrm-multiselect 
						            v-model="selectedDesignation" 
						            :options="designation" 
						            :multiple="false" 
						            :close-on-select="true"
						            :clear-on-select="true"
						            :hide-selected="false"
						            :show-labels="true"
						            placeholder="Designation"
						            select-label=""
						            selected-label="selected"
						            deselect-label=""
						            :taggable="false"
						            label="title"
						            :allow-empty="true">

						        </hrm-multiselect>  
					    	</div>
					        <div class="hrm-clear"></div>
				    		<span class="description">Select designation</span>
					    </div>

					   	<div class="hrm-form-field">
							<label>
								Salary Component Group
								<em>*</em>
							</label>
							<div class="hrm-multiselect">
								<hrm-multiselect 
						            v-model="selectedDesignation" 
						            :options="componentGroup" 
						            :multiple="false" 
						            :close-on-select="true"
						            :clear-on-select="true"
						            :hide-selected="false"
						            :show-labels="true"
						            placeholder="Component Group"
						            select-label=""
						            selected-label="selected"
						            deselect-label=""
						            :taggable="false"
						            label="name"
						            :allow-empty="true">

						        </hrm-multiselect>  
					    	</div>
					        <div class="hrm-clear"></div>
				    		<span class="description">Select salary component group</span>
					    </div>

				        <table class="wp-list-table widefat fixed striped pages">
				        	<thead>
					        	<tr class="tr-main">
					        		<td class="tb-main">Income</td>
					        		<td></td>
					        		<td></td>
					        	</tr>
					        	<tr v-for="incomeFormula in incomeFormulas">
					        		<td class="tb-child">{{ incomeFormula.description }}</td>
					        		<td>{{ executeFormula(incomeFormula) }}</td>
					        		<td>{{ incomeFormula.formula }}</td>
					        	</tr>
					        	<tr v-if="meta.others">
					        		<td class="tb-child">Othres</td>
					        		<td>{{ meta.others }}</td>
					        		<td></td>
					        	</tr>
					        	<tr class="total-tr">
					        		<td class="tb-child total">Gross Total</td>
					        		<td>{{ meta.incomeTotal }}</td>
					        		<td></td>
					        	</tr>
					        	<tr class="tr-main">
					        		<td class="tb-main">Deduction</td>
					        		<td></td>
					        		<td></td>
					        	</tr>
					        	<tr v-for="deductionFormula in deductionFormulas">
					        		<td class="tb-child">{{ deductionFormula.description }}</td>
					        		<td>-{{ executeFormula(deductionFormula) }}</td>
					        		<td>{{ deductionFormula.formula }}</td>
					        	</tr>
					        	<tr class="total-tr">
					        		<td class="tb-child total">Deduction Total</td>
					        		<td>-{{ meta.deductionTotal }}</td>
					        		<td></td>
					        	</tr>
					        	<tr class="total-tr">
					        		<td class="tb-child total">Employee Will Get</td>
					        		<td>{{ meta.employeeGet }}</td>
					        		<td></td>
					        	</tr>
					        	<tr class="tr-main">
					        		<td class="tb-main">Net Pay</td>
					        		<td>
					        			<input class="amount" v-model="salary" type="number" placeholder="Monthly/Annual salary" step="any">
					        		</td>
					        		<td></td>
					        	</tr>
				        	</thead>
				        </table>
				        <div class="action">
					        <a href="#" @click.prevent="" class="button button-primary hrm-button-primary">Save</a>
					        <a href="#" @click.prevent="generateSalaryStatement()" class="button button-secondary hrm-button-secondary">Generate</a>
				    	</div>
				    </form>
				</div>
			</div>
		</div>
	</div>
</template>

<style lang="less">
	.hrm-salary {
		.tb-child {
			padding-left: 5%;
		}
		.tr-main {
			background: #eee;
		}
		.tb-main {
			font-weight: 600;
		}
		.action {
			margin-top: 20px;
		}
		.total {
			font-weight: 600;
		}
		.total-tr {
			background: #f9f9f9;
		}
		.wp-list-table {
			margin-top: 10px;
		}
		.amount {
			width: 50% !important;
			margin: 0 !important;
			float: none !important;
			padding: 5px;
		}
	}

</style>

<script>
	import Mixin from './mixin'
	import PayrollMixin from '@components/payroll/mixin'

	export default {
		mixins: [Mixin, PayrollMixin],
		data () {
			return {
				selectedEmployees: '',
				selectedDesignation: '',
				salary: '',
				salaryType: 'designation',
				salaryDay: '',
				salaryComponentGroup: ''
			}
		},

		components: {
			'hrm-multiselect': hrm.Multiselect.Multiselect
		},

		created () {
			var self = this;
			this.getEmployess();
			this.getDesignation();
			this.getFormulas({
				callback (res) {
					self.$store.commit( 'salary/setFormulas', res.data );
				}
			});
			this.getSalaryGroupRecords({

			});
		},

		computed: {
			employees () {
				return this.$store.state[this.nameSpace].employees;
			},

			designation () {
				return this.$store.state[this.nameSpace].designation;
			},

			componentGroup () {
				return this.$store.state.group.records;
			},

			incomeFormulas () {
				var dbfomulas = this.$store.state.salary.formulas;

				return dbfomulas.filter(function (formula) {
					return formula.type == 'income';
				});
			},

			deductionFormulas () {
				var dbfomulas = this.$store.state.salary.formulas;

				return dbfomulas.filter(function (formula) {
					return formula.type == 'deduction';
				});
			},

			meta () {
				return this.$store.state.salary.meta;
			}
		},

		methods: {
			getEmployess () {
				var self = this;

				var form_data = {
		            data: {
		            	number: -1
		            },

		            success: function(res) {
		            	self.$store.commit(self.nameSpace + '/setEmployees', res.data);
		            },

		            error: function(res) {
		            }
		        };

		        this.httpRequest('hrm_employee_filter', form_data);
			},

			getDesignation () {
				var self = this;

				var postData = {
					'class': 'Designation',
					'method': 'gets',
					'transformers': 'Designation_Transformer',
					'page': 1,
					'per_page': 1000
				};
				
	            var request_data = {
	                data: postData,
	                success: function(res) {
	                    self.$store.commit( self.nameSpace + '/setDesignation', res.data );
	                }
	            };

	            self.httpRequest('hrm_get_records', request_data);
			},

			executeFormula (statement) {
				if(!statement.amount) {
					return 0;
				}

				return statement.amount;
			},

			generateSalaryStatement () {
				var self = this;

				var form_data = {
		            data: {
		            	salary: self.salary
		            },

		            success: function(res) {
		            	self.$store.commit( 'salary/setFormulas', res.data );
		            	self.$store.commit( 'salary/setOthers', res.meta );
		            },

		            error: function(res) {
		            }
		        };

		        this.httpRequest('hrm_generate_salary_statement', form_data);
			}
		}
	}
</script>