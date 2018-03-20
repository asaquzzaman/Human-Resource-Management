function FormFields (self) { 
	return [
		{
			type: 'text',
			model: '',
			label: 'User Name',
			name: 'userName',
			//tableHead: 'Title',
			//tbRowAction: true,
			editable: false
		},
		{
			type: 'email',
			model: '',
			label: 'Email',
			name: 'email',
		},
		{
			type: 'text',
			model: '',
			label: 'First Name',
			name: 'firstName',
			editable: true
		},
		{
			type: 'text',
			model: '',
			label: 'Last Name',
			name: 'lastName',
			editable: true
		},
		{
			type: 'select',
			model: '',
			options: hrmGetRoles(),
			label: 'Role',
			optionLabel: 'display_name',
			placeholder: 'Select Role',
			name: 'role',
			tableHead: 'Role',
			editable: true,
			//Filter submited new data
			filterSubmited (val) {
				return val.name;
			},

			//Table print data
			filterPrintData (val) {
				if (!val) {
					return '&#8211 &#8211';
				}
				return val.display_name;
			},
			
			//Filter edit submited data
			filterEditingData (val) {
				if (val) {
					return val.name;
				}
			}
		},
		{
			type: 'select',
			model: '',
			options: [],
			label: 'Department',
			optionLabel: 'name',
			placeholder: 'Select Department',
			name: 'department',
			tableHead: 'Department',
			editable: true,
			//Filter submited new data
			filterSubmited (val) {
				return val.id;
			},
			//Table print data
			filterPrintData (val) {
				if (!val) {
					return '&#8211 &#8211';
				}
				return val.data.name;
			},
			// Filter edit form field data
			filterComputedGet (val) {
				if (!val) {
					return '';
				}
				return val.data;
			},
			// Filer edit changable data
			filterComputedSet (val) {
				return { data: val }
			},
			//Filter edit submited data
			filterEditingData (val) {
				if (val) {
					return val.data.id;
				}
			}	
		},
		{
			type: 'select',
			model: '',
			options: [],
			label: 'Designation',
			optionLabel: 'title',
			placeholder: 'Select Designation',
			name: 'designation',
			tableHead: 'Designation',
			editable: true,
			//Filter submited new data
			filterSubmited (val) {
				return val.id;
			},
			//Table print data
			filterPrintData (val) {

				if (!val) {
					return '&#8211 &#8211';
				}
				return val.data.title;
			},
			// Filter edit form field data
			filterComputedGet (val) {

				if (!val) {
					return '';
				}
				return val.data;
			},
			// Filer edit changable data
			filterComputedSet (val) {
				return { data: val }
			},
			//Filter edit submited data
			filterEditingData (val) {
				if (val) {
					return val.data.id;
				}
			}	
		},
		{
			type: 'select',
			model: '',
			options: [],
			label: 'Location',
			optionLabel: 'name',
			placeholder: 'Select Location',
			name: 'location',
			tableHead: 'Location',
			editable: true,

			//Filter submited new data
			filterSubmited (val) {
				return val.id;
			},
			//Table print data
			filterPrintData (val) {

				if (!val) {
					return '&#8211 &#8211';
				}
				return val.data.name;
			},
			// Filter edit form field data
			filterComputedGet (val) {

				if (!val) {
					return '';
				}
				return val.data;
			},
			// Filer edit changable data
			filterComputedSet (val) {
				return { data: val }
			},
			//Filter edit submited data
			filterEditingData (val) {
				if (val) {
					return val.data.id;
				}
			}
			
		},
		{
			type: 'select',
			model: '',
			options: hrmGetStatus(),
			label: 'Status',
			optionLabel: 'label',
			placeholder: 'Select Status',
			name: 'status',
			tableHead: 'Status',
			editable: true,
			//Filter submited new data
			filterSubmited (val) {
				return val.key;
			},
			//Filter edit submited data
			filterEditingData (val) {
				return val.key;
			},	
			//Table print data
			filterPrintData (val) {

				if (!val) {
					return '&#8211 &#8211';
				}
				return val.label;
			},
			
		},
		{
			type: 'select',
			model: '',
			options: hrmGetGender(),
			label: 'Gender',
			optionLabel: 'label',
			placeholder: 'Select Gender',
			name: 'gender',
			tableHead: 'Gender',
			editable: true,
			//Filter submited new data
			filterSubmited (val) {
				return val.key;
			},
			//Filter edit submited data
			filterEditingData (val) {
				return val.key;
			},
			//Table print data
			filterPrintData (val) {

				if (!val) {
					return '&#8211 &#8211';
				}
				return val.label;
			},
		},
		{
			type: 'text',
			model: '',
			label: 'Mobile Number',
			name: 'mobileNumber',
			editable: true
		},
		{
			type: 'datePickerFrom',
			model: '',
			label: 'Joining Date',
			name: 'joiningDate',
			editable: true
		},
		{
			type: 'textarea',
			model: '',
			label: 'Description',
			name: 'description',
			tableHead: 'Description',
			editable: true
		},
		{
			type: 'file',
			model: [],
			label: 'Profile Picture',
			name: 'employee_image',
			editMode: false,
			multiple: false,
			deleted_files: [],
			attr: {
				height: '80px',
				width: '80px'
			},
			default: []
		},
	]
}

function hrmGetGender() {
	return [
		{
			key: 1,
			label: 'Male'
		},
		{
			key: 2,
			label: 'Female'
		},
		{
			key: 3,
			label: 'Others'
		}
	]
}

function hrmGetStatus() {
	return [
		{
			key: 1,
			label: 'Active'
		},
		{
			key: 2,
			label: 'Disable'
		}
	]
}

function hrmGetRoles() {
	var roles = [];

	jQuery.each(HRM_Vars.hrm_roles, function(key, val) {
		roles.push(
			{
				name: key,
				display_name: val
			}
		);
	})

	return roles;
}

export { FormFields }