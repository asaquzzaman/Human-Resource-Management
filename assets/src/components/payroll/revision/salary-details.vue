<template>
	<div class="hrm-salary-details">
		
		<table v-if="hasSalary()" class="wp-list-table widefat fixed striped pages">
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
	        	<tr>
	        		<td class="tb-child">Othres</td>
	        		<td>{{ others(salary) }}</td>
	        		<td></td>
	        	</tr>
	        	<tr class="total-tr">
	        		<td class="tb-child total">Gross Total</td>
	        		<td>{{ incomeTotal(salary) }}</td>
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
	        		<td>-{{ deductionTotal(salary) }}</td>
	        		<td></td>
	        	</tr>
	        	<tr class="total-tr">
	        		<td class="tb-child total">Net Pay</td>
	        		<td>{{ employeeGet(salary) }}</td>
	        		<td></td>
	        	</tr>
	        	<tr class="tr-main">
	        		<td class="tb-main">Salary</td>
	        		<td>
	        			{{ salary.salary }}
	        		</td>
	        		<td>
	        			
	        		</td>
	        	</tr>
        	</thead>
        </table>
	</div>
</template>

<style lang="less">
	.hrm-salary-details {
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
			width: 79% !important;
			margin: 0 !important;
			float: none !important;
			padding: 5px;
		}
	}

</style>

<script>
    import Directive from './directive'

	export default {
		props: {
			salary: {
				type: [Object],
				default () {
					return {};
				}
			},
		},

		computed: {
			incomeFormulas () {
				if(!this.salary.hasOwnProperty('info')) {
					return [];
				}

				if(!this.salary.info.hasOwnProperty('data')) {
					return [];
				}

				return this.salary.info.data.filter(function (formula) {
					return formula.type == 'income';
				});
			},

			// meta () {
			// 	var totalIncome = 0,
			// 		others = 0;

			// 	this.incomeFormulas.forEach(function(income) {
			// 		totalIncome = totalIncome + parseFloat(income.amout);
			// 	});

			// 	others = parseFloat(this.salary.salary) - totalIncome;
			// },

			deductionFormulas () {
				if(!this.salary.hasOwnProperty('info')) {
					return [];
				}

				if(!this.salary.info.hasOwnProperty('data')) {
					return [];
				}

				return this.salary.info.data.filter(function (formula) {
					return formula.type == 'deduction';
				});
			}
		},
		methods: {
			hasSalary () {
				if (jQuery.isEmptyObject(this.salary)) {
					return false;
				}

				return true;
			},
			executeFormula (statement) {
				if(!statement.amount) {
					return 0;
				}

				return statement.amount;
			},
			incomeTotal (salary) {
				if(typeof salary.info == 'undefined') {
					return 0;
				}
				if(typeof salary.info.meta == 'undefined') {
					return 0;
				}
				if(typeof salary.info.meta.salaryMeta == 'undefined') {
					return 0;
				}
				return salary.info.meta.salaryMeta.incomeTotal;
			},

			deductionTotal (salary) {
				if(typeof salary.info == 'undefined') {
					return 0;
				}
				if(typeof salary.info.meta == 'undefined') {
					return 0;
				}
				if(typeof salary.info.meta.salaryMeta == 'undefined') {
					return 0;
				}
				return salary.info.meta.salaryMeta.deductionTotal;
			},

			employeeGet (salary) {
				if(typeof salary.info == 'undefined') {
					return 0;
				}
				if(typeof salary.info.meta == 'undefined') {
					return 0;
				}
				if(typeof salary.info.meta.salaryMeta == 'undefined') {
					return 0;
				}
				return salary.info.meta.salaryMeta.employeeGet;
			},

			others (salary) {
				if(typeof salary.info == 'undefined') {
					return 0;
				}
				if(typeof salary.info.meta == 'undefined') {
					return 0;
				}
				if(typeof salary.info.meta.salaryMeta == 'undefined') {
					return 0;
				}
				return salary.info.meta.salaryMeta.others;
			},
		}
	}
</script>