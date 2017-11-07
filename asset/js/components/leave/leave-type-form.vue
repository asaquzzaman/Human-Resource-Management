<template>
	<div class="metabox-holder hrm-slide-up hrm-punch-in-out-wrap">
		<div class="postbox">

			<h2 class="hndle ui-sortable-handle">
				<span>Leave Type</span>
			</h2>

			<div class="inside">
				<div class="hrm-attendance-configuration" id="hrm-hidden-form">
					<form action="" @submit.prevent="createNewLeaveType()">
						<div class="hrm-form-field ">
							<label for="hrm-leave-type-text-field">Leave Type<em>  *</em></label>
							<input type="text"  id="hrm-leave-type-text-field"  required="required"  v-model="leave_type"  name="leave_type"  />
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-leave-entitlement-text-field">Entitlement <em>  *</em></label>
							<input type="text"  id="hrm-leave-entitlement-text-field"  required="required"  v-model="entitlement"  name="entitlement"  />
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-leave-entitlement-from-text-field">Entitle from<em>  *</em></label>
							<input type="text"  v-hrm-datepicker  class="hrm-date-picker-from"  id="hrm-leave-entitlement-from-text-field"  required="required"  :value="entitle_from"  name="entitle_from"  />
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-leave-entitlement-to-text-field">Entitle to<em>  *</em></label>
							<input type="text"  v-hrm-datepicker  class="hrm-date-picker-to"  id="hrm-leave-entitlement-to-text-field"  required="required"  name="entitle_to"  :value="entitle_to"  />
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>		

						<div class="hrm-form-field ">
							<label for="">
								Next Year
								<em></em>
							</label>
							<span class="hrm-checkbox-wrap">
								<input v-model="nextYear"  type="checkbox" id="hrm-next-year">
								<label for="hrm-next-year" class="hrm-radio">Enable/Disable</label>
							</span>
							<span class="hrm-clear"></span>
							<span class="description">Carry to next financial year.</span>
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
import HRM_Leave_Store from './leave-store';

var Hrm_Leave_Type_Form = {
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	
	data: function() {
		return {
			entitle_from: '',
			entitle_to: '',
			leave_type: '',
			entitlement: '',
			nextYear: false
		}
	},

	created: function() {
		this.$on('hrm_date_picker', this.setDateTime);
	},
	methods: {
		setDateTime: function(date) {
			if (date.field == 'datepicker_from') {
				this.entitle_from = date.date
			}

			if (date.field == 'datepicker_to') {
				this.entitle_to = date.date
			}
		},
		show_hide_new_leave_type_form: function(el) {
			var self = this;
			var node = jQuery(el.target).closest('.hrm-slide-up');

			node.slideUp(400, function() {
				self.$store.commit('isNewLeaveTypeFormVisible', {is_visible: false});
			});
						
		},

		createNewLeaveType: function() {
		    var request_data = {
                _wpnonce: HRM_Vars.nonce,
                entitlement: this.entitlement,
                leave_type: this.leave_type,
                entitle_from: this.entitle_from,
                entitle_to: this.entitle_to,
                nextYear: this.nextYear
            },
            
            self = this;

            this.show_spinner = true;

            wp.ajax.send('create_new_leave_type', {
                data: request_data,
                
                success: function(res) {
                	self.show_spinner = false;
                    
                    // Display a success toast, with a title
                    toastr.success(res.success);

                    self.show_hide_new_leave_type_form({target: '.hrm-form-cancel'});
                    
                    // self.slideUp(jQuery('.hrm-form-cancel'), function() {
                    // 	self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
                    // });

                    self.$store.commit('updateDepartment', {
                        is_update: is_update, 
                        dept_id: self.department_id,
                        target_index: target_index,
                        departments: res.departments,
                        dept_drop_down: res.dept_drop_down
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

export default Hrm_Leave_Type_Form;
	
</script>

