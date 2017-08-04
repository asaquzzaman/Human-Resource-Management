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
		'leave-type-records': Hrm_Leave_Type_Records
	},

	computed: {

	},

	created: function() {

	},
	methods: {

	}
};