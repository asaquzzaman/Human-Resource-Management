<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Leave Type', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<form action="">
					<?php
						        //hidden form
					        $field_obj = array(
					            'label' =>  __( 'Leave Type', 'hrm' ),
					            'field_elements' => array(
									'value'   => '',
									'id' => 'hrm-leave-type-text-field',
									'required' => 'required'
					            )
					        );

							echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
					            'label' =>  __( 'Entitlement ', 'hrm' ),
					            'field_elements' => array(
					            	'value' => '',
					            	'id' => 'hrm-leave-entitlement-text-field',
					            	'required' => 'required'
					            ),
					        );

					        echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
					            'label' =>  __( 'Entitle from', 'hrm' ),
					            'field_elements' => array(
									'v-hrm-datepicker',
									'class'  => 'hrm-date-picker-from',
									'value' => '',
									'id' => 'hrm-leave-entitlement-from-text-field',
									'required' => 'required'
					            ),
					        );

					         echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
								'label' =>  __( 'Entitle to', 'hrm' ),
					            'field_elements' => array(
									'v-hrm-datepicker',
									'class'  => 'hrm-date-picker-to',
									'value' => '',
									'id' => 'hrm-leave-entitlement-to-text-field',
									'required' => 'required'
					            ),
					        );

					        echo Hrm_Settings::getInstance()->new_text_field( $field_obj );
					?>
					<input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="<?php _e( 'Save changes', 'hrm' ); ?>">
					<input  type="submit" class="button hrm-submit-button button-secondary" name="requst" value="<?php _e( 'Cancel', 'hrm' ); ?>">
				</form>
			</div>

		</div>
	</div>
</div>