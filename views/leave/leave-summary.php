
<?php

$search['leave_status'] = array(
    'type' => 'select',
    'option'   => hrm_Leave::getInstance()->leave_status(),
);

$search['table_option'] = 'hrm_leave';
$search['action'] = 'hrm_search';
echo hrm_Settings::getInstance()->get_serarch_form( $search, 'Leave');
?>

<div id="hrm_Leave_list"></div>
<?php

    $limit = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 10;
    if( isset( $_GET['type'] ) && ( $_GET['type'] == '_search' ) ) {
        $results = $this->search_query( $limit );
    } else {
        $results = $this->hrm_query( 'hrm_leave', $limit );
    }

    $total = $results['total_row'];
    unset( $results['total_row'] );

    $leave_types = $this->hrm_query('hrm_leave_type');
    unset( $leave_types['total_row'] );
    foreach ( $leave_types as $key => $leave_type ) {
        $leave_cat[$leave_type->id] = $leave_type->leave_type_name;
    }

    $leave_cat = isset( $leave_cat ) ? $leave_cat : array();

    $users = get_users( array( 'role' => 'hrm_employee' ));
    foreach ( $users as $key => $user ) {
        $user_info[$user->ID] = $user->display_name;
    }

    $user_info = isset( $user_info ) ? $user_info : array();


    $work_in_week = get_option( 'hrm_work_week' );

    $holidays = $this->hrm_query('hrm_holiday');
    unset( $holidays['total_row'] );

    $add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;

    $holiday_index = array();
    foreach ( $holidays as $key => $holiday ) {
        $holiday_index = array_merge( $holiday_index, maybe_unserialize( $holiday->index_holiday ) );
    }
    $leave_action_acess = hrm_user_can_access( $tab, $subtab, 'leave_summary_action', true );
    if ( $leave_action_acess === 'leave_summary_action' || $leave_action_acess ) {
        $action = true;
    } else {
        $action = false;
    }

    foreach ( $results as $key => $value) {
        $leave_type = isset( $leave_cat[$value->leave_type_id] ) ? $leave_cat[$value->leave_type_id] : '';
        if ( $add_permission ) {
          $name_id = '<a href="#" class="hrm-editable" data-user_id='.$value->emp_id.' data-table_option="hrm_leave" data-id='.$value->id.'>'.$leave_type.'<a>';
        } else {
          $name_id = $leave_type;
        }

        if ( $delete_permission ) {
                $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
        } else {
                $del_checkbox = '';
        }
        if ( $action ) {
            $leave_action_dropdown = array(
                'class'    => 'hrm-leave-action',
                'extra'    => array(
                    'data-leave_id' => $value->id,
                ),
                'option'   => hrm_Leave::getInstance()->leave_status(),
                'selected' => $value->leave_status
            );
            $leave_action = $this->select_field( 'leave_action', $leave_action_dropdown, $holiday_index );
        } else {
            $leave_action = __('Permission denied', 'hrm' );
        }


        $body[] = array(
            $del_checkbox,
            $name_id,
            '<a href="#">'. $user_info[$value->emp_id] . '</a>',
            get_date2mysql( $value->start_time ),
            get_date2mysql( $value->end_time ),
            hrm_Leave::getInstance()->leave_status( $value->leave_status ),
            $value->leave_comments,
            hrm_Leave::getInstance()->total_leave( $value->start_time, $value->end_time, $work_in_week, $holiday_index ),
            hrm_Leave::getInstance()->leave_take( $value->start_time, $value->end_time, $work_in_week, $holiday_index ),
            hrm_Leave::getInstance()->leave_remain( $value->start_time, $value->end_time, $work_in_week, $holiday_index ),
            $leave_action
        );

        $td_attr[] = array(
            'class="check-column"'
        );
    }
    $del_checkbox = ( $delete_permission ) ? '<input type="checkbox">' : '';
    $table['head'] = array(
        $del_checkbox,
        __('Leave Type', 'erhm' ),
        __('Employee Name', 'erhm' ),
        __('Start Date', 'erhm' ),
        __('End Date', 'erhm' ),
        __('Leave Status', 'erhm' ),
        __('Comments', 'erhm' ),
        __('Total Leave(day)', 'erhm' ),
        __('Leave Take(day)', 'erhm' ),
        __('Leave Remain(day)', 'erhm' ),
        __('Action', 'hrm' )
    );
    $table['body'] = isset( $body ) ? $body : '';


    $table['td_attr'] = isset( $td_attr ) ? $td_attr : '';
    $table['th_attr'] = array( 'class="check-column"' );
    $table['table_attr'] = array( 'class' => 'widefat' );

    $table['table'] = 'hrm_leave';
    $table['action'] = 'hrm_delete';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['tab'] = $tab;
    $table['subtab'] = $subtab;

    echo $this->table( $table );
    //table
    echo hrm_Settings::getInstance()->pagination( $total, $limit );
?>
<?php $url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm_Leave_list',
       class_name : 'hrm_Leave',
       function_name : 'assign',
       redirect : '<?php echo $url; ?>',
       user_info: '<?php echo json_encode( $user_info ); ?>',
       leave_cat: '<?php echo json_encode( $leave_cat ); ?>',
    };
});
</script>