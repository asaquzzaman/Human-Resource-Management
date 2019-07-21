<template>
	<div class="wrap hrm-leave">
		<div class="leave-add-new-wrap">
			<h1 class="wp-heading-inline">Leaves</h1>
			<a v-if="employeeRole && !processInit" @click.prevent="showHideLeaveRecordsForm('toggle')" href="#" class="page-title-action hrm-btn">
				Add New
			</a>
			<a v-else href="#" @click.prevent="" class="page-title-action hrm-btn">
				Add New
			</a>

			<div class="add-new-notice" v-if="!employeeRole">
				Only HR emaployee and manager can apply leave.
			</div>
		</div>
		
		<leave-header></leave-header>
		
		<hrm-leave-records-form class="hrm-toggle" v-if="is_leave_form_active"></hrm-leave-records-form>
		
		<!-- <div v-employee-leave-records class="hrm-employee-leave-records"></div> -->
		<hrm-leave-records-render></hrm-leave-records-render>
	</div>
</template>


<script>
import header from './leave-header.vue';
import leave_record_add_btn from './leave-records-add-btn.vue';
import leave_records_form from './leave-records-form.vue';
import leave_records_render from './leave-records-render.vue';
import Mixin from './mixin'



export default {
	mixins: [Mixin],

	data () {
		return {
			employeeRole: true,
			processInit: true
		}
	},
	
	computed: {
		is_leave_form_active: function() {
			return this.$store.state.leave.is_leave_form_active;
		}
	},
	components: {
		'leave-header': header,
		'hrm-leave-records-add-btn': leave_record_add_btn,
		'hrm-leave-records-form': leave_records_form,
		'hrm-leave-records-render': leave_records_render
	},

	created () {
		this.leaveInit();
	},

	methods: {
		leaveInit () {
			var self = this;
			wp.ajax.send('leave_init', {
                data: {	_wpnonce: HRM_Vars.nonce },

                beforeSend () {
                	self.processInit = true;
                }, 
                
                success: function(res) {
                	self.employeeRole = res.employee_role;
                	self.processInit = false;
                },

                error: function(res) {
                	
                }
            });
		}
	}
}

</script>

<style lang="less">
	.hrm-leave {
		.leave-add-new-wrap {
			display: flex;
			.add-new-notice {
				margin: auto;
    			margin-left: 10px;
    			margin-top: 15px;
    			color: #b33838;
    			font-size: 12px;
			}
		}
	}

	.hrm-employee-leave-records {
		width: 50%;
	}
</style>




