<template>
    <div v-if="total_pages > 1" class="hrm-pagination-wrap">
        <div class="hrm-pagination-inner">
            <router-link 
                v-if="parseInt(current_page_number) > 1" 
                class="hrm-pagination-btn prev page-numbers" 
                :to="{ 
                    name: component_name,  
                    params: { 
                        current_page_number: ( current_page_number - 1 ) 
                    },
                    query: route_query
                }">
                &laquo;
            </router-link>
            
            <router-link 
                :key="page" 
                v-for="page in total_pages" 
                :class="pageClass(page) + ' hrm-pagination-btn'" 
                :to="{ 
                    name: component_name,  
                    params: { 
                        current_page_number: page 
                    },
                    query: route_query
                }">
                {{ page }}
            </router-link>
            
            <router-link 
                v-if="parseInt(current_page_number) < parseInt(total_pages)" 
                class="hrm-pagination-btn next page-numbers" 
                :to="{ 
                    name: component_name,  
                    params: { 
                        current_page_number: ( current_page_number + 1 ) 
                    },
                    query: route_query
                }">
                &raquo;
            </router-link> 

        </div>
        <div class="hrm-clear"></div>
    </div>
</template>

<script>
    export default {
        props: ['total_pages', 'component_name'],

        data () {
            return {
                route_query: this.$route.query
            }
        },

        watch: {
            '$route' (url) {
                this.route_query = url.query;
            }
        },

        computed: {
            current_page_number () {
                return this.$route.params.current_page_number;
            }
        },

        methods: {
            pageClass: function( page ) {
                if ( page == this.current_page_number ) {
                    return 'page-numbers current'
                }

                return 'page-numbers';
            },
        }
    }
</script>

<style>
    .hrm .hrm-pagination-btn,
    #hrm .hrm-pagination-btn {
        display: inline-block;
        text-decoration: none;
        font-size: 13px;
        line-height: 26px;
        height: 28px;
        margin: 0;
        padding: 0 10px 1px;
        cursor: pointer;
        border-width: 1px;
        border-style: solid;
        -webkit-appearance: none;
        border-radius: 3px;
        white-space: nowrap;
        box-sizing: border-box;
        color: #555;
        border-color: #ccc;
        background: #f7f7f7;
        vertical-align: top;
        margin-right: 3px;
    }
    .hrm .router-link-exact-active,
    #hrm .router-link-exact-active {
        background: #e5e5e5;
    }
    .hrm-pagination-wrap {
        margin-top: 8px;
    }
</style>


