<template>
	
	<div class="hrm-content-wrap">
	    
	    <div class="hrm-department">
	        
	        <div class="hrm-update-notification"></div>

	    	<div id="hrm-admin-department">

	            <div class="hrm-slide-up" v-hrm-slide-down style="display: none;" v-if="is_new_department_form_visible">
	            	<new-department-form></new-department-form>
	            </div>

	            <form id="hrm-list-form" class="" action="" method="post">

	                <div class="hrm-table-action-wrap">
	                    <div class="hrm-left-action">
	                        <department-add-btn></department-add-btn>
	                        <department-del-btn :type="'group'"></department-del-btn>
	                        <span class="hrm-clear"></span>
	                    </div>


	                    <span class="hrm-clear"></span>
	                    
	                </div>

	    			<div id="hrm-data-table_wrapper" class="dataTables_wrapper no-footer">
	    				
	                   <department-table></department-table>
	                   
	            	</div>
	            </form>
	            <!-- <department-pagination></department-pagination> -->
	        </div>
	        
	    </div>
	</div>

</template>

<script>
	import NewDepartmentButton from './department-add-btn.vue';
	import NewDepartmentform from './new-department-form.vue';
	import DepartmentDelButton from './department-del-btn.vue';
	import DepartmentTable from './department-table.vue';
	import DepartmentPagination from './department-pagination.vue';

	export default {
		computed: {
	 		is_new_department_form_visible: function() {
	 			return this.$store.state.departments.is_department_form_active;
	 		}
	 	},
		components: {
			'new-department-form': NewDepartmentform,
			'department-add-btn': NewDepartmentButton,
			'department-del-btn': DepartmentDelButton,
			'department-table': DepartmentTable,
			'department-pagination': DepartmentPagination
		}
	}
</script>

<style>
	#hrm-list-form .hrm-table-action-wrap {
		display: inline;
	}
	.hrm-tbl-action-btn-sibling {
		width: 11%;
	}
	.hrm-left-action {
		margin-bottom: 2%;
	}
</style>