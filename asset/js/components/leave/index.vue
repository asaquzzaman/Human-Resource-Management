<template>
	<div>
		<router-view name="hrm-leave-records"></router-view>
		<router-view name="hrm-leave-configuration"></router-view>
		<router-view name="hrm-leave-requests"></router-view>
	</div>
</template>

<script>
	import store from './leave-store';
    import mixin from './leave-mixin';
    import directive from './leave-directive';

    export default {
        store,
    }

</script>