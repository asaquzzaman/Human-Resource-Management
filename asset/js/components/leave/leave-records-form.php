<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Holidays', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<form action="" @submit.prevent="createNewHolidays()">
					<div  class="cpm-multiselect cpm-multiselect-single-task">

				        <hrm-multiselect 
				            v-model="employee" 
				            :options="employees" 
				            :multiple="false" 
				            :close-on-select="true"
				            :clear-on-select="true"
				            :hide-selected="false"
				            :show-labels="true"
				            placeholder="<?php _e( 'Select User', 'cpm' ); ?>"
				            select-label=""
				            selected-label="selected"
				            deselect-label=""
				            :taggable="true"
				            label="name"
				            track-by="id"
				            :allow-empty="true">

				            <template  slot="option" scope="props">
				                <div>
				                    <img height="16" width="16" class="option__image" :src="props.option.img" alt="<?php _e( 'No Man’s Sky', 'cpm' ); ?>">
				                    <div class="option__desc">
				                        <span class="option__title">{{ props.option.title }}</span>
				                        <!-- <span class="option__small">{{ props.option.desc }}</span> -->
				                    </div>
				                </div>
				            </template>
				                
				        </hrm-multiselect>               
				    </div>
					<?php
						        //hidden form
					        $field_obj = array(
								'label'    =>  __( 'Name', 'hrm' ),
								'required' =>  true,
					            'field_elements' => array(
									'id'       => 'hrm-leave-type-text-field',
									'required' => 'required',
									'v-model'  => 'name',
									'name'     => 'name',
					            )
					        );

							echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
								'label'    =>  __( 'From ', 'hrm' ),
								'required' =>  true,
					            'field_elements' => array(
					            	'v-hrm-datepicker',
									'class'    => 'hrm-date-picker-from',
									'id'       => 'hrm-leave-holidays-from-text-field',
									'required' => 'required',
									':value'  => 'from',
									'name'     => 'from',
					            ),
					        );

					        echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
					            'label' =>  __( 'To', 'hrm' ),
					            'required' =>  true,
					            'field_elements' => array(
									'v-hrm-datepicker',
									'class'    => 'hrm-date-picker-to',
									'id'       => 'hrm-leave-holidays-to-text-field',
									'required' => 'required',
									':value'   => 'to',
									'name'     => 'to',
					            ),
					        );

					         echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
								'label' =>  __( 'Description', 'hrm' ),
								'required' =>  true,
					            'field_elements' => array(
									'class'    => '',
									'id'       => 'hrm-leave-description-textarea-field',
									'required' => 'required',
									'name'     => 'description',
									'v-model'  => 'description'
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