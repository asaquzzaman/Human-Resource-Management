<template>
<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Holidays', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<form action="" @submit.prevent="createNewLeave()">
					<div class="hrm-form-field">
						<label>
							<?php _e( 'Employee', 'hrm' ); ?>
							<em>*</em>
						</label>
						<div class="hrm-multiselect">

					        <hrm-multiselect 
					            v-model="emp" 
					            :options="employees" 
					            :multiple="false" 
					            :close-on-select="true"
					            :clear-on-select="true"
					            :hide-selected="false"
					            :show-labels="true"
					            placeholder="<?php _e( 'Select employee', 'cpm' ); ?>"
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
					                    	<img height="16" width="16" class="option__image" :src="props.option.avatar_url" alt="<?php _e( '', 'cpm' ); ?>">
					                    </div>
					                    <div class="option__descΩ">
					                        <span class="option__title">{{ props.option.display_name }}</span>
					                        <!-- <span class="option__small">{{ props.option.desc }}</span> -->
					                    </div>
					                    <div class="hrm-clear"></div>
					                </div>
					            </template>
					                
					        </hrm-multiselect>               
					    </div>
					    <div class="hrm-clear"></div>
					</div>
					
					<div class="hrm-form-field" v-if="!disable_leave_type">
						<label>
							<?php _e( 'Leave Type', 'hrm' ); ?>
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
					            placeholder="<?php _e( 'Select leave type', 'cpm' ); ?>"
					            select-label=""
					            selected-label="selected"
					            deselect-label=""
					            :taggable="false"
					            label="leave_type_name"
					            track-by="id"
					            :allow-empty="true"
					            @input="change_leve_type_statue()">

					        </hrm-multiselect>               
					    </div>
					    <div class="hrm-clear"></div>
					</div>

					<?php
					$field = array(
			            'label' => __( 'Disable leave type', 'hrm' ),
			            'is_vue' => true,
			            'fields' => array(
			                array(
			                    'label'   => __( 'Disable', 'hrm' ),
			                    'checked' => '',
			                    'elements' => array(
			                    	'id'      => 'hrm-disable-leave-type-checkbox',
			                    	'v-model' => 'disable_leave_type',
			                    	"@change" => 'change_leve_type_statue()'
			                    )
			                )
			            ),
			        );

			        echo Hrm_Settings::getInstance()->new_checkbox_field( $field );

			        ?>

					<div class="hrm-form-field">
						<label>
							<?php _e( 'Apply to', 'hrm' ); ?>
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
					            placeholder="<?php _e( 'Select administrators', 'cpm' ); ?>"
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
					                        <!-- <span class="option__small">{{ props.option.desc }}</span> -->
					                    </div>
					                    <div class="hrm-clear"></div>
					                </div>
					            </template>
					                
					        </hrm-multiselect>               
					    </div>
					    <div class="hrm-clear"></div>
					</div>

					<?php
					    //hidden form
				        $field_obj = array(
							'label'    =>  __( 'Status', 'hrm' ),
							'required' =>  true,
							'is_vue' => true,
							'option'  => Hrm_Leave::getInstance()->leave_status(),
				            'field_elements' => array(
								'id'       => 'hrm-leave-type-select-field',
								//'required' => 'required',
								'v-model'  => 'leave_status',
								'name'     => 'leave_status',
				            )
				        );

						echo Hrm_Settings::getInstance()->new_select_field( $field_obj );

				        $field_obj = array(
							'label' =>  __( 'Description', 'hrm' ),
							'id'       => 'hrm-leave-description-textarea-field',
				            'field_elements' => array(
								'v-model'  => 'leave_comments'
				            ),
				        );

					    echo Hrm_Settings::getInstance()->new_textarea_field( $field_obj );
					?>
					<div class="hrm-form-field">
						<label><?php _e( 'Leave Duration', 'hrm' ); ?><em>*</em></label>
						<div v-hrm-leave-jquery-fullcalendar class="hrm-leave-jquery-fullcalendar"></div>
					</div>

					
					<input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="<?php _e( 'Save changes', 'hrm' ); ?>">
					<a @click.prevent="show_hide_new_leave_records_form($event)" target="_blank" href="#" class="button hrm-form-cancel"><?php _e( 'Cancel', 'hrm' ); ?></a>
				</form>
			</div>

		</div>
	</div>
</div>
</template>

<script>
	export default {
		//mixins: [HRM_Mixin],

		//store: HRM_Leave_Store,
		
		data: function() {
			return {
				employees: [],
				emp: '',
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
				disable_leave_type: false
			}
		},

		created: function() {
			this.$on('hrm_date_picker', this.setDateTime);
			this.getInitialData();
		},
		methods: {
			getInitialData: function() {
				var request_data = {
	                _wpnonce: HRM_Vars.nonce,
	            },
	            self = this;

				wp.ajax.send('get_leave_records_init_data', {
	                data: request_data,
	                
	                success: function(res) {
						self.leave_types    = res.leave_types;
						self.employees      = res.employess;
						self.administrators = res.apply_to;
						self.emp_leave_with_type_record  = res.emp_leave_with_type_record;
						self.leave_entitlements     = res.leave_entitlements;
						self.work_week      = res.work_week;
						self.emp = res.current_user;
						self.leave_status = 1;
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
				
			    var request_data = {
	                _wpnonce: hrm_ajax_data.nonce,
	                leave_status: this.leave_status,
	                leave_comments: this.leave_comments,
	                leave_type_id: ! this.leave_type ? '' : this.leave_type.id,
	                emp_id: ! this.emp ? '' : this.emp.ID,
	                time: this.apply_leave_date,
	                disable_leave_type: this.disable_leave_type,
	                apply_to: this.apply_to.length ? true : '',
	                class: 'Leave',
	                method: 'create'
	            },
	            
	            // is_update  = parseInt( this.department_id ) ? true : false,
	            
	            // target_index = is_update ? this.getIndex(
	            //     this.$store.state.departments, this.department_id, 'id'
	            // ) : false,

	            self = this;

	            this.show_spinner = true;

	            wp.ajax.send('create_new_leave', {
	                data: request_data,
	                
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
	            });
			},

			change_leve_type_statue: function() {
				
				jQuery.each(this.calendar_evt_id, function(index, event_id) {
					jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('removeEvents', event_id);
				});
				
				this.calendar_evt_id  = [];
	        	this.apply_leave_date = [];
			},
		}
	};	
</script>

