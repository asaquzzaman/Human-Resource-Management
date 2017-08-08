<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Holidays', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="hrm-attendance-configuration" id="hrm-hidden-form">
				<form action="">
				<?php
					$field = array (
						'label'    => __( 'Saturday', 'hrm' ),
						'type'     => 'select',
						'selected' => isset( $data['data']['saturday'] ) ? $data['data']['saturday'] : '',
						'id'       => 'hrm-work-week-saturday',
					    'option'   => array(
					        'full' => 'Full Day',
					        'non'  => 'Non-Working Day'
					    ),
					    'field_elements' => array(
					    	'v-model' => 'saturday',
					    	'name'    => 'saturday',
					    	'@change.prevent' => 'saveWorkWeek()'
					    ),

					);

					echo Hrm_Settings::getInstance()->new_select_field( $field );

					$field = array(
					    'label' => __( 'Sunday', 'hrm' ),
					    'type' => 'select',
					    'selected' => isset( $data['data']['sunday'] ) ? $data['data']['sunday'] : '',
					    'id' => 'hrm-work-weed-sunday',
					    'option' => array(
					        'full' => 'Full Day',
					        'non' => 'Non-Working Day'
					    ),

					    'field_elements' => array(
					    	'v-model' => 'sunday',
					    	'name'    => 'sunday',
					    	'@change.prevent' => 'saveWorkWeek()'
					    ),

					);

					echo Hrm_Settings::getInstance()->new_select_field( $field );

					$field = array(
						'label'    => __( 'Monday', 'hrm' ),
						'type'     => 'select',
						'selected' => isset( $data['data']['monday'] ) ? $data['data']['monday'] : '',
						'id'       => 'hrm-work-weed-monday',
					    'option' => array(
					        'full' => 'Full Day',
					        'non'  => 'Non-Working Day'
					    ),
					    'field_elements' => array(
					    	'v-model' => 'monday',
					    	'name'    => 'monday',
					    	'@change.prevent' => 'saveWorkWeek()'
					    ),
					);

					echo Hrm_Settings::getInstance()->new_select_field( $field );

					$field = array(
						'label'    => __( 'Tuesday', 'hrm' ),
						'type'     => 'select',
						'selected' => isset( $data['data']['tuesday'] ) ? $data['data']['tuesday'] : '',
						'id'       => 'hrm-work-week-tuesday',
					    'option' => array(
					        'full' => 'Full Day',
					        'non' => 'Non-Working Day'
					    ),

					    'field_elements' => array(
					    	'v-model' => 'tuesday',
					    	'name'    => 'tuesday',
					    	'@change.prevent' => 'saveWorkWeek()'
					    ),
					);

					echo Hrm_Settings::getInstance()->new_select_field( $field );

					$field = array(
					    'label' => __( 'Wednesday', 'hrm' ),
					    'type' => 'select',
					    'selected' => isset( $data['data']['wednesday'] ) ? $data['data']['wednesday'] : '',
					    'id' => 'hrm-work-week-wednesday',
					    'option' => array(
					        'full' => 'Full Day',
					        'non' => 'Non-Working Day'
					    ),
					    'field_elements' => array(
					    	'v-model' => 'wednesday',
					    	'name'    => 'wednesday',
					    	'@change.prevent' => 'saveWorkWeek()'
					    ),
					);

					echo Hrm_Settings::getInstance()->new_select_field( $field );

					$field = array(
						'label'    => __( 'Thursday', 'hrm' ),
						'type'     => 'select',
						'selected' => isset( $data['data']['thursday'] ) ? $data['data']['thursday'] : '',
						'id'       => 'hrm-work-week-thursday',
					    'option' => array(
					        'full' => 'Full Day',
					        'non'  => 'Non-Working Day'
					    ),
					    'field_elements' => array(
					    	'v-model' => 'thursday',
					    	'name'    => 'thursday',
					    	'@change.prevent' => 'saveWorkWeek()'
					    ),
					);

					echo Hrm_Settings::getInstance()->new_select_field( $field );

					$field = array(
						'label'    => __( 'Friday', 'hrm' ),
						'type'     => 'select',
						'selected' => isset( $data['data']['friday'] ) ? $data['data']['friday'] : '',
						'id'       => 'hrm-work-week-friday',
					    'option' => array(
					        'full' => 'Full Day',
					        'non'  => 'Non-Working Day'
					    ),
					    'field_elements' => array(
					    	'v-model' => 'friday',
					    	'name'    => 'friday',
					    	'@change.prevent' => 'saveWorkWeek()'
					    ),
					);

					echo Hrm_Settings::getInstance()->new_select_field( $field );

					?>
					<!-- <input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="<?php _e( 'Save changes', 'hrm' ); ?>"> -->
				</form>
			</div>

		</div>
	</div>
</div>