<style type="text/css">
   #example_length{
        display: none;
    }
</style>
<div class="hrm-update-notification"></div>
<?php
if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {

    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}

$can_edit = hrm_user_can( 'manage_hrm_organization' );

$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'admin' );

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}

?>

<div id="hrm-admin-notice"></div>
<?php

$results = Hrm_Settings::getInstance()->hrm_query( 'hrm_notice' );

if( isset( $results['total_row'] ) ) {
    $total = $results['total_row'];
    unset( $results['total_row'] );
} else {
    $total = 0;
};

$body              = array();
$td_attr           = array();
$add_permission    = true;

foreach ( $results as $key => $value) {

    if ( $can_edit ) {
        $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$value->id.']" value="" type="checkbox">';
        $delete_text  = '<a href="#" class="hrm-delete" data-id='.$value->id.'>'.__( 'Delete', 'hrm' ).'</a>';
        $td_attr[][0] = 'class="hrm-table-checkbox"';
    } else {
        $del_checkbox = '<input disabled="disabled" class="hrm-single-checked" name="" value="" type="checkbox">';;
        $delete_text  = '';
    }

    if ( $add_permission ) {
        $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable hrm-title" data-table_option="hrm_notice" data-id='.$value->id.'>'.$value->title.'</a>
        <div class="hrm-title-action"><a href="#" class="hrm-editable hrm-edit" data-table_option="hrm_notice" data-id='.$value->id.'>'.__( 'Edit', 'hrm' ).'</a>'
        .$delete_text. '</div></div>';
    } else {
        $name_id = $value->title;
    }

    $user_info = get_userdata( $value->user_id );

    $body[] = array(
        $del_checkbox,
        $name_id,
        $value->description,
        $user_info->display_name,
        hrm_get_date2mysql( $value->date )
    );

}

if ( $can_edit ) {
    $checkbox = '<input class="hrm-all-checked" type="checkbox">';
} else {
    $checkbox = '<input disabled="disabled" class="hrm-all-checked" type="checkbox">';
}

$table = array();


$table['head'] = array(
    $checkbox,
    __( 'Title', 'hrm' ),
    __( 'Description', 'hrm' ),
    __( 'Signature', 'hrm' ),
    __( 'Date', 'hrm' )
);


$table['body']       = isset( $body ) ? $body : array();

$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['table']      = 'hrm_notice';
$table['action']     = 'hrm_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;
$table['page']       = $page;
$table['add_btn']     = $can_edit;
$table['delete_btn']  = $can_edit;


echo Hrm_Settings::getInstance()->table( $table );
//table
$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
$file_path = urlencode(__FILE__);
global $hrm_is_admin;
?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
            add_form_generator_action : 'add_form',
            add_form_apppend_wrap : 'hrm-admin-notice',
            class_name : 'Hrm_Admin',
            redirect : '<?php echo $url; ?>',
            function_name : 'admin_notice',
            page: '<?php echo $page; ?>',
            tab: '<?php echo $tab; ?>',
            subtab: '<?php echo $subtab; ?>',
            req_frm: '<?php echo $file_path; ?>',
            is_admin : '<?php echo $hrm_is_admin; ?>'
        };
    });
</script>




