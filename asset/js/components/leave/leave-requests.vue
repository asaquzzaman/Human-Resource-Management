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
		mixins: [HRMMixin.leave],
		
		components: {
			'leave-header': leave_header
		},

		created () {
			if ( this.$route.path == '/leave-requests' ) {
				this.$router.push(
					{
						name: 'leave_pending'
					}
				);
			}
		}
		
	};

	export default Hrm_Leave_Request;
</script>


