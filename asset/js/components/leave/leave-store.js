var HRM_Leave_Store = new Vuex.Store({
	state: {
		header: {}
	},

	mutations: {
		header: function(state, header) {
			state.header = header.header;
		}
	}
});