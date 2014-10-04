<?php

$limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 5;
if( isset( $_GET['type'] ) && ( $_GET['type'] == '_search' ) ) {
    $results = hrm_Settings::getInstance()->search_query( $limit );

} else {
    $results = hrm_Settings::getInstance()->hrm_query( 'hrm_location', $limit );
}

if( isset( $results['total_row'] ) ) {
    $total = $results['total_row'];
    unset( $results['total_row'] );
} else {
    $total = 0;
};

$field['name'] = array(
    'label' => __( 'Location Name', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert location name',
);
$field['city'] = array(
    'label' => __( 'City Name', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert city',
);
$field['phone'] = array(
    'label' => __( 'Phone Number', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert phone number',
);

$field['action'] = 'hrm_search';
$field['table_option'] = 'hrm_location_option';
$field['pagination_limit'] = $limit;

echo hrm_Settings::getInstance()->get_serarch_form( $field, 'Location');

foreach ( $results as $key => $value ) {
	if ( !isset( $value->name ) && empty( $value->name ) ) {
		continue;
	}
	?>
	<div id="hrm-visible-form-warp">
		<div class="hrm-search-head">
			<h2 id="hrm-searchLocationHeading"><?php echo 'Location ' . $value->name; ?></h2>
		</div>
		<?php
			if ( isset( $value->name ) && !empty( $value->name ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Name', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->name; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->name ) && !empty( $value->name ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Name', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->name; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->country_code ) && !empty( $value->country_code ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Country', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $this->get_country_by_code( $value->country_code ); ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->province ) && !empty( $value->province ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'State/Province', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->province; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->city ) && !empty( $value->city ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'City', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->city; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->address ) && !empty( $value->address ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Address', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->address; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>

		<?php
			if ( isset( $value->zip_code ) && !empty( $value->zip_code ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Zip/Postal Code', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->zip_code; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>

		<?php
			if ( isset( $value->phone ) && !empty( $value->phone ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Phone', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->phone; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>

		<?php
			if ( isset( $value->fax ) && !empty( $value->fax ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Fax', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->fax; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->notes ) && !empty( $value->notes ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Notes', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->notes; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
	</div>
	<?php
}