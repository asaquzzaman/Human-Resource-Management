var Hrm_Leave_Configuration = {
	template: '#tmpl-hrm-leave-configuration',
	
	mixins: [HRM_Mixin],

	components: {
		
	},
	
	data: function() {
		return {
			
		}
	},

	computed: {

	},

	created: function() {
		if ( this.$route.path == '/leave-configuration' ) {
			this.$router.push({name: 'leave_type'});
		}
	},
	methods: {

	}
};