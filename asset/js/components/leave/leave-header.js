var Hrm_Leave_Header = {
	template: '#tmpl-hrm-leave-header',

	mixins: [HRM_Mixin],
	
	data: function() {
		return {
			
		}
	},
	created: function() {
		this.getHeader();
	},

	computed: {
		header: function() {
			return this.$store.state.header;
		},

	},
	methods: {
		is_it_child: function() {

			if( this.$route.matched.length > 1 ) {
				return true;
			}
		},
		has_child_menu: function() {
			var path = this.$route.path;
				has_submenu = false;
			
			jQuery.each( this.$store.state.header, function(key, val ) {
				if (val.url == path) {
					if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
						has_submenu = true;
					}
				}
			});

			return has_submenu;
		},
		get_child_menu: function() {
			var path = this.$route.path;
				submenu = [];

			if ( this.is_it_child() ) {
				var partent_name = this.$route.matched[0].name;
				
				jQuery.each( this.$store.state.header, function(key, val ) {
					if (val.name == partent_name) {
						if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
							submenu = val.submenu;
						}
					}
				});

				return submenu;
			}
			
			
			jQuery.each( this.$store.state.header, function(key, val ) {
				if (val.url == path) {
					if( typeof val.submenu != 'undefined' && jQuery(val.submenu).length ) {
						submenu = val.submenu;
					}
				}
			});

			return submenu;
		},
		getHeader: function() {
			var request_data = {
				_wpnonce: hrm_ajax_data.nonce,
			},
			self  = this;

			wp.ajax.send( 'leave_header', {
                data: request_data,
                success: function(res) {
                	self.$store.commit( 'header', {'header': res.header} );
      			
                },

                error: function(res) {
                	
                }
            });
		}
	}
};