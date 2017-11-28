<div class="hrm-department-del-btn-wrap hrm-tbl-action-btn-sibling">
	<a @click.prevent="departmentGroupDelete()"" v-if="type == 'group'" href="#" class="button hrm-delete-button"><?php _e( 'Delete', 'hrm' ); ?></a>
	<a @click.prevent="departmentDelete()" v-if="type == 'single'" href="#" class="hrm-delete"><?php _e( 'Delete', 'hrm' ); ?></a>
</div>