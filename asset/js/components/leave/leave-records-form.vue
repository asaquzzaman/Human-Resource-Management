<template>
<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span>Leave Records</span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<form action="" @submit.prevent="createNewLeave()">
					<div v-if="leave_proxy" class="hrm-form-field">
						<label>
							Employee
							<em>*</em>
						</label>
						<div class="hrm-multiselect">
							<hrm-multiselect 
 
					            select-label=""
					            selected-label="selected"
					            deselect-label=""
								v-model="selectedEmployee" 
								id="ajax" 
								label="display_name" 
								track-by="ID" 
								placeholder="Type to search" 
								open-direction="bottom" 
								:options="employees" 
								:multiple="false" 
								:searchable="true" 
								@input="changeEmployee"
								@search-change="asyncFind">

									<template slot="clear" scope="props">
										<div class="multiselect__clear" 
											v-if="selectedEmployee.length" 
											@mousedown.prevent.stop="clearAll(props.search)">
											
										</div>
									</template><span slot="noResult">No user found.</span>

							</hrm-multiselect>
             
					    </div>
					    <div class="hrm-clear"></div>
					</div>

					<div class="hrm-form-field ">
						<label for="">
							Apply for others leave
							<em></em>
						</label>
						<span class="hrm-checkbox-wrap">
							<input v-model="leave_proxy"  type="checkbox" id="hrm-disable-leave-proxy-checkbox">
							<label for="hrm-disable-leave-proxy-checkbox" class="hrm-radio">Enable/Disable</label>
						</span>
						<span class="hrm-clear"></span>
						<span class="description"></span>
					</div>
					
					<div class="hrm-form-field" v-if="!disable_leave_type">
						<label>
							Leave Type
							<em>*</em>
						</label>
						<div class="hrm-multiselect">

					        <hrm-multiselect 
					            v-model="leave_type" 
					            :options="leave_types" 
					            :multiple="false" 
					            :close-on-select="true"
					            :clear-on-select="true"
					            :hide-selected="false"
					            :show-labels="true"
					            placeholder="Select leave type"
					            select-label=""
					            selected-label="selected"
					            deselect-label=""
					            :taggable="false"
					            label="name"
					            track-by="id"
					            :allow-empty="true"
					            @input="change_leve_type_statue()">

					        </hrm-multiselect>               
					    </div>
					    <div class="hrm-clear"></div>
					</div>

					<div class="hrm-form-field ">
						<label for="">
							Leave type
							<em></em>
						</label>
						<span class="hrm-checkbox-wrap">
							<input @change="onOff('disable_leave_type')" type="checkbox" id="hrm-disable-leave-type-checkbox">
							<label for="hrm-disable-leave-type-checkbox" class="hrm-radio">Enable/Disable</label>
						</span>
						<span class="hrm-clear"></span>
						<span class="description"></span>
					</div>
<!-- 
					<div class="hrm-form-field">
						<label>
							Request to
							<em>*</em>
						</label>
						<div class="hrm-multiselect">

					        <hrm-multiselect 
					            v-model="apply_to" 
					            :options="administrators" 
					            :multiple="true" 
					            :close-on-select="true"
					            :clear-on-select="true"
					            :hide-selected="false"
					            :show-labels="true"
					            placeholder="Select administrators"
					            select-label=""
					            selected-label="selected"
					            deselect-label=""
					            :taggable="false"
					            label="display_name"
					            track-by="ID"
					            :allow-empty="true">

					            <template  slot="option" scope="props">
					                <div>
					                	<div class="multi-img-wrap">
					                    	<img height="16" width="16" class="option__image" :src="props.option.avatar_url" alt="<?php _e( 'kkk', 'cpm' ); ?>">
					                    </div>
					                    <div class="option__descΩ">
					                        <span class="option__title">{{ props.option.display_name }}</span>
					                        
					                    </div>
					                    <div class="hrm-clear"></div>
					                </div>
					            </template>
					                
					        </hrm-multiselect>               
					    </div>
					    <div class="hrm-clear"></div>
					</div>
 -->
					<!-- <div class="hrm-form-field ">
						<label for="hrm-leave-type-select-field">
							Status
							<em></em>
						</label>
						<select id="hrm-leave-type-select-field" name="leave_status">
							<option value="">- Select -</option>
							<option value="1">Pending</option>
							<option value="2">Approve</option>
							<option value="3">Cancel</option>
						</select>
						<span class="hrm-clear"></span>
						<span class="description"></span>
					</div> -->

					<div class="hrm-form-field ">
						<label for="">
							Comments
							<em></em>
						</label>
						<span class="hrm-checkbox-wrap">
							<textarea v-model="leave_comments"></textarea>
							<label for="hrm-disable-leave-type-checkbox" class="hrm-radio"></label>
						</span>
						<span class="hrm-clear"></span>
						<span class="description"></span>
					</div>

					<div class="hrm-form-field">
						<label>Leave Duration<em>*</em></label>
						<div v-hrm-leave-jquery-fullcalendar class="hrm-leave-jquery-fullcalendar"></div>
					</div>

					
					<input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="Save changes">
					<a @click.prevent="showHideLeaveRecordsForm(false)" target="_blank" href="#" class="button hrm-form-cancel">Cancel</a>
				</form>
			</div>

		</div>
	</div>
</div>
</template>

<script>
	import Multiselect from './../../vue-multiselect/vue-multiselect.min';

	export default {
		data: function() {
			return {
				employees: [],
				apply_to: '',
				leave_type: '',
				leave_types: [],
				administrators: [],
				leave_status: '',
				start_time: '',
				end_time: '',
				leave_comments: '',
				emp_leave_with_type_record: [],
				work_week: [],
				leave_entitlements: [],
				apply_leave_date: [],
				calendar_evt_id: [],
				disable_leave_type: false,
				selectedEmployee: false,
				isLoading: false,
				leave_proxy: false,
				apply_emp_lev_records: [],
				is_leave_btn_disable: false
			}
		},

		watch: {
			leave_proxy (proxy) {
				this.refresh();
				this.change_leve_type_statue();
			}
		},

		components: {
			'hrm-multiselect': Multiselect
		},

		created: function() {
			this.$on('hrm_date_picker', this.setDateTime);
			this.getInitialData();
		},
		methods: {
			changeEmployee: function() {
				this.refresh();
				this.change_leve_type_statue();
			},
			refresh () {
				jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar( 'refetchEvents' );
			},
			getInitialData: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

				wp.ajax.send('get_leave_records_init_data', {
	                data: request_data,
	                
	                success: function(res) {
						self.leave_types    = res.leave_types.data;
						self.administrators = res.apply_to;
	                },

	                error: function(res) {
	 
	                }
	            });
			},
			setDateTime: function(date) {
				if (date.field == 'datepicker_from') {
					this.from = date.date
				}

				if (date.field == 'datepicker_to') {
					this.to = date.date
				}
			},
			show_hide_new_leave_records_form: function(el) {
				var self = this;

				this.slideUp(el.target, function() {
					self.$store.commit('isNewLeaveRecordsFormVisible', {is_visible: false});
				});
							
			},

			createNewLeave: function() {

				if( this.is_leave_btn_disable ) {
					return false;
				}

				if (!this.apply_leave_date.length) {
					// Display a success toast, with a title
		            toastr.error('Please select your leave date');
					return false;
				}

				var self = this;
				
			    var request_data = {
	                leave_comments: this.leave_comments,
	                leave_type_id: ! this.leave_type ? '' : this.leave_type.id,
	                emp_id: ! this.selectedEmployee ? false : this.selectedEmployee.ID,
	                time: this.apply_leave_date,
	                disable_leave_type: this.disable_leave_type,
	                class: 'Leave',
	                method: 'create'
	            };

	            this.show_spinner = true;

	            var form_data = {
	                data: request_data,

	                beforSend: function(xhr) {
	                	self.is_leave_btn_disable = true;
	                },
	                
	                success: function(res) {
	                	self.show_spinner = false;
	                    
	                    // Display a success toast, with a title
	                    toastr.success(res.success);
	                    
	                    self.slideUp(jQuery('.hrm-form-cancel'), function() {
	                    	//self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
	                    });

	                    
	                },

	                error: function(res) {
	                	self.show_spinner = false;
	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        toastr.error(value);
	                    });
	                }
	            };

	            this.httpRequest('create_new_leave', form_data);
			},

			change_leve_type_statue: function() {
				jQuery.each(this.calendar_evt_id, function(index, event_id) {
					jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('removeEvents', event_id);
				});
				
				this.calendar_evt_id  = [];
	        	this.apply_leave_date = [];
			},

		    asyncFind (query) {
		    	var self = this;
		    	if (query.length < 3) {
		    		return [];
		    	}
		    	var start = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('getView').start;
		    	var start = moment(start._d).format('YYYY-MM-DD');
		    	var end = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('getView').end;
		    	var end = moment(end._d).format('YYYY-MM-DD');
		    	
		    	var http_data = {
		    		data: {
		    			user: query,
		    			start: start,
		    			end: end
		    		},
		    		type: 'POST',
		    		success (res) {
		    			self.employees = res;
		    		}
		    	};

		    	self.httpRequest('search_emp_leave_records', http_data);
		    },
		    clearAll () {
				this.selectedEmployee = []
		    },

		}
	}
</script>