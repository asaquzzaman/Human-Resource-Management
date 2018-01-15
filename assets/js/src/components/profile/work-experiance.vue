<template>
	    <div id="hrm-hidden-form-warp" class="postbox">
        <div class="hrm-search-head">
            <h3>Work Experiance</h3>
        </div>
        <form id="hrm-hidden-form" action="" @submit.prevent="createNewExperiance()">
            <div id="hrm-form-field">
            	<hrm-form-fields :fields="fields"></hrm-form-fields>

  <!--               <div class="hrm-form-field ">
                    <label for="title">
                        Title<em>*</em>
                    </label>
                    <input type="text" required="required" v-model="title" name="title" value="" placeholder="" class="title" id="title"  data-hrm_validation="1" data-hrm_required="1" data-hrm_required_error_msg="This field is required"  />
                    <span class="hrm-clear"></span>
                    <span class="description"></span>
                </div>

                <div class="hrm-form-field ">
                    <label for="title">
                        From
                    </label>
                	<hrm-date-picker placeholder="From" v-model="start_time" class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
                  	<span class="hrm-clear"></span>
                    <span class="description"></span>
                </div>

                <div class="hrm-form-field ">
                    <label for="title">
                        To
                    </label>
					<hrm-date-picker placeholder="To" v-model="end_time" class="pm-datepickter-from" dependency="pm-datepickter-to"></hrm-date-picker>
					<span class="hrm-clear"></span>
                    <span class="description"></span>
                </div>

				<div class="hrm-form-field ">
					<label for="description">
						Description<em>   </em>
					</label>
					<textarea name="description" class="hrm-des-field" id="description"></textarea>
					<span class="hrm-clear"></span>
					<span class="description"></span>
				</div> -->
                
            </div>

            <div class="hrm-action-wrap">
                <input  type="submit" class="button  button-primary" name="requst" value="Submit">

                <a  target="_blank" href="#" class="button hrm-form-cancel">Cancel</a>
                <div class="hrm-spinner" v-if="true">Saving....</div>
            </div>
        </form>
    </div>
</template>

<script>
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
		created () {
			
		},
		components: {

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