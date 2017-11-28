<template>
	<div class="hrm-tbl-action-btn-sibling">
		<a @click.prevent="showHideNewLeaveTypeForm()" href="#" class="button button-primary hrm-add-button">Add</a>
	</div>
</template>


<script>
	export default {
		mixins: [HRMMixin.leave],
		
		methods: {
			showHideNewLeaveTypeForm: function() {
				this.$store.commit('leave/isNewLeaveTypeFormVisible', {is_visible: true});
			}
		}
	};
</script>