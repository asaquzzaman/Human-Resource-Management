<template>
	<router-view></router-view>
</template>

<script>
	export default {
		created () {
			this.matchDefaultRoute();
		},

		watch: {
			'$route' () {
				this.matchDefaultRoute();
			}
		},

		methods: {
			matchDefaultRoute () {
				if (
					this.$route.path == '/attendance'
						&&
					this.$route.name == 'attendance'
				) {
					this.$router.push({
						name: 'attendance_records'
					});
				}
			}
		}
	}
</script>