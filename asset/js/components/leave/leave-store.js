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
		is_leave_form_active: false,
		leave_records: [],
		leave_meta: {},
		current_emp_current_month_leaves: [],
		pending_leaves: [],
		departmentDropDown: [],
		getIndex: function ( itemList, id, slug) {
            var index = false;

            itemList.forEach(function(item, key) {
                if (item[slug] == id) {
                    index = key;
                }
            });

            return index;
        },
	},

	mutations: {
		header (state, header) {
			state.header = header.header;
		},
		isNewLeaveTypeFormVisible (state, is_visible) {
			state.is_new_leave_type_form_visible = is_visible.is_visible;
		},
		isNewLeaveRecordsFormVisible ( state, is_visible ) {
			state.is_new_leave_records_form_visible = is_visible.is_visible;
		},

		showHideleaveForm  (state, status) {
			if ( status === 'toggle' ) {
                state.is_leave_form_active = state.is_leave_form_active ? false : true;
            } else {
                state.is_leave_form_active = status;
            }
		},

		getLeaveRecords (state, leave_records) {
			state.leave_records = leave_records.data;
			state.leave_meta = leave_records.meta;
		},

		setPendingLeaves (state, pending_leaves) {
			state.pending_leaves = pending_leaves;
		},

		afterDeleteLeave (state, id) {
			var index = state.getIndex(state.leave_records, id, 'id');
			state.leave_records.splice( index, 1 );
		},
		setDepartment (state, dropDown) {
			state.departmentDropDown = dropDown;
		}
	}
});


export default HRM_Leave_Store;