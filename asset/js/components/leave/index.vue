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
    import router from './leave-router';
    import form_directive from './leave-form-directive';
    import records_directive from './leave-records-directive';

    export default {
        store,

        created () {
            // if (this.$route.path === '/') {
            //     this.$router.push({
            //         name: 'leave_records'
            //     });
            // }
        },
    }

</script>