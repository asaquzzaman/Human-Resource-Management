var Hrm_Leave_Type = {
	template: '#tmpl-hrm-leave-type',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {

		}
	},

	components: {
		'leave-type-form': Hrm_Leave_Type_Form,
		'leave-type-records': Hrm_Leave_Type_Records,
		'leave-type-add-btn': HRM_Leave_Type_Add_Btn,
	},

	computed: {
		is_new_leave_type_form_visible: function() {
			return this.$store.state.is_new_leave_type_form_visible;
		}
	},

	created: function() {

	},
	methods: {

	}
};