<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'leave' );

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}
if ( ( isset( $_GET['action_search'] ) && $_GET['action_search'] ) )  {
    $search_status = true;
    $search_post = get_user_meta( get_current_user_id(), '_hrm_search_data', true );
} else if ( isset( $_POST['action_search'] ) ) {
    $search_status = true;
    $search_post = $_POST;
} else if ( isset( $_POST['search_status'] ) && $_POST['search_status'] ) {
    $search_status = true;
    $search_post = get_user_meta( get_current_user_id(), '_hrm_search_data', true );
} else {
    $search_status = false;
}
if ( $search_status && $search_post['emp_id'] == -1 ) {
    $summery = false;
} else {
    $summery = true;
}
if ( $search_status ) {
    ?>
    <div class="hrm-update-notification"></div>
    <?php
} else {
    ?>
    <div class="updated"><p><?php  _e( 'Logged in user leave summery', 'hrm' ); ?></p></div>
    <div class="hrm-update-notification"></div>
    <?php
}
?>
<div id="hrm-admin-leave-summary">
    <?php

    $users = get_users();
    $user_info['-1'] = __( 'All', 'hrm' );
    foreach ( $users as $key => $user ) {
        $user_info[$user->ID] = $user->display_name;
    }

    $user_info = isset( $user_info ) ? $user_info : array();

    $leave_types = Hrm_Settings::getInstance()->hrm_query('hrm_leave_type');

    unset( $leave_types['total_row'] );
    $leave_cat[-1] = __( 'All', 'hrm' );
    foreach ( $leave_types as $key => $leave_type ) {
        $leave_cat[$leave_type->id] = $leave_type->leave_type_name;
    }

    $leave_cat = isset( $leave_cat ) ? $leave_cat : array();

    $search['emp_id'] = array(
        'label'    => __( 'Employee Name', 'hrm' ),
        'required' => 'required',
        /*'extra' => array(
            'data-hrm_validation' => true,
            'data-hrm_required' => true,
            'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
        ),*/
        'class'  => 'hrm-chosen',
        'type'   => 'select',
        'option' => $user_info,
        'selected' => $search_status ? $search_post['emp_id'] : get_current_user_id(),
    );

    $search['type_id'] = array(
        'label'    => __( 'Leave Type', 'hrm' ),
        'type'     => 'select',
        'required' => 'required',
        'class'    => 'hrm-chosen',
        'option'   => $leave_cat,
        'selected' => $search_status ? $search_post['type_id'] : '-1'
    );

    $search['start_time'] = array(
        'label'  => __( 'From', 'hrm' ),
        'class'  => 'hrm-datepicker-from',
        'type'   => 'text',
        'value' => $search_status ? hrm_date2mysql( $search_post['start_time'] ) : ''
    );

    $search['end_time'] = array(
        'label'  => __( 'To', 'hrm' ),
        'class'  => 'hrm-datepicker-to',
        'type'   => 'text',
        'value' => $search_status ? hrm_date2mysql( $search_post['end_time'] ) : ''
    );

    $search['visibility']   = $search_status ? true : false;
    $search['table_option'] = 'hrm_leave';
    $search['action'] = 'hrm_search';
    echo hrm_Settings::getInstance()->get_serarch_form( $search, __( 'Leave', 'hrm') );
    ?>
    <div id="hrm_Leave_list"></div>
    <?php

    $work_in_week = get_option( 'hrm_work_week' );
    $holidays = Hrm_Settings::getInstance()->hrm_query('hrm_holiday');
    unset( $holidays['total_row'] );

    $holiday_index = array();
    foreach ( $holidays as $key => $holiday ) {
        $holiday_index = array_merge( $holiday_index, maybe_unserialize( $holiday->index_holiday ) );
    }

    $add_permission = hrm_user_can_access( $page, $tab, $subtab, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $page, $tab, $subtab, 'delete' ) ? true : false;
    $body              = array();
    $td_attr           = array();

    if ( hrm_user_can_access( $page, $tab, $subtab, 'leave_summary_action' ) ) {
        $action = true;
    } else {
        $action = false;
    }

    $total_leave_count = 0;
    $pagenum     = hrm_pagenum();
    $limit       = hrm_result_limit();

    if( $search_status ) {
        $get_leave_users = Hrm_Leave::getInstance()->leave_emp_search_query( $search_post, $limit, $pagenum );
        update_user_meta( get_current_user_id(), '_hrm_search_data',
            array( 'table_option' => 'hrm_leave', 'emp_id' => $search_post['emp_id'], 'type_id' => $search_post['type_id'], 'start_time' => $search_post['start_time'], 'end_time' => $search_post['end_time'] ) );
    } else{
        $get_leave_users = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', array( 'DISTINCT emp_id' ), array( 'emp_id' => get_current_user_id() ), false );
        update_user_meta( get_current_user_id(), '_hrm_search_data', false );
    }

    $total           = $get_leave_users['total_row'];
    unset( $get_leave_users['total_row'] );

    $get_distinct_users = array();

    foreach ( $get_leave_users as $key => $get_leave_user ) {
        $get_distinct_users[] = $get_leave_user->emp_id;
    }
    if( $search_status ) {
        $results  = Hrm_Leave::getInstance()->leave_search_query( $search_post,  $get_distinct_users );
    } else {
        $results  = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', '*', array( 'emp_id' => $get_distinct_users ) );
    }

    $leaves = array();
    unset( $results['total_row'] );

    foreach ( $results as $leave_record ) {
        $leaves[$leave_record->leave_type_id][] = $leave_record;
    }

    if ( ! count( $leaves ) ) {
        $table = array();
        $table['head'] = array(
            '<input class="hrm-all-checked" type="checkbox">',
            __('Employee', 'hrm' ),
            __('Start', 'hrm' ),
            __('End', 'hrm' ),
            __('Status', 'hrm' ),
            __('Details', 'hrm' ),
           // __('Comments', 'erhm' ),
           // __('Leave', 'erhm' ), // <div class="hrm-head-notice">(include holiday and leave week)</div>
            //__('Action', 'hrm' )
        );


        $table['search']    = __( 'Search Mode', 'hrm' );
        $table['search_mode']    = true;
        $table['delete_button'] = false;
        $table['td_attr']    = isset( $td_attr ) ? $td_attr : '';
        $table['th_attr']    = isset( $th_attr ) ? $th_attr : '';
        $table['table_attr'] = array( 'class' => 'widefat' );
        $table['table']      = 'hrm_leave';
        $table['action']     = 'hrm_delete';
        $table['tab']        = $tab;
        $table['subtab']     = $subtab;
        $table['page']     = $page;
        $table['data_table'] = false;
        $table['pagination'] = false;
        $table['body']       = isset( $body ) ? $body : array();
        echo Hrm_Settings::getInstance()->table( $table );
    }

    $del_checkbox         = ( $delete_permission ) ? '<input class="hrm-all-checked" type="checkbox">' : '';
    $table                = array();
    $table['search_mode'] = true;
    $table['search']      = __( 'Search Mode', 'hrm' );

    foreach ( $leaves as $leave_id => $leave_objs ) {
        $total_leave_count = 0;
        $leave_type = isset( $leave_cat[$leave_id] ) ? $leave_cat[$leave_id] : '';
        ?>
        <div class="">
            <?php
            $table['before'] = "<div class=\"hrm-search-head\">
                <h3>Leave for $leave_type</h3>
            </div>";

            foreach ( $leave_objs as $leave_obj ) {
                $user_emp = get_user_by( 'id', $leave_obj->emp_id );
                if ( $delete_permission ) {
                    $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$leave_obj->id.']" value="" type="checkbox">';
                    $delete_text  = '<a href="#" class="hrm-delete" data-id='.$leave_obj->id.'>'.__( 'Delete', 'hrm' ).'</a>';
                } else {
                    $del_checkbox = '';
                    $delete_text  = '';
                }

                if ( $add_permission ) {
                    $name_id = '<div class="hrm-title-wrap">'.$user_emp->display_name.'
                    <div class="hrm-title-action">'
                    .$delete_text. '</div></div>';
                } else {
                    $name_id = $user_emp->display_name;
                }

                if ( $action ) {
                    $leave_action_dropdown = array(
                        'class'    => 'hrm-leave-action',
                        'extra'    => array(
                            'data-leave_id' => $leave_obj->id,
                        ),
                        'option'   => hrm_Leave::getInstance()->leave_status(),
                        'selected' => $leave_obj->leave_status
                    );
                    $leave_action = Hrm_Settings::getInstance()->select_field( 'leave_action', $leave_action_dropdown, $holiday_index );
                } else {
                    $leave_action = hrm_Leave::getInstance()->leave_status( $leave_obj->leave_status );
                }


                $individual_leave_total = hrm_Leave::getInstance()->total_leave( $leave_obj->start_time, $leave_obj->end_time, $work_in_week, $holiday_index );
                $total_leave_count      = $individual_leave_total + $total_leave_count;

                $details = sprintf('<a href="#" class="hrm-popup-desc" data-task_id="%s">%s</a>', $leave_obj->id, __( 'Details', 'hrm' ) );

                $leave_start = hrm_get_date2mysql( $leave_obj->start_time );
                $leave_end  = hrm_get_date2mysql( $leave_obj->end_time );

                if ( $delete_permission ) {
                    $body[] = array(
                        $del_checkbox,
                        $name_id,
                        $leave_start,
                        $leave_end,
                        $leave_action,
                        $details
                    );
                } else {
                    $body[] = array(
                        $name_id,
                        $leave_start,
                        $leave_end,
                        $leave_action,
                        $details
                    );
                }

                ?>
                    <div title="<?php _e( 'Individual Leave details', 'hrm' ); ?>" class="hrm-leave-details-dialog" id="hrm-popup-desc-wrap-<?php echo $leave_obj->id; ?>" style="display: none;">
                        <table class="widefat">
                            <tr>
                                <th><?php _e( 'Type', 'hrm' ); ?></th>
                                <td><?php echo $leave_type; ?></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Employee', 'hrm' ); ?></th>
                                <td><?php echo $user_emp->display_name; ?></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Start', 'hrm' ); ?></th>
                                <td><?php echo $leave_start; ?></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'End', 'hrm' ); ?></th>
                                <td><?php echo $leave_end; ?></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Status', 'hrm' ); ?></th>
                                <td><?php echo hrm_Leave::getInstance()->leave_status( $leave_obj->leave_status ); ?></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Comments', 'hrm' ); ?></th>
                                <td><?php echo $leave_obj->leave_comments; ?></td>
                            </tr>
                            <tr>
                                <th><?php _e( 'Leave <div class="hrm-head-notice">(include holiday and leave week)</div>', 'hrm' ); ?></th>
                                <td><?php echo $individual_leave_total; ?></td>
                            </tr>
                        </table>
                    </div>
                <?php
            }

            $table['head'] = array(
                '<input class="hrm-all-checked" type="checkbox">',
                __('Employee', 'hrm' ),
                __('Start', 'hrm' ),
                __('End', 'hrm' ),
                __('Status', 'hrm' ),
                __('Details', 'hrm' ),
               // __('Comments', 'erhm' ),
               // __('Leave', 'erhm' ), // <div class="hrm-head-notice">(include holiday and leave week)</div>
                //__('Action', 'hrm' )
            );


            $table['td_attr']    = isset( $td_attr ) ? $td_attr : '';
            $table['th_attr']    = isset( $th_attr ) ? $th_attr : '';
            $table['table_attr'] = array( 'class' => 'widefat' );
            $table['table']      = 'hrm_leave';
            $table['action']     = 'hrm_delete';
            $table['tab']        = $tab;
            $table['subtab']     = $subtab;
            $table['page']     = $page;
            $table['data_table'] = false;
            $table['body']       = isset( $body ) ? $body : '';
            $table['pagination'] = false;
            echo Hrm_Settings::getInstance()->table( $table );
            $body = array();

            $table = array(
                'search'        => false,
                'search_mode'   => false,
                'add_btn_name'  => false,
                'delete_button' => true,
            );

            $searc_leave_type = Hrm_Settings::getInstance()->edit_query( 'hrm_leave_type', $leave_id );

            $Balance          = intval( $searc_leave_type['entitlement'] - $total_leave_count );
            $leave_for        = $searc_leave_type['leave_type_name'];
            if ( ! $summery ) {
                continue;
            }
            ?>
            <a href="#" class="hrm-popup-desc-leave-cat" data-task_id="<?php echo $leave_id; ?>"><?php _e( "$leave_type Leave Summary" ); ?></a>
            <div title="<?php _e( "$leave_type Leave details", 'hrm' ); ?>" class="hrm-leave-details-dialog" id="hrm-cat-popup-desc-wrap-<?php echo $leave_id; ?>" style="display: none;">
                <table class="hrm-sub-table widefat">
                    <tr>
                        <td class="hrm-leave-cal hrm-leave-cal-tob" colspan="8"><strong><?php _e( 'Total leave take', 'hrm' ); ?></strong></td>
                        <td colspan="1"><?php echo $total_leave_count; ?></td>
                    </tr>


                    <tr>
                        <td class="hrm-leave-cal" colspan="8"><strong><?php  _e( 'Leave Balance', 'hrm' ); ?></strong></td>
                        <td colspan="1"><?php echo  $Balance; ?></td>
                    </tr>

                    <tr>
                        <td class="hrm-leave-cal" colspan="8"><strong><?php _e( 'Leave Duration', 'hrm' ); ?></strong></td>
                        <td colspan="1"><?php echo hrm_get_date2mysql( $searc_leave_type['entitle_from'] ) . '<div>to </div>' . hrm_get_date2mysql( $searc_leave_type['entitle_to'] ); ?></td>
                    </tr>

                    <tr>
                        <td class="hrm-leave-cal hrm-leave-cal-bottom" colspan="8"><strong><?php _e( 'Total leave for '. $leave_for, 'hrm' ); ?></strong></td>
                        <td class="hrm-leave-cal-bottom" colspan="1"><span><?php echo $searc_leave_type['entitlement'];?></span></td>
                    </tr>
                </table>
            </div>
            <?php
        echo '</div>';
    }

    $url                 = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
    $file_path           = urlencode(__FILE__);
    echo hrm_Settings::getInstance()->pagination( $total, $limit, $pagenum );
    global $hrm_is_admin;
    ?>
</div>
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
       page: '<?php echo $page; ?>',
       tab: '<?php echo $tab; ?>',
       subtab: '<?php echo $subtab; ?>',
       req_frm: '<?php echo $file_path; ?>',
       limit: '<?php echo $limit; ?>',
       search_status: '<?php echo $search_status; ?>',
       is_admin : '<?php echo $hrm_is_admin; ?>'
    };
});
</script>

<script type="text/javascript">
    jQuery(function($) {
        $( ".hrm-leave-details-dialog" ).dialog({
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


