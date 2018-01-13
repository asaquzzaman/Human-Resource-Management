<template>

	<div class="hrm-tbl-action-btn-sibling">
		<a @click.prevent="showHideNewLeaveTypeForm()" href="#" class="button button-primary ">Add</a>
	</div>

</template>

<script>
	import HRM_Mixin from './../../mixin';
	import leave_directive from './../../hrm-directive';

	var HRM_Leave_Type_Add_Btn = {
		mixins: [HRMMixin.leave],
		methods: {
			showHideNewLeaveTypeForm: function() {
				this.$store.commit('leave/isNewLeaveTypeFormVisible', {is_visible: true});
			}
		}
	};

	export default HRM_Leave_Type_Add_Btn;
</script>