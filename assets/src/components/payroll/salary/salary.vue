<template>
	<div>
		<payroll-menu></payroll-menu>
		<div>
			
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
		        		<td><input v-model="salary" type="number" placeholder="Monthly salary" step="any"></td>
		        	</tr>
	        	</thead>
	        </table>

	        <a href="#" @click.prevent="" class="button button-primary hrm-button-primary">Save</a>
	        <a href="#" @click.prevent="generateSalaryStatement()" class="button button-secondary hrm-button-secondary">Generate</a>
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
				salary: ''
			}
		},

		components: {
			'hrm-multiselect': hrm.Multiselect.Multiselect
		},

		created () {
			this.getEmployess();
			this.getDesignation();
			this.getFormulas();
		},

		computed: {
			employees () {
				return this.$store.state[this.nameSpace].employees;
			},

			designation () {
				return this.$store.state[this.nameSpace].designation;
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