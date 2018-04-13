<template>
	<div>
		<h1 v-if="manageEmployee()" class="wp-heading-inline">Employee</h1>
		<a v-if="manageEmployee()" @click.prevent="showHideNewRecordForm('toggle')" class="page-title-action">Add New</a>

		<add-new-record-form class="hrm-toggle" v-if="isNewRecordFormActive && manageEmployee()" :fields="fields"></add-new-record-form>

	    <div class="hrm-tbl-action-wrap">
			<div v-if="manageEmployee()" class="hrm-table-action hrm-bulk-wrap">
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
						<input v-model="search.name" size="40" placeholder="Search by user login, nicename, email" type="search">

						<input type="submit" class="button hrm-button-secondary button-secondary" value="Filter">
					</form>

				</div>

			</div>
			<div class="hrm-clear"></div>
		</div>
		
	    <hrm-table id="hrm-employee-list-table" :fields="fields"></hrm-table>
	    
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
    import Mixin from './mixin'
	

	export default {
		mixins: [Mixin],

		data () {

			return {
				search: {
					filter: 'active',
					name: this.$route.query.name
				},
				bulkAction: -1,
				fields: FormFields(this),
			}
		},

		watch: {
			search: {
				handler(obj){
			    	if (obj.name == '') {
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
            	var pagination = this.$store.state[this.nameSpace].pagination;
            	pagination['total_pages'] = Math.ceil(pagination.total/pagination.per_page);
            	return pagination;
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
			}
		}
	}
</script>