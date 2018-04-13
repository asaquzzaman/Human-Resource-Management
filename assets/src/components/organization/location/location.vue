<template>
	<div class="page-organization">
		<h1 v-if="manageOrganization()" class="wp-heading-inline">Locations</h1>
		<a v-if="manageOrganization()" @click.prevent="showHideNewRecordForm('toggle')" class="page-title-action">Add New</a>

		<organization-menu></organization-menu>

		<add-new-record-form class="hrm-toggle" v-if="isNewRecordFormActive && manageOrganization()" :fields="fields"></add-new-record-form>

	    <div class="hrm-tbl-action-wrap">
			<div  v-if="manageOrganization()" class="hrm-table-action hrm-bulk-wrap">
				<label for="bulk-action-selector-top" class="screen-reader-text">
					Select bulk action
				</label>
				<select v-model="bulkAction" name="action" id="bulk-action-selector-top">
					<option value="-1">Bulk Actions</option>
					<option value="delete">Delete</option>
				</select>
				<a href="#" @click.prevent="selfBulkAction()" class="button hrm-button-secondary button-secondary">Apply</a>
			</div>

			<div class="hrm-table-action hrm-filter-wrap">
				<div class="alignleft actions">
					<form @submit.prevent="recordSearch()">
						<input v-model="search.name" placeholder="Title" type="search">
						<input type="submit" class="button hrm-button-secondary button-secondary" value="Filter">
					</form>
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
	import Countires from '@helpers/countries/countries'
    import Mixin from './mixin'

	export default {
		mixins: [Mixin],

		data () {

			return {
				search: {
					filter: 'active',
					name: this.$route.query.name,
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
						tbRowAction: this.manageOrganization(),
						editable: true,
						required: true
					},
					{
						type: 'select',
						model: '',
						options: Countires,
						label: 'Country',
						optionLabel: 'name',
						placeholder: 'Select Country',
						name: 'country_code',
						tableHead: 'Country',
						editable: true,
						//Filter submited new data
						filterSubmited (val) {
							return val.code;
						},
						//Table print data
						filterPrintData (val, self) {
							let index = self.getIndex( Countires, val, 'code' );

							if (!val || index === false) {
								return '&#8211 &#8211';
							}

							return Countires[index].name;
						},
						// Filter edit form field data
						filterComputedGet (val, self) {
							let index = self.getIndex( Countires, val, 'code' );

							if (!val) {
								return '';
							}
							return Countires[index];
						},
						// Filer edit changable data
						filterComputedSet (val) {
							return val.code;
						},
						//Filter edit submited data
						filterEditingData (val) {
							return val;
						}
						
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