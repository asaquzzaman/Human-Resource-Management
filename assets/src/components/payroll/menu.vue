<template>
    <div v-if="menu.length">
        <h2 class="nav-tab-wrapper">
            <router-link v-for="(item, index) in filterChildren(menu[0].children)" :key="index" class="nav-tab" :to="{name: item.name}">{{ item.meta.label }}</router-link>
        </h2>

        <h3 class="hrm-sub-nav">
            <ul class="hrm-subsubsub">

                <li v-for="children in childrens()">
                    <router-link  :to="{name: children.name}">{{ children.meta.label }}</router-link> |&nbsp; 
                </li> 
              
            </ul>
        </h3>

    </div>
</template>

<script>
   
    import Menu from './router';

    var Hrm_Leave_Header = {
        
        data: function() {
            return {
                menu: [],
            }
        },

        created () {
            this.menu = Menu;
        },

        methods: {
            childrens () {
                if (!this.menu.length) {
                    return [];
                }
                let root_menu = this.$route.matched[1].name;

                let index = this.getIndex(this.menu[0].children, root_menu, 'name');
                
                if (index === false) {
                    return [];
                }

                if (this.menu[index].hasOwnProperty('children')) {
                    if (this.menu[index].children.length) {
                        return this.menu[index].children;
                    }
                } else {
                    return [];
                }
            },
            filterChildren(children) {
                var menu = [];

                children.forEach(function(child) {
                    if( 
                        typeof child.meta != 'undefined' 
                            &&
                        typeof child.meta.label != 'undefined'
                    ) {
                        menu.push(child);
                    }
                });
                
                return menu;
            }
            // is_it_child: function() {

            //     if( this.$route.matched.length > 1 ) {
            //         return true;
            //     }
            // },
            // has_child_menu: function() {
            //     var path = this.$route.path,
            //         has_submenu = false;
                
            //     jQuery.each( this.header, function(key, val ) {
                    
            //         if (val.url == path) {
            //             if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
            //                 has_submenu = true;
            //             }
            //         }
            //     });

            //     return has_submenu;
            // },
            // get_child_menu: function() {
            //     var path = this.$route.path,
            //         submenu = [];

            //     if ( this.is_it_child() ) {
            //         var partent_name = this.$route.matched[0].name;
                    
            //         jQuery.each( this.header, function(key, val ) {
            //             if (val.name == partent_name) {
            //                 if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
            //                     submenu = val.submenu;
            //                 }
            //             }
            //         });

            //         return submenu;
            //     }
                
                
            //     jQuery.each( this.header, function(key, val ) {
            //         if (val.url == path) {
            //             if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
            //                 submenu = val.submenu;
            //             }
            //         }
            //     });

            //     return submenu;
            // },
            // getHeader: function() {
            //     var request_data = {
            //         _wpnonce: HRM_Vars.nonce,
            //     },
            //     self  = this;

            //     wp.ajax.send( 'leave_header', {
            //         data: request_data,
            //         success: function(res) {
            //             self.header = res.header;
            //             //self.$store.commit( 'header', {'header': res.header} );
                    
            //         },

            //         error: function(res) {
                        
            //         }
            //     });
            // }
        }
    };

    export default Hrm_Leave_Header;
</script>

