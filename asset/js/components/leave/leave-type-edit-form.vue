<template>
	<div class="hrm-td-editble-wrap inline-edit-row">
		<form @submit.prevent="updateSelfLeaveType()">
			<fieldset class="inline-edit-col-left">
				<legend class="inline-edit-legend">Quick Edit</legend>
				

				<label>
					<span class="title">Leave Type</span>
					<span class="input-text-wrap">
						<input type="text" v-model="leaveType.name" name="post_title" class="ptitle" value="">
					</span>
				</label>

				<label>
					<span class="title">Next Year</span>
					<span class="input-text-wrap">
						<input type="checkbox" v-model="leaveType.next_year" name="post_title" class="ptitle" value="">
						<span class="checkbox-title">Leave type carry to next financial year.</span>
					</span>
				</label>





								<label>
									<span class="title">Departments</span>
									
									<em>*</em>
								
									<div class="hrm-multiselect">

								        <hrm-multiselect 
								            v-model="leaveType.departments" 
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
							    </label>
							


			</fieldset>

			<p class="submit inline-edit-save">
				<button @click.prevent="showHideLeaveTypeUpdateForm('toggle', leaveType)" type="button" class="button cancel alignleft">Cancel</button>			
				<input type="submit" value="submit" class="button button-primary save alignright">
				<br class="clear">
			</p>
		</form>
	</div>
</template>

<script>
	import Multiselect from './../../vue-multiselect/vue-multiselect.min';

	export default {
		props: ['leaveType'],

		data () {
			return {
				//departments: []
			}
		},

		computed: {
			departmentDropDown () {
				return this.$store.state.departmentDropDown;
			}
		},

		components: {
			'hrm-multiselect': Multiselect
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












