<template>
	<div>
		<leave-header></leave-header>
		<router-view name="hrm-leave-pending"></router-view>
		<router-view name="hrm-leave-approve"></router-view>
		<router-view name="hrm-leave-cancel"></router-view>
	</div>
</template>


<script>
	import leave_header from './leave-header.vue';
	
	var Hrm_Leave_Request = {
		
		components: {
			'leave-header': leave_header
		},
		
	};

	export default Hrm_Leave_Request;
</script>


