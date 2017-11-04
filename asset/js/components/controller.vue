<template>
	<div>
		
		<hrm-leave></hrm-leave>
		<hrm-settings></hrm-settings>
	</div>
</template>

<script>
	import leave from './leave/index.vue';
	import settings from './settings/start.vue';
	
	export default {
		components: {
			'hrm-leave': leave,
			'hrm-settings': settings
		}
	}
</script>


