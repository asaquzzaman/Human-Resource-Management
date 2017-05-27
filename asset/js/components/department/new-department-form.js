Vue.component('new-department-form', {
	template: '#tmpl-hrm-new-department-form',

	mixins: [HRM_Common_Mixin],

	data: function() {
		return {
			title: '',
			description: '',
			status: '0',
			parent: '0'
		}
	},

	methods: {
		showHideNewDepartmentForm: function(el) {

			var self = this;

			this.slideUp(el, function() {
				self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
			});
						
		},

		createNewDepartment: function() {
		    var request_data = {
                _wpnonce: HRM_Admin.nonce,
                title: this.title,
                description: this.description,
                status: this.status,
                parent: this.parent
            },
            self = this;

            wp.ajax.send('create_new_department', {
                data: request_data,
                success: function(res) {
                    
                }
            });
		}
	}
});