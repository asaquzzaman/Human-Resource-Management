<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
	import menu from './menu.vue';

	hrm.Vue.component('payroll-menu', menu);
	
	export default {

	}
</script>