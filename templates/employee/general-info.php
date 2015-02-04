<?php
$general_info = Hrm_Admin::getInstance()->get_general_info();
$general_info = isset( $general_info['data'] ) ? $general_info['data'] : '' ;
?>

<div id="hrm-visible-form-warp">
	<div class="hrm-search-head">
		<h2 id="hrm-searchLocationHeading"><?php _e( 'General Information', 'hrm' ); ?></h2>
	</div>
	<?php
	if ( isset( $general_info['organization_name'] ) && !empty( $general_info['organization_name'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Organization Name', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['organization_name']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['tax_id'] ) && !empty( $general_info['tax_id'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Tax ID', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['tax_id']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['registration_number'] ) && !empty( $general_info['registration_number'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Registration Number', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['registration_number']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['phone'] ) && !empty( $general_info['phone'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Phone', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['phone']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['fax'] ) && !empty( $general_info['fax'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Fax', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['fax']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['addres_street_1'] ) && !empty( $general_info['addres_street_1'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Address Street 1', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['addres_street_1']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['address_street_2'] ) && !empty( $general_info['address_street_2'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Address Street 2', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['address_street_2']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['city'] ) && !empty( $general_info['city'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'City', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['city']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['state_province'] ) && !empty( $general_info['state_province'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'State/Province', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['state_province']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['zip'] ) && !empty( $general_info['zip'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Zip/Postal Code', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['zip']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['country'] ) && !empty( $general_info['country'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Country', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo hrm_Settings::getInstance()->get_country_by_code( $general_info['country'] ); ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>

	<?php
	if ( isset( $general_info['note'] ) && !empty( $general_info['note'] ) ) {
		?>
		<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Note', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $general_info['note']; ?></div><div class="hrm-clear"></div></div>
		<?php
	}
	?>
</div>



