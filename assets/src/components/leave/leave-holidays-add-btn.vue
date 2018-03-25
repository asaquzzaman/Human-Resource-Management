<template>
	<div>
		<h1 class="wp-heading-inline">Holiday</h1>
		<a @click.prevent="showHideNewHolidayForm()" href="#" class="page-title-action hrm-btn">
			Add New
		</a>
	</div>
</template>


<script>
	export default {
		mixins: [HRMMixin.leave],
		
		methods: {
			showHideNewHolidayForm: function() {
				this.$store.commit('leave/isNewHolidayFormVisible', {is_visible: true});
			}
		}
	};
</script>