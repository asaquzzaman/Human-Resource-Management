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

						<input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="Save changes">
						<a @click.prevent="show_hide_new_leave_type_form($event)" target="_blank" href="#" class="button hrm-form-cancel">Cancel</a>
					</form>
				</div>

			</div>
		</div>
	</div>
</template>



<script>
import Multiselect from './../../vue-multiselect/vue-multiselect.min';
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
			nextYear: false,
			financial_start: HRM_Vars.financial_start,
			financial_end: HRM_Vars.financial_end,
			departments: [],
			departmentDropDown: []
		}
	},

	created: function() {
		this.getDepartments();
		this.$on('hrm_date_picker', this.setDateTime);
	},

	components: {
		'hrm-multiselect': Multiselect
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

		getDepartments () {
			var self = this;
			var request_data = {
				data: {},
				success (res) {
					self.departmentDropDown = res.dept_drop_down;
				}
			}
			this.httpRequest('get_departments', request_data);
		},

		filterDepartmentName (department) {
			var pad = '&#8212; ';
			return pad.repeat(department.hierarchical_depth) + department.name;

		},

		createNewLeaveType: function() {

		    var request_data = {
                _wpnonce: HRM_Vars.nonce,
                entitlement: this.entitlement,
                leave_type: this.leave_type,
                // entitle_from: this.entitle_from,
                // entitle_to: this.entitle_to,
                nextYear: this.nextYear,
                departments: this.departments
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

