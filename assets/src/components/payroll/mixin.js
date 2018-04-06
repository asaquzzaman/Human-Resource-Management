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
		}
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
	                    args.callback(true, res);
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
	}	
	
}