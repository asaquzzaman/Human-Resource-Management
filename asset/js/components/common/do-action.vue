<script>
    import Vue from './../../vue/vue.js';
    
    function HRMGetComponents() {
        var components = {};
        
        HRM_Components.map(function(obj, key) {
            if (obj.property.mixins) {
                obj.property.mixins.push(mixin);
            } 

            components[obj.component] = obj.property;
        });

        return components;
    }

    var action = {
        props: {
            hook: {
                type: String,
                required: true
            },

            actionData: {
                type: [Object, Array, String, Number],

                default: function () {
                    return {}
                }
            }
        },

        components: HRMGetComponents(),

        render (h) {
            this.$options.components = HRMGetComponents();

            var components = [],
                self = this;

            HRM_Components.map(function(obj, key) {
                if (obj.hook == self.hook) {
                    components.push(
                       Vue.compile('<'+obj.component+' :actionData="actionData"></'+obj.component+'>').render.call(self)
                    );
                }
            });
            
            return h('span', {}, components);
        }
    }

    export default action;
    
</script>


