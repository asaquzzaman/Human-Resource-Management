<template>
	<div class="metabox-holder">
		<div id="hrm-hidden-form-warp" class="postbox">
	        
	        <h2 class="hndle">Work Experiance</h2>
	        <div class="inside">
		        <form id="hrm-hidden-form" action="" @submit.prevent="selfNewRecord()">
		            <div id="hrm-form-field">
		            	<hrm-form-fields :fields="fields"></hrm-form-fields>
		                
		            </div>

		            <div class="hrm-action-wrap">
		                <input :disabled="!canSubmit" type="submit" class="button hrm-button-primary button-primary" name="requst" value="Submit">

		                <a @click.prevent="showHideNewRecordForm(false)"  target="_blank" href="#" class="button hrm-button-secondary">Cancel</a>
		                <div class="hrm-spinner" v-if="loading">Saving....</div>
		            </div>
		        </form>
	    	</div>
	    </div>
	</div>
</template>

<script>
	import Mixins from '@components/payroll/group/mixin'
	import PayrollMixin from '@components/payroll/mixin'
	
	export default {
		mixins: [Mixins, PayrollMixin],
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

				if (!this.canSubmit) {
					return false;
				}

				var postData = this.generateFieldData(this.fields);
					postData['employee_id']  = this.$route.params.employeeId;
					postData['class']        = this.modelName;
					postData['method']       = 'create';
					postData['transformers'] = this.modelTransformer;
				
				if (!this.formValidation(this.fields, postData)) {
					return false;
				}	

				var args = {
					data: postData,

					callback (success, res) {
						self.loading = false;
						self.canSubmit = true;
						self.showHideNewRecordForm(false);
						self.makeEmptyField(self.fields);
					}
				}

				self.loading = true;
				self.canSubmit = false;

				this.addNewRecord(args);
			},

			generateFieldData (data) {
				var formated = {};

				data.forEach(function(val) {
					if (typeof val.filterSubmited !== 'undefined') {
						formated[val.name] = val.filterSubmited(val.model);
					} else {
						formated[val.name] = val.model;
					}
				});

				return formated;
			},
			makeEmptyField (data) {
				data.forEach(function(val) {
					val.model = [];
				});
			}
		}
	}
</script>