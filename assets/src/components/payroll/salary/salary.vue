<template>
	<div>
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
					        	<tr>
					        		<td>Gross</td>
					        		<td></td>
					        	</tr>
					        	<tr v-for="incomeFormula in incomeFormulas">
					        		<td>{{ incomeFormula.description }}</td>
					        		<td>{{ executeFormula(incomeFormula) }}</td>
					        	</tr>
					        	<tr>
					        		<td>Gross Total</td>
					        		<td>00</td>
					        	</tr>
					        	<tr>
					        		<td>Deduction</td>
					        		<td></td>
					        	</tr>
					        	<tr v-for="deductionFormula in deductionFormulas">
					        		<td>{{ deductionFormula.description }}</td>
					        		<td>-{{ executeFormula(deductionFormula) }}</td>
					        	</tr>
					        	<tr>
					        		<td>Deduction Total</td>
					        		<td>-00</td>
					        	</tr>
					        	<tr>
					        		<td>Net Pay</td>
					        		<td><input v-model="salary" type="number" placeholder="Monthly/Annual salary" step="any"></td>
					        	</tr>
				        	</thead>
				        </table>

				        <a href="#" @click.prevent="" class="button button-primary hrm-button-primary">Save</a>
				        <a href="#" @click.prevent="generateSalaryStatement()" class="button button-secondary hrm-button-secondary">Generate</a>
				    </form>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
	table tr th {
		
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
			this.getEmployess();
			this.getDesignation();
			this.getFormulas();
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
				if(!this.salary) {
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
		            	
		            },

		            error: function(res) {
		            }
		        };

		        this.httpRequest('hrm_generate_salary_statement', form_data);
			}
		}
	}
</script>