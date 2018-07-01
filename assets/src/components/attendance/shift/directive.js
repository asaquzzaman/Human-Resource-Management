var HRM_Dashboard = {
	dialog (el, binding, vnode) {
		jQuery(el).dialog({
			close () {
				vnode.context.$store.commit('shift/closePopUp');
			}
		});
	}
}


// Register a global custom directive called v-cpm-datepicker
hrm.Vue.directive('hrm-break-dialog', {
    inserted: function (el, binding, vnode) {
		
        HRM_Dashboard.dialog( el, binding, vnode );
    }
});