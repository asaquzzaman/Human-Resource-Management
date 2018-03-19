<template>
	<div class="hrm-tbl-action-btn-sibling">
		<a @click.prevent="showHideNewLeaveTypeForm()" href="#" class="button hrm-button-primary ">Add</a>
	</div>
</template>


<script>
	export default {
		mixins: [HRMMixin.leave],
		
		methods: {
			showHideNewLeaveTypeForm: function() {
				this.$store.commit('leave/isNewHolidayFormVisible', {is_visible: true});
			}
		}
	};
</script>