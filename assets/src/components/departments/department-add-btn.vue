<template>
	<div v-if="manageDepartment()" class="hrm-tbl-action-btn-sibling">
		<a @click.prevent="showHideDepartmentForm('toggle')" href="#" class="button hrm-button-primary button-primary">Add</a>
	</div>

</template>

<script>
	import Mixin from './mixin'
	
	export default {
		mixins: [Mixin],
	}
</script>
