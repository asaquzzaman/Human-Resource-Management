<template>
	<div>
		<div class="hrm-slide-up" v-hrm-slide-down style="display: none;" v-if="is_new_leave_type_form_visible">
			<leave-holidays-form></leave-holidays-form>
		</div>
		<leave-holidays-add-btn></leave-holidays-add-btn>
		<leave-holidays-record></leave-holidays-record> 
	</div>
</template>


<script>
	import HRM_Mixin from './../../mixin';
	import directive from './../../hrm-directive';

	import Hrm_Leave_Holidays_Form from './leave-holidays-form.vue';
	import Hrm_Leave_Holidays_Record from './leave-holidays-record.vue';
	import HRM_Leave_Holidays_Add_Btn from './leave-holidays-add-btn.vue';
	
	var Hrm_Leave_Holidays = {

		mixins: [HRMMixin.leave],

		//store: HRM_Leave_Store,
		
		data: function() {
			return {

			}
		},

		components: {
			'leave-holidays-form': Hrm_Leave_Holidays_Form,
			'leave-holidays-record': Hrm_Leave_Holidays_Record,
			'leave-holidays-add-btn': HRM_Leave_Holidays_Add_Btn,
		},

		computed: {
			is_new_leave_type_form_visible: function() {
				return this.$store.state.leave.is_new_leave_type_form_visible;
			}
		},
	};

	export default Hrm_Leave_Holidays;
</script>


