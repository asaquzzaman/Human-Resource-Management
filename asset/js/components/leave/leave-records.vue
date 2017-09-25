<template>
	<div>
		<leave-header></leave-header>
		<div class="hrm-slide-up" v-hrm-slide-down style="display: none;" v-if="is_new_leave_records_form_visible">
			<hrm-leave-records-form></hrm-leave-records-form>
		</div>
		<hrm-leave-records-add-btn></hrm-leave-records-add-btn>
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
	store,

	computed: {
		is_new_leave_records_form_visible: function() {
			return this.$store.state.is_new_leave_records_form_visible;
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




