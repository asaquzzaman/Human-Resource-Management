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

<div id="hrm-admin-role"></div>
<?php

//hidden form

global $wp_roles;

if ( !$wp_roles ) {
    $wp_roles = new WP_Roles();
}

$role_names = $wp_roles->get_names();
$wp_built_in_role = array( 'administrator', 'editor', 'author', 'contributor', 'subscriber', 'hrm_employee' );

$add_permission = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;
$current_user_role = hrm_current_user_role();

foreach ( $role_names as $name => $display_name) {
    if ( $current_user_role == $name ) {
        continue;
    }

    if ( $delete_permission ) {
        $del_checkbox = '<input name="hrm_check['.$name.']" value="" type="checkbox">';
    } else {
        $del_checkbox = '';
    }

    if ( $add_permission ) {
        $name_id = '<a data-role_name="'.$name.'" data-action="get_role" data-display_name="'.$display_name.'" class="hrm-editable" href="#">'.$name.'</a>';
    } else {
        $name_id = $name;
    }
    $body[] = array(
        $del_checkbox,
        $name_id,
        $display_name
    );
}

$del_checkbox             = ( $delete_permission ) ? '<input type="checkbox">' : '';
$table['head']            = array( $del_checkbox, 'User Role', 'Display Name' );
$table['body']            = isset( $body ) ? $body : array();


$table['td_attr']         = isset( $td_attr ) ? $td_attr : '';
$table['th_attr']         = array( 'class="check-column"' );
$table['table_attr']      = array( 'class' => 'widefat' );

$table['action']          = 'role_delete';
$table['table_attr']      = array( 'class' => 'widefat' );
$table['tab']             = $tab;
$table['subtab']          = $subtab;
$table['page']            = $page;
$table['add_button']      = false;
//$table['delete_button'] = false;
$table['pagination']      = false;

echo Hrm_Settings::getInstance()->table( $table );
$file_path = urlencode(__FILE__);
$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
global $hrm_is_admin;
?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-admin-role',
           class_name : 'HRM_File',
           redirect : '<?php echo $url; ?>',
           function_name : 'role_permission',
           tab: '<?php echo $tab; ?>',
           page: '<?php echo $page; ?>',
           tab: '<?php echo $tab; ?>',
           subtab: '<?php echo $subtab; ?>',
           req_frm: '<?php echo $file_path; ?>',
           is_admin : '<?php echo $hrm_is_admin; ?>'
        };
    });
</script>