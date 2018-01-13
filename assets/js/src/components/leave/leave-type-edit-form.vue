<template>
	<div class="hrm-td-editble-wrap inline-edit-row">
		<form @submit.prevent="updateSelfLeaveType()">
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
				<input type="submit" value="submit" class="button button-primary save alignright">
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

	export default {
		props: ['leaveType'],

		mixins: [HRMMixin.leave],

		data () {
			return {
				//departments: []
			}
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
			updateSelfLeaveType () {
            	var args = {
            		data: {
            			id: this.leaveType.id,
            			leave_type: this.leaveType.name,
            			nextYear: this.leaveType.next_year,
            			departments: this.leaveType.departments
            		},
            		callback: function() {

            		}
            	}
            	this.updateLeaveType(args);
        	}
		}
	}
</script>












