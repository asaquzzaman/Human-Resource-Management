<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'file' );

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}

if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {
    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}

?>
<div class="hrm-update-notification"></div>
<?php

$file_posts  = HRM_File::getInstance()->get_share_file_posts();
$share_files = HRM_File::getInstance()->get_share_files();

$posts       = $file_posts->posts;
$files       = $share_files->posts;
$total       = $file_posts->found_posts;

?>

<div id="hrm-file">

<div id="hrm-file-form-wrap"></div>

<?php
$add_permission    = true;
$delete_permission = true;

foreach ( $posts as $key => $post ) {
	$file_url = '';
	foreach ( $files as $key => $file ) {
		if ( $file->post_parent ==  $post->ID ) {
			$file_info = HRM_File::getInstance()->get_file( $file->ID );
			$file_url .= sprintf( '<a href="%1$s" target="_blank"><img class="hrm-file-tag" src="%2$s" alt="%3$s" /></a>', $file_info['url'], $file_info['thumb'], esc_attr( $file_info['name'] ) );
		}
	}

	$assign_to = HRM_File::getInstance()->get_assing_user( $post->ID );

    if ( $delete_permission ) {
        $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$post->ID.']" value="" type="checkbox">';
        $delete_text  = '<a href="#" class="hrm-delete" data-id='.$post->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
        $td_attr[][0] = 'class="hrm-table-checkbox"';
    } else {
        $del_checkbox = '';
        $delete_text  = '';
    }

    if ( $add_permission ) {
        $post_title = '<div class="hrm-title-wrap"><a href="#" class="hrm-file-edit hrm-title" data-table_option="hrm_notice" data-id='.$post->ID.'>'.$post->post_title.'</a>
        <div class="hrm-title-action"><a href="#" class="hrm-file-edit hrm-edit" data-table_option="hrm_notice" data-id='.$post->ID.'>'.__( 'Edit', 'hrm' ).'</a>'
        .$delete_text. '</div></div>';
    } else {
        $post_title = $post->post_title;
    }

    if ( $delete_permission ) {
        $body[] = array(
            $del_checkbox,
            $post_title,
            $file_url,
            $assign_to,
            $post->post_content,
        );
    } else {
        $body[] = array(
            $post_title,
            $file_url,
            $assign_to,
            $post->post_content,
        );
    }
}

    $table = array();

    if ( $delete_permission ) {
        $table['head'] = array(
            '<input class="hrm-all-checked" type="checkbox">',
            __( 'Title', 'hrm' ),
            __( 'File', 'hrm' ),
            __( 'Share User', 'hrm' ),
            __( 'Description', 'hrm' )
        );
    } else {
        $table['head'] = array(
            __( 'Title', 'hrm' ),
            __( 'File', 'hrm' ),
            __( 'Share User', 'hrm' ),
            __( 'Description', 'hrm' )
        );
    }

    $table['body']       = isset( $body ) ? $body : array();
    $table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['table']      = 'hrm_job_title_option';
    $table['action']     = 'file_delete';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['tab']        = $tab;
    $table['subtab']     = $subtab;
    $table['page']       = $page;


echo Hrm_Settings::getInstance()->table( $table );
//echo Hrm_settings::getInstance()->pagination( $total, $limit, $pagenum );
$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
$file_path = urlencode(__FILE__);

?>
</div>
<?php global $hrm_is_admin; ?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm-file-form-wrap',
       redirect : '<?php echo $url; ?>',
       class_name : 'HRM_File',
       function_name : 'file_upload_form',
       page: '<?php echo $page; ?>',
       tab: '<?php echo $tab; ?>',
       subtab: '<?php echo $subtab; ?>',
       req_frm: '<?php echo $file_path; ?>',
       is_admin: '<?php echo $hrm_is_admin; ?>',
    };
});
</script>

