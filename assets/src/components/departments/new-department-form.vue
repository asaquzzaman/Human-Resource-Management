<template>
    <div class="metabox-holder">
        <div v-if="manageDepartment()"  id="hrm-hidden-form-warp" class="postbox">
            <h2 class="hndle">Department</h2>
            <div class="inside">
                <form id="hrm-hidden-form" action="" @submit.prevent="createNewDepartment()">
                    <div id="hrm-form-field">

                        <div class="hrm-form-field ">
                            <label for="title">
                                Title<em>*</em>
                            </label>
                            <input type="text" required="required" v-model="title" name="title" value="" placeholder="" class="title" id="title"  data-hrm_validation="1" data-hrm_required="1" data-hrm_required_error_msg="This field is required"  />
                            <span class="hrm-clear"></span>
                            <span class="description"></span>
                        </div>

                        <div class="hrm-form-field ">
                            <label for="description">
                                Description<em></em>
                            </label>
                            <textarea name="description" v-model="description" class="hrm-admin-notice-field" id="description"></textarea>
                            <span class="hrm-clear"></span>
                            <span class="description"></span>
                        </div>

                        <div class="hrm-form-field ">
                            <label for="status">Parent<em>   </em></label>
                            
                            <select v-model="parent" class="status" name="status" id="status" data-placeholder="-- Chose --">
                                <option value="-1">-Select-</option>
                                <option v-for="department in deptDropDown" :value="department.id"><span v-html="department.hierarchical_free_pad"></span>{{ department.name }}</option>
                            </select>
                            <span class="hrm-clear"></span>
                            <span class="description">Choose Parent Department</span>
                        </div>

                        
                        <div  class="hrm-form-field ">
                            <label for="status">Status<em>   </em></label>
                            <select v-model="status" class="status" name="status" id="status" data-placeholder="-- Chose --">
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>
                            </select>
                            <span class="hrm-clear"></span>
                            <span class="description">Choose department status</span>
                        </div>
                        
                    </div>

                    <div class="hrm-action-wrap">
                        <input  type="submit" class="button hrm-button-primary button-primary" name="requst" value="Submit">

                        <a @click.prevent="showHideDepartmentForm(false)" target="_blank" href="#" class="button hrm-button-secondary">Cancel</a>
                        <div class="hrm-spinner" v-if="show_spinner">Saving....</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Mixin from './mixin'
    
    export default {

        mixins: [Mixin],

        data: function() {
            return {
                title: '',
                description: '',
                status: '1',
                parent: '-1',
                department_id: false,
                show_spinner: false,
            }
        },

        created: function() {

            this.defaultFormValu(this.$store.state.departments.department_id);

            // if ( !this.$store.state.departments.departments.length ) {
            //     this.getDepartments();
            // }
        },

        watch: {
            '$store.state.department_id': function(department_id) {
                this.defaultFormValu(department_id);
            }
        },

        computed: {
            departments: function() {
                return this.$store.state.departments.departments;
            },

            deptDropDown: function() {
                return this.$store.state.departments.dept_drop_down;  
            }
        },

        methods: {
            defaultFormValu: function(department_id) {
                if (!department_id) {
                    return;
                }

                var dept_index = this.getIndex(this.$store.state.departments.departments, department_id, 'id' ),
                    department = this.$store.state.departments.departments[dept_index];

                //console.log('alksjhfaksjdh');

                this.department_id = department_id;
                this.title         = department.name;
                this.description   = department.description;
                this.status        = department.active;
                this.parent        = !parseInt(department.parent) ? '-1' : department.parent;
            },

            createNewDepartment: function() {
                var request_data = {
                    _wpnonce: HRM_Vars.nonce,
                    title: this.title,
                    description: this.description,
                    status: this.status,
                    parent: this.parent,
                    dept_id: this.department_id,
                    page_number: this.$route.params.page_number
                },
                is_update  = parseInt( this.department_id ) ? true : false,
                
                target_index = is_update ? this.getIndex(
                    this.$store.state.departments.departments, this.department_id, 'id'
                ) : false,

                self = this;

                this.show_spinner = true;

                wp.ajax.send('create_new_department', {
                    data: request_data,
                    
                    success: function(res) {
                        self.show_spinner = false;
                        
                        // Display a success toast, with a title
                        hrm.Toastr.success(res.success);
                        self.showHideDepartmentForm(false);
                        
                        self.slideUp(jQuery('.hrm-form-cancel'), function() {
                            self.$store.commit('departments/showHideDepartmentForm', false);
                        });

                        self.$store.commit('departments/updateDepartment', {
                            is_update: is_update, 
                            dept_id: self.department_id,
                            target_index: target_index,
                            departments: res.departments,
                            dept_drop_down: res.dept_drop_down
                        });

                        self.title = '';
                        self.description = '';
                        self.status = '1';
                        self.parent = '-1';
                        self.department_id = false;
                        
                    },

                    error: function(res) {
                        self.show_spinner = false;
                        // Showing error
                        res.error.map( function( value, index ) {
                            hrm.Toastr.error(value);
                        });
                    }
                });
            }
        }
    }
</script>

