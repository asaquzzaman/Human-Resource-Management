<template>
	<div v-if="manageDepartment()" class="hrm-department-edit-btn-wrap">
		<a @click.prevent="departmentEdit()" href="#" class="hrm-edit" data-table_option="hrm_job_title_option" data-id="3">Edit</a>
	</div>
</template>
<script>
	import Mixin from './mixin'
	
	export default {
		props: ['department_id'],

		mixins: [Mixin],

		methods: {
			departmentEdit: function() {
				this.$store.commit('departments/department_edit_id', {department_id: this.department_id});
				this.$store.commit('departments/showHideDepartmentForm', true);
			}
		}
	}
</script>
