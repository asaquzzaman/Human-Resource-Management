export default {
	state: {
		isNewRecordFormActive: false,
		records: [],
		getIndex: function ( itemList, id, slug) {
            return itemList.findIndex(x => x[slug]==id);
        },
        deletedId: [],
	},

	mutations: {
		showHideNewRecordForm  (state, status) {
			if ( status === 'toggle' ) {
                state.isNewRecordFormActive = state.isNewRecordFormActive ? false : true;
            } else {
                state.isNewRecordFormActive = status;
            }
		},

		setRecords (state, records) {
			state.records = records;
		},

		setRecord (state, record) {
			state.records.push(record);
		},

		showHideEditForm (state, data) {
			var index = state.getIndex(state.records, data.id, 'id' );

			if (data.status == 'toggle') {
				state.records[index].editMode = state.records[index].editMode ? false : true;
			} else {
				state.records[index].editMode = data.status;
			}
		},

		setDeletedId (state, deletedId) {
			state.deletedId = deletedId;
		}
	}
};