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

<div id="hrm-client-list"></div>
<?php

$results           = HRM_Client::getInstance()->get_clients();

$add_permission    = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;
//var_dump( $results->posts ); die();
foreach ( $results->results as $key => $client ) {

	if ( $delete_permission ) {
        $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$client->ID.']" value="'.$client->ID.'" type="checkbox">';
        $delete_text  = '<a href="#" class="hrm-delete" data-id='.$client->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
        $td_attr[][0] = 'class="hrm-table-checkbox"';
    } else {
        $del_checkbox = '';
        $delete_text  = '';
    }

    if ( $add_permission ) {
        $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable"  data-id='.$client->ID.'>'.$client->display_name.'</a>
         <div class="hrm-title-action"><a href="#" class="hrm-editable hrm-edit" data-action="client_edit" data-id='.$client->ID.'>'.__( 'Edit', 'hrm' ).'</a>'
         .$delete_text. '</div></div>';
    } else {
        $name_id = $client->display_name;
    }

	$joining_date = hrm_get_date2mysql( get_user_meta( $client->ID, '_joining_date', true ) );
	$project_list = '';
	ob_start();
	?>
	<ul>
		<li>
			<strong><?php _e( 'Phone  ', 'hrm' ); ?></strong>
			<?php echo get_user_meta( $client->ID, '_phone', true ); ?>
		</li>
        <li>
        	<strong><?php _e( 'Fax  ', 'hrm' ); ?></strong>
        	<?php echo get_user_meta( $client->ID, '_fax', true ); ?>
        </li>
        <li>
        	<strong><?php _e( 'E-mail  ', 'hrm' ); ?></strong>
        	<?php echo $client->user_email; ?>
        </li>
        <li>
        	<strong><?php _e( 'Addres Street 1  ', 'hrm' ); ?></strong>
        	<?php echo get_user_meta( $client->ID, '_addres_street_1', true ); ?>
        </li>
        <li>
        	<strong><?php _e( 'Addres Street 2  ', 'hrm' ); ?></strong>
        	<?php echo get_user_meta( $client->ID, '_address_street_2', true ); ?>
        </li>
        <li>
        	<strong><?php _e( 'City  ', 'hrm' ); ?></strong>
        	<?php echo get_user_meta( $client->ID, '_city', true ); ?>
        </li>
        <li>
        	<strong><?php _e( 'State Province  ', 'hrm' ); ?></strong>
        	<?php echo get_user_meta( $client->ID, '_state_province', true ); ?>
        </li>
        <li>
        	<strong><?php _e( 'Zip  ', 'hrm' ); ?></strong>
        	<?php echo get_user_meta( $client->ID, '_zip', true ); ?>
        </li>
        <li>
        	<strong><?php _e( 'Country  ', 'hrm' ); ?></strong>
        	<?php echo Hrm_Settings::getInstance()->get_country_by_code( get_user_meta( $client->ID, '_country', true ) ); ?>
        </li>
	</ul>
	<?php
	$contact_details = ob_get_clean();
    $client_projects = Hrm_Client::getInstance()->get_projects_by_client( $client->ID );
    ob_start();
    echo '<ul>';
    foreach ( $client_projects->posts as $key => $project ) {
        ?>
        <li>
            <?php echo $project->post_title; ?>
        </li>
        <?php
    }
    echo '</ul>';
    $project_list = ob_get_clean();
	$description = get_user_meta( $client->ID, 'description', true );

    if ( $delete_permission ) {
        $body[] = array(
            $del_checkbox,
            $name_id,
            $joining_date,
            $project_list,
            $contact_details,
            $description
        );
    } else {
        $body[] = array(
           	$name_id,
            $joining_date,
            $project_list,
            $contact_details,
            $description
        );
    }

    $task_id = '';
}

$table['body'] = isset( $body ) ? $body : array();

if ( $delete_permission ) {
    $table['head'] = array(
        '<input class="hrm-all-checked" type="checkbox">',
        __('Name', 'hrm' ),
        __('Joining Date', 'hrm'),
        __( 'Projects', 'hrm' ),
        __( 'Contact Details', 'hrm' ),
        __( 'Description', 'hrm' ),
    );
} else {
    $table['head'] = array(
        __('Name', 'hrm' ),
        __('Joining Date', 'hrm'),
        __( 'Projects', 'hrm' ),
        __( 'Contact Details', 'hrm' ),
        __( 'Description', 'hrm' )
    );
}

$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['table_attr'] = array( 'class' => 'widefat' );
$table['action']     = 'client_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;
$table['page']       = $page;


echo Hrm_Settings::getInstance()->table( $table );

$file_path = urlencode(__FILE__);

$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );

global $hrm_is_admin;
?>

<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm-client-list',
       redirect : '<?php echo $url; ?>',
       class_name : 'HRM_Client',
       function_name : 'new_client_form',
       page: '<?php echo $page; ?>',
       tab: '<?php echo $tab; ?>',
       subtab: '<?php echo $subtab; ?>',
       req_frm: '<?php echo $file_path; ?>',
       is_admin: '<?php echo $hrm_is_admin; ?>',
    };
});
</script>

<script type="text/javascript">
    jQuery(function($) {
        $( ".hrm-deposit-dialog" ).dialog({
            autoOpen: false,
            modal: true,
            dialogClass: 'hrm-ui-dialog',
            width: 485,
            height: 425,
            position:['middle', 100],
            zIndex: 99999,

        });
    });


</script>

