<template>
	<div class="hrm-department-edit-btn-wrap">
		<a @click.prevent="departmentEdit()" href="#" class="hrm-edit" data-table_option="hrm_job_title_option" data-id="3"><?php _e( 'Edit', 'hrm' ); ?></a>
	</div>
</template>
<script>
	
	export default {
		props: ['department_id'],

		mixins: [HRM_Common_Mixin],

		methods: {
			departmentEdit: function() {
				this.$store.commit('department_edit_id', {department_id: this.department_id});
				this.$store.commit('isNewDepartmentForVisible', {is_visible: true});
			}
		}
	}
</script>
