<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Attendance Configuration', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<?php
					$field = array(
			            'label' => __( 'Enabale multiple attendance', 'hrm' ),
			            'desc' => __( 'Enable multiple attendance for per day', 'hrm' ),
			            'fields' => array(
			                array(
			                    'label'   => __( 'Enable', 'hrm' ),
			                    'checked' => '',
			                    'elements' => array(
			                    	'value'   => 'yes',
			                    	'id'      => 'hrm-multi-attendance-checkbox',
			                    	'v-model' => 'hrm_is_multi_attendance'
			                    )
			                )
			            ),
			        );

			        echo Hrm_Settings::getInstance()->new_checkbox_field( $field );

			        $field_obj = array(
						'label' =>  __( 'Office start time', 'hrm' ),
						'field_elements' => array(
							'v-hrm-datepicker',
							':value' => 'office_start_with_date_time',
							'class'  => 'hrm-date-time-picker-from',
							'id'     => 'hrm-office-start-date-field',
						)
					);

					echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

					$field_obj = array(
						'label' =>  __( 'Office closing time', 'hrm' ),
						'field_elements' => array(
							'v-hrm-datepicker',
							':value' => 'office_closed_with_date_time',
							'class'  => 'hrm-date-time-picker-to',
							'id'     => 'hrm-office-closed-date-field',
						)
					);

					echo Hrm_Settings::getInstance()->new_text_field( $field_obj );
				?>
				<input @click.prevent="saveConfiguration()" type="submit" class="button hrm-submit-button button-primary" name="requst" value="<?php _e( 'Save changes', 'hrm' ); ?>">
			</div>

		</div>
	</div>
</div>