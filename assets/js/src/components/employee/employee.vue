<template>
	<div>
		<h1 class="wp-heading-inline">Employee</h1>
		<a @click.prevent="showHideNewRecordForm('toggle')" class="page-title-action">Add New</a>

		<add-new-record-form v-if="isNewRecordFormActive" :fields="fields"></add-new-record-form>

	    <div class="hrm-tbl-action-wrap">
			<div class="hrm-bulk-wrap">
				<label for="bulk-action-selector-top" class="screen-reader-text">
					Select bulk action
				</label>
				<select v-model="bulkAction" name="action" id="bulk-action-selector-top">
					<option value="-1">Bulk Actions</option>
					<option value="delete">Delete</option>
				</select>
				<a href="#" @click.prevent="selfBulkAction()" class="button button-secondary">Apply</a>
			</div>

			<div class="hrm-filter-wrap">
				<div class="alignleft actions">
					<input v-model="search.title" type="text">
					<hrm-date-picker placeholder="From" v-model="search.from"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
					<hrm-date-picker placeholder="To" v-model="search.to" class="pm-datepickter-from" dependency="pm-datepickter-to"></hrm-date-picker>
					<a href="#" class="button button-secondary" @click.prevent="recordSearch()">Filter</a>

				</div>

			</div>
			<div class="hrm-clear"></div>
		</div>
		
	    <hrm-table :fields="fields"></hrm-table>

	    <hrm-pagination 
            :total_pages="pagination.total_pages" 
            component_name='designation_pagination'>
            
        </hrm-pagination> 

	</div>
</template>

<style>
	.hrm-bulk-wrap, .hrm-filter-wrap {
		float: left;
	}
	.hrm-tbl-action-wrap {
		margin-top: 20px;
	}
</style>

<script>
	import Table from './employee-table.vue';
	import Form from './new-employee-form.vue';

	export default {
		mixins: [HRMMixin.employee],

		data () {

			return {
				search: {
					filter: 'active',
					title: this.$route.query.title,
					from: this.$route.query.from,
					to: this.$route.query.to
				},
				bulkAction: -1,

				fields: [
					{
						type: 'text',
						model: '',
						label: 'User Name',
						name: 'user_name',
						tableHead: 'User Name',
						editable: true,
						default: '',
						required: true
					},
					{
						type: 'email',
						model: '',
						label: 'Email',
						name: 'email',
						tableHead: 'Email',
						editable: true,
						default: '',
						required: true
					},
					{
						type: 'text',
						model: '',
						label: 'First Name',
						name: 'first_name',
						tableHead: 'First Name',
						editable: true,
						default: '',
						required: true
					},
					{
						type: 'text',
						model: '',
						label: 'Last Name',
						name: 'last_name',
						tableHead: 'Last Name',
						editable: true,
						default: '',
						required: true
					},
					{
						type: 'select',
						model: '',
						options: [],
						label: 'Role',
						optionLabel: 'name',
						placeholder: 'Role',
						name: 'role',
						tableHead: 'Rore',
						editable: true,
						options: 
						[
							{
								label: 'Employee',
								value: 'employee',
							},

							{
								label: 'Manager',
								value: 'manager',
							}
						],
						//Filter submited new data
						filterSubmited (val) {
							return val.value;
						},
						//Table print data
						filterPrintData (val) {

							if (!val) {
								return '&#8211 &#8211';
							}
							return val.label;
						},
						// Filter edit form field data
						filterComputedGet (val) {

							if (!val) {
								return '';
							}
							return val.label;
						},
						// Filer edit changable data
						filterComputedSet (val) {
							return { data: val }
						},
						//Filter edit submited data
						filterEditingData (val) {
							if (val) {
								return val.value;
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
						type: 'radio',
						model: '',
						label: 'Gender',
						name: 'gender',
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
						type: 'radio',
						model: '',
						label: 'Status',
						name: 'status',
						editMode: false,
						options: 
						[
							{
								label: 'Active',
								value: 'active',
							},

							{
								label: 'Inactive',
								value: 'inactive',
							}
						],
						default: '&#8211 &#8211',
						filter (val) {
							if(val == 'active' ) {
								return 'Active';
							} 
							if(val == 'Inactive' ) {
								return 'inactive';
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
						placeholder: 'Date of Birth',
						name: 'birthday',
						editMode: false,
						default: '&#8211 &#8211',
						filter (val, self) {
							return self.dateFormat(val);
						}
					},					
					{
						type: 'text',
						model: '',
						label: 'Mobile Number',
						name: 'mobile',
					},
					{
						type: 'datePickerFrom',
						model: '',
						label: 'Joning Date',
						name: 'joining_date',
						filter (val, self) {
							return self.dateFormat(val);
						}
					},	
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
				],
			}
		},
		
		created () {
			var self = this;
			this.getDepartments({
				callback (departments) {
					var index = self.getIndex(self.fields, 'department', 'name');
					self.fields[index].options = departments.dept_drop_down;
				}
			});
		},

		computed: {
			isNewRecordFormActive () {
				return this.$store.state[this.nameSpace].isNewRecordFormActive;
			},

            total_experiance_page () {
                return 10;
            },

            pagination () {
            	return this.$store.state[this.nameSpace].pagination;
            }
		},
		components: {
			'hrm-table': Table,
			'add-new-record-form': Form
		},

		methods: {

			selfBulkAction () {
				var self = this;
				switch( this.bulkAction) {
					case 'delete':
						this.recordDelete(self.$store.state[self.nameSpace].deletedId, function() {
							var hasRecords = self.$store.state[self.nameSpace].records.length;
							var page = self.$route.params.current_page_number;
							
							if (!hasRecords && page > 1) {
								self.$router.push({
									params: {
										current_page_number: page - 1
									},
									query: self.$route.query
								});
							}
							if (!hasRecords && self.pagination.total_pages > 1) {
								self.getRecords();
							}
						});
						break;

					default:

						break;
				}
			},

			recordSearch () {
				this.$router.push({query: this.search});
				this.getRecords();
			}
		}
	}
</script>