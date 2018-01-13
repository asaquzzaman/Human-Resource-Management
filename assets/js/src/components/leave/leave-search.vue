<template>
	
	<div class="hrm-form-field hrm-leave-search-wrap">
		
		<date-picker placeholder="Leave From" v-model="start_time" class="pm-datepickter-to" dependency="pm-datepickter-from"></date-picker>
		<date-picker placeholder="Leave To" v-model="end_time" class="pm-datepickter-from" dependency="pm-datepickter-to"></date-picker>
		
		<div v-if="canManamgeLeave()" class="hrm-multiselect hrm-leave-search">
	        <hrm-multiselect 
	            v-model="emp_id" 
	            :options="employessDropDown" 
	            :multiple="false" 
	            :close-on-select="true"
	            :clear-on-select="true"
	            :hide-selected="false"
	            :show-labels="true"
	            placeholder="Select Employee"
	            select-label=""
	            selected-label="selected"
	            deselect-label=""
	            :taggable="false"
	            label="name"
	            track-by="id"
	            :allow-empty="true">

	        </hrm-multiselect>               
	    </div>
	    
	    <button @click.prevent="leaveFilter()"  class="button button-secondary">Filter</button>
	</div>
	
</template>

<style>
	.hrm-form-field {
		margin-bottom: 12px;
	}
	.search-date-field-wrap, .hrm-multiselect {
		
	}
	.hrm-leave-search .multiselect {
		width: auto;
	}
	.hrm-leave-search .multiselect__tags {
		background: inherit !important;
		border: none !important;
		padding: 0 !important;
		min-height: 0 !important;
	}
	.hrm-leave-search .multiselect {
		min-height: 0 !important;
	}
	.hrm-leave-search .multiselect__select {
		display: none !important;
	}
	.pm-datepickter-to, .pm-datepickter-from {
		height: 30px;
	}
	.hrm-leave-search .multiselect__input {
		margin-bottom: 0 !important;
		width: 30% !important;
	}
	.hrm-leave-search {
		margin-left: 2px;
	}
	.hrm-leave-search-wrap .button-secondary {
		margin-left: 8px !important;
    	margin-top: 2px !important;
	}
	.hrm-leave-search, .pm-datepickter-to, .pm-datepickter-from, .button-secondary {
		display: inline-block;
	}
</style>

<script>

	import DatePicker from './../common/date-picker.vue';

	export default {
		data () {
			return {
				employee_id: '',
				start_time: this.$route.query.start_time || HRM_Vars.financial_start,
				end_time: this.$route.query.end_time || HRM_Vars.financial_end
			}
		},
		created () {
			this.selfEmployeeDropDown();
		},
		mixins: [HRMMixin.leave],
		computed: {
			emp_id: {
				get () {
					let emp_id = this.$route.query.emp_id || HRM_Vars.current_user.data.ID;
					let dropDown = this.$store.state.leave.employeeDropDown;

					let index = this.getIndex( dropDown, emp_id, 'id' );

					if ( index !== false ) {
						return dropDown[index];
					} 

					return '';

				},

				set (emp) {
					this.employee_id = emp.id;
				}
			},
			employessDropDown () {
				return this.$store.state.leave.employeeDropDown;
			},
		},
		watch: {
			'$route' () {
				this.getLeaveRecords({
					data: {
						'emp_id': HRM_Vars.current_user.data.ID,
						'query': this.$route.query
					}
				});
			}
		},
		components: {
			'hrm-multiselect': hrm.Multiselect,
			'date-picker': DatePicker
		},
		methods: {
			selfEmployeeDropDown () {
				var args = {
					callback () {

					}
				}
				this.getEmployeeDropDown(args);
			},

			leaveFilter () {
				var query = {
					start_time: this.start_time || '',
					end_time: this.end_time || '',
					emp_id: this.employee_id || '' 
				}
				
				this.$router.push({
					name: 'leave_records',
					query: query
				});
			}
		}
	}
</script>