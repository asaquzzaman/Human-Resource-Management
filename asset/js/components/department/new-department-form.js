Vue.component('new-department-form', {
	template: '#tmpl-hrm-new-department-form',

	mixins: [HRM_Common_Mixin],

	data: function() {
		return {
			title: '',
			description: '',
			status: '0',
			parent: '0',
			show_spinner: false
		}
	},

	methods: {
		showHideNewDepartmentForm: function(el) {
			var self = this;

			this.slideUp(el.target, function() {
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

            this.show_spinner = true;

            wp.ajax.send('create_new_department', {
                data: request_data,
                success: function(res) {
                	self.show_spinner = false;
                    
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.slideUp(jQuery('.hrm-form-cancel'), function() {
                    	self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
                    });
                },

                error: function(res) {
                	self.show_spinner = false;
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		}
	}
});