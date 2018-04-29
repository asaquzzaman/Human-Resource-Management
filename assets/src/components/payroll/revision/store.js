export default {
	state: {
		isNewRecordFormActive: false,
		employees: [],
		records: [],
		getIndex: function ( itemList, id, slug) {
            return itemList.findIndex(x => x[slug]==id);
        },
        deletedId: [],
        pagination: {},
        slideUp (callBack) {
        	jQuery('.hrm-toggle').slideUp(400, function() {
        		callBack();
        	});
        },
        slideDwon () {
        	var node = jQuery('.hrm-toggle');
	        node.css({
	            display: 'none'
	        });

			node.slideDown(400);
	    },
	    editSlideUp (id, callBack) {
        	jQuery('#hrm-edit-'+id)
        		.find('form')
        		.slideUp(400, function() {
        			callBack();
        		}
        	);
        },
        editSlideDwon (id) {
        	var node = jQuery('#hrm-edit-'+id);

	        node.find('form').css({
	            display: 'none'
	        });

			node.find('form').slideDown(400);
	    }
	},

	mutations: {
		setEmployees (state, employees) {
			state.employees = employees;
		},
		showHideNewRecordForm  (state, status) {
			if (status === 'toggle') {
				status = state.isNewRecordFormActive ? false : true;
            } 

        	if (status === false) {
				state.slideUp(function() {
					state.isNewRecordFormActive = status;
				});
			} else {
				state.isNewRecordFormActive = status;
				hrm.Vue.nextTick(function() {
					state.slideDwon();
				});
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
			var index = state.getIndex(state.records, data.id, 'id' ),
				status = data.status,
				id     = state.records[index].id;

			if (data.status == 'toggle') {
				status = state.records[index].editMode ? false : true;
			} 

			if ( status === false ) {
				state.editSlideUp(id, function() {
					state.records[index].editMode = status;
				});
			} else {
				state.records[index].editMode = status;
				hrm.Vue.nextTick(function() {
					state.editSlideDwon(id);
				});
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
				state.pagination.total = parseInt(state.pagination.total) - 1;
			});
		},

		setSearchResults (state, records) {

		}
	}
};