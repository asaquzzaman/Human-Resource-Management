<template>
	<router-view></router-view>
</template>

<script>
	export default {
		created () {
			if ( this.$route.name === 'hrm_setting' ) {
				this.$router.push(
					{
						name: 'hrm_general_settings'
					}
				);
			};
		}
	}
</script>