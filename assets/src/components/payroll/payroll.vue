<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
	import menu from './menu.vue';

	hrm.Vue.component('payroll-menu', menu);
	
	export default {
		created () {

			if ( '/payroll' === this.$route.path ) {
				this.$router.push(
					{
						name: 'salary_components',
					}
				);
			}
		},

		watch: {
			'$route' () {
				if ( '/payroll' === this.$route.path ) {
					this.$router.push(
						{
							name: 'salary_components',
						}
					);
				}
			}
		}
	}
</script>