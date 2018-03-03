<template>
	<div id="hrm-hidden-form-warp" class="postbox">
        <div class="hrm-search-head">
            <h3>Work Experiance</h3>
        </div>
        <form id="hrm-hidden-form" action="" @submit.prevent="selfNewRecord()">
            <div id="hrm-form-field">
            	<hrm-form-fields :fields="fields"></hrm-form-fields>
                
            </div>

            <div class="hrm-action-wrap">
                <input :disabled="!canSubmit" type="submit" class="button  button-primary" name="requst" value="Submit">

                <a @click.prevent="showHideNewRecordForm(false)"  target="_blank" href="#" class="button hrm-form-cancel">Cancel</a>
                <div class="hrm-spinner" v-if="loading">Saving....</div>
            </div>
        </form>
    </div>
</template>

<script>
	export default {
		mixins: [HRMMixin.workExperience],
		props: {
			fields: {
				type: [Array]
			}
		},

		data () {
			return {
				loading: false,
				canSubmit: true
			}
		},

		computed: {
			
		},

		methods: {
			selfNewRecord () {
				var self = this;

				self.loading = true;
				self.canSubmit = false;
				
				var postData = this.generateFieldData(this.fields);
					postData['employee_id']  = this.$route.params.employeeId;
					postData['class']        = 'Work_Experience';
					postData['method']       = 'create';
					postData['transformers'] = 'Work_Experiance_Transformer';

				var args = {
					data: postData,

					callback (success, res) {
						self.loading = false;
						self.canSubmit = true;
						self.showHideNewRecordForm(false);
						self.makeEmptyField(self.fields);
					}
				}

				this.addNewRecord(args);
			},

			generateFieldData (data) {
				var formated = {};

				data.forEach(function(val) {
					formated[val.name] = val.model;
				});

				return formated;
			},
			makeEmptyField (data) {
				data.forEach(function(val) {
					val.model = '';
				});
			}
		}
	}
</script>