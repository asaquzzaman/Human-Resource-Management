<template>
	<div>
        
        <div class="metabox-holder">
            <div id="pm_general" class="group" style="">
                <form @submit.prevent="emailSettings()" method="post" action="options.php">
                    <h2>Email</h2>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="hrm_form_email">From Email</label>
                                </th>
                                <td>
                                    <input v-model="hrm_form_email" type="text" class="regular-text" id="hrm_form_email" name="hrm_form_email" value="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="email_type">Email type</label>
                                </th>
                                <td>
                                    <fieldset>
                                        <select name="email_type" id="email_type" v-model="email_type">
                                            <option value="html" selected>HTML</option>
                                        </select>
                                        
                                    </fieldset>
                                </td>
                            </tr>

                        </tbody>
                    </table> 

                    <div style="padding-left: 10px">
                        <p class="submit">
                            <input :disabled="!canSubmit" type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings">
                            <span  class="pm-spinner"></span>
                        </p>                            
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
	import date_picker from './date-picker.vue';
    import Mixin from './mixin'
    
    export default {
        mixins: [Mixin],
        data () {
            return {
               hrm_form_email: this.getEmailSettings('form_email', ''),
               email_type: this.getEmailSettings('email_type', 'html'),
               canSubmit: true
            }
        },

        created () {
            
        },

        components: {
            'hrm-datepickter': date_picker,
        },

        methods: {
   			emailSettings () {
                if (!this.canSubmit) {
                    return false;
                }
   				var self = this;
                this.canSubmit = false;
                var data = {
                    form_email: this.hrm_form_email,
                    email_type: this.email_type
                };
                var request = {
                    data: data,
                    success (res) {
                        hrm.Toastr.success('Udpate settings successfully!');
                        self.canSubmit = true;
                    }
                };
                
                this.httpRequest('hrm_email_settings', request);

            },
            getEmailSettings (key, predefine) {
                var predefine = predefine || false;
                var emailSettings = HRM_Vars.email_settings;
    
                if (typeof emailSettings[key] == 'undefined' || !emailSettings[key] ) {
                    return predefine;
                }

                return emailSettings[key];

            }
        
        }
    }
</script>
	