<template>
    <div id="hrm">
        <router-view></router-view>
        <!-- <hrm-leave></hrm-leave>
        <hrm-settings></hrm-settings> -->
    </div>
</template>

<script>

    
    export default {
        created () {

            this.registerModule();
        },
        methods: {
            registerModule () {
                let self = this;

                HRMModules.forEach(function(module) {
                    
                    let mixin = require('./components/'+module.path+'/mixin.js');
                    let store = require('./components/'+module.path+'/store.js');
                    HRMMixin[module.name] = mixin.default;

                    self.registerStore(module.name, store.default );
                });

                HRM_Store.forEach(function(store) {
                    var state = store.store.state;
                    var mutations = store.store.mutations;
                    
                    self.$store.registerModule(store.name, {
                        namespaced: true,
                        state,
                        mutations,
                    });
                });

            
            }
        },
    
    }
</script>


