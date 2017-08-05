<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Leave Type', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<form action="" @submit.prevent="createNewLeaveType()">
					<?php
						        //hidden form
					        $field_obj = array(
					            'label' =>  __( 'Leave Type', 'hrm' ),
					            'required' =>  true,
					            'field_elements' => array(
									'id'       => 'hrm-leave-type-text-field',
									'required' => 'required',
									'v-model'  => 'leave_type',
									'name'     => 'leave_type',
					            )
					        );

							echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
					            'label' =>  __( 'Entitlement ', 'hrm' ),
					            'required' =>  true,
					            'field_elements' => array(
									'id'       => 'hrm-leave-entitlement-text-field',
									'required' => 'required',
									'v-model'  => 'entitlement',
									'name'     => 'entitlement',
					            ),
					        );

					        echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
					            'label' =>  __( 'Entitle from', 'hrm' ),
					            'required' =>  true,
					            'field_elements' => array(
									'v-hrm-datepicker',
									'class'    => 'hrm-date-picker-from',
									'id'       => 'hrm-leave-entitlement-from-text-field',
									'required' => 'required',
									':value'   => 'entitle_from',
									'name'     => 'entitle_from',
					            ),
					        );

					         echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					        $field_obj = array(
								'label' =>  __( 'Entitle to', 'hrm' ),
								'required' =>  true,
					            'field_elements' => array(
									'v-hrm-datepicker',
									'class'    => 'hrm-date-picker-to',
									'id'       => 'hrm-leave-entitlement-to-text-field',
									'required' => 'required',
									'name'     => 'entitle_to',
									':value'   => 'entitle_to'
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