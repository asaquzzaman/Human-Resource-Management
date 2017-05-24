Vue.component('new-department-form', {
	template: '#tmpl-hrm-new-department-form',

	mixins: [HRM_Common_Mixin],

	methods: {
		showHideNewDepartmentForm: function(el) {

			var self = this;

			this.slideUp(el, function() {
				self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
			});
						
		}
	}
});