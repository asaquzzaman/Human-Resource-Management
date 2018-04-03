<template>
	<div class="page-payroll metabox-holder">
		<payroll-menu></payroll-menu>
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
									<li>item 1</li>
									<li>item 2</li>
								</ul>
							</li>
							<li class="deducations-li">
								Total Deductions
								<ul class="deductions-item-ul">
									<li>item 1</li>
									<li>item 2</li>
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
				<div>
					<div class="field-wrap">
						<label>Name</label>
						<input type="text">
					</div>
					<div class="field-wrap">
						<label>Description</label>
						<input type="text">
					</div>
					<div class="field-wrap">
						<label>Salary Type</label>
						<label>
							<input type="radio">
							Income
						</label>
						<label>
							<input type="radio">
							Deduction
						</label>
					</div>
					<div class="field-wrap">
						<textarea id="component-textarea" v-model="operation" class="component-textarea"></textarea>
					</div>
					<div>
						<div class="component-operator">
							<ul class="functions-ul">
								<li>Functions</li>
								<li>Operator</li>
							</ul>
						</div>

						<div class="component-function">
							<ul>
								<li v-for="(functionEl, key) in functions">
									<a class="operator-link" href="#" @click.prevent="setFunction(key)">{{ functionEl }}</a>
								</li>
							
							</ul>
							<ul>
								<li v-for="(operator, key) in operators">
									<a class="operator-link" href="#" @click.prevent="setOperator(key)">{{ operator }}</a>
								</li>
							
							</ul>
						</div>
						<div class="hrm-clear"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="hrm-clear"></div>
	</div>
</template>

<style lang="less">
	.page-payroll {
		width: 100%;

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
				padding-left: 20px;
				padding-top: 5px;
			}

		}
		.hrm-right {
			width: 65%;
			margin-left: 5%;
			
			.component-operator {
				width: 30%;
				border: 1px solid #ddd;
				padding: 8px
			}

			.component-function {
				width: 60%;
			    border: 1px solid #ddd;
			    margin-left: 15px;
			    padding: 8px;
			}
			.field-wrap {
				display: block;
				margin-bottom: 10px;
				label {
					width: 30%;
					display: inline-block;
					padding: 10px;
					padding-left: 0;
				}
				.component-textarea {
					width: 97%;
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

	export default {

		data () {

			return {
				operation: '',
				functions: {
					abs: 'ABS(x)',
					ceil: 'CEIL(x)',
					floor: 'FLOOR(x)',
					greatest: 'GREATEST(a1, a2,...,an)',
					if: 'IF(exp or true or false)',
					least: 'LEAST(a1, a2,...,an)',
					mod: 'MOD(x, y)',
					prorate: 'PRORATE()',
					round: 'ROUND(exp)',
					sqrt: 'SQRT(x)',
					sum: 'SUM()'
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
				}
				
			}
		},

		watch: {
			operation (val) {
				console.log(val);
			}
		},
		
		computed: {

		},
		components: {

		},

		methods: {

			setFunction (fun) {
				
				this.operation = this.operation+this.functions[fun];
				
  				
  				hrm.Vue.nextTick(function() {
  					var txtarea = document.getElementById("component-textarea");
  					setCaretToPos(txtarea, 4);
  				});
  				
			},

			setOperator (ope) {
				console.log(ope);
			}
		}
	}
</script>