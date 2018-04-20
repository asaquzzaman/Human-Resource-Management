<template>
	<div>
		<h1 v-if="manageDesignation()" class="wp-heading-inline">Designation</h1>
		<a v-if="manageDesignation()" @click.prevent="showHideNewRecordForm('toggle')" class="page-title-action">Add New</a>

		<add-new-record-form class="hrm-toggle" v-if="isNewRecordFormActive" :fields="fields"></add-new-record-form>

	    <div class="hrm-tbl-action-wrap">
			<div v-if="manageDesignation()" class="hrm-table-action hrm-bulk-wrap">
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
						<input v-model="search.title"  type="search">

						<input type="submit" class="button hrm-button-secondary button-secondary" value="Filter">
					</form>

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
	import Table from './designation-table.vue';
	import Form from './new-designation-form.vue';
    import Mixin from './mixin'
	
	export default {
		mixins: [Mixin],

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
						label: 'Title',
						name: 'title',
						tableHead: 'Title',
						tbRowAction: this.manageDesignation(),
						editable: true,
						required: true
					},
					{
						type: 'select',
						model: '',
						options: [],
						label: 'Employee',
						optionLabel: 'display_name',
						placeholder: 'Select Employee',
						name: 'employee',
						editable: true,
						required: true,
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
						type: 'textarea',
						model: '',
						label: 'Description',
						name: 'description',
						tableHead: 'Description',
						editable: true
					}
				],
			}
		},
		watch: {
			search: {
				handler(obj){
			    	if (obj.title == '') {
			    		this.recordSearch();
			       	}
			    },
			    deep: true
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