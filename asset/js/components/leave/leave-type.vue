<template>
	<div>
		<div class="hrm-slide-up" v-hrm-slide-down style="display: none;" v-if="is_new_leave_type_form_visible">
			<leave-type-form></leave-type-form>
		</div>
		<leave-type-add-btn></leave-type-add-btn>
		<leave-type-records></leave-type-records>

	</div>

</template>

<script>
	import HRM_Mixin from './../../mixin';
	import HRM_Leave_Store from './leave-store';

	import Hrm_Leave_Type_Form from './leave-type-form.vue';
	import Hrm_Leave_Type_Records from './leave-type-records.vue';
	import HRM_Leave_Type_Add_Btn from './leave-type-add-btn.vue';
	import do_action from './../do-action.vue';
	
	var Hrm_Leave_Type = {

		mixins: [HRM_Mixin],

		store: HRM_Leave_Store,
		
		components: {
			'leave-type-form': Hrm_Leave_Type_Form,
			'leave-type-records': Hrm_Leave_Type_Records,
			'leave-type-add-btn': HRM_Leave_Type_Add_Btn,
			'my-action': do_action
		},

		computed: {
			is_new_leave_type_form_visible: function() {
				return this.$store.state.is_new_leave_type_form_visible;
			}
		},

		created () {
			this.getDepartments();
		},

		methods: {
			getDepartments () {
				var self = this;
				var request_data = {
					data: {},
					success (res) {
						self.$store.commit('setDepartment', res.dept_drop_down);
					}
				}
				this.httpRequest('get_departments', request_data);
			},
		}

	};

	export default Hrm_Leave_Type;
</script>
