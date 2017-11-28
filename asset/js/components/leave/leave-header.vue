<template>
    <div>
        <h2 class="nav-tab-wrapper">
            <router-link v-for="head in header" class="nav-tab" :to="head.url">{{ head.title }}</router-link>
        </h2>

        <h3 class="hrm-sub-nav" v-if="has_child_menu() || is_it_child()">
            <ul class="hrm-subsubsub">

                <li v-for="child_menu in get_child_menu()">
                    <router-link  :to="{name: child_menu.name}">{{ child_menu.title }}</router-link> |&nbsp;
                </li> 
              
            </ul>
        </h3>

    </div>
</template>

<script>
    var Hrm_Leave_Header = {
        mixins: [HRMMixin.leave],

        data: function() {
            return {
                header: []
            }
        },
        created: function() {
            this.getHeader();
        },

        // computed: {
        //     header: function() {
        //         return this.$store.state.leave.header;
        //     },

        // },
        methods: {
            is_it_child: function() {

                if( this.$route.matched.length > 1 ) {
                    return true;
                }
            },
            has_child_menu: function() {
                var path = this.$route.path,
                    has_submenu = false;
                console.log(this.$route);
                jQuery.each( this.header, function(key, val ) {
                    
                    if (val.url == path) {
                        if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
                            has_submenu = true;
                        }
                    }
                });

                return has_submenu;
            },
            get_child_menu: function() {
                var path = this.$route.path,
                    submenu = [];

                if ( this.is_it_child() ) {
                    var partent_name = this.$route.matched[0].name;
                    
                    jQuery.each( this.header, function(key, val ) {
                        if (val.name == partent_name) {
                            if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
                                submenu = val.submenu;
                            }
                        }
                    });

                    return submenu;
                }
                
                
                jQuery.each( this.header, function(key, val ) {
                    if (val.url == path) {
                        if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
                            submenu = val.submenu;
                        }
                    }
                });

                return submenu;
            },
            getHeader: function() {
                var request_data = {
                    _wpnonce: HRM_Vars.nonce,
                },
                self  = this;

                wp.ajax.send( 'leave_header', {
                    data: request_data,
                    success: function(res) {
                        self.header = res.header;
                        //self.$store.commit( 'header', {'header': res.header} );
                    
                    },

                    error: function(res) {
                        
                    }
                });
            }
        }
    };

    export default Hrm_Leave_Header;
</script>

