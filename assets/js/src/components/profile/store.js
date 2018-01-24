export default {
	state: {
		isExperianceFormActive: false,
		experiance: [],
		getIndex: function ( itemList, id, slug) {
            return itemList.findIndex(x => x[slug]==id);
        },
	},

	mutations: {
		showHideExperianceForm  (state, status) {
			if ( status === 'toggle' ) {
                state.isExperianceFormActive = state.isExperianceFormActive ? false : true;
            } else {
                state.isExperianceFormActive = status;
            }
		},

		setExperiance (state, experiance) {
			state.experiance = experiance;
		},

		showHideEditForm (state, data) {
			var index = state.getIndex(state.experiance, data.id, 'id' );

			if (data.status == 'toggle') {
				state.experiance[index].editMode = state.experiance[index].editMode ? false : true;
			} else {
				state.experiance[index].editMode = data.status;
			}
		}
	}
};