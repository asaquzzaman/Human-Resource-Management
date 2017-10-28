<template>
	<div>
		<leave-header></leave-header>
		<!-- <div class="hrm-slide-up" v-hrm-slide-down style="display: none;" v-if="is_new_leave_records_form_visible"> -->
			<hrm-leave-records-form v-if="is_leave_form_active"></hrm-leave-records-form>
		<!-- </div> -->
		<a @click.prevent="showHideLeaveRecordsForm('toggle')" href="#" class="button button-primary hrm-add-button">Apply Leave</a>
		<hrm-leave-records-render></hrm-leave-records-render> 
	</div>
</template>


<script>
import header from './leave-header.vue';
import leave_record_add_btn from './leave-records-add-btn.vue';
import leave_records_form from './leave-records-form.vue';
import leave_records_render from './leave-records-render.vue';
import store from './leave-store';
import './leave-directive';

export default {

	computed: {
		is_leave_form_active: function() {
			return this.$store.state.is_leave_form_active;
		}
	},
	components: {
		'leave-header': header,
		'hrm-leave-records-add-btn': leave_record_add_btn,
		'hrm-leave-records-form': leave_records_form,
		'hrm-leave-records-render': leave_records_render
	}
}

</script>




