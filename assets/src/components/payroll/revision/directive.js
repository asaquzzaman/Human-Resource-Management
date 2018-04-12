var HRM_Dashboard = {
	dialog (el, binding, vnode) {
		jQuery(el).dialog({
			'width': '60%',
			close () {
				vnode.context.afterCloseDialog(vnode.context);
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