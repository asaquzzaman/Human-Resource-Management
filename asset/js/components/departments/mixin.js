export default {
	methods: {
		showHideDepartmentForm (status, department) {
            var department   = department || false,
                department   = jQuery.isEmptyObject(department) ? false : department;

            if ( department ) {
                if ( status === 'toggle' ) {
                    department.edit_mode = department.edit_mode ? false : true;
                } else {
                    department.edit_mode = status;
                }
            } else {
                this.$store.commit( 'departments/showHideDepartmentForm', status);
            }
        },

        manageDepartment() {
            return hrm_user_can('manage_department');
        }
		
	}	
}