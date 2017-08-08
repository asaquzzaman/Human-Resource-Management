var Hrm_Leave_Holidays = {
	template: '#tmpl-hrm-leave-holidays',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {

		}
	},

	components: {
		'leave-holidays-form': Hrm_Leave_Holidays_Form,
		'leave-holidays-record': Hrm_Leave_Holidays_Record,
		'leave-holidays-add-btn': HRM_Leave_Holidays_Add_Btn,
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