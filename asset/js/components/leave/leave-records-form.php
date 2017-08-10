<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Holidays', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<form action="" @submit.prevent="createNewHolidays()">
					<div class="hrm-form-field">
						<label>
							<?php _e( 'Employee', 'hrm' ); ?>
							<em>*</em>
						</label>
						<div class="hrm-multiselect">

					        <hrm-multiselect 
					            v-model="emp_id" 
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
					
					<div class="hrm-form-field">
						<label>
							<?php _e( 'Leave Type', 'hrm' ); ?>
							<em>*</em>
						</label>
						<div class="hrm-multiselect">

					        <hrm-multiselect 
					            v-model="leave_type_id" 
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
					            :allow-empty="true">

					        </hrm-multiselect>               
					    </div>
					    <div class="hrm-clear"></div>
					</div>

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
							'option'  => array( 
								'1' => __( 'Approved', 'hrm' ), 
								'2' => __( 'Pending', 'hrm' ),
								'0' => __( 'Cancel', 'hrm' ) 
							),
				            'field_elements' => array(
								'id'       => 'hrm-leave-type-select-field',
								'required' => 'required',
								'v-model'  => 'leave_status',
								'name'     => 'leave_status',
				            )
				        );

						echo Hrm_Settings::getInstance()->new_select_field( $field_obj );
					?>
					<div class="hrm-form-field">
						<label><?php _e( 'Leave Duration', 'hrm' ); ?><em>*</em></label>
						<div v-hrm-leave-jquery-fullcalendar class="hrm-leave-jquery-fullcalendar"></div>
					</div>

					<?php

					   //      $field_obj = array(
								// 'label'    =>  __( 'From ', 'hrm' ),
								// 'required' =>  true,
					   //          'field_elements' => array(
					   //          	'v-hrm-datepicker',
								// 	'class'    => 'hrm-date-picker-from',
								// 	'id'       => 'hrm-leave-holidays-from-text-field',
								// 	'required' => 'required',
								// 	':value'  => 'start_time',
								// 	'name'     => 'start_time',
					   //          ),
					   //      );

					   //      echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					   //      $field_obj = array(
					   //          'label' =>  __( 'To', 'hrm' ),
					   //          'required' =>  true,
					   //          'field_elements' => array(
								// 	'v-hrm-datepicker',
								// 	'class'    => 'hrm-date-picker-to',
								// 	'id'       => 'hrm-leave-holidays-to-text-field',
								// 	'required' => 'required',
								// 	':value'   => 'end_time',
								// 	'name'     => 'end_time',
					   //          ),
					   //      );

					   //       echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
								'label' =>  __( 'Description', 'hrm' ),
								'required' =>  true,
					            'field_elements' => array(
									'class'    => '',
									'id'       => 'hrm-leave-description-textarea-field',
									'required' => 'required',
									'name'     => 'leave_comments',
									'v-model'  => 'leave_comments'
					            ),
					        );

					        echo Hrm_Settings::getInstance()->new_text_field( $field_obj );
					?>
					<input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="<?php _e( 'Save changes', 'hrm' ); ?>">
					<a @click.prevent="show_hide_new_leave_records_form($event)" target="_blank" href="#" class="button hrm-form-cancel"><?php _e( 'Cancel', 'hrm' ); ?></a>
				</form>
			</div>

		</div>
	</div>
</div>