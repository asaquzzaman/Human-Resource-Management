<!-- default instance $instance = hrm_Admin::getInstance(); -->
<?php
if ( ! hrm_user_can_access( $tab, $subtab, 'view' ) ) {

    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}

$country = Hrm_Settings::getInstance()->country_list();
$search['name'] = array(
    'label' => __( 'Name', 'hrm' ),
    'type' => 'text',
    'desc' => __( 'Location search by name', 'hrm' ),
);

$search['city'] = array(
    'label' => __( 'City', 'hrm' ),
    'type' => 'text',
    'desc' => __( 'Location search by city', 'hrm' ),
);

$search['country'] = array(
    'label' =>  __( 'Country', 'hrm' ),
    'type' => 'select',
    'option'=> $country,
    'selected' => isset( $_GET['country'] ) ? $_GET['country'] : '',
    'desc' => __( 'Location search by country', 'hrm' ),
);

$search['phone'] = array(
    'label' => __( 'Phone Number', 'hrm' ),
    'type' => 'text',
    'desc' => __( 'Location search by phone number', 'hrm' ),
);
$search['table_option'] = 'hrm_location_option';
$search['action'] = 'hrm_search';

echo Hrm_settings::getInstance()->get_serarch_form( $search, __( 'Location', 'hrm' ) );
?>
 <?php

    $limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 10;
    if( isset( $_GET['type'] ) && ( $_GET['type'] == '_search' ) ) {
        $results = Hrm_Settings::getInstance()->search_query( $limit );

    } else {
        $results = Hrm_Settings::getInstance()->hrm_query( 'hrm_location', $limit );
    }

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
        $add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
        $delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;

        foreach ( $results as $key => $value) {
            if ( $add_permission ) {
                $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_location_option" data-id='.$value->id.'>'.$value->name.'<a>';
            } else {
                $name_id = $value->name;
            }

            if ( $delete_permission ) {
                $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
            } else {
                $del_checkbox = '';
            }

            $body[] = array(
                $del_checkbox,
                $name_id,
                $value->city,
                hrm_Settings::getInstance()->get_country_by_code( $value->country_code ),
                $value->phone,
            );

            $td_attr[] = array(
                'class="check-column"'
            );
        }

        $del_checkbox = ( $delete_permission ) ? '<input type="checkbox">' : '';
        $table['head'] = array( $del_checkbox, 'Name', 'City', 'Country', 'Phone' );
        $table['body'] = isset( $body ) ? $body : '';


        $table['td_attr'] = isset( $td_attr ) ? $td_attr : '';

        $table['th_attr'] = array( 'class="check-column"' );

        $table['table_attr'] = array( 'class' => 'widefat' );

        $table['table'] = 'hrm_location_option';
        $table['action'] = 'hrm_delete';
        $table['table_attr'] = array( 'class' => 'widefat' );
        $table['tab'] = $tab;
        $table['subtab'] = $subtab;

        echo Hrm_Settings::getInstance()->table( $table );

    ?>

    </div>

   <?php

        echo Hrm_Settings::getInstance()->pagination( $total, $limit );
   ?>
</div>

<?php $url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>

<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-admin-location',
           class_name : 'Hrm_Admin',
           redirect : '<?php echo $url; ?>',
           function_name : 'admin_location',
        };
    });
</script>