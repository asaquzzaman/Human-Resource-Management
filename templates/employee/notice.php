<?php

$pagenum     = hrm_pagenum();
$limit       = '20000';

if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
    $post = $_POST;
    $results = Hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
    $search_status = true;

} else {
    $results = Hrm_Settings::getInstance()->hrm_query( 'hrm_notice', $limit, $pagenum );
    $search_status = false;
}

$total = $results['total_row'];
unset( $results['total_row'] );
//search form
$search['title'] = array(
    'label' => __( 'Title', 'hrm' ),
    'type' => 'text',
    'desc' => 'please insert title',
);

$search['type'] = array(
    'type' => 'hidden',
    'value' => '_search'
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_notice';
echo hrm_Settings::getInstance()->get_serarch_form( $search, 'Notice');

foreach ( $results as $key => $value ) {
	if ( !isset( $value->title ) && empty( $value->title ) ) {
		continue;
	}
	?>
	<div id="hrm-visible-form-warp" class="postbox">
		<div class="hrm-search-head">
			<h3><?php echo 'Notice ' . $value->title; ?></h3>
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
				<div class="hrm-text-wrap"><strong class="hrm-text-label"><?php _e( 'Date', 'hrm' ); ?></strong><div class="hrm-text-info"><?php echo hrm_get_date2mysql( $value->date ); ?></div><div class="hrm-clear"></div></div>
				<?php
			}
		?>
	</div>
	<?php
}
$file_path = urlencode(__FILE__);
global $hrm_is_admin;
?>

<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
			page: '<?php echo $page; ?>',
			tab: '<?php echo $tab; ?>',
			subtab: '<?php echo $subtab; ?>',
			req_frm: '<?php echo $file_path; ?>',
			limit: '<?php echo $limit; ?>',
			search_status: '<?php echo $search_status; ?>',
			is_admin : '<?php echo $hrm_is_admin; ?>'
        };
    });
</script>