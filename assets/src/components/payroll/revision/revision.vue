<template>
	<div class="page-revision">

		<payroll-menu></payroll-menu>

	    <div class="hrm-tbl-action-wrap">
			<div v-if="manageOrganization()" class="hrm-table-action  hrm-bulk-wrap">
				<label for="bulk-action-selector-top" class="screen-reader-text">
					Select bulk action
				</label>
				<select v-model="bulkAction" name="action" id="bulk-action-selector-top">
					<option value="-1">Bulk Actions</option>
					<option value="delete">Delete</option>
				</select>
				<a href="#" @click.prevent="selfBulkAction()" class="button hrm-button-secondary button-secondary">Apply</a>
			</div>

			<div class="hrm-table-action  hrm-filter-wrap">
				<div class="alignleft actions">
					<form @submit.prevent="recordSearch()">

						<div class="hrm-multiselect">
							<hrm-multiselect 
					            v-model="employee" 
					            :options="employees" 
					            :multiple="false" 
					            :close-on-select="true"
					            :clear-on-select="true"
					            :hide-selected="false"
					            :show-labels="true"
					            placeholder="Employees"
					            select-label=""
					            selected-label="selected"
					            deselect-label=""
					            :taggable="false"
					            label="display_name"
					            :allow-empty="true">

					        </hrm-multiselect>  
				    	</div>
					    
						<hrm-date-picker placeholder="Salary date" v-model="search.from"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
						<input type="submit" class="button hrm-button-secondary button-secondary" value="Filter">
					</form>
				</div>

			</div>
			<div class="hrm-clear"></div>
		</div>
		
	    <hrm-table></hrm-table>

	    <hrm-pagination 
            :total_pages="pagination.total_pages" 
            component_name='notice_pagination'>
            
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
	.page-revision .hrm-multiselect {
		display: inline-block;
	}
</style>

<script>
	import Table from './revision-table.vue';
	import Mixin from './mixin';

	
	export default {
		mixins: [Mixin],

		data () {

			return {
				employee: '',
				search: {
					filter: 'active',
					title: this.$route.query.title,
					from: this.$route.query.from,
					to: this.$route.query.to,
					employee_id: ''
				},
				bulkAction: -1,
			}
		},

		created () {
			var self = this;
			this.getEmployess({
				callback (res) {
					
					let empId = self.$route.query.employee_id;

					if(empId) {
						let index = self.getIndex(res.data, empId, 'id');
	                	self.employee = res.data[index];
					}
				}
			});
		},
		
		computed: {
			employees () {
				return this.$store.state[this.nameSpace].employees;
			},
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
			'hrm-multiselect': hrm.Multiselect.Multiselect
		},

		methods: {
			getEmployess (args) {
				var self = this;

				var form_data = {
		            data: {
		            	number: -1
		            },

		            success: function(res) {
		            	self.$store.commit(self.nameSpace + '/setEmployees', res.data);
		            	if(typeof args.callback != 'undefined') {
		            		args.callback(res);
		            	}
		            },

		            error: function(res) {
		            }
		        };

		        this.httpRequest('hrm_employee_filter', form_data);
			},

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
			
				if(this.employee) {
					this.search.employee_id = this.employee.id;
				}
				
				this.$router.push({query: this.search});
				this.getRecords();
			}
		}
	}
</script>