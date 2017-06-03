Vue.component('department-table', {
	template: '#tmpl-hrm-department-table',

    data: function() {
        return {
            del_all_dept: false,
            del_dept: []
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
        delAllDept: function() {
            if (this.del_all_dept) {
                var depts_id = [];

                this.$store.state.departments.map(function(department) {
                    depts_id.push(department.id);
                });

                this.del_dept = depts_id;

            } else {
                this.del_dept = [];
            }

            this.$store.commit('departmentDelId', {del_dept: this.del_dept});
        },

        delDept: function() {
            var depts_id = [];

            this.$store.state.departments.map(function(department) {
                depts_id.push(department.id);
            });

            if (depts_id.length == this.del_dept.length) {
                this.del_all_dept = true;
            }

            if (depts_id.length != this.del_dept.length) {
                this.del_all_dept = false;
            }

            this.$store.commit('departmentDelId', {del_dept: this.del_dept});
        },

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