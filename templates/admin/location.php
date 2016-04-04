<div class="hrm-update-notification"></div>

<?php
if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {

    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}


$results = Hrm_Settings::getInstance()->hrm_query( 'hrm_location' );

if( isset( $results['total_row'] ) ) {
    $total = $results['total_row'];
    unset( $results['total_row'] );
} else {
    $total = 0;
};

?>
<div class="hrm-location">

    <div class="hrm-main-content">
        <div id="hrm-admin-location"></div>

        <?php
        $add_permission    = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
        $delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;
        $body              = array();
        $td_attr           = array();

        foreach ( $results as $key => $value) {

            if ( $delete_permission ) {
                $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$value->id.']" value="" type="checkbox">';
                $delete_text  = '<a href="#" class="hrm-delete" data-id='.$value->id.'>'.__( 'Delete', 'hrm' ).'</a>';
                $td_attr[][0] = 'class="hrm-table-checkbox"';
            } else {
                $del_checkbox = '';
                $delete_text  = '';
            }

            if ( $add_permission ) {
                $name_id = '<div class="hrm-title-wrap"><a href="#" class="hrm-editable" data-table_option="hrm_location_option" data-id='.$value->id.'>'.$value->name.'</a>
                 <div class="hrm-title-action"><a href="#" class="hrm-editable hrm-edit" data-table_option="hrm_location_option" data-id='.$value->id.'>'.__( 'Edit', 'hrm' ).'</a>'
                 .$delete_text. '</div></div>';
            } else {
                $name_id = $value->name;
            }

            if ( $delete_permission ) {
                $body[] = array(
                    $del_checkbox,
                    $name_id,
                    $value->city,
                    hrm_Settings::getInstance()->get_country_by_code( $value->country_code ),
                    $value->phone,
                );
            } else {
                $body[] = array(
                    $name_id,
                    $value->city,
                    hrm_Settings::getInstance()->get_country_by_code( $value->country_code ),
                    $value->phone,
                );
            }
        }

        $table = array();

        if ( $delete_permission ) {
            $table['head'] = array( '<input class="hrm-all-checked" type="checkbox">', __( 'Name', 'hrm' ), __( 'City', 'hrm' ), __( 'Country', 'hrm' ), __( 'Phone', 'hrm' ) );
        } else {
            $table['head'] = array( __( 'Name', 'hrm' ), __( 'City', 'hrm' ), __( 'Country', 'hrm' ), __( 'Phone', 'hrm' ) );
        }

        $table['body']       = isset( $body ) ? $body : '';
        $table['td_attr']    = isset( $td_attr ) ? $td_attr : '';
        $table['th_attr']    = array();
        $table['table_attr'] = array( 'class' => 'widefat' );
        $table['table']      = 'hrm_location_option';
        $table['action']     = 'hrm_delete';
        $table['table_attr'] = array( 'class' => 'widefat' );
        $table['tab']        = $tab;
        $table['subtab']     = $subtab;
        $table['page']       = $page;
        $table['search']     = __( 'Search Mode', 'hrm' );

        echo Hrm_Settings::getInstance()->table( $table );

    ?>

    </div>
</div>

<?php
$file_path = urlencode(__FILE__);
$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
global $hrm_is_admin;
?>

<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
            add_form_generator_action : 'add_form',
            add_form_apppend_wrap : 'hrm-admin-location',
            class_name : 'Hrm_Admin',
            redirect : '<?php echo $url; ?>',
            function_name : 'admin_location',
            page: '<?php echo $page; ?>',
            tab: '<?php echo $tab; ?>',
            subtab: '<?php echo $subtab; ?>',
            req_frm: '<?php echo $file_path; ?>',
            is_admin : '<?php echo $hrm_is_admin; ?>'
        };
    });
</script>