<?php
$pagenum     = hrm_pagenum();
$limit       = '20000';

if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
    $post = $_POST;
    $results = Hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
    $search_satus = true;

} else {
    $results = Hrm_Settings::getInstance()->hrm_query( 'hrm_location', $limit, $pagenum );
    $search_satus = false;
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
    'value' => isset( $_POST['name'] ) ? $_POST['name'] : '',
);
$field['city'] = array(
    'label' => __( 'City Name', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert city',
    'value' => isset( $_POST['city'] ) ? $_POST['city'] : '',
);
$field['phone'] = array(
    'label' => __( 'Phone Number', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert phone number',
    'value' => isset( $_POST['phone'] ) ? $_POST['phone'] : '',
);
$field['type'] = array(
    'type' => 'hidden',
    'value' => '_search'
);
$field['action'] = 'hrm_search';
$field['table_option'] = 'hrm_location_option';


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
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Country', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo hrm_Settings::getInstance()->get_country_by_code( $value->country_code ); ?></div><div class="hrm-clear"></div></div>
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

$file_path = urlencode(__FILE__);
?>

<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
			page: '<?php echo $page; ?>',
			tab: '<?php echo $tab; ?>',
			subtab: '<?php echo $subtab; ?>',
			req_frm: '<?php echo $file_path; ?>',
			limit: '<?php echo $limit; ?>',
			search_satus: '<?php echo $search_satus; ?>',
			subtab: true
        };
    });
</script>