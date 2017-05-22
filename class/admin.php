<?php

class Hrm_Admin {

    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new Hrm_Admin();
        }

        return self::$_instance;
    }


    function __construct() {

        add_action( 'init', array($this, 'admin_init_action') );
        add_filter( 'hrm_search_parm', array( $this, 'project_search_parm' ), 10, 1 );
        add_action( 'text_field_before_input', array($this, 'task_budget_crrency_symbol'), 10, 2 );
    }

    function get_employer() {

        $arg = array(
            'meta_key'       => 'hrm_admin_level',
            'meta_value'     => 'admin',
            'meta_compare'   => '=',
            'count_total'    => true,
        );

        return new WP_User_Query( $arg );
    }

    function task_budget_crrency_symbol( $name, $element ) {
        if ( $name == 'task_budget' ) {
            $project_id = isset( $element['extra']['project_id'] ) ? $element['extra']['project_id'] : false;
            if ( $project_id ) {
                $currency_symbol = get_post_meta( $project_id, '_currency_symbol', true );
                ?>
                <div style="float: left;"><?php echo $currency_symbol; ?></div>
                <?php
            }
        }
    }

    function get_general_info() {
        return get_option( 'hrm_general_info' );
    }

    function task_complete( $task_id ) {
        $update = update_post_meta( $task_id, '_completed', 1 );

        if ( $update ) {
            return true;
        } else {
            return false;
        }
    }

    function task_incomplete( $task_id ) {
        $update = update_post_meta( $task_id, '_completed', 0 );

        if ( $update ) {
            return true;
        } else {
            return false;
        }
    }

    function admin_notice( $field_value = null ) {
        $user_id = get_current_user_id();
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        if ( $field_value !== null ) {
            $notice['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }

        $notice['title'] = array(
            'label' =>  __( 'Title', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_value['title'] ) ? $field_value['title'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $notice['description'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'class' => 'hrm-admin-notice-field',
            'type' => 'textarea',
            'value' => isset( $field_value['description'] ) ? $field_value['description'] : '',
        );

        $notice['user_id'] = array(
            'type' => 'hidden',
            'value' => isset( $user_id ) ? $user_id : '',
        );
        $notice['date'] = array(
            'label' =>  __( 'date', 'hrm' ),
            'type' => 'text',
            'class' => 'hrm-datepicker',
            'value' => isset( $field_value['date'] ) ? $field_value['date'] : '',
        );

        $notice['action'] = 'ajax_referer_insert';
        $notice['table_option'] = 'hrm_notice';
        $notice['header'] = 'Notice';
        $notice['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $notice );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function project_search_parm( $data ) {
        return $data;
    }

    function project_delete( $project_id ) {
        global $wpdb;
        $table = $wpdb->prefix . 'hrm_user_role';
        $wpdb->delete( $table, array( 'project_id' => $project_id ), array('%d') );

        $project_delete = wp_delete_post( $project_id, true );
        if ( $project_delete ) {
            return true;
        } else {
            return false;
        }
    }

    function sub_task_form( $post = null ) {
        $project_id = isset( $_POST['project_id'] ) ? $_POST['project_id'] : '';
        if ( gettype( $post ) !== 'object' && isset( $_POST['task_id'] ) ) {
            $form['task_id'] = array(
                'type' => 'hidden',
                'value' => $_POST['task_id'],
            );
        } else {
            $form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $post->ID ) ? $post->ID : '',
            );
        }
        $form['title'] = array(
            'label' => __( 'Task title', 'hrm' ),
            'value' => isset( $post->post_title ) ? $post->post_title : '',
            'type' => 'text'
        );

        $form['description'] = array(
            'label' => __( 'Description', 'hrm' ),
            'value' => isset( $post->post_content ) ? $post->post_content : '',
            'type' => 'textarea'
        );

        $start_date = isset( $post->ID ) ? get_post_meta( $post->ID, '_start_date', true ) : '';
        $start_date = !empty( $start_date ) ? date_i18n( 'M j, Y', strtotime( $start_date ) ) : '';


        $form['start_date'] = array(
            'label' => __( 'Start date', 'hrm' ),
            'value' => $start_date,
            'type' => 'text',
            'class' => 'hrm-datepicker'
        );

        $end_date = isset( $post->ID ) ? get_post_meta( $post->ID, '_end_date', true ) : '';
        $end_date = !empty( $end_date ) ? date_i18n( 'M j, Y', strtotime( $end_date ) ) : '';

        $form['end_date'] = array(
            'label' => __( 'End date', 'hrm' ),
            'value' => $end_date,
            'type' => 'text',
            'class' => 'hrm-datepicker'
        );

        $status = isset( $post->ID ) ? get_post_meta( $post->ID, '_status', true ) : '';

        $form['status'] = array(
            'label' => __( 'Status', 'hrm' ),
            'type'=> 'select',
            'option'=> array( 'running' => __( 'Running', 'hrm'), 'completed' => 'Completed'),
            'selected' => !empty( $status ) ? $status : '',
        );

        $assigned = $this->get_project_assigned_user( $project_id );
        $bb_assign = isset( $post->ID ) ? get_post_meta( $post->ID, '_assigned', true ) : '';
        //$bb_assign = !empty( $bb_assign ) ? $bb_assign : array();

        foreach ( $assigned as $user_id => $assign ) {
            $check[] = array(
                'label' => $assign['name'],
                'value' => $user_id,
                'checked' => $bb_assign,
            );
        }

        $form['assigned'] = array(
            'label' => __( 'Assigned', 'hrm' ),
            'type' => 'radio',
            'desc' => 'Choose co-workers',
            'fields' => $check,
        );

        $form['action'] = 'add_sub_task';
        $form['header'] = __('Add Sub Task', 'hrm');

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function task_form( $post = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        if ( gettype( $post ) !== 'object' && isset( $_POST['project_id'] ) ) {
            $project_id = $_POST['project_id'];
            $form['project_id'] = array(
                'type' => 'hidden',
                'value' => isset( $_POST['project_id'] ) ? $_POST['project_id'] : '',
            );
        } else {
            $project_id = $post->post_parent;
            $form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $post->ID ) ? $post->ID : '',
            );
        }

        $form['title'] = array(
            'label' => __( 'Task title', 'hrm' ),
            'value' => isset( $post->post_title ) ? $post->post_title : '',
            'type' => 'text',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $form['description'] = array(
            'label' => __( 'Description', 'hrm' ),
            'class' => 'hrm-task-des-field',
            'value' => isset( $post->post_content ) ? $post->post_content : '',
            'type' => 'textarea'
        );

        $start_date = isset( $post->ID ) ? get_post_meta( $post->ID, '_start_date', true ) : '';
        $start_date = !empty( $start_date ) ? date_i18n( 'M j, Y', strtotime( $start_date ) ) : '';

        $form['start_date'] = array(
            'label' => __( 'Start date', 'hrm' ),
            'value' => $start_date,
            'type' => 'text',
            'class' => 'hrm-datepicker'
        );

        $end_date = isset( $post->ID ) ? get_post_meta( $post->ID, '_end_date', true ) : '';
        $end_date = !empty( $end_date ) ? date_i18n( 'M j, Y', strtotime( $end_date ) ) : '';

        $form['end_date'] = array(
            'label' => __( 'End date', 'hrm' ),
            'value' => $end_date,
            'type' => 'text',
            'class' => 'hrm-datepicker'
        );

        $status = isset( $post->ID ) ? get_post_meta( $post->ID, '_completed', true ) : '';

        $form['status'] = array(
            'label' => __( 'Status', 'hrm' ),
            'type'=> 'select',
            'option'=> array( '0' => __( 'Running', 'hrm'), '1' => 'Completed'),
            'selected' => !empty( $status ) ? $status : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $assigned = $this->get_project_assigned_user( $project_id );
        $bb_assign = isset( $post->ID ) ? get_post_meta( $post->ID, '_assigned', true ) : '';
        $bb_assign = !empty( $bb_assign ) ? $bb_assign : 0;

        foreach ( $assigned as $user_id => $assign ) {
            $check[] = array(
                'label' => $assign['name'],
                'value' => $user_id,
                'checked' =>  ( $user_id == $bb_assign) ? $user_id : '',
            );
        }

        $form['assigned'] = array(
            'label' => __( 'Assigned', 'hrm' ),
            'type' => 'radio',
            'desc' => 'Choose co-workers',
            'fields' => $check,

        );

        $currency_symbol = get_post_meta( $project_id, '_currency_symbol', true );
        $total_budget = get_post_meta( $project_id, '_budget', true );
        $budget_utilize = get_post_meta( $project_id, '_project_budget_utilize', true );
        $budget_remain = $total_budget - $budget_utilize;

        if ( $total_budget ) {
            $form['task_budget'] = array(
                'label' => __( 'Budget', 'hrm' ),
                'type' => 'text',
                'placeholder' => __( 'Insert value should be less than ' . $budget_remain, 'hrm' ),
                'extra' => array( 'project_id' => $project_id ),
                'value' => isset( $post->ID ) ? get_post_meta( $post->ID, '_task_budget', true ) : '',
                'desc' => sprintf( 'Total budget: %1s, Budget utilize: %2s, Budget remain %3s', $currency_symbol . $total_budget, $currency_symbol . $budget_utilize, $currency_symbol . $budget_remain ),
            );
        }


        $form['action'] = 'add_task';
        $form['header'] = __('Add Task', 'hrm');
        $form['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }


    function get_project_assigned_user( $project_id ) {

        global $wpdb;

        $user_list = array();
        $table = $wpdb->prefix . 'hrm_user_role';
        $project_users = $wpdb->get_results( $wpdb->prepare( "SELECT user_id, role FROM {$table} WHERE project_id = %d", $project_id ) );

        if ( $project_users ) {
            foreach ($project_users as $row ) {
                $user = get_user_by( 'id', $row->user_id );

                if ( !is_wp_error( $user ) && $user ) {
                    $user_list[$user->ID] = array(
                        'id' => $user->ID,
                        'email' => $user->user_email,
                        'name' => $user->display_name,
                        'role' => $row->role
                    );
                }
            }
        }

        return $user_list;

    }

    function get_task_title( $results, $task_id = array(), $project_id, $add_permission, $currency_symbol ) {
        if ( !is_array( $task_id ) ) {
            return;
        }
        ob_start();
        foreach ($results as $key => $result ) {

            if ( !in_array( $result->ID, $task_id ) ) {
                continue;
            }
            $task_budget = get_post_meta( $result->ID, '_task_budget', true );
            $task_budget = empty( $task_budget ) ? '0' : $task_budget;
            $assign_to   = get_post_meta($result->ID, '_assigned', true);
            $user        = get_user_by( 'id', $assign_to );
            $url         = hrm_task_assing_user_url( 'hrm_pim', 'my_task', $assign_to );
            ?>

            <div class="hrm-task-wrap">
                <div class="hrm-task-title-wrap">
                    <div class="hrm-task-content">
                        <a href="#" class="hrm-editable hrm-task-title" data-task="task" data-action="task_edit"  data-id="<?php echo $result->ID; ?>"><strong><?php echo $result->post_title; ?></strong></a>
                        <div>
                            <strong><?php _e( 'Task Budget: ' ); ?></strong><?php echo $currency_symbol . $task_budget; ?>
                        </div>
                        <div>
                            <strong><?php _e( 'Assign to: ', 'hrm' ); ?></strong>
                            <a href="<?php echo $url; ?>"><?php echo isset( $user->display_name ) ? $user->display_name : ''; ?></a>
                        </div>
                        <div>
                            <strong><?php _e( 'Status: ', 'hrm' ); ?></strong>
                            <?php echo $this->get_task_status( $result->ID ); ?>
                        </div>
                    </div>
                    <div class="hrm-task-avatar">
                        <a href="<?php echo $url; ?>"><?php echo isset( $user->ID ) ? get_avatar( $user->ID, '32' ) : ''; ?></a>
                    </div>
                    <div style="clear: both;"></div>
                </div>

                <div class="hrm-task-status-desc">
                    <ul>
                        <li>
                            <div data-task_assign="<?php echo $assign_to; ?>" data-task_id="<?php echo $result->ID; ?>" data-project_id="<?php echo $project_id; ?>" class="hrm-delete-task button-secondary"><?php _e( 'Delete', 'cpm' ); ?></div>
                        </li>
                        <li>
                            <div class="button-secondary hrm-task-edit hrm-editable hrm-task-title" data-task="task" data-action="task_edit"  data-id="<?php echo $result->ID; ?>"><?php _e( 'Edit', 'hrm' ); ?></div>
                        </li>
                        <li>
                            <div class="button-secondary hrm-popup-desc" data-task_id="<?php echo $result->ID; ?>"><?php _e( 'Description', 'hrm' ); ?></div>
                        </li>
                    </li>
                </div>
            </div>

            <div title="<?php echo $result->post_title; ?>" class="hrm-deposit-dialog" id="hrm-popup-desc-wrap-<?php echo $result->ID; ?>" style="display: none;">
                <?php echo $result->post_content; ?>
            </div>

            <?php
        }

        if ( $add_permission ) {
            ?>

            <div>
                <a href="#" class="hrm-add-button button-primary" data-task="task" data-project_id="<?php echo esc_attr( $project_id ); ?>"><?php _e( 'Add Task', 'ehrn' ); ?></a>
            </div>
            <?php

        }
        return ob_get_clean();
    }

    function get_task_description( $results, $task_id = array() ) {

        if ( !is_array( $task_id ) ) {
            return;
        }

        ob_start();
        foreach ($results as $key => $result ) {
            if ( !in_array( $result->ID, $task_id ) ) {
                continue;
            }
            ?>

            <div><?php echo $result->post_content; ?></div>
            <?php
        }

        return ob_get_clean();
    }

    function get_sub_task_title( $results, $tasks_id = array(), $project_id, $add_permission ) {

        if ( !is_array( $tasks_id ) ) {
            return;
        }

        ob_start();
        foreach ( $tasks_id as $task_id ) {
            sprintf( '<div class="hrm-sub-task-wrap-%s">', $task_id );
            foreach ( $results as $key => $result ) {
                if ( $task_id == $result->ID ) {
                    ?>
                    <a href="#"><?php echo $result->post_title; ?></a>
                    <?php
                }

                if ( $result->post_parent == $task_id && $result->post_type == 'hrm_sub_task' ) {
                    ?>
                    <div><a href="#" class="hrm-editable" data-project_id="<?php echo esc_attr( $project_id ); ?>" data-action="sub_task_edit" data-id="<?php echo $result->ID; ?>" ><?php echo $result->post_title; ?> </a></div>

                    <?php
                }
            }

            if ( $add_permission ) {
                ?>
                <div><a href="#" class="hrm-add-button" data-project_id="<?php echo esc_attr( $project_id ); ?>" data-sub_task="sub_task" data-task_id="<?php echo esc_attr( $task_id ); ?>"><?php _e( 'Add more', 'ehrn' ); ?></a></div>
                <?php
            }

            echo '</div>';
        }

        return ob_get_clean();
    }

    function get_sub_task_description( $results, $task_id = array() ) {
        if ( !is_array( $task_id ) ) {
            return;
        }
        ob_start();
        foreach ( $results as $key => $result ) {
            if ( $result->post_type != 'hrm_sub_task' || !in_array( $result->post_parent, $task_id ) ) {
                continue;
            }

            ?>
            <div><?php echo $result->post_content; ?></div>
            <?php
        }
        return ob_get_clean();
    }


    function get_projects( $tab, $subtab, $limit = '-1' ) {

        $args = array(
            'posts_per_page' => $limit,
            'post_type'      => 'hrm_project',
            'post_status'    => 'publish',
        );

        if ( hrm_user_can_access( $page, $tab, $subtab, $subtab.'_assign_project' ) ) {
            add_filter('posts_join', array( $this, 'project_role_table' ) );
            add_filter( 'posts_where', array( $this, 'get_project_role' ), 10, 2 );
        }

        if ( isset( $_POST['type'] ) && $_POST['type'] == '_search' ) {
            $args['s'] = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
            $args['post_type'] = array( 'hrm_project', 'hrm_task' );
        }

        $projects_query = new WP_Query( $args );
        $posts['found_posts'] = $projects_query->found_posts;

        $projects  = $projects_query->get_posts();
        $tasks     = $this->get_tasks();
        $sub_tasks = $this->get_sub_tasks();

        $posts['posts'] = array_merge( $projects, $tasks, $sub_tasks );

        remove_filter( 'posts_where', array($this, 'get_project_where'), 10, 2 );
        remove_filter( 'posts_where', array($this, 'get_project_role'), 10, 2 );
        remove_filter( 'posts_join', array($this, 'project_role_table'), 10, 2 );

        return $posts;
    }

    function get_project_role( $where, &$wp_query ) {
        $current_user_id = get_current_user_id();
        $where .= " AND rl.user_id = $current_user_id";
        return $where;
    }

    function project_role_table($join) {
        global $wp_query, $wpdb;
        $table = $wpdb->prefix . 'hrm_user_role';
        $join .= "LEFT JOIN $table AS rl  ON $wpdb->posts.ID = rl.project_id";
        return $join;
    }

    function get_tasks( $limit = -1 ) {
        $args = array(
            'posts_per_page' => $limit,
            'post_type' => 'hrm_task',
            'post_status' => 'publish',
        );

        return get_posts( $args );
    }

    function get_task_status( $task_id ) {
        $coplete = get_post_meta( $task_id, '_completed', true );
        if ( $coplete ) {
            return '<span>' . __( 'Completed', 'hrm' ) . '</span>'; //class="hrm-complete-text";
        }

        $due_date = get_post_meta( $task_id, '_end_date', true );

        if ( empty( $due_date ) ) {
            return '<span>' . __( 'Running' ) . '</span>'; // class="hrm-running-text"
        }

        $due_date = strtotime( date( 'Y-m-d', strtotime( $due_date ) ) );
        $today = strtotime( date( 'Y-m-d', time() ) );

        if ( $due_date < $today ) {
            return '<span>' . __( 'Outstanding' ) . '</span>'; // class="hrm-outstanding-text"
        } else {
            return '<span>' . __( 'Running' ) . '</span>'; //class="hrm-running-text"
        }

    }

    function get_sub_tasks( $limit = -1 ) {
        $args = array(
            'posts_per_page' => $limit,
            'post_type' => 'hrm_sub_task',
            'post_status' => 'publish',
        );

        return get_posts( $args );
    }

    function project_post_groupby( $groupby ) {

        global $wpdb;
        $groupby = "{$wpdb->posts}.post_type";

        return $groupby;
    }

    function get_project_where( $where, &$wp_query ) {

        $post_title = $_GET['title'];
        $where .= " AND post_title LIKE '%$post_title%'";

        return $where;
    }

    function project_insert_form( $project = null ) {
        $get_client = HRM_Client::getInstance()->get_clients();
        $clients    = array();
        $clients[-1] = __( '-Select-', 'hrm' );
        foreach ( $get_client->results as $key => $client ) {
            $clients[$client->ID] = $client->display_name;
        }
        if ( $project !== null ) {
            $form['id'] = array(
                'type'  => 'hidden',
                'value' => isset( $project->ID ) ? $project->ID : '',
            );
        }
        $form['title'] = array(
            'label' => __( 'Title', 'hrm' ),
            'type'  => 'text',
            'value' => isset( $project->post_title ) ? $project->post_title : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $form['description'] = array(
            'label' => __( 'Description', 'hrm' ),
            'type'  => 'textarea',
            'class' => 'hrm-pro-des',
            'value' => isset( $project->post_content ) ? $project->post_content : '',
        );

        $form['client'] = array(
            'label'    => __( 'Client', 'hrm' ),
            'type'     => 'select',
            'class'    => 'hrm-chosen',
            'option'   => $clients,
            'selected' => isset( $project->ID ) ? get_post_meta( $project->ID, '_client', true ) : '',
        );

        $form['worker'] = array(
            'label'       => __( 'Worker', 'hrm' ),
            'type'        => 'text',
            'class'       => 'hrm-project-autocomplete',
            'extra'       => array( 'data-action' => 'project_worker' ),
            'placeholder' => __( 'Add co-workers', 'hrm' ),
        );

        if ( $project !== null ) {
            $user_lists = $this->get_co_worker( $project->ID );
            foreach ( $user_lists as $id => $user_list ) {
                $form['role['.$id.']'] = $this->get_co_worker_field( $user_list['name'], $id, $user_list['role']  );
            }
        }

        $form['budget'] = array(
            'label'       => __( 'Budget', 'hrm' ),
            'type'        => 'text',
            'placeholder' => __( 'Greater than budget utilize amount', 'hrm' ),
            'desc'        => __( 'Budget amount should be greater than budget utilize amount', 'hrm' ),
            'value'       => isset( $project->ID ) ? get_post_meta( $project->ID, '_budget', true ) : '',
        );

        $form['currency_symbol'] = array(
            'label' => __( 'Currency Symbol', 'hrm' ),
            'type'  => 'text',
            'value' => isset( $project->ID ) ? get_post_meta( $project->ID, '_currency_symbol', true ) : '',
        );

        $form['action'] = 'add_project';
        $form['header'] = __('Add Project', 'hrm');
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $form );

        $return_value = array(
            'append_data'          => ob_get_clean(),
            'project_autocomplete' => true
        );

        return $return_value;
    }

    function get_co_worker( $project_id ) {

        global $wpdb;

        $user_list = array();
        $table = $wpdb->prefix . 'hrm_user_role';
        $project_users = $wpdb->get_results( $wpdb->prepare( "SELECT user_id, role FROM {$table} WHERE project_id = %d", $project_id ) );

        if ( $project_users ) {
            foreach ($project_users as $row ) {
                $user = get_user_by( 'id', $row->user_id );

                if ( !is_wp_error( $user ) && $user ) {
                    $user_list[$user->ID] = array(
                        'id' => $user->ID,
                        'email' => $user->user_email,
                        'name' => $user->display_name,
                        'role' => $row->role
                    );
                }
            }
        }

        return $user_list;
    }

    function language( $field_data = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_data !== null ) {
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_data['id'] ) ? $field_data['id'] : '',
            );
        }


        $hidden_form['language'] = array(
            'label' =>  __( 'Name', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_data['language'] ) ? $field_data['language'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_language';
        $hidden_form['header'] = __('Add Language', 'hrm');
        $hidden_form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;

    }

    function admin_role_form ( $role_name = false, $display_name = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        if ( $role_name !== false ) {
            $roles =  get_role( $role_name );
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => 'edit'
            );
        }

        $page = hrm_page( false );
        $menu_label = hrm_menu_label();
        //hidden form
        $hidden_form['role_name'] = array(
            'label' =>  __( 'Role', 'hrm' ),
            'type' => ( $role_name === false ) ? 'text' : 'hidden',
            'required' => 'required',
            'value' => ( $role_name === false ) ? '' : esc_attr( $role_name ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );
        $hidden_form['display_name'] = array(
            'label' =>  __( 'Display Name', 'hrm' ),
            'type' => ( $display_name === null ) ? 'text' : 'hidden',
            'value' => ( $display_name === null ) ? '' : esc_attr( $display_name ),
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $check_existence_tab = array();
        $toggle_check = __( 'Toggle Check', 'hrm' );
        foreach( $page as $tab => $tab_item )  {

            if ( isset( $tab_item['tab'] ) && ( $tab_item['tab'] === false ) ) {
                continue;
            }

            if ( apply_filters( 'hrm_exclude_from_permission_field', false, $tab, $tab_item ) ) {
                continue;
            }

            $hidden_form[] = array(
                'type' => 'html',
                'content' => '<div class="postbox">
                                <div  class="hrm-search-head"><h3>'.$menu_label[$tab].'
                                    <a class="hrm-toggle button button-secondary hrm-permission-check-all" href="#">'.$toggle_check.'</a>
                                    <span class="hrm-clear"><span>
                                </h3>
                                </div>
                                <div class="hrm-permission-content">',
            );

            if ( $tab == hrm_employee_page() ) {
                $hidden_form[] = array(
                    'type' => 'html',
                    'content' => __( 'Same as Employee Section', 'hrm' ),
                );

                $hidden_form[] = array(
                    'type' => 'html',
                    'content' => '</div>',
                );
                continue;
            }

            foreach ( $tab_item as $tab_name => $tab_name_itme ) {
                if ( isset( $tab_name_itme['tab'] ) && ( $tab_name_itme['tab'] === false ) ) {
                    continue;
                }

                $check_existence_tab[] = $tab_name;
                $view                  = isset( $roles->capabilities[$tab_name.'_view'] ) ? 'view' : '';
                $add                   = isset( $roles->capabilities[$tab_name.'_add'] ) ? 'add' : '';
                $delete                = isset( $roles->capabilities[$tab_name.'_delete'] ) ? 'delete' : '';

                $tab_role[] = array(
                    'label' => __( 'View', 'hrm' ),
                    'value' => 'view',
                    'class' => 'hrm-cap-'.$tab_name.'_view hrm-permission-toggle-check',
                    'checked' => ( $role_name === false ) ? 'view' : $view,
                );

                $hidden_form["remove_role[{$tab_name}_view]"] = array(
                    'type' => 'hidden',
                    'value' => '0',
                );

                $tab_role[] = array(
                    'label' => __( 'Add', 'hrm' ),
                    'value' => 'add',
                    'class' => 'hrm-cap-'.$tab_name.'_add hrm-permission-toggle-check',
                    'checked' => ( $role_name === false ) ? 'add' : $add,
                );

                $hidden_form["remove_role[{$tab_name}_add]"] = array(
                    'type' => 'hidden',
                    'value' => '0',
                );

                $tab_role[] = array(
                    'label' => __( 'Delete', 'hrm' ),
                    'value' => 'delete',
                    'class' => 'hrm-cap-'.$tab_name.'_delete hrm-permission-toggle-check',
                    'checked' => ( $role_name === false ) ? 'delete' : $delete,
                );

                $hidden_form["remove_role[{$tab_name}_delete]"] = array(
                    'type' => 'hidden',
                    'value' => '0',
                );

                if ( isset( $tab_name_itme['role'] ) && is_array( $tab_name_itme['role'] ) && count( $tab_name_itme['role'] ) ) {
                    foreach ( $tab_name_itme['role'] as $role_value => $label ) {
                        $checked = isset( $roles->capabilities[$tab_name.'_'.$role_value] ) ? $role_value : '';
                        $tab_role[] = array(
                            'label' => $label,
                            'value' => $role_value,
                            'class' => 'hrm-cap-'.$tab_name.'_'.$role_value. ' hrm-permission-toggle-check',
                            'checked' => ( $role_name === false ) ? $role_value : $checked,
                        );

                        $hidden_form["remove_role[{$tab_name}_{$role_value}]"] = array(
                            'type' => 'hidden',
                            'value' => '0',
                        );
                    }
                }

                $hidden_form['cap['.$tab_name.'][]'] = array(
                    'label'      => isset( $tab_name_itme['title'] ) ? $tab_name_itme['title'] : '',
                    'type'       => 'checkbox',
                    'desc'       => 'Choose access permission',
                    'wrap_class' => 'hrm-parent-field',
                    'fields'     => $tab_role,
                );

                $tab_role = '';

                $tab_name_itme_submenus = isset( $tab_name_itme['submenu'] ) ? $tab_name_itme['submenu'] : array();
                foreach ( $tab_name_itme_submenus as $submenu => $submenu_item ) {

                    $view = isset( $roles->capabilities[$submenu.'_view'] ) ? 'view' : '';
                    $add = isset( $roles->capabilities[$submenu.'_add'] ) ? 'add' : '';
                    $delete = isset( $roles->capabilities[$submenu.'_delete'] ) ? 'delete' : '';

                    $submenu_role[] = array(
                        'label' => __( 'View', 'hrm' ),
                        'value' => 'view',
                        'class' => 'hrm-cap-'.$submenu.'_view' . ' hrm-cap-'.$tab_name.'-view-child' . ' hrm-cap-'.$tab_name. ' hrm-permission-toggle-check',
                        'checked' => ( $role_name === false ) ? 'view' : $view,
                    );

                    $hidden_form["remove_role[{$submenu}_view]"] = array(
                        'type' => 'hidden',
                        'value' => '0',
                    );

                    $submenu_role[] = array(
                        'label' => __( 'Add', 'hrm' ),
                        'value' => 'add',
                        'class' => 'hrm-cap-'.$submenu.'_add' . ' hrm-cap-'.$tab_name.'-add-child' . ' hrm-cap-'.$tab_name. ' hrm-permission-toggle-check',
                        'checked' => ( $role_name === false ) ? 'add' : $add,
                    );

                    $hidden_form["remove_role[{$submenu}_add]"] = array(
                        'type' => 'hidden',
                        'value' => '0',
                    );

                    $submenu_role[] = array(
                        'label' => __( 'Delete', 'hrm' ),
                        'value' => 'delete',
                        'class' => 'hrm-cap-'.$submenu.'_delete' . ' hrm-cap-'.$tab_name.'-delete-child' . ' hrm-cap-'.$tab_name. ' hrm-permission-toggle-check',
                        'checked' => ( $role_name === false ) ? 'delete' : $delete,
                    );

                    $hidden_form["remove_role[{$submenu}_delete]"] = array(
                        'type' => 'hidden',
                        'value' => '0',
                    );

                    if ( isset( $submenu_item['role'] ) && is_array( $submenu_item['role'] ) && count( $submenu_item['role'] ) ) {
                        foreach ( $submenu_item['role'] as $role_value => $label ) {
                            $checked = isset( $roles->capabilities[$submenu.'_'.$role_value] ) ? $role_value : '';
                            $submenu_role[] = array(
                                'label' => $label,
                                'value' => $role_value,
                                'class' => 'hrm-cap-'.$submenu.'_'.$role_value . ' hrm-cap-'.$tab_name.'-delete-child' . ' hrm-cap-'.$tab_name. ' hrm-permission-toggle-check',
                                'checked' => ( $role_name === false ) ? $role_value : $checked,
                            );

                            $hidden_form["remove_role[{$submenu}_{$role_value}]"] = array(
                                'type' => 'hidden',
                                'value' => '0',
                            );
                        }
                    }

                    $hidden_form['cap['.$submenu.'][]'] = array(
                        'label'      => $submenu_item['title'],
                        'type'       => 'checkbox',
                        'desc'       => 'Choose access permission',
                        'wrap_class' => 'hrm-child-field',
                        'fields'     => $submenu_role,
                    );
                    $submenu_role = '';
                }
            }

            $hidden_form[] = array(
                'type' => 'html',
                'content' => '</div></div>',
            );
        }

        $hidden_form['header'] = false;
        $hidden_form['form_wrap_class'] = 'hrm-premission-form-wrap';
        $hidden_form['action'] = 'user_role';
        $hidden_form['url'] = $redirect;

        $hidden_form['submit_btn_disabled'] = true;
        $hidden_form['submit_btn_value'] = __( 'To get this feature you have to purchase the HRM permission addon', 'hrm' );
        $hidden_form['cancel_href'] = HRM_PERMISSION_PURCHASE_URL;
        $hidden_form['cancel_text'] = __( 'Purchase HRM persmission addon', 'hrm' );
        $hidden_form['cancel_btn_class'] = 'none';

        $hidden_form = apply_filters( 'hrm_tab_subtab_access_permission_form', $hidden_form, $role_name, $display_name );

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function new_role_form( $role_name = false, $display_name = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        if ( $role_name !== false ) {
            $roles =  get_role( $role_name );
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => 'edit'
            );
        }

        $page = hrm_page();
        $menu_label = hrm_menu_label();
        //hidden form
        $hidden_form['role_name'] = array(
            'label' =>  __( 'Role', 'hrm' ),
            'type' => ( $role_name === false ) ? 'text' : 'hidden',
            'required' => 'required',
            'value' => ( $role_name === false ) ? '' : esc_attr( $role_name ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );
        $hidden_form['display_name'] = array(
            'label' =>  __( 'Display Name', 'hrm' ),
            'type' => ( $display_name === null ) ? 'text' : 'hidden',
            'value' => ( $display_name === null ) ? '' : esc_attr( $display_name ),
            'required' => 'required',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['header'] = __( 'New Role', 'hrm' );
        $hidden_form['action'] = 'new_role';
        $hidden_form['url'] = $redirect;

        $hidden_form['submit_btn_disabled'] = true;
        $hidden_form['submit_btn_value'] = __( 'To get this feature you have to purchase the HRM permission addon', 'hrm' );
        $hidden_form['cancel_href'] = HRM_PERMISSION_PURCHASE_URL;
        $hidden_form['cancel_text'] = __( 'Purchase HRM persmission addon', 'hrm' );
        $hidden_form['cancel_btn_class'] = 'none';

        $hidden_form = apply_filters( 'hrm_new_role_form_field', $hidden_form, $role_name, $display_name );

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function main_menu_access_permission_form( $role_name = false, $display_name = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        if ( $role_name !== false ) {
            $roles =  get_role( $role_name );
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => 'edit'
            );

            $hidden_form['role_name'] = array(
                'type'     => 'hidden',
                'required' => 'required',
                'value'    => $role_name,
            );
        }
        $capabilities = isset( $roles->capabilities ) ? $roles->capabilities : array();

        $menu_label = hrm_menu_label();
        //unset( $menu_label[hrm_employee_page()] );

        foreach( $menu_label as $menu_slug => $menu_name )  {

            $hidden_form["page_access[$menu_slug]"] = array(
                'label'      => $menu_name,
                'type'       => 'checkbox',
                //'desc'       => 'Choose access permission',
                'wrap_class' => 'hrm-child-field',
                'fields'     => array(
                    array(
                        'label' => __( 'View', 'hrm' ),
                        'value' => 1,
                        'checked' => isset( $capabilities[$menu_slug] ) && $capabilities[$menu_slug] == 1 ? 1 : '',
                    )
                )
            );

            $hidden_form["delete_page_access[$menu_slug]"] = array(
                'type'       => 'hidden',
                'value'     => '0'
            );
        }

        $hidden_form['action'] = 'menu_access';
        $hidden_form['header'] = __('Menu Access Control Form', 'hrm');
        $hidden_form['url'] = $redirect;

        $hidden_form['submit_btn_disabled'] = true;
        $hidden_form['submit_btn_value'] = __( 'To get this feature you have to purchase the HRM permission addon', 'hrm' );
        $hidden_form['cancel_href'] = HRM_PERMISSION_PURCHASE_URL;
        $hidden_form['cancel_text'] = __( 'Purchase HRM persmission addon', 'hrm' );
        $hidden_form['cancel_btn_class'] = 'none';

        $hidden_form = apply_filters( 'hrm_main_menu_access_permission_form', $hidden_form, $role_name, $display_name );

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function project( $field_value = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        $country = hrm_Settings::getInstance()->country_list();
        if ( $field_value !== null ) {
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }

        $hidden_form['education_name'] = array(
            'label' =>  __( 'Customer Name', 'hrm' ),
            'class' => 'hrm-chosen',
            'type' => 'select',
            'extra' => array(
                'multiple' => 'multiple'
            ),
            'option' => $country,
            'selected' => isset( $field_value['education_name'] ) ? $field_value['education_name'] : '',
        );
        $hidden_form['project_name'] = array(
            'label' =>  __( 'Name', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_value['project_name'] ) ? $field_value['project_name'] : '',
        );
        $hidden_form['project_admin'] = array(
            'label' =>  __( 'Project Admin', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_value['project_admin'] ) ? $field_value['project_admin'] : '',
        );
        $hidden_form['description'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'class' => 'hrm-des-field',
            'type' => 'text',
            'value' => isset( $field_value['description'] ) ? $field_value['description'] : '',
        );


        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_qualification_education';
        $hidden_form['header'] = __('Add Skills', 'hrm');
        $hidden_form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function customer( $field_value = null ) {
        if( $field_value !== null ) {
            $hidden_form['customer_name'] = array(
                'type' => 'hidden',
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }
        $hidden_form['customer_name'] = array(
            'label' =>  __( 'Name', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_value['customer_name'] ) ? $field_value['customer_name'] : '',
        );
        $hidden_form['customer_desc'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_value['customer_desc'] ) ? $field_value['customer_desc'] : '',
        );
        $hidden_form['customer_deleted'] = array(
            'type' => 'hidden',
            'value' => isset( $field_value['customer_deleted'] ) ? $field_value['customer_deleted'] : '',

        );

        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_project_customer';
        $hidden_form['header'] = __('Add Customer', 'hrm');
        ob_start();
        hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function education( $field_value = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_value !== null ) {
            $hidden_form['id'] = array(
                'type' => 'hidden'
,                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            );
        }
        $hidden_form['education_name'] = array(
            'label' =>  __( 'Name', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_value['education_name'] ) ? $field_value['education_name'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_qualification_education';
        $hidden_form['header'] = __('Add Skills', 'hrm');
        $hidden_form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function skills( $field_data = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $field_data !== null ) {
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $field_data['id'] ) ? $field_data['id'] : '',
            );
        }


        $hidden_form['skill_name'] = array(
            'label' =>  __( 'Name', 'hrm' ),
            'type' => 'text',
            'value' => isset( $field_data['skill_name'] ) ? $field_data['skill_name'] : '',
            'extra' => array(
                'data-action' => 'skills',
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['skill_desc'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $field_data['skill_desc'] ) ? $field_data['skill_desc'] : '',
        );

        $hidden_form['action'] = 'ajax_referer_insert';
        $hidden_form['table_option'] = 'hrm_qualification_skills';
        $hidden_form['header'] = __('Add Skills', 'hrm');
        $hidden_form['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function admin_location( $set_form_field = null ) {
        $country = hrm_Settings::getInstance()->country_list();

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        if ( $set_form_field !== null ) {
            $location['id'] = array(
                'type' => 'hidden',
                'value' => isset( $set_form_field['id'] ) ? $set_form_field['id'] : '',
            );
        }

        $location['name'] = array(
            'label' =>  __( 'Name', 'hrm' ),
            'type' => 'text',
            'value' => isset( $set_form_field['name'] ) ? $set_form_field['name'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $location['country'] = array(
            'label' =>  __( 'Country', 'hrm' ),
            'type' => 'select',
            'option'=> $country,
            'selected' => isset( $set_form_field['country'] ) ? $set_form_field['country'] : '',
        );

        $location['province'] = array(
            'label' =>  __( 'State/Province', 'hrm' ),
            'type' => 'text',
            'value' => isset( $set_form_field['province'] ) ? $set_form_field['province'] : '',
        );
        $location['city'] = array(
            'label' =>  __( 'City', 'hrm' ),
            'type' => 'text',
            'value' => isset( $set_form_field['city'] ) ? $set_form_field['city'] : '',
        );

        $location['address'] = array(
            'label' =>  __( 'Address', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $set_form_field['address'] ) ? $set_form_field['address'] : '',
        );

        $location['zipcode'] = array(
            'label' =>  __( 'Zip/Postal Code', 'hrm' ),
            'type' => 'text',
            'value' => isset( $set_form_field['zipcode'] ) ? $set_form_field['zipcode'] : '',
        );
        $location['phone'] = array(
            'label' =>  __( 'Phone', 'hrm' ),
            'type' => 'text',
            'value' => isset( $set_form_field['phone'] ) ? $set_form_field['phone'] : '',
        );

        $location['fax'] = array(
            'label' =>  __( 'Fax', 'hrm' ),
            'type' => 'text',
            'value' => isset( $set_form_field['fax'] ) ? $set_form_field['fax'] : '',
        );
        $location['notes'] = array(
            'label' =>  __( 'Notes', 'hrm' ),
            'type' => 'textarea',
            'value' => isset( $set_form_field['notes'] ) ? $set_form_field['notes'] : '',
        );
        $location['action'] = 'ajax_referer_insert';
        $location['table_option'] = 'hrm_location_option';
        $location['header'] = 'Location';
        $location['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $location );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function job_category_insert_form( $field_value = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        $add_field['id'] = array(
            'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
            'type' => 'hidden',
        );
        $add_field['job_category'] = array(
            'label' =>  __( 'Category', 'hrm' ),
            'type' => 'text',
            'desc' => 'please insert category name',
            'value' => isset( $field_value['job_category'] ) ? $field_value['job_category'] : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $add_field['active'] = array(

            'label' => __( 'Status', 'hrm' ),
            'type' => 'checkbox',
            'desc' => 'please active this category',
            'fields' => array(
                array(
                    'label' => __( 'active', 'hrm' ),
                    'value' => 'yes',
                    'checked' => isset( $field_value['active'] ) ? $field_value['active'] : '',
                ),
            )
        );

        $add_field['action'] = 'ajax_referer_insert';
        $add_field['table'] = 'hrm_job_category';
        $add_field['header'] = 'Job Catgory';
        $add_field['table_option'] = 'hrm_job_category';
        $add_field['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $add_field );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function job_title_insert_form( $field_value = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        if ( $field_value !== null ) {

            $job['id'] = array(
                'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
                'type' => 'hidden',
            );
        }
        //hidden form
        $job['job_title'] = array(
            'label' =>  __( 'job Title', 'hrm' ),
            'value' => isset( $field_value['job_title'] ) ? $field_value['job_title'] : '',
            'type' => 'text',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );
        $job['job_description'] = array(
            'label' =>  __( 'Job Description', 'hrm' ),
            'value' => isset( $field_value['job_description'] ) ? $field_value['job_description'] : '',
            'type' => 'text',
        );

        $job['note'] = array(
            'label' =>  __( 'Note', 'hrm' ),
            'value' => isset( $field_value['note'] ) ? $field_value['note'] : '',
            'type' => 'textarea',
        );
        $job['action'] = 'ajax_referer_insert';
        $job['table_option'] = 'hrm_job_title_option';
        $job['header'] = 'Job Title';
        $job['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $job );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function get_user_role() {
        global $current_user;

        $user_roles = $current_user->roles;
        $user_role = array_shift($user_roles);

        return $user_role;
    }

    function do_action() {
        add_action( 'hrm_after_new_entry_form_field', array( $this, 'employee_image_upload_form' ) );
    }

    function get_image( $attachment_id ) {
        $file = get_post( $attachment_id );
        if ( $file ) {
            $response = array(
                'id' => $attachment_id,
                'name' => get_the_title( $attachment_id ),
                'url' => wp_get_attachment_url( $attachment_id ),
            );

            if ( wp_attachment_is_image( $attachment_id ) ) {

                $thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
                $response['thumb'] = $thumb[0];
                $response['type'] = 'image';
                return $response;
            }
        }

        return false;
    }

    function employee_image_upload_form($data) {
        $employee_id     = isset( $_POST['id'] )  ?  $_POST['id'] : false;
        $this->emp_upload_image($employee_id);
    }

    function emp_upload_image( $employee_id ) {

        $image_id        = get_user_meta( $employee_id, '_hrm_user_image_id', true );
        $image_attchment = $this->get_image( $image_id );

        ?>

        <div id="hrm-upload-file-container" >
            <div class="hrm-employee-pic-text"><strong><?php  _e( 'Profile Picture', 'hrm' ); ?></strong></div>
            <div class="hrm-drop-area" id="hrm-drop-files-zone">
                <a id="hrm-pickfiles" href="#"><?php _e( 'Change', 'hrm' ); ?></a>
                <?php
                if ( $image_attchment ) {
                    ?>
                    <!-- <a href="#" data-id="<?php echo $image_attchment['id']; ?>" class="hrm-delete-file"><?php _e( 'Delete', 'hrm' ); ?></a> -->
                    <?php
                }
                ?>
            </div>
            <div id="hrm-user-image-wrap">
                <?php
                if ( $image_attchment ) {
                    $delete = sprintf( '<a href="#" data-id="%d" class="hrm-delete-file">%s</a>', $image_attchment['id'], __( 'Delete', 'hrm' ) );
                    $hidden = sprintf( '<input type="hidden" name="hrm_attachment[]" value="%d" />', $image_attchment['id'] );
                    $file_url = sprintf( '<a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s" height="160" width="160"/></a>', $image_attchment['url'], $image_attchment['thumb'], esc_attr( $image_attchment['name'] ) );

                    echo '<div class="hrm-uploaded-item">' . $delete.' '. $file_url  . $hidden . '</div>';
                } else {
                    echo get_avatar( $employee_id, 160 );
                }
                ?>

            </div>
        </div>
        <?php
    }

    function add_new_employer( $postdata ) {
        if ( isset( $postdata['employer_id'] ) && !empty( $postdata['employer_id'] ) ) {
            $user_id = $postdata['employer_id'];
            $this->update_empoyer( $user_id, $postdata );
            return $user_id;
        }
        $validate = $this->new_admin_form_validate( $postdata );

        if ( is_wp_error( $validate ) ) {
            return $validate;
        }

        $random_password = wp_generate_password( 8, false );
        $first_name = sanitize_text_field( $postdata['first_name'] );
        $last_name = sanitize_text_field( $postdata['last_name'] );
        $display_name = $first_name .' '. $last_name;

        $userdata = array(
            'user_login' => $postdata['user_name'],
            'user_pass' =>  $random_password,
            'user_email' => $postdata['email'],
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $display_name,
            'role'  => 'hrm_employee'
        );

        $user_id = wp_insert_user( $userdata );

        if( $user_id ) {
            $image = isset( $postdata['hrm_attachment'] ) ? $postdata['hrm_attachment'] : array();
            $image_id = is_array( $image ) && $image ? reset( $image ) : 0;
            update_user_meta( $user_id, '_hrm_user_role', 'hrm_employee' );
            update_user_meta( $user_id, '_hrm_user_image_id', $image_id );
            $this->update_empoyer( $user_id, $postdata );

            wp_new_user_notification( $user_id, $random_password );

            return $user_id;

        } else {
            return false;
        }

    }

    function update_empoyer( $user_id, $postdata ) {
        wp_update_user( array( 'ID' => $user_id, 'role' => $postdata['emp_role'] ) );
        update_user_meta( $user_id, 'hrm_admin_level', 'admin' );
        $display_name = $postdata['first_name'] . ' ' . $postdata['last_name'];
        update_user_meta( $user_id, 'first_name', $postdata['first_name'] );
        update_user_meta( $user_id, 'last_name', $postdata['last_name'] );

        wp_update_user(array( 'ID' =>  $user_id, 'display_name' => $display_name));
        update_user_meta( $user_id, '_job_title', $postdata['job_title'] );
        update_user_meta( $user_id, '_job_category', $postdata['job_category'] );
        update_user_meta( $user_id, '_location', $postdata['location'] );
        update_user_meta( $user_id, '_job_desc', $postdata['job_desc'] );
        update_user_meta( $user_id, '_status', $postdata['status'] );
        update_user_meta( $user_id, '_mob_number', $postdata['mobile'] );
        update_user_meta( $user_id, '_joined_date', hrm_date2mysql( $postdata['joined_date'] ) );

        $image = isset( $postdata['hrm_attachment'] ) ? $postdata['hrm_attachment'] : array();
        $image_id = is_array( $image ) && $image ? reset( $image ) : 0;
        update_user_meta( $user_id, '_hrm_user_image_id', $image_id );

    }

    function new_admin_form_validate( $postdata ) {

        if( empty($postdata['user_name']) ) {
            return new WP_Error( 'error', __('Username required ', 'cpm' ) );
        }

        if( empty($postdata['email']) ) {
            return new WP_Error( 'error', __('Eamil required', 'cpm' ) );
        }

        if ( ! is_email($postdata['email'] ) ) {
            return new WP_Error( 'error', __('Invalid email', 'cpm' ) );
        }

        if( username_exists( $postdata['user_name'] ) ) {
            return new WP_Error( 'error', __('Username already exist', 'cpm' ) );
        }

        if( email_exists( $postdata['email']) ) {
            return new WP_Error( 'error', __('Email already exist', 'cpm' ) );
        }

        return true;
    }

    function admin_list( $user_id = null ) {
        global $wp_roles;
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( !$wp_roles ) {
            $wp_roles = new WP_Roles();
        }

        $role_names = $wp_roles->get_names();

        unset( $role_names['hrm_employee'] );

        $current_user_role = $this->get_user_role();

        $job_title    = json_decode( stripcslashes( $_POST['hrm_dataAttr']['job_title'] ) );
        $job_category = json_decode( stripcslashes( $_POST['hrm_dataAttr']['job_category'] ) );
        $location     = json_decode( stripcslashes( $_POST['hrm_dataAttr']['location'] ) );

        $employer_id = isset( $employer->ID ) ? $employer->ID : false;
        if ( $user_id === null ) {
            $hidden_form['user_name'] = array(
                'label' =>  __( 'User Name', 'hrm' ),
                'type'  => 'text',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                ),
            );

            $hidden_form['email'] = array(
                'label' =>  __( 'E-mail', 'hrm' ),
                'type'  => 'text',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_email' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                    'data-hrm_email_error_msg'=> __( 'Please enter a valid email', 'hrm' ),
                ),
            );
        } else {
            $hidden_form['employer_id'] = array(
                'value' => $user_id,
                'type'  => 'hidden',
            );
        }

        $hidden_form['emp_role'] = array(
            'label'    => __( 'Role', 'hrm' ),
            'type'     => 'select',
            'option'   => $role_names,
            'selected' => '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['first_name'] = array(
            'label' =>  __( 'First Name', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $user_id, 'first_name', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );
        $hidden_form['last_name'] = array(
            'label' =>  __( 'Last Name', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $user_id, 'last_name', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $new_job_title_url = hrm_job_title();
        $hidden_form['job_title'] = array(
            'label' => __( 'Job Title', 'hrm' ),
            'type' => 'select',
            'option' => $job_title,
            'selected' => get_user_meta( $user_id, '_job_title', true ),
            'desc' => sprintf( '<a class="hrm-form-link" href="%s">%s</a>', $new_job_title_url,  __( 'Create New', 'hrm' ) ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $category_url = hrm_job_category();
        $hidden_form['job_category'] = array(
            'label' => __( 'Job Category', 'hrm' ),
            'type' => 'select',
            'option' => $job_category,
            'selected' => get_user_meta( $user_id, '_job_category', true ),
            'desc' => sprintf( '<a class="hrm-form-link" href="%s">%s</a>', $category_url,  __( 'Create New', 'hrm' ) ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $location_url = hrm_job_location();
        $hidden_form['location'] = array(
            'label' => __( 'Location', 'hrm' ),
            'type' => 'select',
            'option' => $location,
            'selected' => get_user_meta( $user_id, '_location', true ),
            'desc' => sprintf( '<a class="hrm-form-link" href="%s">%s</a>', $location_url,  __( 'Create New', 'hrm' ) ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $hidden_form['status'] = array(
            'label' =>  __( 'status', 'hrm' ),
            'type'  => 'select',
            'option' => array(
                'yes' => 'Enable',
                'no' => 'Disable'
            ),
            'selected' => get_user_meta( $user_id, '_status', true )
        );
        $hidden_form['mobile'] = array(
            'label' =>  __( 'Mobile Number', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $user_id, '_mob_number', true )
        );
        $hidden_form['joined_date'] = array(
            'label' =>  __( 'Joined Date', 'hrm' ),
            'type'  => 'text',
            'class' => 'hrm-datepicker',
            'value' => get_user_meta( $user_id, '_joined_date', true )
        );

        $hidden_form['job_desc'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'type'  => 'textarea',
            'value' => get_user_meta( $user_id, '_job_desc', true )
        );


        $hidden_form['action'] = 'update_user_role';
        $hidden_form['header'] = 'Employer Information';
        $hidden_form['url'] = $redirect;

        ob_start();
        $this->do_action();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );
        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function get_co_worker_field( $display_name, $user_id, $value = null ) {
        $name = str_replace(' ', '_', $display_name );
        $user = get_user_by( 'id', $user_id );

        $fields = array();
        if ( reset( $user->roles ) != 'hrm_employee' ) {
            $fields[] = array(
                'label'   => __( 'Manager', 'hrm' ),
                'id'      => 'hrm-manager-'.$name,
                'value'   => 'manager',
                'checked' => isset( $value ) ? $value : '',
            );

            $fields[] = array(
                'label'   => __( 'Client', 'hrm' ),
                'id'      => 'hrm-client-'.$name,
                'value'   => 'client',
                'checked' => isset( $value ) ? $value : '',
            );
        }

        $fields[] = array(
            'label'   => __( 'Co-worker', 'hrm' ),
            'id'      => 'hrm-co-worker-'.$name,
            'value'   => 'co_worker',
            'checked' => isset( $value ) ? $value : 'co_worker',
        );

        return $hidden_form = array(
            'label'  => $display_name,
            'type'   => 'radio',
            'desc'   => 'Choose access permission',
            'fields' => $fields,
        );
    }

    function project_user_meta( $display_name, $user_id, $user ) {
        $form = $this->get_co_worker_field( $display_name, $user_id );

        ob_start();
            echo hrm_settings::getInstance()->radio_field( 'role['.$user_id.']', $form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function create_user_meta( $display_name, $user_id, $role = null ) {
        global $wp_roles;

        $role = ( $role == null ) ? 'subscriber' : $role ;
        if ( !$wp_roles ) {
            $wp_roles = new WP_Roles();
        }

        $role_names = $wp_roles->get_names();

        unset( $role_names['hrm_employee'] );
        ob_start();
        ?>
            <div class="select-field">
                <label id="<?php echo $display_name .'_'.$user_id; ?>"><?php echo $display_name; ?><em>*</em></label>
                <input type="hidden" name="admin[]" value="<?php echo $user_id; ?>">
                <select name="admin_role[]" data-required="required" data-required_error_msg="This field is required">
                    <?php
                        foreach( $role_names as $key => $name ) {
                            ?>
                            <option <?php selected( $role, $key ); ?> value="<?php echo $key; ?>"><?php echo $name; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <span class="hrm-delte-user-meta"></span>
                <span class="hrm-clear"></span>
                <span class="description"><?php printf( 'Select %s role', $display_name ); ?></span>
            </div>
        <?php

        return ob_get_clean();
    }

    function skill_user_meta( $id, $first_name, $last_name ) {
        ob_start();
        ?>
        <div>
            <span class="hrm-delte-user-meta hrm-label-font"><?php echo ucfirst( $first_name .' '.$last_name ); ?></span>
            <input type="hidden" value="<?php echo $id; ?>" name="user_id[]">
            <input type="hidden" value="<?php echo $first_name .' '.$last_name; ?>" name="user_name[]">
        </div>
        <?php
        return ob_get_clean();
    }


    function admin_init_action() {

        if( isset( $_POST['hrm_search'] ) ) {
            hrm_Settings::getInstance()->search();
        }

        if( isset( $_POST['hrm_pagination'] ) ) {
            hrm_Settings::getInstance()->pagination_query_arg();
        }

    }


    function search( $limit = null ) {

        check_ajax_referer( 'hrm_nonce' );

        if( ! isset( $_POST['table_option'] ) || empty( $_POST['table_option'] ) ) {

            foreach ($_GET as $key => $value) {
                $data[$key] = $value;
            }
            unset( $data['pagenum'] );
            $data['hrm_error'] = 'table_option';
            $query_arg = add_query_arg( $data, admin_url( 'admin.php' ));

            wp_redirect( $query_arg  );
        }

        $table_option = get_option( $_POST['table_option'] );
        $table_option['table_option'] = ( isset( $table_option['table_option'] ) && is_array( $table_option['table_option'] ) ) ? $table_option['table_option'] : array();


        foreach ( $table_option['table_option'] as $name => $value ) {
            if( isset( $_POST[$value] ) && ! empty( $_POST[$value] ) ) {
                $data[$value] = urlencode( $_POST[$value] );
            }

            if( isset( $_GET[$value] ) ) {

                unset( $_GET[$value] );
            }
        }



        if( $data ) {
            $data['table_option'] = $_POST['table_option'];
            $data['_wpnonce'] = $_POST['_wpnonce'];
            $data['type'] = '_search';
        }

        foreach ($_GET as $key => $value) {
            $data[$key] = $value;
        }

        unset( $data['pagenum'] );
        $query_arg = add_query_arg( $data, admin_url( 'admin.php' ));


        wp_redirect(  $query_arg );
    }

    function search_query( $limit ) {
        check_ajax_referer( 'hrm_nonce' );
        if( ! isset( $_GET['table_option'] ) && empty( $_GET['table_option'] ) ) {
            return;
        }
        $table_option['table_option'] = array();
        $table_option = get_option( $_GET['table_option'] );

        $data = array();
        foreach ( $table_option['table_option'] as $name => $value ) {
            if( isset( $_GET[$value] ) && ! empty( $_GET[$value] ) ) {
                $data[] = $name .' LIKE ' ."'%".trim( $_GET[$value] ) ."%'";
            }
        }

        $where = implode( $data, ' AND ');


        global $wpdb;
        $tabledb = $wpdb->prefix . $table_option['table_name'];

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;

        $results = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb WHERE $where ORDER BY id desc LIMIT $offset,$limit" );
        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );

        return $results;
    }

    function show_tab_page( $page = null ) {
        $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';
        $menu = hrm_page();


        if( empty( $tab ) && count( $menu['admin'] )  ) {
            $tab = key( $menu['admin'] );

            if ( ! hrm_user_can_access( $page, $tab, null, 'view' ) ) {
                printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
                return false;
            }

            $path = isset( $menu['admin'][$tab]['file_path'] ) ? $menu['admin'][$tab]['file_path'] : '';

            if( file_exists( $path ) ) {
                require_once $path;
            } else {
                echo 'Page not found';
            }
        } else {

            if ( ! hrm_user_can_access( $page, $tab, null, 'view' ) ) {
                printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
                return false;
            }

            $path = isset( $menu['admin'][$tab]['file_path'] ) ? $menu['admin'][$tab]['file_path'] : '';

            if( file_exists( $path ) ) {
                require_once $path;
            } else {
                echo 'Page not found';
            }
        }
    }


    function show_sub_tab_page( $page, $tab ) {
        $subtab = isset( $_GET['sub_tab'] ) ? $_GET['sub_tab'] : '';
        $menu = hrm_page();

        if( empty( $subtab ) && count( $menu['admin'][$tab]['submenu'] ) ) {

            $subtab = key( $menu['admin'][$tab]['submenu'] );

            if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {
                printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
                return false;
            }

            $path = isset( $menu['admin'][$tab]['submenu'][$subtab]['file_path'] ) ? $menu['admin'][$tab]['submenu'][$subtab]['file_path'] : '';

            if( file_exists( $path ) ) {
                require_once $path;
            } else {
                echo 'Page not found';
            }
        } else {

            if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {
                printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
                return;
            }

            $path = isset( $menu['admin'][$tab]['submenu'][$subtab]['file_path'] ) ? $menu['admin'][$tab]['submenu'][$subtab]['file_path'] : '';


            if( file_exists( $path ) ) {
                require_once $path;
            } else {
                echo 'Page not found';
            }
        }
    }

    function hrm_query( $table, $limit ) {
        global $wpdb;
        $tabledb = $wpdb->prefix . $table;

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;
        $results = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb ORDER BY id desc LIMIT $offset,$limit" );
        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );

        return $results;
    }

    function pagination( $total, $limit ) {

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $num_of_pages = ceil( $total / $limit );

        $page_links = paginate_links( array(
            'base' => add_query_arg( 'pagenum', '%#%' ),
            'format' => '',
            'prev_text' => __( '&laquo;', 'aag' ),
            'next_text' => __( '&raquo;', 'aag' ),
            'total' => $num_of_pages,
            'current' => $pagenum
        ) );

        if ( $page_links ) {
            return '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
        }
    }


    function admin_init() {
        //var_dump( $_POST);
    }

    function menu_section() {
        $sections['organization'] = array(
            'id' => 'hrm-organization',
            'title' => __( 'Organization', 'hrm' ),
            'file_name' => 'organization',

            'submenu' => array(
                'general_info' => array(
                    'id' => 'hrm-organization-sub-genral_info',
                    'title' => __( 'General Information', 'hrm' ),
                    'file_name' => 'general_info',
                ),

                'location' => array(
                    'id' => 'hrm-organization-sub-location',
                    'title' => __( 'Location', 'hrm' ),
                    'file_name' => 'location',
                ),
            ),
        );

        $sections['job'] = array(
            'id' => 'hrm-job',
            'title' => __( 'job', 'hrm' ),
            'file_name' => 'job',

            'submenu' => array(
                'job_title' => array(
                    'id' => 'hrm-job-title',
                    'title' => __( 'Job Title', 'hrm' ),
                    'file_name' => 'job_title',
                ),

                'job_categories' => array(
                    'id' => 'hrm-job-categories',
                    'title' => __( 'Job Categories', 'hrm' ),
                    'file_name' => 'job-categories',
                ),
            ),
        );

        $sections['admin'] = array(
            'id' => 'hrm-admin',
            'title' => __( 'admin', 'hrm' ),
            'file_name' => 'admin',
            'submenu' => array(
                'admin_list' => array(
                    'title' => __( 'Admin lists', 'hrm' ),
                    'file_name' => 'admin-lists',
                ),

                'admin_role' => array(
                    'title' => __( 'Admin Role', 'hrm' ),
                    'file_name' => 'admin-role',
                ),
            ),

        );

        $sections['qualification'] = array(
            'id' => 'hrm-qualification',
            'title' => __( 'Qualification', 'hrm' ),
            'file_name' => 'qualification',
            'submenu' => array(
                'skills' => array(
                    'title' => __( 'Skills', 'hrm' ),
                    'file_name' => 'skills',
                ),

                'user_select' => array(
                    'title' => __( 'User selection demo', 'hrm' ),
                    'file_name' => 'user-selection-demo',
                ),

                'education' => array(
                    'title' => __( 'Education', 'hrm' ),
                    'file_name' => 'education',
                ),
                'language' => array(
                    'title' => __( 'Language', 'hrm' ),
                    'file_name' => 'language',
                ),
            ),

        );

        $sections['project_info'] = array(
            'id' => 'hrm-project-info',
            'title' => __( 'Project info', 'hrm' ),
            'file_name' => 'project-info',
            'submenu' => array(
                'skills' => array(
                    'title' => __( 'Customers', 'hrm' ),
                    'file_name' => 'customer',
                ),

                'education' => array(
                    'title' => __( 'Projects', 'hrm' ),
                    'file_name' => 'project',
                ),
            ),

        );



        $menu = apply_filters( 'hrm_admin_menu_tabs', $sections );

        if( ! empty( $menu ) && is_array( $menu ) ) {
            return $menu;
        }

        return array();
    }

    function pay_grade( $db_value = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        if ( $db_value != null ) {
            $form['id'] = array(
                'type' => 'hidden',
                'value' => isset( $db_value['id'] ) ? $db_value['id'] : ''
            );
        }

        $form['name'] = array(
            'label' => __( 'Name', 'hrm' ),
            'value'=> isset( $db_value['name'] ) ? $db_value['name'] : '',
            'type' => 'text',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $form['action'] = 'ajax_referer_insert';
        $form['table_option'] = 'hrm_pay_grade';
        $form['header'] = 'Pay Grades';
        $form['url'] = $redirect;

        ob_start();
        echo hrm_settings::getInstance()->hidden_form_generator( $form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;

    }

    function change_admin_status( $user_id, $status ) {

        $success = update_user_meta( $user_id, '_status', $status );

        if ( $success ) {
            return $user_id;
        } else {
            return false;
        }
    }

    function update_project_meta( $project_id, $post ) {
        $budget = floatval( $post['budget'] );
        $symbol = $post['currency_symbol'];
        $budget_utilize = get_post_meta( $project_id, '_project_budget_utilize', true );
        if ( $budget >=  $budget_utilize ) {
            update_post_meta( $project_id, '_budget', $budget );
        }
        $client = ( isset( $post['client'] ) && $post['client'] != '-1' ) ? $post['client'] : 0;
        update_post_meta( $project_id, '_currency_symbol', $symbol );
        update_post_meta( $project_id, '_client', $client );

        if ( empty( $budget_utilize ) ) {
            update_post_meta( $project_id, '_project_budget_utilize', '0' );
        } else {
          update_post_meta( $project_id, '_project_budget_utilize', $budget_utilize );
        }
    }

}