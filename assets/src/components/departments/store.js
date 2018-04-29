export default {
	state: {
		is_department_form_active: false,
		departments: [],
		department_id: false,
		del_dept: [],
		dept_pagination: {
			total: 0,
			limit: 5,
			page_number: 1
		},
		dept_drop_down: []
	},

	mutations: {
		showHideDepartmentForm: function(state, status) {
			if ( status === 'toggle' ) {
                state.is_department_form_active = state.is_department_form_active ? false : true;
            } else {
                state.is_department_form_active = status;
            }
		},

		setDepartments: function(state, departments) {
			state.departments           = departments.departments;
			state.dept_pagination.total = departments.total_dept;
			state.dept_drop_down        = departments.dept_drop_down;
		},

		department_edit_id: function(state, department) {
			state.department_id = department.department_id;
		},

		updateDepartment: function(state, department) {
			if (department.is_update) {
				state.departments = department.departments;
			} else {
				state.departments = department.departments;
			}

			state.dept_drop_down = department.dept_drop_down;
			state.department_id = false;
		},

		departmentDelId: function(state, del_dept) {
			state.del_dept = del_dept.del_dept;
		},
		afterDeleteDept: function(state, deleted_dept) {
			state.departments.splice(deleted_dept.target_del_dept, 1);
			state.dept_drop_down = deleted_dept.dept_drop_down;
		}
	}
};