<template>
	<div class="page-organization">
		<h1 class="wp-heading-inline">Locations</h1>
		<a @click.prevent="showHideNewRecordForm('toggle')" class="page-title-action">Add New</a>

		<organization-menu></organization-menu>

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
            component_name='location_pagination'>
            
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
	import Table from './location-table.vue';
	import Form from './new-location-form.vue';

	export default {
		mixins: [HRMMixin.location],

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
						label: 'Name',
						name: 'name',
						tableHead: 'Name',
						tbRowAction: true,
						editable: true
					},
					{
						type: 'select',
						model: '',
						options: [],
						label: 'Country',
						optionLabel: 'country',
						placeholder: 'Select Country',
						name: 'country_code',
						tableHead: 'Country',
						editable: true,
						//Filter submited new data
						// filterSubmited (val) {
						// 	return val.id;
						// },
						// //Table print data
						// filterPrintData (val) {

						// 	if (!val) {
						// 		return '&#8211 &#8211';
						// 	}
						// 	return val.data.name;
						// },
						// // Filter edit form field data
						// filterComputedGet (val) {

						// 	if (!val) {
						// 		return '';
						// 	}
						// 	return val.data;
						// },
						// // Filer edit changable data
						// filterComputedSet (val) {
						// 	return { data: val }
						// },
						// //Filter edit submited data
						// filterEditingData (val) {
						// 	if (val) {
						// 		return val.data.id;
						// 	}
						// }
						
					},
					{
						type: 'text',
						model: '',
						label: 'State/Province',
						name: 'province',
						tableHead: 'State/Province',
						editable: true
					},
					{
						type: 'text',
						model: '',
						label: 'City',
						name: 'city',
						tableHead: 'City',
						editable: true
					},
					{
						type: 'text',
						model: '',
						label: 'Address Street 1',
						name: 'address',
						tableHead: 'Address Street 1',
						editable: true
					},
					{
						type: 'text',
						model: '',
						label: 'Zip/Postal Code',
						name: 'zip_code',
						tableHead: 'Zip/Postal Code',
						editable: true
					},
					{
						type: 'text',
						model: '',
						label: 'Phone',
						name: 'phone',
						tableHead: 'Phone',
						editable: true
					},
					{
						type: 'text',
						model: '',
						label: 'Fax',
						name: 'fax',
						tableHead: 'Fax',
						editable: true
					},
					{
						type: 'textarea',
						model: '',
						label: 'Note',
						name: 'notes',
						tableHead: 'Note',
						editable: true
					}
				],
			}
		},
		
		created () {
			var self = this;
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