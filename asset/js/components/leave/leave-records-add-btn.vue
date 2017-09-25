<template>
	<div class="hrm-tbl-action-btn-sibling">
		<a @click.prevent="showHideLeaveRecordsForm()" href="#" class="button button-primary hrm-add-button">Add</a>
	</div>
</template>

<script>
	export default {
		methods: {
			showHideLeaveRecordsForm: function() {
				this.$store.commit('isNewLeaveRecordsFormVisible', {is_visible: true});
			}
		}
	};
</script>