<?php

$limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 2;
if( isset( $_GET['type'] ) && ( $_GET['type'] == '_search' ) ) {

    $results = hrm_Settings::getInstance()->search_query( $limit );
} else {
    $results = hrm_Settings::getInstance()->hrm_query( 'hrm_notice', $limit );
}

$total = $results['total_row'];
unset( $results['total_row'] );
//search form
$search['title'] = array(
    'label' => __( 'Title', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert title',
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_notice';
echo hrm_Settings::getInstance()->get_serarch_form( $search, 'Notice');

foreach ( $results as $key => $value ) {
	if ( !isset( $value->title ) && empty( $value->title ) ) {
		continue;
	}
	?>
	<div id="hrm-visible-form-warp">
		<div class="hrm-search-head">
			<h2 id="hrm-searchLocationHeading"><?php echo 'Notice ' . $value->title; ?></h2>
		</div>
		<?php
			if ( isset( $value->title ) && !empty( $value->title ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Title', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->title; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->description ) && !empty( $value->description ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Description', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $value->description; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->user_id ) && !empty( $value->user_id ) ) {
				$user_info = get_userdata( $value->user_id );
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Signature', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo $user_info->display_name; ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
		<?php
			if ( isset( $value->date ) && !empty( $value->date ) ) {
				?>
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'State/Province', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo get_date2mysql( $value->date ); ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
	</div>
	<?php
}