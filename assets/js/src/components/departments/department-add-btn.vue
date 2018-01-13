<template>
	<div v-if="manageDepartment()" class="hrm-tbl-action-btn-sibling">
		<a @click.prevent="showHideDepartmentForm('toggle')" href="#" class="button button-primary">Add</a>
	</div>

</template>

<script>
	export default {
		mixins: [HRMMixin.departments],
	}
</script>
