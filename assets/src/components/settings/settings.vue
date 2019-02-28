<template>
	<div class="hrm-settings">
		<settings-header></settings-header>
		<router-view></router-view>
	</div>
</template>

<script>
	import SettingsHeader from './header.vue';
	export default {
		created () {
			if ( this.$route.name === 'hrm_setting' ) {
				this.$router.push(
					{
						name: 'hrm_general_settings'
					}
				);
			};
		},
		components: {
			SettingsHeader
		}
	}
</script>