<template>
	<router-view></router-view>
</template>

<script>
	import menu from './menu.vue';

	hrm.Vue.component('profile-menu', menu);
	
	export default {
		created () {
			if ( '/employees' === this.$route.path ) {
				this.$router.push(
					{
						name: 'personal_information',
						params: {
							employeeId: this.getEmployeeId()
						}
					}
				);
			}
		},

		watch: {
			'$route' () {
				if ( '/employees' === this.$route.path ) {
					this.$router.push(
						{
							name: 'personal_information',
							params: {
								employeeId: this.getEmployeeId()
							}
						}
					);
				}
			}
		}
	}
</script>