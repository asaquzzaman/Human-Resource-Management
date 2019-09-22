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
        //add_action( 'init', array($this, 'admin_init_action') );
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

        $postdata = [
            'title' => hrm_clean( $_POST['title'] ),
            'page'  => intval( $_POST['page'] )
        ];

        $locations = $this->designation_filter( $postdata );

        wp_send_json_success($locations);
    }

    function designation_filter( $postdata = [], $id = false  ) {
            
        $title     = empty( $postdata['title'] ) ? '' : hrm_clean( $postdata['title'] );
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

        $postdata = [
            'title' => hrm_clean( $_POST['title'] ),
            'from'  => hrm_clean( $_POST['from'] ),
            'to'    => hrm_clean( $_POST['to'] ),
            'page'  => intval( $_POST['page'] )
        ];

        $locations = $this->notice_filter( $postdata );

        wp_send_json_success($locations);
    }

    function notice_filter( $postdata = [], $id = false  ) {
            
        $title     = empty( $postdata['title'] ) ? '' : hrm_clean( $postdata['title'] );
        $page      = empty( $postdata['page'] ) ? 1 : intval( $postdata['page'] );
        $from      = empty( $postdata['from'] ) ? '' : hrm_clean( $postdata['from'] );
        $to        = empty( $postdata['to'] ) ? '' : hrm_clean( $postdata['to'] );
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

        $postdata = [
            'name' => hrm_clean( $_POST['name'] ),
            'page'  => intval( $_POST['page'] )
        ];
        
        $locations = $this->location_filter( $postdata );

        wp_send_json_success( $locations );
    }

    function location_filter( $postdata = [], $id = false  ) {
            
        $name     = empty( $postdata['name'] ) ? '' : hrm_clean( $postdata['name'] );
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
                    <th><label for="hrm-role"><?php esc_html_e( 'HRM Manager', 'erp' ); ?></label></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>HRM Manager</span></legend>
                            <label for="hrm-manager">
                                <input <?php echo esc_html( $checked ); ?> name="hrm_manager" type="checkbox" id="hrm-manager" value="hrm_manager" >
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

        // Bail if no user ID was passed
        if ( empty( $user_id ) ) {
            return;
        }

        // AC role we want the user to have
        $new_role = isset( $_POST['hrm_manager'] ) ? hrm_clean( $_POST['hrm_manager'] ) : false;


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

    function get_general_info() {
        return get_option( 'hrm_general_info' );
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
        $employee_id     = isset( $POST['id'] )  ?  intval( $POST['id'] ) : false;
        $this->emp_upload_image($employee_id);
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

    public static function ajax_update_department() {
        check_ajax_referer('hrm_nonce');

        $postdata = [
            'title'       => hrm_clean( $_POST['title'] ),
            'status'      => hrm_clean( $_POST['status'] ),
            'description' => hrm_clean( $_POST['description'] ),
            'parent'      => hrm_clean( $_POST['parent'] ),
            'dept_id'     => intval( $_POST['dept_id'] )
        ];
        
        $department  = self::update_department( $postdata );
        $page_number = empty( $_POST['page_number'] ) ? 1 : intval( $_POST['page_number'] );
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
        
        if ( empty( hrm_clean( $postdata['title'] ) ) ) {
            return new WP_Error( 'dept_title', __( 'Department title required', 'hrm' ) );
        }

        global $wpdb;
        
        $dept_id = empty( $postdata['dept_id'] ) ? false : absint( $postdata['dept_id'] );
        $dept_id = $dept_id ? $dept_id : false;

        $table = $wpdb->prefix . 'hrm_job_category'; 
        $data  = array(
            'name'        => hrm_clean( $postdata['title'] ),
            'active'      => hrm_clean( $postdata['status'] ),
            'description' => sanitize_textarea_field( $postdata['description'] ),
            'parent'      => empty( $postdata['parent'] ) || ( $postdata['parent'] == '-1' ) ? 0 : absint( $postdata['parent'] ),
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
        
        $page_number = empty( $_POST['page_number'] ) ? 1 : intval( $_POST['page_number'] );
        
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
                FROM        " . $wpdb->prefix . "hrm_job_category
                WHERE       1 = 1
                AND         id = %d
                ",
                $dept_id
            ); 

            $results = $wpdb->get_row( $query );

        } else if ( true === $show_all ) {
            
            $query = "
                SELECT      SQL_CALC_FOUND_ROWS *
                FROM        " . $wpdb->prefix . "hrm_job_category
                WHERE       1 = 1
                ORDER BY    id ASC"; 
            
            $results = $wpdb->get_results( $query );
            $total_departments = $wpdb->get_var( "SELECT FOUND_ROWS()" );

        } else {
            
            $query =  $wpdb->prepare( 
                "
                SELECT      SQL_CALC_FOUND_ROWS *
                FROM        " . $wpdb->prefix . "hrm_job_category
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

            $query = $wpdb->prepare("
                SELECT      meta_value as department_id, count(meta_value) as num_of_employee
                FROM        " . $wpdb->prefix . "usermeta
                WHERE       1 = 1
                AND         meta_key = %s
                AND         meta_value = %d
                GROUP BY meta_value
                ", 'hrm_job_category', $dept_id);
                
            $employee_counts = $wpdb->get_row($query);
            $results->number_of_employee = empty( $employee_counts->num_of_employee ) ? 0 : $employee_counts->num_of_employee;
        
        } else if ( $results ) {
            $dept_emps = wp_list_pluck( $results, 'id' );
            $dept_emps = implode( ",", $dept_emps);
            
            $query = "
                SELECT      meta_value as department_id, count(meta_value) as num_of_employee
                FROM        {$user_meta_table}
                WHERE       1 = 1
                AND         meta_key = 'hrm_job_category'
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
        
        $results = self::delete_department( hrm_clean( $_POST['dept_id'] ) );

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
        $dept_id = !is_array( $dept_id ) ? [$dept_id] : $dept_id;
        
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
             DELETE FROM " . $wpdb->prefix . "hrm_job_category
             WHERE id IN ('$dept_ids')
            "
        ); 
        
        if ( $delete ) {
            return array( 'deleted_dept' => $dept_id, 'undone_dept' => $undone_dept ); 
        } else {
            return new WP_Error( 'dept_unknoen', __( 'Something wrong!', 'hrm' ) );
        }
          
    }

    public static function is_employee_exist_in_department( $depts_id ) {
        
        $args = array(
            'role__in' => array( 'hrm_employee' ),
            'fields'   => 'all_with_meta',
            'meta_query' => array(

                array(
                    'key'     => 'hrm_job_category',
                    'value'   => $depts_id,
                    'compare' => 'IN'
                )
            )
        );

        $users = new WP_User_Query( $args );

        foreach ( $users->results as $key => $user ) {
            $user->department_id = get_user_meta( $user->id, 'hrm_job_category', true );
        }

        return $users->results;

    }
}


