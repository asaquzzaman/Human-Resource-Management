<template>
	<div class="hrm-tbl-action-btn-sibling">
		<a @click.prevent="showHideLeaveRecordsForm()" href="#" class="button button-primary ">Add</a>
	</div>
</template>

<script>
    import Mixin from './mixin'
	
	export default {
		methods: {
			mixins: [Mixin],
			
			showHideLeaveRecordsForm: function() {
				this.$store.commit('leave/isNewLeaveRecordsFormVisible', {is_visible: true});
			}
		}
	};
</script>