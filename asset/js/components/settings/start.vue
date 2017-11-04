<template>
	<div>
		<router-view name="hrm-settings"></router-view>
	</div>
</template>

<script>
	import store from './store';
	import mixin from './mixin';
	import router from './router';

	export default {
		store
	}
</script>