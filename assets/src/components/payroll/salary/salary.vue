<template>
	<div class="hrm-salary">
		<payroll-menu></payroll-menu>
		<div class="metabox-holder" id="hrm-hidden-form-warp">
			<div v-if="isLoaded"  class="postbox">
	        
	        	<h2 class="hndle">Salary</h2>

	        	<div class="inside">
	        		<form @submit.prevent="generateSalaryStatement(true)" id="hrm-hidden-form">
	        			<div class="hrm-form-field">
							<label>
								Salary Day
								<em>*</em>
							</label>
	        				<hrm-date-picker v-model="salaryDay" :required="true"  placeholder="From" class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
    						<div class="hrm-clear"></div>
				    		<span class="description"></span>
					    </div>

		       			<div class="hrm-form-field">
							<label>
								Salary Type
								<em>*</em>
							</label>
							<select v-model="salaryType">
								<option value="designation">Designation</option>
								<option value="employee">Employee</option>
							</select>
							<div class="hrm-clear"></div>
				    		<span class="description">Salary will goes to</span>
					    </div>

						<div v-if="salaryType=='employee'" class="hrm-form-field">
							<label>
								Employee
								<em>*</em>
							</label>
							<div class="hrm-multiselect">
								<hrm-multiselect 
						            v-model="categoryId" 
						            :options="employees" 
						            :multiple="false" 
						            :close-on-select="true"
						            :clear-on-select="true"
						            :hide-selected="false"
						            :show-labels="true"
						            placeholder="Employees"
						            select-label=""
						            selected-label="selected"
						            deselect-label=""
						            :taggable="false"
						            label="display_name"
						            :allow-empty="true">

						        </hrm-multiselect>  
					    	</div>
					        <div class="hrm-clear"></div>
				    		<span class="description">Select employee</span>
					    </div>

				       	<div v-if="salaryType=='designation'" class="hrm-form-field">
							<label>
								Designation
								<em>*</em>
							</label>
							<div class="hrm-multiselect">
								<hrm-multiselect 
						            v-model="categoryId" 
						            :options="designation" 
						            :multiple="false" 
						            :close-on-select="true"
						            :clear-on-select="true"
						            :hide-selected="false"
						            :show-labels="true"
						            placeholder="Designation"
						            select-label=""
						            selected-label="selected"
						            deselect-label=""
						            :taggable="false"
						            label="title"
						            track-by="id"
						            :allow-empty="true">

						        </hrm-multiselect>  
					    	</div>
					        <div class="hrm-clear"></div>
				    		<span class="description">Select designation</span>
					    </div>

					   	<div class="hrm-form-field">
							<label>
								Salary Component Group
								<em></em>
							</label>
							<div class="hrm-multiselect">
								<hrm-multiselect 
						            v-model="salaryComponentGroup" 
						            :options="componentGroup" 
						            :multiple="false" 
						            :close-on-select="true"
						            :clear-on-select="true"
						            :hide-selected="false"
						            :show-labels="true"
						            placeholder="Component Group"
						            select-label=""
						            selected-label="selected"
						            deselect-label=""
						            :taggable="false"
						            label="name"
						            track-by="id"
						            :allow-empty="true">

						        </hrm-multiselect>  
					    	</div>
					        <div class="hrm-clear"></div>
				    		<span class="description">Select salary component group</span>
					    </div>

				        <table id="hrm-salary-lists" class="wp-list-table widefat fixed striped pages">
				        	<thead>
					        	<tr class="tr-main">
					        		<td class="tb-main">Income</td>
					        		<td></td>
					        		<td></td>
					        	</tr>
					        	<tr v-for="incomeFormula in incomeFormulas">
					        		<td class="tb-child">{{ incomeFormula.description }}</td>
					        		<td>{{ executeFormula(incomeFormula) }}</td>
					        		<td>{{ incomeFormula.formula }}</td>
					        	</tr>
					        	<tr v-if="meta.others">
					        		<td class="tb-child">Othres</td>
					        		<td>{{ meta.others }}</td>
					        		<td></td>
					        	</tr>
					        	<tr class="total-tr">
					        		<td class="tb-child total">Gross Total</td>
					        		<td>{{ meta.incomeTotal }}</td>
					        		<td></td>
					        	</tr>
					        	<tr class="tr-main">
					        		<td class="tb-main">Deduction</td>
					        		<td></td>
					        		<td></td>
					        	</tr>
					        	<tr v-for="deductionFormula in deductionFormulas">
					        		<td class="tb-child">{{ deductionFormula.description }}</td>
					        		<td>-{{ executeFormula(deductionFormula) }}</td>
					        		<td>{{ deductionFormula.formula }}</td>
					        	</tr>
					        	<tr class="total-tr">
					        		<td class="tb-child total">Deduction Total</td>
					        		<td>-{{ meta.deductionTotal }}</td>
					        		<td></td>
					        	</tr>
					        	<tr class="total-tr">
					        		<td class="tb-child total">Net Pay</td>
					        		<td>{{ meta.employeeGet }}</td>
					        		<td></td>
					        	</tr>
					        	<tr class="tr-main">
					        		<td class="tb-main">Salary</td>
					        		<td>
					        			<input class="amount" required="required" v-model="salary" type="number" placeholder="Monthly/Annual salary" step="any">
					        		</td>
					        		<td>
					        			<select v-model="salaryPeriod">
					        				<option value="monthly">Monthly</option>
					        				<option value="annual">Annual</option>
					        			</select>
					        		</td>
					        	</tr>
				        	</thead>
				        </table>
				        <div class="action">
					        <input v-if="!isUpdate" type="submit" value="Save" class="button button-primary hrm-button-primary">
					        <input v-if="isUpdate" type="submit" value="Update" class="button button-primary hrm-button-primary">
					        <a href="#" @click.prevent="generateSalaryStatement(false)" class="button button-secondary hrm-button-secondary">Generate</a>
				    	</div>
				    </form>
				</div>
			</div>
		</div>
	</div>
</template>

<style lang="less">
	.hrm-salary {
		.tb-child {
			padding-left: 5%;
		}
		.tr-main {
			background: #eee;
		}
		.tb-main {
			font-weight: 600;
		}
		.action {
			margin-top: 20px;
		}
		.total {
			font-weight: 600;
		}
		.total-tr {
			background: #f9f9f9;
		}
		.wp-list-table {
			margin-top: 10px;
		}
		.amount {
			width: 79% !important;
			margin: 0 !important;
			float: none !important;
			padding: 5px;
		}
		.inside {
			margin: 11px 0;
		}
	}

</style>

<script>
	import Mixin from './mixin'
	import PayrollMixin from '@components/payroll/mixin'

	export default {
		mixins: [Mixin, PayrollMixin],
		data () {
			return {
				categoryId: '',
				salary: '',
				salaryType: 'designation',
				salaryDay: '',
				salaryComponentGroup: {
					id: '',
					name: 'All'
				},
				salaryPeriod: 'monthly',
				isUpdate: false,
				isLoaded: false,
				allLoad: {
					getEmployee: false,
					getDesignation: false,
					getGroup: false,
					getFormula: false
				},
				salaryId: false
			}
		},

		components: {
			'hrm-multiselect': hrm.Multiselect
		},

		created () {
			var self = this;
			self.loadingStart('hrm-hidden-form-warp');
			this.getEmployess({
				callback () {
					self.allLoad.getEmployee = true;
					self.checkAllLoad();
				}
			});
			this.getDesignation({
				callback () {
					self.allLoad.getDesignation = true;
					self.checkAllLoad();
				}
			});
			
			this.getSalaryGroupRecords({
				callback () {
					self.allLoad.getGroup = true;
					self.checkAllLoad();
				}
			});

			this.getSelfFromulas({
				callback () {
					self.allLoad.getFormula = true;
					self.checkAllLoad();
				}
			});
		},

		watch: {
			categoryId (newVal) {
				this.fetchStatement();
			},

			salaryDay (newVal) {
				this.fetchStatement();
			}
		},

		computed: {
			employees () {
				return this.$store.state[this.nameSpace].employees;
			},

			designation () {
				return this.$store.state[this.nameSpace].designation;
			},

			componentGroup () {
				var group = [];
				group.push({
					id: '',
					name: 'All'
				});

				this.$store.state.group.records.forEach(function(grp) {
					group.push(grp);
				});
				

				return group;
			},

			incomeFormulas () {
				var dbfomulas = this.$store.state.salary.formulas;

				return dbfomulas.filter(function (formula) {
					return formula.type == 'income';
				});
			},

			deductionFormulas () {
				var dbfomulas = this.$store.state.salary.formulas;

				return dbfomulas.filter(function (formula) {
					return formula.type == 'deduction';
				});
			},

			meta () {
				if(!this.$store.state.salary.meta) {
					return 0;
				}
				return this.$store.state.salary.meta;
			}
		},

		methods: {
			checkAllLoad () {
				var status = true;
				jQuery.each(this.allLoad, function(key, load) {
					if (load === false) {
						status = false;
						return;
					}
				});

				if( status ) {
					this.isLoaded = true;
					this.loadingStop('hrm-hidden-form-warp');
				}
 			},
			getEmployess (args) {
				var self = this;

				var form_data = {
		            data: {
		            	number: -1
		            },

		            success: function(res) {
		            	self.$store.commit(self.nameSpace + '/setEmployees', res.data);
		            	
		            	if(typeof args.callback != 'undefined') {
		            		args.callback();
		            	}
		            },

		            error: function(res) {
		            }
		        };

		        this.httpRequest('hrm_employee_filter', form_data);
			},

			getDesignation (args) {
				var self = this;

				var postData = {
					'class': 'Designation',
					'method': 'gets',
					'transformers': 'Designation_Transformer',
					'page': 1,
					'per_page': 1000
				};
				
	            var request_data = {
	                data: postData,
	                success: function(res) {
	                    self.$store.commit( self.nameSpace + '/setDesignation', res.data );

	                 	if(typeof args.callback != 'undefined') {
		            		args.callback();
		            	}
	                }
	            };

	            self.httpRequest('hrm_get_records', request_data);
			},

			executeFormula (statement) {
				if(!statement.amount) {
					return 0;
				}

				return statement.amount;
			},

			generateSalaryStatement (save) {
				var self = this;

				if(!self.salaryDay) {
					hrm.Toastr.error('Salary day required!');
					return;
				}

				if(!self.salaryType) {
					hrm.Toastr.error('Salary type required!');
					return;
				}

				if(!self.categoryId) {
					hrm.Toastr.error('Employee/Designation required!');
					return;
				}
				if(!self.salary) {
					hrm.Toastr.error('Monthly/Annual salary required!');
					return;
				}
				
				var form_data = {
		            data: {
		            	salary: self.salary,
		            	group: self.salaryComponentGroup.id,
		            	salary_period: self.salaryPeriod,
		            	month: self.salaryDay,
		            	category: self.salaryType,
			        	category_id: self.categoryId.id,
			        	isUpdate: self.isUpdate,
			        	save: save,
			        	salary_id: self.salaryId

		            },

		            success: function(res) {
		            	

		            	if (save) {
							self.categoryId = '';
							self.salary = '';
							self.salaryType = 'designation';
							self.salaryDay = '';
							self.salaryComponentGroup = '';
							self.salaryPeriod = 'monthly';
							
							self.$store.commit( 'salary/setFormulas', [] );
		            		self.$store.commit( 
		            			'salary/setOthers',  
		            			{
		            				salaryMeta: {
										others: false,
										incomeTotal: 0,
										deductionTotal: 0,
										employeeGet: 0
									}
								} 
							);

		            		hrm.Toastr.success('Salary has been saved!');
		            	} else {
		            		self.$store.commit( 'salary/setFormulas', res.data );
		            		self.$store.commit( 'salary/setOthers', res.meta );
		            	}
		            },

		            error: function(res) {
		            	res.error.map( function( value, index ) {
                            hrm.Toastr.error(value);
                        });
		            }
		        };

		        this.httpRequest('hrm_generate_salary_statement', form_data);
			},


			getSelfFromulas (args) {
				var self = this;
					this.getFormulas({
					callback (res) {
						self.$store.commit( 'salary/setFormulas', res.data );
						if(typeof args.callback != 'undefined') {
		            		args.callback();
		            	}
					}
				});
			},

			fetchStatement () {
			
				var self = this;
				if (self.salaryDay == '') {
					return;
				}
				if (self.categoryId == '') {
					return;
				}
	            var request_data = {
	                data: {
	                	type: self.salaryType,
	                	id: self.categoryId.id,
	                	salaryDay: self.salaryDay
	                },
	                beforeSend () {
	                	self.loadingStart('hrm-salary-lists');
	                },
	                success: function(res) {
	                	self.loadingStop('hrm-salary-lists');
	                	if(typeof res == 'undefined') {
	                		self.$store.commit( 'salary/setFormulas', [] );
		            		self.$store.commit( 
		            			'salary/setOthers',  
		            			{
		            				salaryMeta: {
										others: false,
										incomeTotal: 0,
										deductionTotal: 0,
										employeeGet: 0
									}
								} 
							);
	                		self.isUpdate = false;
	                		self.salary = '';
	                		return;
	                	}

	                	self.salaryId = res.data.id;
	                	self.salary = res.data.salary;
						self.salaryDay = res.data.month;

						if(res.data.group_id) {
	                		let index = self.getIndex(self.componentGroup, res.data.group_id, 'id');
	                		self.salaryComponentGroup = self.componentGroup[index];
	                	}
						self.isUpdate = true;
						self.salaryPeriod = res.data.type;
						self.$store.commit( 'salary/setFormulas', res.data.info.data );
		            	self.$store.commit( 'salary/setOthers', res.data.info.meta );
	                }
	            };

	            self.httpRequest('hrm_fetch_statement', request_data);
			}
		}
	}
</script>