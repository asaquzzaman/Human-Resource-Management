<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'file' );

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}
?>
<div id="hrm-file-index">
<?php
$user_id = get_current_user_id();
$search['doc_search'] = array(
    'label' => __( 'Search', 'hrm' ),
    'type'  => 'text',
    'value' => isset( $_POST['doc_search'] ) ? $_POST['doc_search'] : '',
    'desc'  => __( 'You can search by file name, title or description', 'hrm'),
);
$search['action'] = 'file_search';

echo Hrm_settings::getInstance()->get_serarch_form( $search, 'Admin');

$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();

if( isset( $_POST['action'] ) && $_POST['action'] == 'file_search' ) {
    $post = $_POST;
    $search_satus = true;
    $file_posts  = HRM_File::getInstance()->search_file_posts_inbox( $post, $limit, $pagenum, $user_id );
} else {
    $file_posts  = HRM_File::getInstance()->get_file_posts_inbox( $limit, $pagenum, $user_id );
    $search_satus = false;
}

$share_files       = HRM_File::getInstance()->get_share_files();
$posts             = $file_posts->posts;
$files             = $share_files->posts;
$total             = $file_posts->found_posts;
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

    if ( $add_permission ) {
        $post_title = '<a href="#" class="hrm-file-edit"  data-id='.$post->ID.'>'.$post->post_title.'<a>';
    } else {
        $post_title = $post->post_title;
    }

    if ( $delete_permission ) {
        $del_checkbox = '<input name="hrm_check['.$post->ID.']" value="" type="checkbox">';
    } else {
        $del_checkbox = '';
    }

    $body[] = array(
        $del_checkbox,
        $file_url,
        $assign_to,
        $post_title,
        $post->post_content,
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}

$table                 = array();
$del_checkbox          = ( $delete_permission ) ? '<input type="checkbox">' : '';
$table['head']         = array( $del_checkbox, __( 'File', 'hrm' ), __( 'Share User', 'hrm' ), __( 'Title', 'hrm' ), __( 'Description', 'hrm' ) );
$table['body']         = isset( $body ) ? $body : array();
$table['td_attr']      = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']      = array( 'class="check-column"' );
$table['table_attr']   = array( 'class' => 'widefat' );
$table['table']        = 'hrm_job_title_option';
$table['action']       = 'delete_inbox_file';
$table['tab']          = $tab;
$table['subtab']       = $subtab;
$table['add_btn_name'] = false;


echo Hrm_Settings::getInstance()->table( $table );
echo Hrm_settings::getInstance()->pagination( $total, $limit, $pagenum );
$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
$file_path = urlencode(__FILE__);

?>
</div>
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
       limit: '<?php echo $limit; ?>',
       search_satus: '<?php echo $search_satus; ?>',
       user_id: '<?php echo $user_id; ?>'
    };
});
</script>


