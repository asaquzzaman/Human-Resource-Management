export default {
	data () {
		return {
			
		}
	},

	computed: {
		incomeFormulas () {
			var dbfomulas = this.$store.state.formula.records;

			return dbfomulas.filter(function (formula) {
				return formula.type == 'income';
			});
		},

		deductionFormulas () {
			var dbfomulas = this.$store.state.formula.records;

			return dbfomulas.filter(function (formula) {
				return formula.type == 'deduction';
			});
		},
	},
	methods: {
		getFormulas (args) {
			var self = this;
			args = args || {};
	
			var form_data = {
	            data: {},

	            beforeSend () {
	            	self.loadingStart('hrm-payroll-loader');
	            },

	            success: function(res) {
	            	res.data.forEach(function(record) {
                		self.recordMeta(record);
                	});

	            	self.$store.commit('formula/setRecords', res.data);
	            	self.$store.commit( 'formula/setPagination', res.meta.pagination );
	            	self.loadingStop('hrm-payroll-loader');
	            	self.isFetchRecord = true;
	            	
	            	if (typeof args.callback != 'undefined') {
	                    args.callback(res);
	                } 
	                
	            },

	            error: function(res) {
	            	self.show_spinner = false;
	            	// Showing error
	                res.error.map( function( value, index ) {
	                    hrm.toastr.error(value);
	                });

	                if (typeof args.callback !== 'function') {
	                    callback(false, res);
	                } 
	            }
	        };

	        this.httpRequest('hrm_get_formula', form_data);
		},

		recordMeta (record) {
			record.editMode = false;
		},

		groupRecordMeta (record) {
			record.editMode = false;
		},

		getSalaryGroupRecords (args) {
			var self = this;
			args = args || {};
			this.$route.query['page'] = this.$route.params.current_page_number;
			this.$route.query['employee_id'] = this.$route.params.employeeId;

			var form_data = {
	            data: this.$route.query,

	            beforeSend () {
	            	self.loadingStart('hrm-list-table');
	            },

	            success: function(res) {
	            	res.data.forEach(function(record) {
                		self.groupRecordMeta(record);
                	});

	            	self.$store.commit('group/setRecords', res.data);
	            	self.$store.commit('group/setPagination', res.meta.pagination );
	            	self.loadingStop('hrm-list-table');
	            	self.isFetchRecord = true;
	            	
	            	if (typeof args.callback !== 'undefined') {
	                    args.callback(true, res);
	                } 
	                
	            },

	            error: function(res) {
	            	self.show_spinner = false;
	            	// Showing error
	                res.error.map( function( value, index ) {
	                    hrm.toastr.error(value);
	                });

	                if (typeof args.callback === 'function') {
	                    callback(false, res);
	                } 
	            }
	        };

	        this.httpRequest('hrm_group_filter', form_data);
		},
	}	
	
}