<template>
	<div class="hrm-td-editble-wrap inline-edit-row">
		<form :id="'hrm-edit-'+leaveType.id"  @submit.prevent="updateSelfLeaveType()">
			<fieldset class="hrm-inline-edit-col-left">
				<legend class="inline-edit-legend">Quick Edit</legend>
				
				<div class="hrm-field-wrap">
					<label class="hrm-inline-edit-label">
						<span class="title">Leave Type</span>
					</label>
					<div class="hrm-inline-edit-field">
						<span class="input-text-wrap">
							<input  type="text" v-model="leaveType.name" name="post_title" class="ptitle hrm-input-width" value="">
						</span>
					</div>
				</div>

				<div class="hrm-field-wrap">
					<label class="hrm-inline-edit-label">
						<span class="title">Next Year</span>
					</label>
					<div class="hrm-inline-edit-field">
						<span class="input-text-wrap">
							<input type="checkbox" v-model="leaveType.next_year" name="post_title" class="ptitle" value="">
							<span class="checkbox-title">Leave type carry to next financial year.</span>
						</span>
					</div>
				</div>


				<div class="hrm-field-wrap">
					<label class="hrm-inline-edit-label">
						<span class="title">Departments</span>
						
					</label>
					
					<div class="hrm-multiselect hrm-inline-edit-field">

				        <hrm-multiselect 
				            v-model="leaveType.departments.data" 
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
				</div>

			</fieldset>

			<p class="submit inline-edit-save">
				<button @click.prevent="showHideLeaveTypeUpdateForm('toggle', leaveType)" type="button" class="button cancel alignleft">Cancel</button>			
				<input :disabled="!canSubmit" type="submit" value="submit" class="button button-primary save alignright">
				<br class="clear">
			</p>
		</form>
	</div>
</template>

<style>
	.hrm-input-width {
		width: 50% !important;
	}
	.hrm-multiselect .multiselect {
		width: 50% !important;
	}
	.hrm-field-wrap {
		display: block;
		width: 100%;
	}
	.hrm-inline-edit-label, .hrm-inline-edit-field {
		float: left;
	}
	.hrm-inline-edit-label {
		width: 15%;
	}
	.hrm-inline-edit-field {
		width: 60%;
	}
	.hrm-field-wrap .title {
		width: 100% !important;
	}
	.hrm-field-wrap:after {
		visibility: hidden;
		display: block;
		font-size: 0;
		content: " ";
		clear: both;
		height: 0;
	}
</style>

<script>
    import Mixin from './mixin'
	
	export default {
		props: ['leaveType'],

		mixins: [Mixin],

		data () {
			return {
				canSubmit: true
			}
		},

		created () {
			this.leaveType.next_year = this.leaveType.next_year == '1' ? 1 : 0;
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
			formValidation (data) {
				var isFormValidate = true;
				
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

			updateSelfLeaveType () {
				if ( !this.canSubmit ) {
					return false;
				}
				var self = this;
            	var args = {
            		data: {
            			id: this.leaveType.id,
            			leave_type: this.leaveType.name,
            			nextYear: this.leaveType.next_year,
            			departments: this.leaveType.departments.data
            		},
            		callback: function() {
            			self.canSubmit = true;
            			self.loadingStop('hrm-edit-'+args.data.id);
            		}
            	}
            	if ( !this.formValidation(args.data) ) {
            		return false;
            	}
            	this.loadingStart(
            		'hrm-edit-'+this.leaveType.id,
            		{animationClass: 'preloader-update-animation'}
            	);
            	this.canSubmit = false;
            	this.updateLeaveType(args);
        	}
		}
	}
</script>












