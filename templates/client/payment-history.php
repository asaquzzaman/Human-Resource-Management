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

<div id="hrm-client-payment"></div>
<?php

$results           = HRM_Client::getInstance()->get_clients();

$add_permission    = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;
//var_dump( $results->posts ); die();
foreach ( $results->results as $key => $client ) {

	if ( false ) {
        $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$client->ID.']" value="'.$client->ID.'" type="checkbox">';
        $delete_text  = '<a href="#" class="hrm-delete" data-id='.$client->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
        $td_attr[][0] = 'class="hrm-table-checkbox"';
    } else {
        $del_checkbox = '';
        $delete_text  = '';
    }

    if ( false ) {
        $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable"  data-id='.$client->ID.'>'.$client->display_name.'</a>
         <div class="hrm-title-action">'
         .$delete_text. '</div></div>';
    } else {
        $name_id = $client->display_name;
    }

    $client_projects = Hrm_Client::getInstance()->get_projects_by_client( $client->ID );

    ob_start();
    echo '<ul>';
    foreach ( $client_projects->posts as $key => $project ) {
        $currency_symbol = get_post_meta( $project->ID, '_currency_symbol', true );
        $table = 'hrm_client_partial_payment';
        $condition = array(
            'client_id'  => $client->ID,
            'project_id' => $project->ID
        );
        $partial_payments = Hrm_Settings::getInstance()->conditional_query_val( $table, '*', $condition );
        unset( $partial_payments['total_row'] );
        $project_budget = get_post_meta( $project->ID, '_budget', true );
        $budget_utilize = get_post_meta( $project->ID, '_project_budget_utilize', true );
        $client_pay     = HRM_Client::getInstance()->client_total_pay( $partial_payments );
        $client_due     = $project_budget - $client_pay;
        ?>
        <li id="hrm-prarial-li-wrap-<?php echo $project->ID; ?>">
            <div><?php echo $project->post_title; ?></div>
            <div><?php echo '<strong>Budget </strong>' . $currency_symbol . $project_budget; ?></div>
            <div><?php echo '<strong>Budget Utilize </strong>' . $currency_symbol . $budget_utilize; ?></div>
            <div class="hrm-paratial-client-summary">
                 <?php echo HRM_Client::getInstance()->partial_client_payemnt_summery( $currency_symbol, $client_pay, $client_due ); ?>
            </div>
            <div>
				<a href="#" class="hrm-popup-desc-leave-cat" data-task_id="<?php echo $project->ID; ?>"><?php echo 'Partial payment details'; ?></a>
	            <div title="<?php echo 'Partial payment details'; ?>" class="hrm-payment-details-dialog" id="hrm-cat-popup-desc-wrap-<?php echo $project->ID; ?>" style="display: none;">
                    <?php echo HRM_Client::getInstance()->partial_payment_table( $partial_payments ); ?>
	            </div>
			</div>
        </li>
        <?php
    }
    echo '</ul>';
    $project_list = ob_get_clean();

    if ( $delete_permission ) {
        $body[] = array(
            $del_checkbox,
            $name_id,
            $project_list,
        );
    } else {
        $body[] = array(
           	$name_id,
            $project_list,
        );
    }

    $task_id = '';
}
$table = array();
$table['body'] = isset( $body ) ? $body : array();

if ( $delete_permission ) {
    $table['head'] = array(
        '<input class="hrm-all-checked" type="checkbox">',
        __('Client Name', 'hrm' ),
        __( 'Projects', 'hrm' ),

    );
} else {
    $table['head'] = array(
        __('Client Name', 'hrm' ),
        __( 'Projects', 'hrm' ),
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
       add_form_apppend_wrap : 'hrm-client-payment',
       redirect : '<?php echo $url; ?>',
       class_name : 'HRM_Client',
       function_name : 'new_client_partial_payment_form',
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
        $( ".hrm-payment-details-dialog" ).dialog({
            autoOpen: false,
            modal: true,
            dialogClass: 'hrm-ui-dialog',
            width: 800,
            height: 425,
            position:['middle', 100],
            zIndex: 99999,

        });
    });
</script>

