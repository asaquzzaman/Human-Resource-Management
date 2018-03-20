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
					this.$route.path == '/leave'
						&&
					this.$route.name == 'leave'
				) {
					this.$router.push({
						name: 'leave_records'
					});
				}

				if (
					this.$route.path == '/leave/leave-request'
						&&
					this.$route.name == 'leave_request'
				) {
					this.$router.push({
						name: 'leave_pending'
					});
				}

				if (
					this.$route.path == '/leave/leave-configuration'
						&&
					this.$route.name == 'leave_configuration'
				) {
					this.$router.push({
						name: 'leave_type'
					});
				}
			}
		}
	}
</script>