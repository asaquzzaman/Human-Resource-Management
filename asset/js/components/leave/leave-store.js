import Vue from './../../vue/vue';
import Vuex from './../../vue/vuex';

/**
 * Make sure to call Vue.use(Vuex) first if using a vuex module system
 */
Vue.use(Vuex);

var HRM_Leave_Store = new Vuex.Store({
	state: {
		header: {},
		is_new_leave_type_form_visible: false,
		is_new_leave_records_form_visible: false,
	},

	mutations: {
		header: function(state, header) {
			state.header = header.header;
		},
		isNewLeaveTypeFormVisible: function(state, is_visible) {
			state.is_new_leave_type_form_visible = is_visible.is_visible;
		},
		isNewLeaveRecordsFormVisible: function( state, is_visible ) {
			state.is_new_leave_records_form_visible = is_visible.is_visible;
		}
	}
});


export default HRM_Leave_Store;