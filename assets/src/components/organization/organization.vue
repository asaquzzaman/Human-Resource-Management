<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
	import menu from './menu.vue';

	hrm.Vue.component('organization-menu', menu);
	
	export default {
		created () {

			if ( '/organization' === this.$route.path ) {
				this.$router.push(
					{
						name: 'general_information',
					}
				);
			}
		},

		watch: {
			'$route' () {
				if ( '/organization' === this.$route.path ) {
					this.$router.push(
						{
							name: 'general_information',
						}
					);
				}
			}
		}
	}
</script>