<template>
    <div>

        <h2 class="nav-tab-wrapper">
            <router-link v-for="(item,  index) in menu[0].children" :key="index" class="nav-tab" :to="{name: item.name}">{{ item.meta.label }}</router-link>

        </h2>

        <h3 class="hrm-sub-nav">
            <ul class="hrm-subsubsub">

                <li v-for="children in childrens()" v-if="children.meta.label">
                    <router-link  :to="{name: children.name}">{{ children.meta.label }}</router-link> |&nbsp; 
                </li> 
              
            </ul>
        </h3>

    </div>
</template>

<script>
    import Menu from './router';
    import Mixin from './mixin'
    
    var Hrm_Settings_Header = {
        mixins: [Mixin],

        data: function() {
            return {
                menu: Menu,
            }
        },

        methods: {
            childrens () {
                let root_menu = this.$route.matched[1].name;

                let index = this.getIndex(this.menu[0].children, root_menu, 'name');
                
                if (index === false) {
                    return [];
                }

                if (this.menu[0].children[index].hasOwnProperty('children')) {
                    if (this.menu[0].children[index].children.length) {
                        return this.menu[0].children[index].children;
                    }
                } else {
                    return [];
                }
            },
            is_it_child: function() {

                if( this.$route.matched.length > 1 ) {
                    return true;
                }
            },
            has_child_menu: function() {
                var path = this.$route.path,
                    has_submenu = false;
                
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
        }
    };

    export default Hrm_Settings_Header;
</script>

