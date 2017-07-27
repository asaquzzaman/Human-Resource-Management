<div class="metabox-holder hrm-attendance-user-serch-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Search', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="main hrm-attendance-user-searach-main">
				<?php 

					$field_obj = array(
						'label' =>  __( 'From', 'hrm' ),
						'type'  => 'text',
						'value' => '',
						'class' => 'hrm-date-picker-from',
						'extra' => array(
							'v-hrm-datepicker'
						)
					);

					echo Hrm_Settings::getInstance()->text_field( 'punch_from', $field_obj );

					$field_obj = array(
						'label' =>  __( 'to', 'hrm' ),
						'type'  => 'text',
						'value' => '',
						'class' => 'hrm-date-picker-to',
						'extra' => array(
							'v-hrm-datepicker'
						)
					);

					echo Hrm_Settings::getInstance()->text_field( 'punch_to', $field_obj );

				?>
				<button class="button button-primary"><?php _e( 'Search', 'hrm' ); ?></button>
				<div class="hrm-clear"></div>
			</div>
		</div>
	</div>
</div>