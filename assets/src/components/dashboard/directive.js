var HRM_Dashboard = {
	dialog (el, binding, vnode) {
		jQuery(el).dialog({
			close () {
				vnode.context.notices.forEach(function(notice) {
					notice.popup = false;
				});
			}
		});
	}
}


// Register a global custom directive called v-cpm-datepicker
hrm.Vue.directive('hrm-dialog', {
    inserted: function (el, binding, vnode) {
		
        HRM_Dashboard.dialog( el, binding, vnode );
    }
});