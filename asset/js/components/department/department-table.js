Vue.component('department-table', {
	template: '#tmpl-hrm-department-table',

    data: function() {
        return {
            
        }
    },

	created: function() {
        if ( !this.$store.state.departments.length ) {
            this.getDepartments();
        }
	},

    computed: {
        departments: function() {
            return this.$store.state.departments;
        }
    },

	methods: {
		getDepartments: function() {
			var request_data = {
                _wpnonce: HRM_Admin.nonce,
            },
            self = this;

            wp.ajax.send('get_departments', {
                data: request_data,
                success: function(res) {
                    self.$store.commit( 'setDepartments', { departments: res.departments} );
                },

                error: function(res) {
                	
                }
            });
		},

        departmentActivity: function(department) {
            return parseInt(department.active) == 0 ? 'Disable' : 'Enable'; 
        }
	}
});