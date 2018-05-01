<template>
	<div>
		<!-- <leave-header></leave-header> -->
		<router-view></router-view>
	</div>
</template>


<script>
	import leave_header from './leave-header.vue';
    import Mixin from './mixin'
	
	var Hrm_Leave_Configuration = {
		mixins: [Mixin],
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