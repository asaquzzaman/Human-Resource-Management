<template>
	<div class="metabox-holder hrm-punch-in-out-wrap">
		<div class="postbox">

			<h2 class="hndle ui-sortable-handle">
				<span>Holidays</span>
			</h2>

			<div class="inside">
				<div class="hrm-attendance-configuration" id="hrm-hidden-form">
					<form action="" @submit.prevent="createNewHolidays()">
						<div class="hrm-form-field ">
							<label for="hrm-leave-type-text-field">
								Name<em>  *</em>
							</label>
							<input type="text" id="hrm-leave-type-text-field" required="required" v-model="name" name="name">
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-leave-holidays-from-text-field">
								From <em>  *</em>
							</label>
							<input type="text" v-hrm-holiday-datepicker class="hrm-date-picker-from" id="hrm-leave-holidays-from-text-field" required="required" :value="from" name="from">
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-leave-holidays-to-text-field">
								To<em>  *</em>
							</label>
							<input type="text" v-hrm-holiday-datepicker class="hrm-date-picker-to" id="hrm-leave-holidays-to-text-field" required="required" :value="to" name="to">
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div  class="hrm-form-field">
							<label for="hrm-leave-entitlement-text-field">Validaty</label>
							<div>From <strong>{{ dateFormat(financial_start) }}</strong> to <strong>{{ dateFormat(financial_end) }}</strong></div>
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-leave-description-textarea-field">
								Description<em>  *</em>
							</label>
							<input type="text" class="" id="hrm-leave-description-textarea-field" required="required" name="description" v-model="description">
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>
						<input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="Save changes">
						<a @click.prevent="show_hide_new_leave_type_form($event)" target="_blank" href="#" class="button hrm-form-cancel">Cancel</a>
					</form>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
	import HRM_Mixin from './../../mixin';
	
	export default {
		
		mixins: [HRMMixin.leave],
		
		data: function() {
			return {
				financial_start: HRM_Vars.financial_start,
				financial_end: HRM_Vars.financial_end,
				name: '',
				from: '',
				to: '',
				description: '',
				records: []
			}
		},

		created: function() {
			this.$on('hrm_date_picker', this.setDateTime);
		},
		methods: {
			setDateTime: function(date) {
				if (date.field == 'datepicker_from') {
					this.from = date.date
				}

				if (date.field == 'datepicker_to') {
					this.to = date.date
				}
			},
			show_hide_new_leave_type_form: function(el) {
				var self = this;

				this.slideUp(el.target, function() {
					self.$store.commit('leave/isNewLeaveTypeFormVisible', {is_visible: false});
				});
							
			},

			createNewHolidays: function() {
				
			    var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	                name: this.name,
	                from: this.from,
	                to: this.to,
	                description: this.description,
	            },
	            
	            // is_update  = parseInt( this.department_id ) ? true : false,
	            
	            // target_index = is_update ? this.getIndex(
	            //     this.$store.state.leave.departments, this.department_id, 'id'
	            // ) : false,

	            self = this;

	            this.show_spinner = true;

	            wp.ajax.send('create_new_holidays', {
	                data: request_data,
	                
	                success: function(res) {
	                	self.show_spinner = false;

	                	self.addHolidayMeta(res.holiday);

	                	self.$store.commit('leave/updateHolidays', res.holiday);
	                    
	                    // Display a success toast, with a title
	                    toastr.success(res.success);
	                    
	                    self.slideUp(jQuery('.hrm-form-cancel'), function() {
	                    	//self.$store.commit('leave/isNewDepartmentForVisible', {is_visible: false});
	                    });

	                    
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
</script>
