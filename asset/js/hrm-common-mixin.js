Vue.directive('hrm-slide-down', {
	inserted: function(el) {
		var node = jQuery(el);

		if (node.is(':visible')) {
			node.slideUp(400);
		} else {
			node.slideDown(400);
		}
		
	},
});

var HRM_Common_Mixin = {
	methods: {
		slideUp: function(target_el, callback) {
			var node = jQuery(target_el).closest('.hrm-slide-up');

			node.slideUp(400, function() {
				callback();
			});
		}
	}
}