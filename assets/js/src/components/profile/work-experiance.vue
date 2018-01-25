<template>
	<div>
		<h1 class="wp-heading-inline">Work Experiance</h1>
		<a @click.prevent="showHideExperianceForm('toggle')" class="page-title-action">Add New</a>

		<div v-if="isExperianceFormActive" id="hrm-hidden-form-warp" class="postbox">
	        <div class="hrm-search-head">
	            <h3>Work Experiance</h3>
	        </div>
	        <form id="hrm-hidden-form" action="" @submit.prevent="createNewExperiance()">
	            <div id="hrm-form-field">
	            	<hrm-form-fields :fields="fields"></hrm-form-fields>
	                
	            </div>

	            <div class="hrm-action-wrap">
	                <input  type="submit" class="button  button-primary" name="requst" value="Submit">

	                <a @click.prevent="showHideExperianceForm('toggle')"  target="_blank" href="#" class="button hrm-form-cancel">Cancel</a>
	                <div class="hrm-spinner" v-if="true">Saving....</div>
	            </div>
	        </form>

	        
	    </div>

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

	export default {
		data () {

			return {
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
			isExperianceFormActive () {
				return this.$store.state.profile.isExperianceFormActive;
			},

            total_experiance_page () {
                return 10;
            }
		},
		components: {
			'hrm-table': Table
		},

		methods: {
			createNewExperiance () {

				var postData = this.generateFieldData(this.fields);
					postData['class'] = 'Work_Experience';
					postData['method'] = 'create';



				var args = {
					data: postData,

					callback (success, res) {

					}
				}

				this.insertRecords(args);
			},

			generateFieldData (data) {
				var formated = {};

				data.forEach(function(val) {
					formated[val.name] = val.model;
				});

				return formated;
			},

			insertRecords (args) {
				var form_data = {
	                data: args.data,

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

	            this.httpRequest('hrm_insert_record', form_data);
			},

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