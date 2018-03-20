<template>
	<router-view></router-view>
</template>

<script>
	export default {
		created () {
			if (
				this.$route.path == '/'
					&&
				this.$route.name == 'hrm_root'
			) {
				this.$router.push({
					name: 'dashboard'
				});
			}
		}
	}
</script>