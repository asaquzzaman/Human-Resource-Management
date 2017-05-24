new Vue({
	store: HRM_Admin_Store,
	
	mixin: [HRM_Common_Mixin],

	computed: {
		is_new_department_form_visible: function() {
			return this.$store.state.is_new_department_form_visible;
		}
	},

}).$mount('.hrm-content-wrap');