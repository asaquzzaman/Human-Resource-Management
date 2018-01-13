<template>
	<div>
        <settings-header></settings-header>
        <div class="metabox-holder">
            <div id="pm_general" class="group" style="">
                <form @submit.prevent="selfGeneralSettings()" method="post" action="options.php">
                    <h2>General</h2>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="">Financial Year</label>
                                </th>
                                <td>
                                     <hrm-datepickter v-model="hrm_financial_year" class="hrm-datepickter-to" dependency="hrm-datepickter-from"></hrm-datepickter>
                                    <p class="description"></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="padding-left: 10px">
                        <p class="submit">
                            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings">
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
    import Header from './header.vue';

    export default {
        mixins: [HRMMixin.settings],
        data () {
            return {
               hrm_financial_year: this.getSettings('hrm_financial_year')
            }
        },

        created () {
            
        },

        components: {
            'hrm-datepickter': date_picker,
            'settings-header': Header
        },

        methods: {
   			selfGeneralSettings () {
   				var self = this;
		        var args = {
		        	data: {
		        		'hrm_financial_year': this.hrm_financial_year
		        	},

		        	callback: function() {

		        	}
		        }
		        
		        self.updateSettings(args);
   			}
        }
    }
</script>
	</div>
</template>