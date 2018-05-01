<template>
	<div class="metabox-holder hrm-slide-up hrm-punch-in-out-wrap">
		<div class="postbox">

			<h2 class="hndle">
				Leave Type
			</h2>

			<div class="inside">
				<div class="hrm-attendance-configuration" id="hrm-hidden-form">
					<form id="hrm-leave-type-form" action="" @submit.prevent="createNewLeaveType()">
						<div class="hrm-form-field ">
							<label for="hrm-leave-type-text-field">Leave Type<em>  *</em></label>
							<input type="text"  id="hrm-leave-type-text-field"  required="required"  v-model="leave_type"  name="leave_type"  />
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>

			

						<div class="hrm-form-field hrm-leave-type-wrap">
							<label>
								Departments
								<em>*</em>
							</label>
							<div class="hrm-multiselect">

						        <hrm-multiselect 
						            v-model="departments" 
						            :options="departmentDropDown" 
						            :multiple="true" 
						            :close-on-select="true"
						            :clear-on-select="true"
						            :hide-selected="false"
						            :show-labels="true"
						            placeholder="Select leave type"
						            select-label=""
						            selected-label="selected"
						            deselect-label=""
						            :taggable="false"
						            label="name"
						            track-by="id"
						            :allow-empty="true">

						        </hrm-multiselect>               
						    </div>
						    <div class="hrm-clear"></div>
						    <span class="description">
						    	<a href="#/departments">Create Department</a>
						    </span>
						</div>

						<div class="hrm-form-field ">
							<label for="hrm-leave-entitlement-text-field">Entitlement <em>  *</em></label>
							<input type="text"  id="hrm-leave-entitlement-text-field"  required="required"  v-model="entitlement"  name="entitlement"  />
							<span class="hrm-clear"></span>
							<span class="description"></span>
						</div>
						<div v-if="!nextYear" class="hrm-form-field">
							<label for="hrm-leave-entitlement-text-field">Duration</label>
							<div>From <strong>{{ dateFormat(financial_start) }}</strong> to <strong>{{ dateFormat(financial_end) }}</strong></div>
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
							<span class="description">Leave type carry to next financial year.</span>
						</div>				

						<input :disabled="!canSubmit"  type="submit" class="button hrm-button-primary button-primary" name="requst" value="Save changes">
						<a @click.prevent="show_hide_new_leave_type_form($event)" target="_blank" href="#" class="button hrm-button-secondary">Cancel</a>
					</form>
				</div>

			</div>
		</div>
	</div>
</template>



<script>
import Mixin from './mixin'

var Hrm_Leave_Type_Form = {
	
	mixins: [Mixin],

	data: function() {
		return {
			entitle_from: '',
			entitle_to: '',
			leave_type: '',
			entitlement: '',
			nextYear: false,
			financial_start: HRM_Vars.financial_start,
			financial_end: HRM_Vars.financial_end,
			departments: [],
			canSubmit: true
		}
	},

	created: function() {
		//this.getDepartments();
		this.$on('hrm_date_picker', this.setDateTime);
	},

	computed: {
		departmentDropDown () {
			return this.$store.state.leave.departmentDropDown;
		}
	},

	components: {
		'hrm-multiselect': hrm.Multiselect
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
		show_hide_new_leave_type_form: function() {
			var self = this;
			var node = jQuery('.hrm-slide-up');

			node.slideUp(400, function() {
				self.$store.commit('leave/isNewLeaveTypeFormVisible', {is_visible: false});
			});
						
		},

		filterDepartmentName (department) {
			var pad = '&#8212; ';
			return pad.repeat(department.hierarchical_depth) + department.name;

		},

		formValidation (data) {
			var isFormValidate = true;

			if(!parseInt(data.entitlement)) {
				hrm.Toastr.error('Entitlement is required!');
				isFormValidate = false;
			}
			if(!data.leave_type) {
				hrm.Toastr.error('Leave type is required!');
				isFormValidate = false;
			}
			if(!data.departments.length) {
				hrm.Toastr.error('Department is required!');
				isFormValidate = false;
			}

			return isFormValidate;
		},

		createNewLeaveType: function() {

			if (!this.canSubmit) {
				return false;
			}

		    var request_data = {
                _wpnonce: HRM_Vars.nonce,
                entitlement: this.entitlement,
                leave_type: this.leave_type,
                // entitle_from: this.entitle_from,
                // entitle_to: this.entitle_to,
                nextYear: this.nextYear,
                departments: this.departments
            }

            if (!this.formValidation(request_data)) {
				return false;
			}	
            
            self = this;
            this.show_spinner = true;

            wp.ajax.send('create_new_leave_type', {
                data: request_data,

                beforeSend () {
                	self.canSubmit = false;
                	self.loadingStart(
                		'hrm-leave-type-form',
                		{animationClass: 'preloader-update-animation'}
                	);
                }, 
                
                success: function(res) {
                	self.show_spinner = false;
                	self.canSubmit = true;
                    self.addLeaveTypeMeta(res.leave_type.data);
                    // Display a success toast, with a title
                    hrm.Toastr.success(res.success);
                    self.show_hide_new_leave_type_form();
                    self.$store.commit('leave/setNewLeaveType', res.leave_type.data);
                    self.loadingStop('hrm-leave-type-form');
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

export default Hrm_Leave_Type_Form;
	
</script>

