<div class="hrm-error-notification"></div>
<div id="hrm-admin-role"></div>
<?php
$jk = get_option( 'pro_test_role' );

//hidden form

global $wp_roles;

if ( !$wp_roles ) {
    $wp_roles = new WP_Roles();
}

$role_names = $wp_roles->get_names();
$wp_built_in_role = array( 'administrator', 'editor', 'author', 'contributor', 'subscriber', 'hrm_employee' );

$add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
$current_user_role = hrm_current_user_role();

foreach ( $role_names as $name => $display_name) {

    if ( $current_user_role == $name || $name == 'hrm_employee'  ) {
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

    $td_attr[] = array(
        'class="check-column"'
    );
}
$del_checkbox        = ( $delete_permission ) ? '<input type="checkbox">' : '';
$table['head']       = array( $del_checkbox, 'User Role', 'Display Name' );
$table['body']       = isset( $body ) ? $body : array();


$table['td_attr']    = isset( $td_attr ) ? $td_attr : '';
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );

$table['action']     = 'role_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;

echo Hrm_Settings::getInstance()->table( $table );

?>
<?php $url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-admin-role',
           class_name : 'Hrm_Admin',
           redirect : '<?php echo $url; ?>',
           function_name : 'admin_role_form',
        };
    });
</script>