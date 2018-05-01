<template>
	<div>
		<leave-header></leave-header>
		<router-view></router-view>
	</div>
</template>


<script>
	import leave_header from './leave-header.vue';
    import Mixin from './mixin'
	
	var Hrm_Leave_Request = {
		mixins: [Mixin],

		watch: {
			'$route' (to, from) {
				this.path();
			}
		},
		
		components: {
			'leave-header': leave_header
		},

		created () {
			this.path();
		},

		methods: {
			path () {
				if ( this.$route.name == 'leave_request' ) {
					this.$router.push(
						{
							name: 'leave_pending'
						}
					);
				}
			}
		}
		
	};

	export default Hrm_Leave_Request;
</script>


