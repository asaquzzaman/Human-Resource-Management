<template>
	
	<div class="hrm-tbl-action-wrap hrm-form-field hrm-leave-search-wrap">
		<form @submit.prevent="leaveFilter()">
			<div class="hrm-table-action">
				<date-picker  placeholder="Leave From" v-model="start_time" class="search-input pm-datepickter-to" dependency="pm-datepickter-from"></date-picker>
			</div>
			<div class="hrm-table-action">
				<date-picker placeholder="Leave To" v-model="end_time" class="search-input pm-datepickter-from" dependency="pm-datepickter-to"></date-picker>
			</div>

			
			<div class="hrm-table-action">
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
			</div>
		    <div class="hrm-table-action">
		    	<input type="submit" class="button hrm-button-secondary button-secondary" value="Filter">
			</div>
		</form>
	</div>
	
</template>

<style>

</style>

<script>
	
	import DatePicker from './../common/date-picker.vue';
    import Mixin from './mixin'
	
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
		mixins: [Mixin],
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