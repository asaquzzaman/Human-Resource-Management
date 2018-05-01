<template>
	<div class="metabox-holder hrm-punch-in-out-wrap">
		<div class="postbox">

			<h2 class="hndle ui-sortable-handle">
				<span>Holidays</span>
			</h2>

			<div class="inside">
				<div class="hrm-attendance-configuration" id="hrm-hidden-form">
					<form action="" id="hrm-holiday-form" @submit.prevent="createNewHolidays()">
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
							<input type="text" v-hrm-datepicker class="hrm-date-picker-from" id="hrm-leave-holidays-from-text-field" required="required" :value="from" name="from">
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-leave-holidays-to-text-field">
								To<em>  *</em>
							</label>
							<input type="text" v-hrm-datepicker class="hrm-date-picker-to" id="hrm-leave-holidays-to-text-field" required="required" :value="to" name="to">
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
								Description
							</label>
							<textarea v-model="description"></textarea>  
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>
						<input :disabled="!canSubmit"  type="submit" class="button button-primary  hrm-button-primary" name="requst" value="Save changes">
						<a @click.prevent="show_hide_new_leave_type_form($event)" target="_blank" href="#" class="button hrm-button-secondary">Cancel</a>
					</form>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
    import Mixin from './mixin'
	
	export default {
		
		mixins: [Mixin],
		
		data: function() {
			return {
				financial_start: HRM_Vars.financial_start,
				financial_end: HRM_Vars.financial_end,
				name: '',
				from: '',
				to: '',
				description: '',
				records: [],
				canSubmit: true
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
					self.$store.commit('leave/isNewHolidayFormVisible', {is_visible: false});
				});
							
			},

			validation (data) {
				var isFormValidate = true;

				if(!data.name) {
					hrm.Toastr.error('Holiday title is required!');
					isFormValidate = false;
				}
				if(!data.from) {
					hrm.Toastr.error('Holiday start date is required!');
					isFormValidate = false;
				}
				if(!data.to) {
					hrm.Toastr.error('Holiday end date is required!');
					isFormValidate = false;
				}

				return isFormValidate;
			},

			createNewHolidays: function() {

				if (!this.canSubmit) {
					return false;
				}
				
			    var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	                name: this.name,
	                from: this.from,
	                to: this.to,
	                description: this.description,
	            },
	            
	            self = this;

	            if( !this.validation(request_data) ) {
	            	return false;
	            }

	            this.show_spinner = true;

	            wp.ajax.send('create_new_holidays', {
	                data: request_data,

	                beforeSend () {
	                	self.loadingStart(
	                		'hrm-holiday-form',
	                		{animationClass: 'preloader-update-animation'}
	                	);
	                },
	                
	                success: function(res) {
	                	self.show_spinner = false;

	                	self.addHolidayMeta(res.holiday);

	                	self.$store.commit('leave/updateHolidays', res.holiday);
	                    
	                    // Display a success toast, with a title
	                    hrm.Toastr.success(res.success);
	                    self.loadingStop('hrm-holiday-form');
	                    
	                    jQuery('#hrm-holiday-form').slideUp(400, function() {
	                    	self.$store.commit('leave/isNewHolidayFormVisible', {is_visible: false});
	                    });
	                },

	                error: function(res) {
	                	self.show_spinner = false;
	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        hrm.Toastr.error(value);
	                    });
	                }
	            });
			}
		}
	};
</script>
