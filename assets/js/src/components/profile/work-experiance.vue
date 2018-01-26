<template>
	<div>
		<h1 class="wp-heading-inline">Work Experiance</h1>
		<a @click.prevent="showHideNewRecordForm('toggle')" class="page-title-action">Add New</a>

		<add-new-record-form v-if="isNewRecordFormActive" :fields="fields"></add-new-record-form>

	    <div class="">
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

	    <hrm-table></hrm-table>

	    <hrm-pagination 
            :total_pages="total_experiance_page" 
            :current_page_number="current_page_number" 
            component_name='work_experiance_pagination'>
            
        </hrm-pagination> 

	</div>
</template>

<style>
	.hrm-bulk-wrap, .hrm-filter-wrap {
		float: left;
	}
</style>

<script>
	import Table from './work-experiance-table.vue';
	import Form from './new-work-experiance-form.vue';

	export default {
		data () {

			return {
				current_page_number: 1,
				search: {
					filter: 'active',
					title: '',
					from: '',
					to: ''
				},
				bulkAction: -1,
				fields: [
					{
						type: 'text',
						model: '',
						label: 'Title',
						name: 'title'
					},
					{
						type: 'date-picker-from',
						model: '',
						label: 'From',
						name: 'start'
					},
					{
						type: 'date-picker-to',
						model: '',
						label: 'To',
						name: 'end'
					},
					{
						type: 'textarea',
						model: '',
						label: 'Description',
						name: 'description'
					}
				]
			}
		},
		mixins: [HRMMixin.profile],
		created () {
			
		},
		computed: {
			isNewRecordFormActive () {
				return this.$store.state[this.nameSpace].isNewRecordFormActive;
			},

            total_experiance_page () {
                return 10;
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
						this.recordDelete(self.$store.state.profile.deletedId);
						break;

					default:

						break;
				}
			},

			filter () {
				var form_data = {
	                data: this.$route.query,

	                success: function(res) {
	                	if (typeof args.callback === 'function') {
	                        args.callback(true, res);
	                    } 
	                    
	                },

	                error: function(res) {
	                	self.show_spinner = false;
	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        hrm.toastr.error(value);
	                    });

	                    if (typeof args.callback === 'function') {
	                        args.callback(false, res);
	                    } 
	                }
	            };

	            this.httpRequest('hrm_experiance_filter', form_data);
			},
			recordSearch () {
				this.$router.push({query: this.search});
				this.filter();
			}
		}
	}
</script>