<div class="hrm-error-notification"></div>

    <div id="hrm-leave-holiday"></div>


    <?php


    $limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 10;
    if( isset( $_GET['type'] ) && ( $_GET['type'] == '_search' ) ) {
        $results = $this->search_query( $limit );
    } else {
        $results = $this->hrm_query( 'hrm_holiday', $limit );
    }

    $total = $results['total_row'];
    unset( $results['total_row'] );
    $add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
    foreach ( $results as $key => $value) {
        if ( $add_permission ) {
          $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_holiday" data-id='.$value->id.'>'.$value->name.'<a>';
        } else {
          $name_id = $value->name;
        }

        if ( $delete_permission ) {
                $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
        } else {
                $del_checkbox = '';
        }

        $value->length = ( $value->length == 'full' ) ? 'Full Day' : 'Half Day';
        $body[] = array(
            $del_checkbox,
            $name_id,
            get_date2mysql( $value->from ),
            get_date2mysql( $value->to ),
            $value->description,
            $value->length
        );

        $td_attr[] = array(
            'class="check-column"'
        );
    }
    $del_checkbox = ( $delete_permission ) ? '<input type="checkbox">' : '';
    $table['head'] = array(
        $del_checkbox,
        __('Name', 'hrm' ),
        __('From', 'hrm'),
        __('To', 'hrm'),
        __('Description','hrm'),
        __('Full Day/Half Day','hrm')
    );
    $table['body'] = isset( $body ) ? $body : '';


    $table['td_attr'] = isset( $td_attr ) ? $td_attr : '';
    $table['th_attr'] = array( 'class="check-column"' );
    $table['table_attr'] = array( 'class' => 'widefat' );

    $table['table'] = 'hrm_holiday';
    $table['action'] = 'hrm_delete';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['tab'] = $tab;
    $table['subtab'] = $subtab;

    echo hrm_Settings::getInstance()->table( $table );
    //table
    echo hrm_Settings::getInstance()->pagination( $total, $limit );
?>
<?php $url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-leave-holiday',
           class_name : 'hrm_Leave',
           redirect : '<?php echo $url; ?>',
           function_name : 'holiday',
        };
    });
</script>