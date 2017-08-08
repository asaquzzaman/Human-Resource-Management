<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Holidays', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<form action="" @submit.prevent="createNewHolidays()">
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
					<a @click.prevent="show_hide_new_leave_type_form($event)" target="_blank" href="#" class="button hrm-form-cancel"><?php _e( 'Cancel', 'hrm' ); ?></a>
				</form>
			</div>

		</div>
	</div>
</div>