<template>
	<div>
		<leave-header></leave-header>
		<router-view name="hrm-leave-type"></router-view>
		<router-view name="hrm-leave-work-week"></router-view>
		<router-view name="hrm-leave-holidays"></router-view>
	</div>
</template>


<script>
	import leave_header from './leave-header.vue';
	
	var Hrm_Leave_Configuration = {
		
		components: {
			'leave-header': leave_header
		},
		
		created: function() {
			if ( this.$route.path == '/leave-configuration' ) {
				this.$router.push({name: 'leave_type'});
			}
		},
	};

	export default Hrm_Leave_Configuration;
</script>