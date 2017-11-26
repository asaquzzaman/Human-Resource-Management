<template>
    <div v-if="total > 1">
        <div class="cpm-pagination-wrap">

            <router-link v-if="page_number > 1" class="cpm-pagination-btn prev page-numbers" :to="{ name: 'hrm-pagination', params: { page_number: ( page_number - 1 ) }}">«</router-link>
            <router-link v-for="page in total" key="page" :class="pageClass(page) + ' cpm-pagination-btn'" :to="{ name: 'hrm-pagination', params: { page_number: page }}">{{ page }}</router-link>
            <router-link v-if="page_number < total" class="cpm-pagination-btn next page-numbers" :to="{ name: 'hrm-pagination', params: { page_number: ( page_number + 1 ) }}">»</router-link> 

        </div>
        <div class="cpm-clearfix"></div>
    </div>
</template>
<script>
    var HRM_Department_pagination = {
        template: "<span></span>",
        mixins: [HRM_Common_Mixin],
        
        created: function() {
            this.getDepartments();
        },
        
        watch: {
            '$route': function (to, from) {
               this.getDepartments();
            }
        }
    };
    export default {
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
    }
</script>


<!-- var HRM_Department_pagination = {
	template: "<span></span>",
	mixins: [HRM_Common_Mixin],
	
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
}); -->