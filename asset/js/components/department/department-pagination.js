var HRM_Department_pagination = {
	template: "<span></span>",
	created: function() {
		console.log(this.$store);
	},
	watch: {
		'$route': function (to, from) {
           console.log(to, from);
        }
	}
};

Vue.component( 'department-pagination', {
    template: '#tmpl-hrm-department-pagination',

    created: function() {
    	
    },

    computed: {
    	total: function() {
    		return this.$store.state.dept_pagination.total;
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