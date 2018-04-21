<template>
    <div>
        <h2 class="nav-tab-wrapper">
            <router-link v-for="(item, index) in menu" :key="index" class="nav-tab" :to="{name: item.name}">{{ item.meta.label }}</router-link>
        </h2>

        <h3 class="hrm-sub-nav">
            <ul class="hrm-subsubsub">

                <li v-for="(children, child_key) in childrens()" :key="child_key">
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
                menu: Menu[0].children,
            }
        },

        created () {
            this.menu = this.menu.filter(function(child) {
                    
                if(
                    typeof child.meta != 'undefined'
                        &&
                    typeof child.meta.label != 'undefined'
                ) {

                    return child;
                }

            });
        },

        methods: {
            childrens () {
                if (!this.has_child) {
                    return [];
                }

                let root_menu = this.getParentName();
                let index = this.getIndex(this.menu, root_menu, 'name');
                
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

            has_child: function() {

                if( this.$route.matched.length > 1 ) {
                    return true;
                } 

                return false;
            },

            getParentName () {
                let index = this.getIndex(this.$route.matched, this.$route.name, 'name');
                    index = parseInt(index) - 1;
                return this.$route.matched[index].name;
            }
        }
    };

    export default Hrm_Leave_Header;
</script>







