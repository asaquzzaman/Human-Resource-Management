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

	    <div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text">
					Select bulk action
				</label>
				<select name="action" id="bulk-action-selector-top">
					<option value="-1">Bulk Actions</option>
					<option value="edit" class="hide-if-no-js">Edit</option>
					<option value="trash">Move to Trash</option>
				</select>
				<input type="submit" id="doaction" class="button action" value="Apply">
			</div>
		</div>
		
	    <hrm-table></hrm-table>

	</div>
</template>

<script>
	import Table from './work-experiance-table.vue';

	export default {
		data () {
			return {
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
			}
		}
	}
</script>