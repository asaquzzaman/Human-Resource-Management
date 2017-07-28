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
							'v-hrm-datepicker',
							':value' => 'punch_in_date'
						)
					);

					echo Hrm_Settings::getInstance()->text_field( 'punch_in', $field_obj );

					$field_obj = array(
						'label' =>  __( 'to', 'hrm' ),
						'type'  => 'text',
						'value' => '',
						'class' => 'hrm-date-picker-to',
						'extra' => array(
							'v-hrm-datepicker',
							':value' => 'punch_out_date'
						)
					);

					echo Hrm_Settings::getInstance()->text_field( 'punch_out', $field_obj );

					$field_obj = array(
						'label' =>  __( 'Users', 'hrm' ),
						'type'  => 'select',
						'option' => Hrm_Employeelist::getInstance()->get_employee_drop_down(),
						'extra' => array(
							'v-model' => 'search_user_id'
						)
					);

					echo Hrm_Settings::getInstance()->select_field( 'user_id', $field_obj );

				?>
				<button @click.prevent="search()" class="button button-primary"><?php _e( 'Search', 'hrm' ); ?></button>
				<div class="hrm-clear"></div>
			</div>
		</div>
	</div>
</div>