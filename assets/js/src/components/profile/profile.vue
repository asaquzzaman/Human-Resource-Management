<template>
	<router-view></router-view>
</template>

<script>
	import menu from './menu.vue';

	hrm.Vue.component('profile-menu', menu);
	
	export default {
		created () {
			
			if ( '/profile' === this.$route.path ) {
				this.$router.push(
					{
						name: 'personal_information',
					}
				);
			}
		},

		watch: {
			'$route' () {
				if ( '/profile' === this.$route.path ) {
					this.$router.push(
						{
							name: 'personal_information',
						}
					);
				}
			}
		}
	}
</script>