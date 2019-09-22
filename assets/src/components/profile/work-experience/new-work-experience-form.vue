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
	import Mixin from './mixin'
	import MainMixin from '@components/profile/mixin'


	export default {
		mixins: [Mixin, MainMixin],
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

				self.loading = true;
				self.canSubmit = false;
				
				var postData = this.generateFieldData(this.fields);
					postData['employee_id']  = this.$route.params.employeeId;
					postData['class']        = 'Work_Experience';
					postData['method']       = 'create';
					postData['transformers'] = 'Work_Experience_Transformer';

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