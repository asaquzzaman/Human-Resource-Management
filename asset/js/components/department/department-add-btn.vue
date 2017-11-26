<template>
	<div class="hrm-tbl-action-btn-sibling">
		<a @click.prevent="showHideNewDepartmentForm()" href="#" class="button button-primary">Add</a>
	</div>

</template>

<script>
	export default {
		methods: {
			showHideNewDepartmentForm: function() {
				this.$store.commit('isNewDepartmentForVisible', {is_visible: true});
			}
		}
	}
</script
