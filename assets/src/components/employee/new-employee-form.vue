<template>
	<div class="metabox-holder">
		<div id="hrm-hidden-form-warp" class="postbox">
	        
	        <h2 class="hndle">Employee</h2>

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
	export default {
		mixins: [HRMMixin.employee],
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
				var postData = this.generateFieldData(this.fields);
				var isFormValidate = true;

				this.fields.forEach(function(val) {
					if(
						val.required === true
							&&
						!postData[val.name]
					) {
						hrm.Toastr.error(val.label + ' is required!');
						isFormValidate = false;
					}
				});
				
				if (!isFormValidate) {
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
					val.model = '';
				});
			}
		}
	}
</script>