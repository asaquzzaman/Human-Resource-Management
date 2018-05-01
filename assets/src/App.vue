<template>
    <div id="hrm" class="wrap">
        <h1 class="hrm-h1"></h1>
        <hrm-do-action :hook="'hrm-before-router-view'"></hrm-do-action>
        <router-view></router-view>
        <hrm-do-action :hook="'hrm-after-router-view'"></hrm-do-action>
    </div>
</template>

<style>
    .hrm-h1 {
        padding: 0 !important;
    }
</style>

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



