Vue.component('department-table', {
	template: '#tmpl-hrm-department-table',
    mixins: [HRM_Mixin],

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

        departmentActivity: function(department) {
            return parseInt(department.active) == 0 ? 'Disable' : 'Enable'; 
        }
	}
});