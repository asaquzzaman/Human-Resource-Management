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
		slideUp: function(el, callback) {
			var node = jQuery(el.target).closest('.hrm-slide-up');

			node.slideUp(400, function() {
				callback();
			});
		}
	}
}