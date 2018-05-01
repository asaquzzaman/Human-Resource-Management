export default {
	state: {
		employees: [],
		designation: [],
		formulas: [],
		meta: {
			others: false,
			incomeTotal: 0,
			deductionTotal: 0,
			employeeGet: 0
		}
	},

	mutations: {
		setEmployees (state, employees) {
			state.employees = employees;
		},

		setDesignation (state, designation) {
			state.designation = designation;
		},

		setFormulas (state, formulas) {
			state.formulas = formulas;
		},		

		setOthers (state, meta) {
			state.meta = meta.salaryMeta;
		},
		setUpdateData (state, data) {
			state.formulas = data.data;
			state.meta = data.meta.salaryMeta;
		}
	}
}