<template>
	<div class="metabox-holder hrm-punch-in-out-wrap">
		<div class="postbox">

			<h2 class="hndle ui-sortable-handle">
				<span>Holidays</span>
			</h2>

			<div class="inside">
				<div class="hrm-attendance-configuration" id="hrm-hidden-form">
					<form action="">
						<div class="hrm-form-field ">
							<label for=" ">
								Saturday<em>   </em>
							</label>
							<select v-model="saturday" name="saturday" @change.prevent="saveWorkWeek()">
								<option value="full">Full Day</option>
								<option value="non">Non-Working Day</option>
							</select>
							<span class="hrm-clear"></span>
							<span class="description"> </span>
						</div>

						<div class="hrm-form-field ">
							<label for=" ">
								Sunday<em>   </em>
							</label>
							<select v-model="sunday" name="sunday" @change.prevent="saveWorkWeek()">
								<option value="full">Full Day</option>
								<option value="non">Non-Working Day</option>
							</select>
							<span class="hrm-clear"></span>
							<span class="description"> </span>
						</div>

						<div class="hrm-form-field ">
							<label for=" ">
								Monday<em>   </em>
							</label>
							<select v-model="monday" name="monday" @change.prevent="saveWorkWeek()">
								<option value="full">Full Day</option>
								<option value="non">Non-Working Day</option>
							</select>
							<span class="hrm-clear"></span>
							<span class="description"> </span>
						</div>

						<div class="hrm-form-field ">
							<label for=" ">
								Tuesday<em>   </em>
							</label>
							<select v-model="tuesday" name="tuesday" @change.prevent="saveWorkWeek()">
								<option value="full">Full Day</option>
								<option value="non">Non-Working Day</option>
							</select>
							<span class="hrm-clear"></span>
							<span class="description"> </span>
						</div>

						<div class="hrm-form-field ">
							<label for=" ">
								Wednesday<em>   </em>
							</label>
							<select v-model="wednesday" name="wednesday" @change.prevent="saveWorkWeek()">
								<option value="full">Full Day</option>
								<option value="non">Non-Working Day</option>
							</select>
							<span class="hrm-clear"></span>
							<span class="description"> </span>
						</div>

						<div class="hrm-form-field ">
							<label for=" ">
								Thursday<em>   </em>
							</label>
							<select v-model="thursday" name="thursday" @change.prevent="saveWorkWeek()">
								<option value="full">Full Day</option>
								<option value="non">Non-Working Day</option>
							</select>
							<span class="hrm-clear"></span>
							<span class="description"> </span>
						</div>

						<div class="hrm-form-field ">
							<label for=" ">
								Friday<em>   </em>
							</label>
							<select v-model="friday" name="friday" @change.prevent="saveWorkWeek()">
							<option value="full">Full Day</option>
							<option value="non">Non-Working Day</option>
						</select>
						<span class="hrm-clear"></span>
						<span class="description"> </span>
					</div>
						
					</form>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
	import HRM_Mixin from './../../mixin';
	
	var Hrm_Leave_Work_Week = {

		mixins: [HRM_Mixin],
		
		data: function() {
			return {
				saturday: 'full',
				sunday: 'full',
				monday: 'full',
				tuesday: 'full',
				wednesday: 'full',
				thursday: 'full',
				friday: 'full'
				
			}
		},

		computed: {

		},

		created: function() {
			this.getWorkWeek();
		},
		methods: {
			getWorkWeek: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

				wp.ajax.send('get_work_week', {
	                data: request_data,
	                
	                success: function(res) {
	                    // Display a success toast, with a title
	                    //toastr.success(res.success);
	                    
						self.saturday  = res.work_week.saturday;
						self.sunday    = res.work_week.sunday;
						self.monday    = res.work_week.monday;
						self.tuesday   = res.work_week.tuesday;
						self.wednesday = res.work_week.wednesday;
						self.thursday  = res.work_week.thursday;
						self.friday    =  res.work_week.friday;
					
	                },

	                error: function(res) {
	                	self.show_spinner = false;
	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        toastr.error(value);
	                    });
	                }
	            });
			},
			saveWorkWeek: function() {
				
			    var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	                saturday: this.saturday,
					sunday: this.sunday,
					monday: this.monday,
					tuesday: this.tuesday,
					wednesday: this.wednesday,
					thursday: this.thursday,
					friday: this.friday
	            };
	            

	            wp.ajax.send('save_work_week', {
	                data: request_data,
	                
	                success: function(res) {
	                    // Display a success toast, with a title
	                    toastr.success(res.success);
	                    
	                },

	                error: function(res) {
	                	self.show_spinner = false;
	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        toastr.error(value);
	                    });
	                }
	            });
			}
		}
	};

	export default Hrm_Leave_Work_Week;
</script>
