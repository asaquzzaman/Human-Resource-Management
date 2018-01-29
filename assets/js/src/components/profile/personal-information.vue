<template>
	<div id="hrm-hidden-form-warp" class="postbox">
        <div class="hrm-search-head">
            <h3>Profile Information</h3>
        </div>
        <div class="inside" id="hrm-visible-form">
        	<div class="main">
        		<hrm-form-fields :fields="fields"></hrm-form-fields>
        	</div>
        </div>
    </div>
</template>

<script>
	export default {
		data () {
			return {
				files: [],
        		deleted_files: [],
				fields: [
					{
						type: 'file',
						model: '',
						label: 'Profile Picture',
						name: 'profile_picture',
						editMode: false,
						multiple: false,
						attr: {
							height: '80px',
							width: '80px'
						}
					},
					{
						type: 'text',
						model: '',
						label: 'Nationality',
						name: 'nationality',
						editMode: false
					},
					{
						type: 'radio',
						model: '',
						label: 'Gender',
						name: 'gender',
						editMode: false,
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
						]
					},
					{
						type: 'datePickerFrom',
						model: '',
						label: 'Birthday',
						name: 'birthday',
						editMode: false
					},

					{
						type: 'text',
						model: '',
						label: 'Address Street 1',
						name: 'street_1',
						editMode: false
					},

					{
						type: 'text',
						model: '',
						label: 'Address Street 2',
						name: 'street_2',
						editMode: false
					},
					{
						type: 'text',
						model: '',
						label: 'City',
						name: 'city',
						editMode: false
					},
					{
						type: 'text',
						model: '',
						label: 'State/Province',
						name: 'state',
						editMode: false
					},
					{
						type: 'text',
						model: '',
						label: 'Zip/Postal Code',
						name: 'zip',
						editMode: false
					},
					{
						type: 'text',
						model: '',
						label: 'Work Telephone',
						name: 'telephone',
						editMode: false
					},
					{
						type: 'template',
						label: 'Email',
						template: '<b>joy.mishu@gmail.com</b>'
					},
					// {
					// 	type: 'checkbox',
					// 	label: 'Gender',
					// 	model: [],
					// 	name: 'genderCheckbox',
					// 	editMode: false,
					// 	options: 
					// 	[
					// 		{
					// 			label: 'Male',
					// 			value: 'rocky'
					// 		},

					// 		{
					// 			label: 'Female',
					// 			value: 'kiron'
					// 		}
					// 	]
					// },
				],

				loading: false,
				canSubmit: true
			}
		}
	}
</script>