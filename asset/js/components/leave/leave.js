var Hrm_Leave = {
	template: '#tmpl-hrm-leave',
	
	mixins: [HRM_Mixin],

	store: HRM_Leave_Store,
	
	data: function() {
		return {

		}
	},

	components: {
      	'hrm-leave-header': Hrm_Leave_Header,
      	'hrm-leave-records': Hrm_Leave_Records,
      	'hrm-leave-configuration': Hrm_Leave_Configuration,
      	'hrm-leave-type': Hrm_Leave_Type,
		'hrm-leave-work-week': Hrm_Leave_Work_Week,
		'hrm-leave-holidays': Hrm_Leave_Holidays,
	},

	computed: {

	},

	created: function() {
		if ( this.$route.path == '/' ) {
			this.$router.push({ name: 'leave_records' });
		}
	},
	methods: {

	}
};
