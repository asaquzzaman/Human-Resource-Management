export default {
	state: {
		isNewRecordFormActive: false,
		records: [],
		getIndex: function ( itemList, id, slug) {
            return itemList.findIndex(x => x[slug]==id);
        },
        deletedId: [],
        pagination: {}
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
			var per_page = state.pagination.per_page,
                length   = state.records.length;

            if (per_page <= length) {
                state.records.splice(0,0,record);
                state.records.pop();
            } else {
                state.records.splice(0,0,record);
            }
		},

		updateRecord (state, record) {
			let index = state.getIndex( state.records, record.id, 'id' );

			state.records.splice(index, 1, record);
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
		},

		setPagination (state, pagination) {
			state.pagination = pagination;
		},

		updatePaginationAfterNewRecord (state) {
            state.pagination.total = state.pagination.total + 1;
            state.pagination.total_pages = Math.ceil( state.pagination.total / state.pagination.per_page );
        },

		afterDelete (state, deletedId) {
			deletedId.forEach(function(id) {
				let index = state.getIndex(state.records, id, 'id');

				state.records.splice(index, 1);
			});
		},

		setSearchResults (state, records) {

		}
	}
};