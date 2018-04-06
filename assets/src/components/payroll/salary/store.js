export default {
	state: {
		employees: [],
		designation: []
	},

	mutations: {
		setEmployees (state, employees) {
			state.employees = employees;
		},

		setDesignation (state, designation) {
			state.designation = designation;
		}
	}
}