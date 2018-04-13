<template>
	<div  class="page-organization metabox-holder">
		<h1 class="wp-heading-inline">Organization</h1>

		<organization-menu></organization-menu>

		<div  id="hrm-hidden-form-warp" class="postbox">

	        
	        <h2 class="hndle ui-sortable-handle">General Information</h2>
	        <div id="hrm-visible-form">
		        <div v-if="isFetchRecord" class="inside">
		        	<div class="main">
		        		<div v-if="!editMode">
			        		<div class="hrm-content-wrap" v-for="(field, index) in fields" :key="index" v-if="field.type == 'file'">
			        			
			        				<label class="hrm-title">
										Profile Picture
									</label> 
									
									<div class="hrm-uploaded-item">
										<a v-for="file in field.model" :href="file.url" target="_blank" class="hrm-uploaded-img">
											<img :src="file.thumb" alt="10-dithering-opt-3" class="hrm-uploaded-file" :style="setStyle(field)">
										</a> 
									</div>
									<div class="hrm-clear"></div>
			        		</div>

			        		<div class="hrm-content-wrap" v-else>

			        				<label class="hrm-title">
			                			{{ field.label }}
			                				
			                		</label> 
			                		
			                		<div class="hrm-content" v-html="filter(field.model, field)"></div>
			                			
			                		<div class="hrm-clear"></div>

			        		</div>

			        		<a v-if="manageOrganization()" @click.prevent="update(true)" class="button hrm-button-primary button-primary" href="#">Update</a>
		        		</div>
		        		
		        		<form id="hrm-general-info-form" v-if="editMode && manageOrganization()" action="" @submit.prevent="selfSaveOrganizationalInfo()" enctype="multipart/form-data">
		        			<hrm-form-fields :fields="fields"></hrm-form-fields>
		        			<input :disabled="canSubmit" type="submit" class="button hrm-button-primary button-primary">
		        			<a @click.prevent="update(false)" class="button hrm-button-secondary button-secondary" href="#">cancel</a>
		        			<div class="hrm-spinner" v-if="loading">Saving....</div>
		        		</form>
		        	</div>
		        </div>
		    </div>
	    </div>
	</div>
</template>

<style type="text/css">
	.hrm-title, .hrm-content {
		float: left;
	}
	.hrm-content {
		width: 65%;
	}
	.hrm-content-wrap {
		display: block;
		margin-bottom: 10px;
		width: 100%;
	}
</style>

<script>
	import Mixin from '@components/profile/mixin'
	
	export default {
		mixins: [Mixin],

		data () {
			return {
				editMode: false,
				isFetchRecord: false,
				fields: [
					{
						type: 'text',
						model: '',
						label: 'Organization Name ',
						name: 'organization_name',
						required: true,
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Tax ID',
						name: 'tax_id',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Registration Number',
						name: 'registration_number',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Phone',
						name: 'phone',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Fax',
						name: 'fax',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Address Street 1',
						name: 'addres_street_1',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Address Street 2',
						name: 'address_street_2',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'City',
						name: 'city',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'State/Province',
						name: 'state_province',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Zip/Postal Code',
						name: 'zip',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'select',
						model: '',
						options: [],
						label: 'Country',
						optionLabel: 'country',
						placeholder: 'Select Country',
						name: 'country',
						editMode: false,
						default: '&#8211 &#8211',
						filter (val) {
							return val.country;
						}
					},
					{
						type: 'textarea',
						model: '',
						label: 'Note',
						name: 'note',
						editMode: false,
						default: '&#8211 &#8211'
					}
				],

				loading: false,
				canSubmit: false,
				record: {}
			}
		},

		created () {
			var self = this;
			var args = {
				callback (res) {
					self.record = res.data;
					self.fields.forEach(function(field) {						
						if (field.name == 'country') {
							field.options = res.countries;
						}
					});

					self.afterGetRecored();
				}
			}
			this.getOrganizationInfo(args);
		},

		methods: {
			filter (value, field) {

				if (!value) {
					return field.default;
				}

				if (typeof field.filter !== 'undefined') {
					return field.filter(value, this);
				}
				return value;
			},
			afterGetRecored () {
				var self = this,
					record = self.record;
				if (record == null) {
					return ;
				}
				self.fields.forEach(function(field) {
					field.model = record[field.name] ? record[field.name] : '';
				});
			},
			update (status) {

				this.editMode = status;

				this.afterGetRecored();
			},
			setStyle (field) {
				return {
					height: field.attr.height,
					width: field.attr.width
				}
			},
			getOrganizationInfo (args) {
				var self = this;
				
	            var request_data = {
	                data: {},
	                beforeSend () {
                		self.loadingStart('hrm-visible-form');
                	},
	                success: function(res) {
	                	// self.$store.commit('general/setOrganizationInfo', res.data);
	                	self.loadingStop('hrm-visible-form');
	                	self.isFetchRecord = true;
	                	if (typeof args.callback === 'function') {
	                        args.callback(res);
	                    } 
	                }
	            };

	            self.httpRequest('hrm_get_organigation_info', request_data);
			},
			selfSaveOrganizationalInfo () {
				var self = this;

				self.loading = true;
				self.canSubmit = true;
				var postData = this.generateFieldData(this.fields);
				var args = {
					data: postData,
					callback (res) {
						self.record = res.data;
						self.loading = false;
						self.canSubmit = false;	
						self.editMode = false;
					}
				}

				this.saveOrganizationalInfo(args);
			},

			generateFieldData (data) {
				var formated = [];

				data.forEach(function(val) {
					formated.push(
						{	
							'name': val.name,
							'value': val.model
						}
					);
				});

				return formated;
			},

			saveOrganizationalInfo (args) {
				var self = this;
				args.data.push({
					name: 'action',
					value: 'single_form'
				});
				args.data.push({
					name: 'table_option',
					value: 'hrm_general_info'
				});
	            var request_data = {
	                data: args.data,
	                type: 'POST',
	                beforeSend () {
                		self.loadingStart(
                			'hrm-general-info-form',
                			{animationClass: 'preloader-update-animation'}
                		);
                	},
	                success: function(res) {
	                	//self.$store.commit('profile/setPersonalInfo', res);
	                	self.loadingStop('hrm-general-info-form');
	                	hrm.Toastr.success('Update successfully!');
	                	if (typeof args.callback === 'function') {
	                        args.callback(res);
	                    } 
	                }
	            };
	            
	            self.httpRequest('single_form', request_data);
			}

		}
	}
</script>