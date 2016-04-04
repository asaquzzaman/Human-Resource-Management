<div class="hrm-update-notification"></div>

<div id="hrm-admin-list"></div>
<?php

$search_query = Hrm_Admin::getInstance()->get_employer();

$results           = $search_query->get_results();
$total             = $search_query->get_total();
$add_permission    = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;
$user              = wp_get_current_user();
$body              = array();
$td_attr           = array();

foreach ( $results as $id => $user_obj) {
    if ( $user->user_login ==  $user_obj->user_login ) {
        continue;
    }
	$flag = get_user_meta( $user_obj->ID, '_status', true );

	$status = ( $flag == 'yes' ) ? 'Enable' : 'Disable';
    $role = isset( $user_obj->roles[0] ) ? $user_obj->roles[0] : '';

    if ( $delete_permission ) {
        $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$user_obj->ID.']" value="" type="checkbox">';
        $delete_text  = '<a href="#" class="hrm-delete" data-id='.$user_obj->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
        $td_attr[][0] = 'class="hrm-table-checkbox"';
    } else {
        $del_checkbox = '';
        $delete_text  = '';
    }

    if ( $add_permission ) {
        $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable" data-action="user-role-edit-form-appear" data-id='.$user_obj->ID.'>'.$user_obj->user_login.'<a>
         <div class="hrm-title-action"><a href="#" data-action="user-role-edit-form-appear" class="hrm-editable hrm-edit" data-id='.$user_obj->ID.'>'.__( 'Edit', 'hrm' ).'</a>'
        .$delete_text. '</div></div>';
    } else {
        $name_id = $user_obj->user_login;
    }

    $employer_status = hrm_user_can_access( $page, $tab, $subtab, 'admin_list_employer_status' );

    if ( $employer_status ) {
        $admin_status_dropdown = array(
            'class'    => 'hrm-admin-status',
            'extra'    => array(
                'data-user_id' => $user_obj->ID,
            ),
            'option'   => array( 'yes' => __( 'Enable', 'hrm' ), 'no' => __('Disable', 'hrm') ),
            'selected' => $flag
        );
        $admin_status_dropdown = Hrm_settings::getInstance()->select_field( 'admin_staus', $admin_status_dropdown );
    } else {
        $admin_status_dropdown = __('Permission denied', 'hrm' );
    }

    if ( $delete_permission ) {
        $body[] = array(
            $del_checkbox,
            $name_id,
            $role,
            $user_obj->display_name,
            $admin_status_dropdown,
        );

    } else {
        $body[] = array(
            $name_id,
            $role,
            $user_obj->display_name,
            $admin_status_dropdown,
        );
    }
}

$table = array();
if ( $delete_permission ) {
    $table['head']   = array( '<input class="hrm-all-checked" type="checkbox">', __( 'Admin Name', 'hrm') , __( 'Role', 'hrm' ), __( 'Display Name', 'hrm' ), __( 'Status', 'hrm' ) );
} else {
    $table['head']   = array( __( 'Admin Name', 'hrm') , __( 'Role', 'hrm' ), __( 'Display Name', 'hrm' ), __( 'Status', 'hrm' ) );
}

$table['body']       = isset( $body ) ? $body : '';
$table['td_attr']    = isset( $td_attr ) ? $td_attr : '';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_job_title_option';
$table['action']     = 'hrm_user_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;
$table['page']       = $page;


echo Hrm_settings::getInstance()->table( $table );
$file_path = urlencode(__FILE__);

?>

<div id="hrm-create-user-wrap" title="<?php _e( 'Create a new user', 'hrm' ); ?>" style="display: none;">
    <div class="hrm-create-user-form-wrap">

        <div class="hrm-error"></div>

        <form action="" class="hrm-user-create-form">
            <?php wp_nonce_field( 'hrm_nonce', '_wpnonce' ); ?>
            <div class="hrm-field-wrap">
                <label><?php _e('Username', 'hrm'); ?></label>
                <input type="text" required name="admin_name">

            </div>
            <div class="hrm-field-wrap">
                <label><?php _e('First Name', 'hrm'); ?></label>
                <input type="text" name="first_name">

            </div>
            <div class="hrm-field-wrap">
                <label><?php _e('Last Name', 'hrm'); ?></label>
                <input type="text" name="last_name">

            </div>
            <div class="hrm-field-wrap">
                <label><?php _e('Email', 'hrm'); ?></label>
                <input type="email" required name="admin_email">

            </div>
            <div>
                <input class="button-primary" type="submit" value="Create User" name="create_user">
                <span></span>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    jQuery(function($) {
        $( "#hrm-create-user-wrap" ).dialog({
            autoOpen: false,
            modal: true,
            dialogClass: 'hrm-ui-dialog',
            width: 400,
            height: 'auto',
            position:['middle', 100],

        });
    });
</script>
<?php $url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
global $hrm_is_admin;
?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm-admin-list',
       redirect : '<?php echo $url; ?>',
       class_name : 'Hrm_Admin',
       function_name : 'admin_list',
       page: '<?php echo $page; ?>',
       tab: '<?php echo $tab; ?>',
       subtab: '<?php echo $subtab; ?>',
       req_frm: '<?php echo $file_path; ?>',
       is_admin : '<?php echo $hrm_is_admin; ?>'
    };
});
</script>