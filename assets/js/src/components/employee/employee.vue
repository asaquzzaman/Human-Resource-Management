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
            component_name='employee_pagination'>
            
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
	import { FormFields } from './employee-form-fields';

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

				fields: FormFields(this),
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

			this.getDesignations({
				callback (designations) {
					var index = self.getIndex(self.fields, 'designation', 'name');
					self.fields[index].options = designations.data;
				}
			});

			this.getLocations({
				callback (location) {
					var index = self.getIndex(self.fields, 'location', 'name');
					self.fields[index].options = location.data;
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