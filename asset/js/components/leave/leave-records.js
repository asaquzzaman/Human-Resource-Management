var Hrm_Leave_Records = {
	
	template: '#tmpl-hrm-leave-records',
	mixins: [HRM_Mixin],
	
	components: {
		'hrm-leave-records-form': Hrm_Leave_Records_Form,
		'hrm-leave-records-add-btn': HRM_Leave_Records_Add_Btn
	},
	
	data: function() {
		return {

		}
	},
	created: function() {

	},
	computed: {
		is_new_leave_records_form_visible: function() {
			return this.$store.state.is_new_leave_records_form_visible;
		}
	},
	methods: {

	}
};