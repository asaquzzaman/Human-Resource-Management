var HRM_Department_pagination = {
	template: "<span></span>",
	mixins: [HRM_Mixin],
	
	created: function() {
		this.getDepartments();
	},
	
	watch: {
		'$route': function (to, from) {
           this.getDepartments();
        }
	}
};

Vue.component( 'department-pagination', {
    template: '#tmpl-hrm-department-pagination',

    computed: {
    	total: function() {
    		return Math.ceil( this.$store.state.dept_pagination.total / this.$store.state.dept_pagination.limit );
    	},

    	limit: function() {
    		return this.$store.state.dept_pagination.limit;
    	},

    	page_number: function() {
    		return this.$store.state.dept_pagination.page_number;
    	}
    },

    methods: {
        pageClass: function( page ) {
            if ( page == this.page_number ) {
                return 'page-numbers current'
            }

            return 'page-numbers';
        },
    }
});