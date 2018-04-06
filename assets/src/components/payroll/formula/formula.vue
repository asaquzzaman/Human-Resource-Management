<template>
	<div class="page-payroll metabox-holder">
		<payroll-menu></payroll-menu>
		<div id="hrm-payroll-loader">
			<div v-if="isFetchRecord">
				<div class="hrm-left postbox">
					<h2 class="hndle">Components</h2>
					<div class="inside">
						<ul class="net-pay">
							<li>
								Net Pay
								<ul class="gross-childred-li">
									<li class="gross-li">
										Gross
										<ul class="gross-item-ul">
											<li v-for="incomeFormula in incomeFormulas">
												<a class="delete-btn" href="#" @click.prevent="deleteFormula(incomeFormula)">
													<i class="far fa-trash-alt"></i>
												</a>
												<a class="formula-display-name" href="#" @click.prevent="setEditDate(incomeFormula)">
													{{ incomeFormula.description }}
												</a>
												
											</li>
											
										</ul>
									</li>
									<li class="deducations-li">
										Total Deductions
										<ul class="deductions-item-ul">
											<li v-for="deductionFormula in deductionFormulas">
												<a class="delete-btn" href="#" @click.prevent="deleteFormula(deductionFormula)">
													<i class="far fa-trash-alt"></i>
												</a>
												<a class="formula-display-name" @click.prevent="setEditDate(deductionFormula)" href="#">
													{{ deductionFormula.description }}
												</a>
												
											</li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>


				<div class="hrm-right postbox">
					<h2 class="hndle">Calculation</h2>
					<div class="inside">
						<form id="hrm-formula-form" @submit.prevent="CreateFormula()">
							<div>
								<div class="field-wrap">
									<label>Name</label>
									<input type="text" v-model="name">
								</div>
								<div class="field-wrap">
									<label>Description</label>
									<input v-model="description" type="text">
								</div>
								<div class="field-wrap">
									<label>Salary Type</label>
									<label>
										<input value="income" v-model="type" type="radio">
										Income
									</label>
									<label>
										<input value="deduction" v-model="type" type="radio">
										Deduction
									</label>
								</div>
								<div class="field-wrap">
									<label class="label">{{ name }}  =</label>
									<div class="field">
										<textarea id="component-textarea" placeholder="Create formula" v-model="formula" class="component-textarea"></textarea>
										<div class="help-text">Create formula by click the under following function and operators</div>
									</div>
									<div class="hrm-clear"></div>
								</div>
								<div>
									<div class="component-operator">
										
										<div class="header-text">Functions</div>
										
										<ul>
											<li v-for="(functionEl, key) in functions">
												<a class="operator-link" href="#" @click.prevent="setFunction(key)">{{ functionEl.label }}</a>
											</li>
										
										</ul>
									</div>

									<div class="component-function">
										<div class="header-text">Operator</div>
										<ul>
											<li v-for="(operator, key) in operators">
												<a class="operator-link" href="#" @click.prevent="setOperator(key)">{{ operator }}</a>
											</li>
										
										</ul>
									</div>

									<div class="component-function">
										<div class="header-text">Variable</div>
										<ul>
											<li v-for="(variable, key) in variables">
												<a class="operator-link" href="#" @click.prevent="setVariable(key)">{{ variable.name }}</a>
											</li>
										</ul>
									</div>
									<div class="hrm-clear"></div>
								</div>

								<div class="submi-btn-wrap">
									<input v-if="!formulaID" :disabled="!canSubmit" type="submit" class="button button-primary hrm-button-primary" value="Save Change">
									<input v-if="formulaID" :disabled="!canSubmit" type="submit" class="button button-primary hrm-button-primary" value="Update">
									<a v-if="formulaID" href="#" @click.prevent="cancelUpdate()" class="button button-secondary hrm-button-secondary">Cancel</a>
									<a href="#" @click.prevent="checkFormulaValidity()" class="button button-secondary hrm-button-secondary">Check Formula Validity</a>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="hrm-clear"></div>
			</div>
		</div>
	</div>
</template>

<script>
	function setSelectionRange(input, selectionStart, selectionEnd) {
	  if (input.setSelectionRange) {
	    input.focus();
	    input.setSelectionRange(selectionStart, selectionEnd);
	  }
	  else if (input.createTextRange) {
	    var range = input.createTextRange();
	    range.collapse(true);
	    range.moveEnd('character', selectionEnd);
	    range.moveStart('character', selectionStart);
	    range.select();
	  }
	}

	function setCaretToPos (input, pos) {
	  setSelectionRange(input, pos, pos);
	}

	import Mixin from './mixin'
	import PayrollMixin from '@components/payroll/mixin'

	export default {
		mixins: [Mixin, PayrollMixin],
		
		data () {

			return {
				isFetchRecord: false,
				canSubmit: true,
				formulaID: false,
				formula: '',
				name: '',
				type: '',
				description: '',
				functions: {
					abs: {
						label: 'ABS(x)',
						fun: 'ABS()'
					},
					ceil: {
						label: 'CEIL(x)',
						fun: 'CEIL()'
					},
					floor: {
						label: 'FLOOR(x)',
						fun: 'FLOOR()'
					},
					greatest: {
						label: 'GREATEST(a1, a2,...,an)',
						fun: 'GREATEST()'
					},
					least: {
						label: 'LEAST(a1, a2,...,an)',
						fun: 'LEAST()'
					},
					if: {
						label: 'IF(exp, true value, false value)',
						fun: 'IF()'
					},
					mod: {
						label: 'MOD(x, y)',
						fun: 'MOD()',
					},
					prorate: {
						label: 'PRORATE()',
						fun: 'PRORATE()',
					},
					round: {
						label: 'ROUND(x)',
						fun: 'ROUND()'
					},
					sqrt: {
						label: 'SQRT(x)',
						fun: 'SQRT()',
					},
					sum: {
						label: 'SUM(a1, a2,...,an)',
						fun: 'SUM()'
					}
				},

				operators: {
					plus: '+',
					minus: '-',
					multiple: '*',
					divided: '/',
					percent: '%',
					or: 'OR',
					and: 'AND',
					notEqual: '!=',
					equal: '==',
					less: '<',
					greater: '>',
					lessOrequal: '<=',
					greaterOrequal: '>=',
					not: '!',
					power: '^',
				},
				
				// variables: {
				// 	monthly_salary: {
				// 		description: 'monthly_salary',
				// 		name: 'monthly_salary'
				// 	},

				// 	yearly_salary: {
				// 		description: 'yearly_salary',
				// 		name: 'yearly_salary'
				// 	}
				// }
			}
		},

		watch: {
			formula (val) {
				
			}
		},

		created () {
			this.getFormulas();

		},
		
		computed: {
			variables () {
				var self = this;
				var dbfomulas = this.$store.state[this.nameSpace].records;
				var formula = {};

				dbfomulas.forEach(function(dbformula) {
					formula[dbformula.name] = {
						description: dbformula.description,
						name: dbformula.name
					}
				});

				formula['monthly_salary'] = {
					description: 'Monthly Salary',
					name: 'monthly_salary'
				}

				formula['annual_salary'] = {
					description: 'Annual Salary',
					name: 'annual_salary'
				}
				

				return formula;
			}
		},
		components: {

		},

		methods: {

			setFunction (fun) {
				var txtarea = jQuery('#component-textarea'),
					rowSelector  = document.getElementById("component-textarea"),
  					start = txtarea.prop('selectionStart'),
  					replaceVal = this.functions[fun].fun;
  					
	            var v = txtarea.val();
	            var textBefore = v.substring(0,  start );
	            var textAfter  = v.substring( start, v.length );
				this.formula = textBefore+ replaceVal +textAfter;
  				
  				hrm.Vue.nextTick(function() {
  					var end = txtarea.prop('selectionEnd'),

  						cursor = start + replaceVal.length - 1;
  					
  					setCaretToPos(rowSelector, cursor);
  				});
  				
			},

			setOperator (ope) {
				var txtarea = jQuery('#component-textarea'),
					rowSelector = document.getElementById("component-textarea"),
					start       = txtarea.prop('selectionStart'),
					replaceVal  = this.operators[ope];
  				
	            var v = txtarea.val();
	            var textBefore = v.substring(0,  start );
	            var textAfter  = v.substring( start, v.length );
				this.formula = textBefore+ replaceVal +textAfter;
  				
  				hrm.Vue.nextTick(function() {
  					var end = txtarea.prop('selectionEnd'),
  						cursor = start + replaceVal.length;
  					
  					setCaretToPos(rowSelector, cursor);
  				});
			},

			setVariable (variable) {
				var txtarea = jQuery('#component-textarea'),
					rowSelector = document.getElementById("component-textarea"),
					start       = txtarea.prop('selectionStart'),
					replaceVal  = this.variables[variable].name;
  				
	            var v = txtarea.val();
	            var textBefore = v.substring(0,  start );
	            var textAfter  = v.substring( start, v.length );
				this.formula = textBefore+ replaceVal +textAfter;
  				
  				hrm.Vue.nextTick(function() {
  					var end = txtarea.prop('selectionEnd'),
  						cursor = start + replaceVal.length;
  					
  					setCaretToPos(rowSelector, cursor);
  				});
			},

			checkValidName (name) {
				var re = /^\w+$/;
				if (!re.test(name)) {
				    return false;
				}

				return true;
			},

			CreateFormula () {
				if (!this.checkValidName(this.name)) {
					hrm.Toastr.error('Name should start with an alphabet and can contain only alphabets, digits and under score');
					return;
				}

				if (!this.description) {
					hrm.Toastr.error('Description required!');
					return;
				}

				if (!this.type) {
					hrm.Toastr.error('Salary type required!');
					return;
				}
				if (!this.formula) {
					hrm.Toastr.error('Formula is required!');
					return;
				}


				var self = this;

				if (!this.canSubmit) {
					return false;
				}

				self.loading = true;
				self.canSubmit = false;
				
				var postData = {
					class        : 'Formula',
					method       : 'create',
					transformers : 'Formula_Transformer',
					name         : self.name,
					formula      : self.formula,
					status       : 'enable',
					type         : self.type,
					description  : self.description
				}

				if (this.formulaID) {
					postData.method = 'update';
					postData.id = parseInt(this.formulaID);
				}

				var args = {
					data: postData,

					callback (success, res) {
						self.loading = false;
						self.canSubmit = true;
						self.name = '';
						self.formula = '';
						self.type = '';
						self.description = '';
						self.formulaID = false;
					}
				}
				if (this.formulaID) {
					this.updateRecord(args);
				} else {
					this.addNewRecord(args);
				}
				
			},

			setEditDate (formula) {
				this.formula     = formula.formula;
				this.name        = formula.name;
				this.type        = formula.type;
				this.description = formula.description;
				this.formulaID   = formula.id;
			},

			cancelUpdate () {
				this.formula     = '';
				this.name        = '';
				this.type        = '';
				this.description = '';
				this.formulaID   = false;
			},

			deleteFormula (formula) {
				if(!confirm('Are you sure!')) {
					return;
				}
				this.recordDelete([formula.id]);
			},

			checkFormulaValidity () {

			}
		}
	}
</script>

<style lang="less">
	.page-payroll {
		width: 100%;
		.help-text {
			font-style: italic;
			font-size: 12px;
		}
		.header-text {
			font-size: 1.2em;
		}
		.submi-btn-wrap {
			display: block;
			margin-top: 10px;
		}
		.delete-btn {
			margin-right: 5px;
		    font-size: 11px;
		    color: #ab4141;
		}
		.formula-display-name {
			text-decoration: none;
		}
		.hrm-left,
		.hrm-right,
		.component-operator,
		.component-function {
			float: left;
		}
		.operator-link {
			text-decoration: none;
		}
		.hrm-left {
			width: 29%;
			.gross-childred-li {
				padding-left: 15px;
    			padding-top: 5px;
			}
			.gross-item-ul,
			.deductions-item-ul {
				padding-left: 15px;
				padding-top: 5px;
			}

		}
		.hrm-right {
			width: 65%;
			margin-left: 5%;
			
			.component-operator {
				width: 28%;
				border: 1px solid #ddd;
				padding: 8px
			}

			.component-function {
				width: 28%;
			    border: 1px solid #ddd;
			    margin-left: 15px;
			    padding: 8px;
			}
			.field-wrap {
				display: block;
				margin-bottom: 10px;
				label {
					width: 25%;
					display: inline-block;
					padding: 10px;
					padding-left: 0;
				}

				.label {
					word-wrap: break-word;
				}
				.field {
					width: 70%;
				}

				.field, .label {
					float: left;
				}
				.component-textarea {
					width: 100%;
					min-height: 160px;

				}
			}
			.functions-ul,
			.operator-ul {
				margin: 0;
			}
		}
	}
</style>

