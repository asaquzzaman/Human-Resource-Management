<?php
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Item as Item;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Models\Location;
use HRM\Transformers\Location_Transformer;
use HRM\Models\Notice;
use HRM\Transformers\Notice_Transformer;
use Illuminate\Pagination\Paginator;
use HRM\Models\Designation;
use HRM\Transformers\Designation_Transformer;
use HRM\Models\Department;

class Hrm_Admin {
    use Transformer_Manager;

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
        add_action( 'wp_ajax_hrm_organization_location_filter', array( $this, 'ajax_location_filter' ) );
        add_action( 'wp_ajax_hrm_notice_filter', array( $this, 'ajax_notice_filter' ) );
        add_action( 'wp_ajax_hrm_designation_filter', array( $this, 'ajax_designation_filter' ) );

        $this->setup_actions();
    }

    /**
     * Setup the admin hooks, actions and filters
     *
     * @return void
     */
    function setup_actions() {

        // Bail if in network admin
        if ( is_network_admin() ) {
            return;
        }

        // User profile edit/display actions
        add_action( 'edit_user_profile', array( $this, 'role_display' ) );
        add_action( 'show_user_profile', array( $this, 'role_display' ) );
        add_action( 'profile_update', array( $this, 'profile_update_role' ) );
    }

    function ajax_designation_filter() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        $locations = $this->designation_filter($POST);

        wp_send_json_success($locations);
    }

    function designation_filter( $postdata = [], $id = false  ) {
            
        $title     = empty( $postdata['title'] ) ? '' : $postdata['title'];
        $page      = empty( $postdata['page'] ) ? 1 : intval( $postdata['page'] );

        $per_page = hrm_per_page();

        if ( $id !== false  ) {

            $designation = Designation::find( $id );
            
            if ( $designation ) {
                $resource = new Item( $designation, new Designation_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $designation = Designation::where( function($q) use( $title ) {
            if ( ! empty(  $title ) ) {
                $q->where( 'title', 'LIKE', '%' . $title . '%' );
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );
    
        $collection = $designation->getCollection();

        $resource = new Collection( $collection, new Designation_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $designation ) );

        return $this->get_response( $resource );
    
    }

    function ajax_notice_filter() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        $locations = $this->notice_filter($POST);

        wp_send_json_success($locations);
    }

    function notice_filter( $postdata = [], $id = false  ) {
            
        $title     = empty( $postdata['title'] ) ? '' : $postdata['title'];
        $page      = empty( $postdata['page'] ) ? 1 : intval( $postdata['page'] );
        $from      = empty( $postdata['from'] ) ? '' : $postdata['from'];
        $to        = empty( $postdata['to'] ) ? '' : $postdata['to'];
        $per_page = hrm_per_page();

        if ( $id !== false  ) {

            $location = Notice::find( $id );
            
            if ( $location ) {
                $resource = new Item( $location, new Location_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $location = Notice::where( function($q) use( $title, $from, $to ) {
            if ( ! empty(  $title ) ) {
                $q->where( 'title', 'LIKE', '%' . $title . '%' );
            }

            if ( ! empty( $from ) ) {
                $from = date( 'Y-m-d', strtotime( $from ) );
                $q->where( 'date', '>=', $from);
            }

            if ( ! empty( $to ) ) {
                $to = date( 'Y-m-d', strtotime( $to ) );
                $q->where( 'date', '<=', $to);
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );
    
        $collection = $location->getCollection();

        $resource = new Collection( $collection, new Notice_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $location ) );

        return $this->get_response( $resource );
    
    }

    function ajax_location_filter() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        $locations = $this->location_filter($POST);

        wp_send_json_success($locations);
    }

    function location_filter( $postdata = [], $id = false  ) {
            
        $name     = empty( $postdata['name'] ) ? '' : $postdata['name'];
        $page     = empty(  $postdata['page'] ) ? 1 : intval( $postdata['page'] );
        $per_page = hrm_per_page();

        if ( $id !== false  ) {

            $location = Location::find( $id );
            
            if ( $location ) {
                $resource = new Item( $location, new Location_Transformer );
                return $this->get_response( $resource );
            }
            
            return $this->get_response( null );
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $location = Location::where( function($q) use( $name ) {
            if ( ! empty(  $name ) ) {
                $q->where( 'name', 'LIKE', '%' . $name . '%' );
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );
    
        $collection = $location->getCollection();

        $resource = new Collection( $collection, new Location_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $location ) );

        return $this->get_response( $resource );
    
    }

    /**
     * Default interface for setting a HR role
     *
     * @param WP_User $profileuser User data
     *
     * @return bool Always false
     */
    public static function role_display( $profileuser ) {
        // Bail if current user cannot edit users
        if ( ! current_user_can( 'edit_user', $profileuser->ID ) || !current_user_can( 'manage_options') ) {
            return;
        }

        $checked = in_array( hrm_manager_role_key(), $profileuser->roles ) ? 'checked' : '';
        
        ?>

        <h3><?php esc_html_e( 'HRM', 'erp' ); ?></h3>

        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="erp-hr-role"><?php esc_html_e( 'HRM Manager', 'erp' ); ?></label></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>HRM Manager</span></legend>
                            <label for="hrm-manager">
                                <input <?php echo $checked; ?> name="hrm_manager" type="checkbox" id="hrm-manager" value="hrm_manager" >
                                Confirm HRM manager
                            </label>
                            <br>
                        </fieldset>
                    </td>
                </tr>

            </tbody>
        </table>

        <?php
    }

    public static function profile_update_role( $user_id ) {
        $POST = wp_unslash( $_POST );
        $postdata = $POST;
        // Bail if no user ID was passed
        if ( empty( $user_id ) ) {
            return;
        }

        // AC role we want the user to have
        $new_role = isset( $postdata['hrm_manager'] ) ? sanitize_text_field( $postdata['hrm_manager'] ) : false;


        // Bail if current user cannot promote the passing user
        if ( ! current_user_can( 'promote_user', $user_id ) ) {
            return;
        }

        // Set the new HRM role
        $user = get_user_by( 'id', $user_id );

        if ( $new_role ) {
            $user->add_role( $new_role );
        } else if ( count( $user->roles ) >= 1 ) {
            $user->remove_role( hrm_manager_role_key() );
            $user->add_role( hrm_employee_role_key() );
        }
    }

    function employer_role() {
        $role_name            = hrm_employee_role_key();
        $display_name         = __( 'HRM Employee', 'hrm' );
        $capabilities['read'] = true;
        add_role( $role_name, $display_name, $capabilities );

        $role_name            = hrm_manager_role_key();
        $display_name         = __( 'HRM Manager', 'hrm' );
        $capabilities['read'] = true;
        add_role( $role_name, $display_name, $capabilities );
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

    // function admin_notice( $field_value = null ) {
    //     $user_id = get_current_user_id();
    //     $redirect = ( isset( $POST['hrm_dataAttr']['redirect'] ) && !empty( $POST['hrm_dataAttr']['redirect'] ) ) ? $POST['hrm_dataAttr']['redirect'] : '';

    //     if ( $field_value !== null ) {
    //         $notice['id'] = array(
    //             'type' => 'hidden',
    //             'value' => isset( $field_value['id'] ) ? $field_value['id'] : '',
    //         );
    //     }

    //     $notice['title'] = array(
    //         'label' =>  __( 'Title', 'hrm' ),
    //         'type' => 'text',
    //         'value' => isset( $field_value['title'] ) ? $field_value['title'] : '',
    //         'extra' => array(
    //             'data-hrm_validation' => true,
    //             'data-hrm_required' => true,
    //             'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
    //         ),
    //     );

    //     $notice['description'] = array(
    //         'label' =>  __( 'Description', 'hrm' ),
    //         'class' => 'hrm-admin-notice-field',
    //         'type' => 'textarea',
    //         'value' => isset( $field_value['description'] ) ? $field_value['description'] : '',
    //     );

    //     $notice['user_id'] = array(
    //         'type' => 'hidden',
    //         'value' => isset( $user_id ) ? $user_id : '',
    //     );
    //     $notice['date'] = array(
    //         'label' =>  __( 'date', 'hrm' ),
    //         'type' => 'text',
    //         'class' => 'hrm-datepicker',
    //         'value' => isset( $field_value['date'] ) ? $field_value['date'] : '',
    //     );

    //     $notice['action'] = 'ajax_referer_insert';
    //     $notice['table_option'] = 'hrm_notice';
    //     $notice['header'] = 'Notice';
    //     $notice['url'] = $redirect;
    //     ob_start();
    //     echo hrm_Settings::getInstance()->hidden_form_generator( $notice );

    //     $return_value = array(
    //         'append_data' => ob_get_clean(),
    //     );

    //     return $return_value;
    // }

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


    function get_projects( $tab, $subtab, $limit = '-1' ) {
        $POST = wp_unslash( $_POST );
        $args = array(
            'posts_per_page' => $limit,
            'post_type'      => 'hrm_project',
            'post_status'    => 'publish',
        );

        if ( hrm_user_can_access( $page, $tab, $subtab, $subtab.'_assign_project' ) ) {
            add_filter('posts_join', array( $this, 'project_role_table' ) );
            add_filter( 'posts_where', array( $this, 'get_project_role' ), 10, 2 );
        }

        if ( isset( $POST['type'] ) && $POST['type'] == '_search' ) {
            $args['s'] = isset( $POST['title'] ) ? trim( $POST['title'] ) : '';
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
        $GET = wp_unslash( $_GET );
        $post_title = $GET['title'];
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
        $employee_id     = isset( $POST['id'] )  ?  $POST['id'] : false;
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
            return new WP_Error( 'error', __('Username required ', 'hrm' ) );
        }

        if( empty($postdata['email']) ) {
            return new WP_Error( 'error', __('Eamil required', 'hrm' ) );
        }

        if ( ! is_email($postdata['email'] ) ) {
            return new WP_Error( 'error', __('Invalid email', 'hrm' ) );
        }

        if( username_exists( $postdata['user_name'] ) ) {
            return new WP_Error( 'error', __('Username already exist', 'hrm' ) );
        }

        if( email_exists( $postdata['email']) ) {
            return new WP_Error( 'error', __('Email already exist', 'hrm' ) );
        }

        return true;
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
        $POST = wp_unslash( $_POST );
        if( isset( $POST['hrm_search'] ) ) {
            hrm_Settings::getInstance()->search();
        }

        if( isset( $POST['hrm_pagination'] ) ) {
            hrm_Settings::getInstance()->pagination_query_arg();
        }

    }


    function search( $limit = null ) {

        check_ajax_referer( 'hrm_nonce' );
        $GET = wp_unslash( $_GET );
        $POST = wp_unslash( $_POST );

        if( ! isset( $POST['table_option'] ) || empty( $POST['table_option'] ) ) {

            foreach ($GET as $key => $value) {
                $data[$key] = $value;
            }
            unset( $data['pagenum'] );
            $data['hrm_error'] = 'table_option';
            $query_arg = add_query_arg( $data, admin_url( 'admin.php' ));

            wp_redirect( $query_arg  );
        }

        $table_option = get_option( $POST['table_option'] );
        $table_option['table_option'] = ( isset( $table_option['table_option'] ) && is_array( $table_option['table_option'] ) ) ? $table_option['table_option'] : array();


        foreach ( $table_option['table_option'] as $name => $value ) {
            if( isset( $POST[$value] ) && ! empty( $POST[$value] ) ) {
                $data[$value] = urlencode( $POST[$value] );
            }

            if( isset( $GET[$value] ) ) {

                unset( $GET[$value] );
            }
        }



        if( $data ) {
            $data['table_option'] = $POST['table_option'];
            $data['_wpnonce'] = $POST['_wpnonce'];
            $data['type'] = '_search';
        }

        foreach ($GET as $key => $value) {
            $data[$key] = $value;
        }

        unset( $data['pagenum'] );
        $query_arg = add_query_arg( $data, admin_url( 'admin.php' ));


        wp_redirect(  $query_arg );
    }

    function search_query( $limit ) {
        check_ajax_referer( 'hrm_nonce' );
        $GET = wp_unslash( $_GET );
        if( ! isset( $GET['table_option'] ) && empty( $GET['table_option'] ) ) {
            return;
        }
        $table_option['table_option'] = array();
        $table_option = get_option( $GET['table_option'] );

        $data = array();
        foreach ( $table_option['table_option'] as $name => $value ) {
            if( isset( $GET[$value] ) && ! empty( $GET[$value] ) ) {
                $data[] = $name .' LIKE ' ."'%".trim( $GET[$value] ) ."%'";
            }
        }

        $where = implode( $data, ' AND ');


        global $wpdb;
        $tabledb = $wpdb->prefix . $table_option['table_name'];

        $pagenum = isset( $GET['pagenum'] ) ? absint( $GET['pagenum'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;

        $results = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb WHERE $where ORDER BY id desc LIMIT $offset,$limit" );
        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );

        return $results;
    }

    function show_tab_page( $page = null ) {
        $GET = wp_unslash( $_GET );
        $tab = isset( $GET['tab'] ) ? $GET['tab'] : '';
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
        $GET = wp_unslash( $_GET );
        $subtab = isset( $GET['sub_tab'] ) ? $GET['sub_tab'] : '';
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
        $GET = wp_unslash( $_GET );
        $tabledb = $wpdb->prefix . $table;

        $pagenum = isset( $GET['pagenum'] ) ? absint( $GET['pagenum'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;
        $results = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb ORDER BY id desc LIMIT $offset,$limit" );
        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );

        return $results;
    }

    function pagination( $total, $limit ) {
        $GET = wp_unslash( $_GET );
        $pagenum = isset( $GET['pagenum'] ) ? absint( $GET['pagenum'] ) : 1;
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
        //var_dump( $POST);
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

    public static function ajax_update_department() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        $department  = self::update_department( $POST );
        $page_number = empty( $POST['page_number'] ) ? 1 : $POST['page_number'];
        //$departments    = self::get_departments(false, true);
        //$formated_depts = self::get_department_by_hierarchical( $departments['departments'] );


        $departments = self::get_departments( false, true );
        
        $send_depts     = self::get_department_by_hierarchical( $departments['departments'], $page_number, 1000 );
        $dept_drop_down = self::get_department_by_hierarchical( $departments['departments'], 1, 1000 );
        

        if ( is_wp_error( $department ) ) {
            wp_send_json_error( array( 'error' => $department->get_error_messages() ) ); 
        } else {
            wp_send_json_success( array( 
                'department'  => $department, 
                'departments' => $send_depts, 
                'total_dept'  => $departments['total_dept'],
                'dept_drop_down' => $dept_drop_down,
                'success'     => __( 'Department has been created successfully', 'hrm' ) 
            ) );
        }
    }

    public static function update_department( $postdata ) {
        
        if ( empty( $postdata['title'] ) ) {
            return new WP_Error( 'dept_title', __( 'Department title required', 'hrm' ) );
        }

        global $wpdb;
        
        $dept_id = empty( $postdata['dept_id'] ) ? false : absint( $postdata['dept_id'] );
        $dept_id = $dept_id ? $dept_id : false;

        $table = $wpdb->prefix . 'hrm_job_category'; 
        $data  = array(
            'name'        => $postdata['title'],
            'active'      => $postdata['status'],
            'description' => $postdata['description'],
            'parent'      => empty( $postdata['parent'] ) || ( $postdata['parent'] == '-1' ) ? 0 : absint( $POST['parent'] ),
        );
        $format = array( '%s', '%d', '%s', '%d' );

        if ( $dept_id ) {
            $result = $wpdb->update( $table, $data, array( 'id' => $dept_id ), $format, array( '%d' ) );

        } else {

            $result  = $wpdb->insert( $table, $data, $format );
            $dept_id = $wpdb->insert_id;
        }

        $department = self::get_departments( $dept_id );

        if ( $result ) {
            return array( 'dept_id' => $dept_id, 'department' => $department );
        }

        return new WP_Error( 'dept_unknoen', __( 'Something went wrong!', 'hrm' ) );
    }

    public static function ajax_get_departments() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        $page_number = empty( $POST['page_number'] ) ? 1 : $POST['page_number'];
        
        $departments = self::get_departments( false, true );
        
        $send_depts     = self::get_department_by_hierarchical( $departments['departments'], $page_number, 1000 );
        $dept_drop_down = self::get_department_by_hierarchical( $departments['departments'], 1, 1000 );
        
        wp_send_json_success(array( 
            'departments' => $send_depts,
            'total_dept'  => $departments['total_dept'],
            'dept_drop_down' => $dept_drop_down
        ));
    }

    public static function get_department_by_hierarchical( $departments, $page_number, $per_page ) {
        $depts = array();
        
        foreach ( $departments as $key => $dept ) {
            $depts[$dept->id] = $dept;
        }
        
        $departments_hierachical = self::display_rows_hierarchical( $departments, $page_number, $per_page );
        $fromated_depts = array();
        
        foreach ( $departments_hierachical as $id => $hierarchical_depth ) {
            $depts[$id]->hierarchical_depth    = $hierarchical_depth;
            $depts[$id]->hierarchical_pad      = str_repeat( '&#8212; ', $hierarchical_depth );
            $depts[$id]->hierarchical_free_pad = str_repeat( '&nbsp; ', $hierarchical_depth ); 

            $fromated_depts[] = $depts[$id];
        }

        return $fromated_depts;
    }

    public static function get_employee_department( $employee_id = false ) {
        $employee_id = $employee_id ? $employee_id : get_current_user_id();
        $dept_id = get_user_meta( $employee_id, 'hrm_job_category', true );

        if ( $dept_id ) {
            return Department::where('active', '1')
                ->where('id', $dept_id)
                ->first();
        }

       return false; 
    }

    public static function get_departments( 
        $dept_id  = false, 
        $show_all = false,
        $pagenum  = 1,
        $limit    = 100
    ) {
        
        global $wpdb;

        $table           = $wpdb->prefix . 'hrm_job_category';
        $user_meta_table = $wpdb->prefix . 'usermeta';
        $offset          = ( $pagenum - 1 ) * $limit;

        if ( $dept_id ) {
            $query =  $wpdb->prepare( 
                "
                SELECT      *
                FROM        {$table}
                WHERE       1 = 1
                AND         id = %d
                ",
                $dept_id
            ); 

            $results = $wpdb->get_row( $query );

        } else if ( true === $show_all ) {
            
            $query = "
                SELECT      SQL_CALC_FOUND_ROWS *
                FROM        {$table}
                WHERE       1 = 1
                ORDER BY    id ASC"; 
            
            $results = $wpdb->get_results( $query );
            $total_departments = $wpdb->get_var( "SELECT FOUND_ROWS()" );

        } else {
            
            $query =  $wpdb->prepare( 
                "
                SELECT      SQL_CALC_FOUND_ROWS *
                FROM        {$table}
                WHERE       1 = 1
                ORDER BY    id ASC
                LiMIT       %d,%d
                ",
                $offset,
                $limit
            ); 

            $results = $wpdb->get_results( $query );
            $total_departments = $wpdb->get_var( "SELECT FOUND_ROWS()" );
            
        }

        
        if ( $dept_id && $results ) {

            $query = "
                SELECT      meta_value as department_id, count(meta_value) as num_of_employee
                FROM        {$user_meta_table}
                WHERE       1 = 1
                AND         meta_key = '_job_category'
                AND         meta_value = $dept_id
                GROUP BY meta_value
                ";
                
            $employee_counts = $wpdb->get_row($query);
            $results->number_of_employee = empty( $employee_counts->num_of_employee ) ? 0 : $employee_counts->num_of_employee;
        
        } else if ( $results ) {
            $dept_emps = wp_list_pluck( $results, 'id' );
            $dept_emps = implode( ",", $dept_emps);
            
            $query = "
                SELECT      meta_value as department_id, count(meta_value) as num_of_employee
                FROM        {$user_meta_table}
                WHERE       1 = 1
                AND         meta_key = '_job_category'
                AND         meta_value IN ($dept_emps)
                GROUP BY    meta_value
                ";
                
            $employee_counts = $wpdb->get_results($query);
            $employee_counts = wp_list_pluck( $employee_counts, 'num_of_employee', 'department_id' );
            

            foreach ( $results as $key => $employee ) {
                $count = empty( $employee_counts[$employee->id] ) ? 0 : $employee_counts[$employee->id];
                $employee->number_of_employee = $count;
            }
        }

        if ( $dept_id ) {
            return $results;
        }
       
        return array( 'total_dept' => $total_departments, 'departments' => $results );
    }



    /**
     * Display Row hierarchical
     *
     * @param array departments
     * @param integer $pagenum
     * @param integer $per_page
     *
     * @return void
     */
    public static function display_rows_hierarchical( $departments, $pagenum = 1, $per_page = 20 ) {
        
        $level = 0;

        if ( empty( $_REQUEST['s'] ) ) {

            $top_level_departments = array();
            $children_departments = array();

            foreach ( $departments as $page ) {

                if ( 0 == $page->parent )
                    $top_level_departments[] = $page;
                else
                    $children_departments[ $page->parent ][] = $page;
            }

            $departments = &$top_level_departments;
        }

        $count = 0;
        $start = ( $pagenum - 1 ) * $per_page;
        $end = $start + $per_page;
        $to_display = array();

        foreach ( $departments as $page ) {
            if ( $count >= $end )
                break;

            if ( $count >= $start ) {
                $to_display[$page->id] = $level;
            }

            $count++;

            if ( isset( $children_departments ) )
                self::page_rows( $children_departments, $count, $page->id, $level + 1, $pagenum, $per_page, $to_display );
        }

        // If it is the last pagenum and there are orphaned departments, display them with paging as well.
        if ( isset( $children_departments ) && $count < $end ){
            foreach ( $children_departments as $orphans ){
                foreach ( $orphans as $op ) {
                    if ( $count >= $end )
                        break;

                    if ( $count >= $start ) {
                        $to_display[$op->id] = 0;
                    }

                    $count++;
                }
            }
        }


        // foreach ( $to_display as $department_id => $level ) {

        //     $this->single_row( $department_id, $level );
        // }
        return $to_display;
    }

        /**
     * Single Page row
     *
     * @param array $children_departments
     * @param integer $count
     * @param integer $parent
     * @param integer $level
     * @param integer $pagenum
     * @param integer $per_page
     * @param array $to_display List of pages to be displayed. Passed by reference.
     *
     * @return void
     */
    public static function page_rows( &$children_departments, &$count, $parent, $level, $pagenum, $per_page, &$to_display ) {

        if ( ! isset( $children_departments[$parent] ) )
            return;

        $start = ( $pagenum - 1 ) * $per_page;
        $end = $start + $per_page;

        foreach ( $children_departments[$parent] as $page ) {

            if ( $count >= $end )
                break;

            // If the page starts in a subtree, print the parents.
            if ( $count == $start && $page->parent > 0 ) {
                $my_parents = array();
                $my_parent = $page->parent;
                while ( $my_parent ) {
                    // Get the ID from the list or the attribute if my_parent is an object
                    $parent_id = $my_parent;
                    if ( is_object( $my_parent ) ) {
                        $parent_id = $my_parent->id;
                    }

                    $my_parent = self::get_departments($parent_id); //(object) \WeDevs\ERP\HRM\Models\Department::find($parent_id)->toArray();//get_post( $parent_id );
                    $my_parents[] = $my_parent;
                    if ( !$my_parent->parent )
                        break;
                    $my_parent = $my_parent->parent;
                }
                $num_parents = count( $my_parents );
                while ( $my_parent = array_pop( $my_parents ) ) {
                    $to_display[$my_parent->id] = $level - $num_parents;
                    $num_parents--;
                }
            }

            if ( $count >= $start ) {
                $to_display[$page->id] = $level;
            }

            $count++;

            self::page_rows( $children_departments, $count, $page->id, $level + 1, $pagenum, $per_page, $to_display );
        }

        unset( $children_departments[$parent] ); //required in order to keep track of orphans
    }

    public static function ajax_delete_department() {
        check_ajax_referer('hrm_nonce');
        $POST = wp_unslash( $_POST );
        $results = self::delete_department( $POST['dept_id'] );

        $departments = self::get_departments( false, true );
        $dept_drop_down = self::get_department_by_hierarchical( $departments['departments'], 1, 1000 );

        if ( is_wp_error( $results ) ) {
            wp_send_json_error( array( 'error' => $results->get_error_messages() ) ); 
        } else {
            wp_send_json_success( array( 
                'deleted_dept' => $results['deleted_dept'], 
                'undone_dept'  => $results['undone_dept'], 
                'dept_drop_down' => $dept_drop_down,
                'success'      => __( 'Department has been deleted successfully', 'hrm' ) 
            ) );
        }
    }

    public static function delete_department($dept_id) {
        
        global $wpdb;

        //get all employee
        $employess   = self::is_employee_exist_in_department( $dept_id );
        //filter department id from all employees
        $emp_dept_id = wp_list_pluck( $employess, 'department_id' );

        $undone_dept = array();

        foreach ( $dept_id as $key => $department_id ) {
            if ( in_array( $department_id, $emp_dept_id ) ) {
                unset( $dept_id[$key] );
                $undone_dept[$department_id] = $department_id;
            }
        }   

        if ( empty( $dept_id ) ) {
            return new WP_Error( 'dept_id', __( 'Required department id!', 'hrm' ) );
        }

        $table    = $wpdb->prefix . 'hrm_job_category';
        $dept_ids = implode( "','", $dept_id );

        $delete = $wpdb->query( 
            "
             DELETE FROM {$table}
             WHERE id IN ('$dept_ids')
            "
        ); 
        
        if ( $delete ) {
            return array( 'deleted_dept' => $dept_id, 'undone_dept' => $undone_dept ); 
        } else {
            return new WP_Error( 'dept_unknoen', __( 'Something went wrong!', 'hrm' ) );
        }
          
    }

    public static function is_employee_exist_in_department( $depts_id ) {
        
        $args = array(
            'role__in' => array( 'hrm_employee' ),
            'fields'   => 'all_with_meta',
            'meta_query' => array(

                array(
                    'key'     => '_job_category',
                    'value'   => $depts_id,
                    'compare' => 'IN'
                )
            )
        );

        $users = new WP_User_Query( $args );

        foreach ( $users->results as $key => $user ) {
            $user->department_id = get_user_meta( $user->id, '_job_category', true );
        }

        return $users->results;

    }
}


