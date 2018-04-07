<template>
	<div>
		<profile-menu></profile-menu>
		<div id="hrm-general-info" class="metabox-holder">
			<div v-if="isFetchRecord" id="hrm-hidden-form-warp" class="postbox">
		        <h2 class="hndle">General Information</h2>
		        <div class="inside">
			        <div id="hrm-visible-form">
			        	<div class="main">
			        		<div v-if="!editMode">
				        		<div class="hrm-content-wrap" v-for="(field, index) in fields" :key="index" v-if="field.type == 'file'">
				        			
				        				<label class="hrm-title">
											Profile Picture
										</label> 
										
										<div v-if="field.model.length" class="hrm-uploaded-item">
											<a v-for="file in field.model" :href="file.url" target="_blank" class="hrm-uploaded-img">
												<img :src="file.thumb" alt="10-dithering-opt-3" class="hrm-uploaded-file" :style="setStyle(field)">
											</a> 
										</div>
										<div v-if="!field.model.length" class="hrm-uploaded-item" v-for="file in field.default">
						                    <img :style="setStyle(field)" class="hrm-uploaded-file" :src="file.url" :alt="file.name">
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

				        		<a @click.prevent="update(true)" class="button hrm-button-primary button-primary" href="#">Update</a>
			        		</div>
			        		
			        		<form id="hrm-personal-gnrl-info" v-if="editMode" action="" @submit.prevent="selfSavePersonalInfo()" enctype="multipart/form-data">
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
	export default {
		mixins: [HRMMixin.profile],

		data () {
			return {
				editMode: false,
				isFetchRecord: false,
        		fields: [
					{
						type: 'file',
						model: [],
						label: 'Profile Picture',
						name: '_hrm_user_image_id',
						editMode: false,
						multiple: false,
						deleted_files: [],
						attr: {
							height: '80px',
							width: '80px'
						},
						default: []
					},

					{
						type: 'template',
						label: 'Department',
						model: '',
						name: 'department',
						default: '&#8211 &#8211'
					},
					{
						type: 'radio',
						model: '',
						label: 'Gender',
						name: '_gender',
						editMode: false,
						default: '&#8211 &#8211',
						options: 
						[
							{
								label: 'Male',
								value: 'male',
							},

							{
								label: 'Female',
								value: 'female',
							}
						],
						filter (val) {
							if(val == 'male' ) {
								return 'Male';
							} 
							if(val == 'female' ) {
								return 'Female';
							} 
						}
					},
					{
						type: 'radio',
						model: '',
						label: 'Marital Status',
						name: '_marital_status',
						editMode: false,
						options: 
						[
							{
								label: 'Single',
								value: 'single',
							},

							{
								label: 'Married',
								value: 'married',
							}
						],
						default: '&#8211 &#8211',
						filter (val) {
							if(val == 'single' ) {
								return 'Single';
							} 
							if(val == 'married' ) {
								return 'Married';
							} 
						}
					},
					{
						type: 'text',
						model: '',
						label: 'Nationality',
						name: '_national_code',
						editMode: false,
						default: '&#8211 &#8211'
					},
					
					{
						type: 'datePickerFrom',
						model: '',
						label: 'Birthday',
						name: '_birthday',
						editMode: false,
						default: '&#8211 &#8211',
						filter (val, self) {
							return self.dateFormat(val);
						}
					},

					{
						type: 'text',
						model: '',
						label: 'Address Street 1',
						name: '_street1',
						editMode: false,
						default: '&#8211 &#8211'
					},

					{
						type: 'text',
						model: '',
						label: 'Address Street 2',
						name: '_street2',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'City',
						name: '_city_code',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'State/Province',
						name: '_state',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Zip/Postal Code',
						name: '_zip',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'text',
						model: '',
						label: 'Work Telephone',
						name: '_work_mobile',
						editMode: false,
						default: '&#8211 &#8211'
					},
					{
						type: 'template',
						label: 'Email',
						model: '<b>joy.mishu@gmail.com</b>',
						name: 'email'
					},

					{
						type: 'select',
						model: '',
						options: [],
						label: 'Country',
						optionLabel: 'country',
						placeholder: 'Select Country',
						name: '_country_code',
						editMode: false,
						default: '&#8211 &#8211',
						filter (val) {
							return val.country;
						}
					},
				],

				loading: false,
				canSubmit: false,
				record: {}
			}
		},

		created () {
			var self = this;
			var args = {
				employee_id: this.$route.params.employeeId,
				callback (info) {

					self.record = info;
					self.fields.forEach(function(field) {						

						if (field.name == '_country_code') {
							field.options = info.country_list;
						}

						if (field.name == '_hrm_user_image_id') {
							field.default = info.default_profile_pic;
						}
					});

					self.afterGetRecored();
				}
			}
			this.getPersonalInfo(args);
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
			selfSavePersonalInfo () {
				var self = this;

				self.loading = true;
				self.canSubmit = true;

				var postData = this.generateFieldData(this.fields);

				var args = {
					data: postData,
					files: this.getFiles(this.fields),
					deleted_files: this.getDeletedFiles(this.fields),
					callback (res) {
						self.record = res;
						self.loading = false;
						self.canSubmit = false;	
						self.editMode = false;
					}
				}

				this.savePersonalInfo(args);
			},

			getDeletedFiles (fields) {
				var deleted = [];

				fields.forEach(function(field) {
					if (field.type == 'file') {
						var newFile = {};
						
						newFile['name'] = field.name;
						newFile['files'] = field.deleted_files;

						deleted.push(newFile);
					}
				});

				return deleted;
			},

			getFiles (fields) {
				var files = [];

				fields.forEach(function(field) {

					if (field.type == 'file') {
						var newFile = {};
						
						newFile['name'] = field.name;
						newFile['files'] = [];
						newFile['multiple'] = field.multiple;

						field.model.forEach(function(fileObj) {
							if (fileObj.hasOwnProperty('lastModifiedDate')) {
								newFile['files'].push(fileObj);
							}
						}); 

						files.push(newFile);
					}
				});
				
				return files;
			},

			generateFieldData (data) {
				var formated = [];

				data.forEach(function(val) {
					if (
						val.type == 'template'
						||
						val.type == 'file'
					) {
						return;
					}
					formated.push(
						{	
							'name': val.name,
							'value': val.model
						}
					);
				});

				return formated;
			},

			savePersonalInfo (args) {
				var self = this;
				
				var data = new FormData();

				args.data.forEach(function(fieldObj) {
					data.set(fieldObj.name, JSON.stringify(fieldObj.value));
				});
	            
	            data.append('action', 'hrm_save_personal_info');
	         
	            args.deleted_files.map(function(del_file) {
	                data.append('deleted_files[]', JSON.stringify(del_file));
	            });
	           
	            args.files.forEach(function(fileObj) {
	            	var name = fileObj.name;
	            	data.append( 'is_multiple_file', fileObj.multiple );
	            	
	            	fileObj.files.forEach(function(attachment) {
	            		if ( typeof attachment.attachment_id === 'undefined' ) {
		                    var decode = self.dataURLtoFile(attachment.thumb, attachment.name);

		                    data.append( name+'[]', decode );
		                }
	            	});
	                
	            });
				
	            var request_data = {
	                data: data,
	                type: 'POST',
	                cache: false,
                	contentType: false,
                	processData: false,
                	beforeSend () {
                		self.loadingStart(
                			'hrm-personal-gnrl-info',
                			{animationClass: 'preloader-update-animation'}
                		);
                	},
	                success: function(res) {
	                	self.$store.commit('profile/setPersonalInfo', res);
	                	if (typeof args.callback === 'function') {
	                        args.callback(res);
	                    } 
	                    hrm.Toastr.success('Update successfully!');
	                    self.loadingStop('hrm-personal-gnrl-info');
	                }
	            };
	            
	            self.httpRequest('hrm_save_personal_info', request_data);
			}

		}
	}
</script>



















