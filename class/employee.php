<?php
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Item as Item;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Models\Work_Experience;
use HRM\Models\Education;
use HRM\Models\Department;
use HRM\Models\Designation;
use HRM\Models\Skill;
use HRM\Transformers\Work_Experience_Transformer;
use HRM\Transformers\Education_Transformer;
use HRM\Transformers\Skill_Transformer;
use HRM\Core\File_System\File_System;
use HRM\Transformers\Employee_Transformer;
use Illuminate\Pagination\Paginator;

class Hrm_Employee {
    use Transformer_Manager;

    public static function getInstance() {
        static $_instance;
        if( ! $_instance ) {
            $_instance = new hrm_Employee();
        }

        return $_instance;
    }

    function __construct() {
        //add_filter( 'hrm_employee_memu', array( $this, 'pim_to_employer' ) );
        add_action( 'cpm_after_ajax_upload', array( $this, 'after_ajax_upload' ), 10, 3 );
        add_action( 'hrm_after_new_information', array( $this, 'after_inset_information' ), 10, 2 );
        add_action( 'wp_ajax_hrm_get_dashboard_birthdays', array( $this, 'get_dashboard_birthdays' ) );
        add_action( 'wp_ajax_hrm_insert_employee', array( $this, 'ajax_insert_employee' ) );
        add_action( 'wp_ajax_hrm_get_employees', array( $this, 'ajax_get_employees' ) );
        add_action( 'wp_ajax_hrm_delete_employee', array( $this, 'ajax_delete_employee' ) );
        add_action( 'wp_ajax_hrm_employee_filter', array( $this, 'ajax_employee_filter' ) );
        add_action( 'wp_ajax_hrm_get_employee_job_location', array( $this, 'ajax_get_employee_job_location' ) );
        add_action( 'wp_ajax_hrm_experiance_filter', array( $this, 'ajax_experiance_filter' ) );
        add_action( 'wp_ajax_hrm_education_filter', array( $this, 'ajax_education_filter' ) );
        add_action( 'wp_ajax_hrm_skill_filter', array( $this, 'ajax_skill_filter' ) );
        add_action( 'wp_ajax_hrm_get_personal_info', array( $this, 'ajax_get_personal_info' ) );
        add_action( 'wp_ajax_hrm_save_personal_info', array( $this, 'ajax_save_personal_info' ) );
    }

    public static function ajax_delete_employee() {
        check_ajax_referer('hrm_nonce');
        $employee_ids = hrm_clean( $_POST['delete'] );
        self::getInstance()->delete_employee( $employee_ids );

        wp_send_json_success();
    }

    public function delete_employee( $ids ) {
        foreach ( $ids as $key => $id ) {
            wp_delete_user( $id );
        }
    }

    public function ajax_employee_filter() {
        check_ajax_referer('hrm_nonce');

        $_POST['page'] = empty( $_POST['page'] ) ? 1 : absint( $_POST['page'] );
        $_POST['name'] = empty( $_POST['name'] ) ? '' : hrm_clean( $_POST['name'] );

        $postdata = [];

        $postdata['search']         = '*' . hrm_clean( $_POST['name'] ) . '*';
        $postdata['search_columns'] = array( 'user_login', 'user_email', 'user_nicename' );
        $postdata['page']           = empty( $_POST['page'] ) ? 1 : absint( $_POST['page'] );
        $postdata['number']         = empty( $_POST['number'] ) ? hrm_per_page() : intval( $_POST['number'] );
        
        $employees = self::getInstance()->get_employees( $postdata );
        
        wp_send_json_success( $employees );
    }

    public static function ajax_get_employees() {
        check_ajax_referer('hrm_nonce');
        
        $postdata['page']  = intval( $_POST['page'] );
        $employees = self::getInstance()->get_employees( $postdata );
        
        wp_send_json_success( $employees );
    }

    public static function  ajax_insert_employee() {
        check_ajax_referer('hrm_nonce');
        $postdata = [
            'id'             => isset( $_POST['id'] ) ? intval( $_POST['id'] ) : '',
            'firstName'      => isset( $_POST['firstName'] ) ? hrm_clean( $_POST['firstName'] ) : '',
            'lastName'       => isset( $_POST['lastName'] ) ? hrm_clean( $_POST['lastName'] ) : '',
            'userName'       => isset( $_POST['userName'] ) ? hrm_clean( $_POST['userName'] ) : '',
            'email'          => isset( $_POST['email'] ) ? hrm_clean( $_POST['email'] ) : '',
            'role'           => isset( $_POST['role'] ) ? hrm_clean( $_POST['role'] ) : '',
            'joiningDate'    => isset( $_POST['joiningDate'] ) ? hrm_clean( $_POST['joiningDate'] ) : '',
            'department'     => isset( $_POST['department'] ) ? hrm_clean( $_POST['department'] ) : '',
            'location'       => isset( $_POST['location'] ) ? hrm_clean( $_POST['location'] ) : '',
            'description'    => isset( $_POST['description'] ) ? hrm_clean( $_POST['description'] ) : '',
            'status'         => isset( $_POST['status'] ) ? hrm_clean( $_POST['status'] ) : '',
            'mobileNumber'   => isset( $_POST['mobileNumber'] ) ? hrm_clean( $_POST['mobileNumber'] ) : '',
            'gender'         => isset( $_POST['gender'] ) ? hrm_clean( $_POST['gender'] ) : '',
            'designation'    => isset( $_POST['designation'] ) ? hrm_clean( $_POST['designation'] ) : '',
            'employee_image' => isset( $_POST['employee_image'] ) ? hrm_clean( $_POST['employee_image'] ) : '', 
        ];

        
        $employee_id = self::getInstance()->add_new_employee( $postdata );
        $employee    = self::getInstance()->get_employee( $employee_id );
        
        wp_send_json_success( $employee );
    }

    function get_dashboard_birthdays() {
        $today    = date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) );
        $next_day = date( 'Y-m-d', strtotime( current_time( 'mysql' ) . ' + 2 days' ) );

        
        $users = new WP_User_Query( array (
            'role__in' => array (
                hrm_manager_role_key(),
                hrm_employee_role_key()
            ),

            'meta_query' => array(
                array(
                    'key' => '_birthday',
                    'value' => $today,
                    'type' => 'DATE',
                    'compare' => '>=' 
                ),

                array(
                    'key' => '_birthday',
                    'type' => 'DATE',
                    'value' => $next_day,
                    'compare' => '<=' 
                )
            )
        ));

        foreach ( $users->results as $key => $result ) {
            $birthday                 = get_user_meta( $result->ID, '_birthday', true );
            $result->data->birthday   = hrm_get_date( $birthday );
            $result->data->avatar_url = hrm_get_avater( $result->ID );
        }

        wp_send_json_success( $users->results );
    }

    function after_inset_information( $post, $last_inserted_id ) {
        if ( isset( $post['table_option'] ) && hrm_clean( $post['table_option'] ) == 'hrm_salary' ) {
            $table_option = get_option( hrm_clean( $post['table_option'] ) );
            $employee_id  = intval( $post['emp_id'] );
            $to_user      = get_user_by( 'id', $employee_id );
            $to           = $to_user->user_email;
            $sender       = get_current_user_id();
            $subject      = __( 'Salary', 'hrm' );

            $last_recored = Hrm_Settings::getInstance()->conditional_query_val( $table_option['table_name'], '*', array( 'id' => $last_inserted_id ), true );

            $message = $this->get_salary_message_body( $last_recored, $post, $to_user );

            Hrm_Settings::getInstance()->send( $to, $subject, $message, $sender );
        }
    }

    function delete_file( $file_id, $force = true, $employee_id ) {
        wp_delete_attachment( $file_id, $force );
        ob_start();
        $this->emp_upload_image($employee_id);
        return ob_get_clean();
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


    function after_ajax_upload( $response, $file, $post ) {
        if ( !isset( $post['employee_id'] ) ) {
            return;
        }
        $file_id = $response['file_id'];
        $employee_id = $post['employee_id'];
        update_user_meta( $employee_id, 'hrm_user_image_id', $file_id );
    }

    function pim_to_employer( $page = null ) {
        $current_user = wp_get_current_user();
        $role = reset( $current_user->roles );

        if ( $role == 'hrm_employee' ) {
            unset( $page['hrm_pim']['employee_list'] );
            $page['hrm_employee'] = $page['hrm_pim'];
            $page['hrm_employee']['personal']['follow_access_role'] = false;
            $page['hrm_employee']['organization_info']['follow_access_role'] = false;
            $page['hrm_employee']['my_task']['follow_access_role'] = false;
            $page['hrm_employee']['leave']['follow_access_role'] = false;
            unset( $page['hrm_pim'] );
        }

        return $page;
    }

    function edit_my_info( $postdata, $table_options ) {
        $id = intval( $postdata['user_id'] );
        $user_id = false;

        foreach ( $table_options as $db_field => $form_field ) {
            if ( ! isset( $postdata[$form_field] ) ) {
                continue;
            }
            $user_id = update_user_meta( $id, $db_field, esc_attr( $postdata[$form_field] ) );
        }

        if ( $user_id ) {
            return $user_id;
        } else {
            return false;
        }

    }

    public static function ajax_experiance_filter() {
        check_ajax_referer('hrm_nonce');

        $postdata = [
            'title'       => isset( $_POST['title'] ) ? hrm_clean( $_POST['title'] ) : '',
            'from'        => isset( $_POST['from'] ) ? hrm_clean( $_POST['from'] ) : '',
            'to'          => isset( $_POST['to'] ) ? hrm_clean( $_POST['to'] ) : '',
            'employee_id' => isset( $_POST['employee_id'] ) ? hrm_clean( $_POST['employee_id'] ) : '',
            'page'        => isset( $_POST['page'] ) ? hrm_clean( $_POST['page'] ) : ''
         ];

        $result = self::getInstance()->experiance_filter( $postdata );
        wp_send_json_success( $result );
    }

    function experiance_filter( $postdata ) {
        $title       = empty( $postdata['title'] ) ? '': hrm_clean( $postdata['title'] );
        $from        = empty( $postdata['from'] ) ? '': hrm_clean( $postdata['from'] );
        $to          = empty( $postdata['to'] ) ? '': hrm_clean( $postdata['to'] );
        $employee_id = empty( $postdata['employee_id'] ) ? '': intval( $postdata['employee_id'] );
        $page        = empty(  $postdata['page'] ) ? 1 : intval( $postdata['page'] );
        $per_page    = hrm_per_page();

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $experiance = Work_Experience::where('employee_id', $employee_id)
            ->where( function($q) use($title, $from, $to) {
            if ( ! empty(  $title ) ) {
                $q->where( 'title', 'LIKE', '%' . $title . '%' );
            }
            
            if ( ! empty( $from ) ) {
                $from = date( 'Y-m-d', strtotime( $from ) );
                $q->where( 'start', '>=', $from);
            }

            if ( ! empty( $to ) ) {
                $to = date( 'Y-m-d', strtotime( $to ) );
                $q->where( 'end', '<=', $to);
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );
    
        $collection = $experiance->getCollection();

        $resource = new Collection( $collection, new Work_Experience_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $experiance ) );

        return $this->get_response( $resource );
    }

    public static function ajax_education_filter() {
        check_ajax_referer('hrm_nonce');

        $postdata = [
            'title'       => isset( $_POST['title'] ) ? hrm_clean( $_POST['title'] ) : '',
            'from'        => isset( $_POST['from'] ) ? hrm_clean( $_POST['from'] ) : '',
            'to'          => isset( $_POST['to'] ) ? hrm_clean( $_POST['to'] ) : '',
            'employee_id' => isset( $_POST['employee_id'] ) ? hrm_clean( $_POST['employee_id'] ) : '',
            'page'        => isset( $_POST['page'] ) ? hrm_clean( $_POST['page'] ) : ''
         ];
        
        $result = self::getInstance()->education_filter( $postdata );
        wp_send_json_success( $result );
    }

    function education_filter( $postdata ) {
        $title       = empty( $postdata['title'] ) ? '' : hrm_clean( $postdata['title'] );
        $from        = empty( $postdata['from'] ) ? '' : hrm_clean( $postdata['from'] );
        $to          = empty( $postdata['to'] ) ? '' : hrm_clean( $postdata['to'] );
        $employee_id = intval( $postdata['employee_id'] );
        $page        = empty(  $postdata['page'] ) ? 1 : intval( $postdata['page'] );
        $per_page    = hrm_per_page();

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $experiance = Education::where('employee_id', $employee_id)
            ->where( function($q) use($title, $from, $to) {
            if ( ! empty(  $title ) ) {
                $q->where( 'education', 'LIKE', '%' . $title . '%' );
            }
            
            if ( ! empty( $from ) ) {
                $from = date( 'Y-m-d', strtotime( $from ) );
                $q->where( 'start_date', '>=', $from);
            }

            if ( ! empty( $to ) ) {
                $to = date( 'Y-m-d', strtotime( $to ) );
                $q->where( 'end_date', '<=', $to);
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );
    
        $collection = $experiance->getCollection();

        $resource = new Collection( $collection, new Education_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $experiance ) );

        return $this->get_response( $resource );
    }
    
    public static function ajax_skill_filter() {
        check_ajax_referer('hrm_nonce');

        $postdata = [
            'title'       => isset( $_POST['title'] ) ? hrm_clean( $_POST['title'] ) : '',
            'employee_id' => isset( $_POST['employee_id'] ) ? hrm_clean( $_POST['employee_id'] ) : '',
            'page'        => isset( $_POST['page'] ) ? hrm_clean( $_POST['page'] ) : ''
         ];

        $result = self::getInstance()->skill_filter( $postdata );
        wp_send_json_success( $result );
    }

    function skill_filter( $postdata ) {
        $title       = empty( $postdata['title'] ) ? '' : hrm_clean( $postdata['title'] );
        // $from        = empty( $postdata['from'] ) ? '' : $postdata['from'];
        // $to          = empty( $postdata['to'] ) ? '' : $postdata['to'];
        $employee_id = intval( $postdata['employee_id'] );
        $page        = empty(  $postdata['page'] ) ? 1 : intval( $postdata['page'] );
        $per_page    = hrm_per_page();

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $experiance = Skill::where('employee_id', $employee_id)
            ->where( function($q) use($title) {
            if ( ! empty(  $title ) ) {
                $q->where( 'skill', 'LIKE', '%' . $title . '%' );
            }
        })
        ->orderBy( 'id', 'DESC' )
        ->paginate( $per_page );
    
        $collection = $experiance->getCollection();

        $resource = new Collection( $collection, new Skill_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $experiance ) );

        return $this->get_response( $resource );
    }


    public static function ajax_get_employee_job_location() {
        check_ajax_referer('hrm_nonce');

        $user_id = empty( $_POST['employee_id'] ) ? get_current_user_id() : intval( $_POST['employee_id'] );
        $result = self::getInstance()->get_employee_job_location( $user_id );
        
        wp_send_json_success( $result );
    }

    public function get_employee_job_location( $employee_id ) {
        $location_id = get_user_meta( $employee_id, 'hrm_location', true );
        $location_id = empty( $location_id ) ? -1 : intval( $location_id );

        return Hrm_Admin::getInstance()->location_filter( [], $location_id );
    }


    public static function ajax_get_personal_info() {
        check_ajax_referer('hrm_nonce');
        
        $user_id = empty( $_POST['employee_id'] ) ? get_current_user_id() : intval( $_POST['employee_id'] );
        $result = self::getInstance()->get_personal_info( $user_id );
        wp_send_json_success( $result );
    }

    function get_personal_info( $user_id = false ) {
        $user_id = empty( $user_id ) ? get_current_user_id() : $user_id;
        $user = get_user_by( 'id', $user_id );

        $country_lists = hrm_Settings::getInstance()->country_list();
        $lists = [];

        foreach ( $country_lists as $key => $value ) {
            $lists[] = ['iso' => $key, 'country' => $value];
        }

        $profile_pic = $this->get_profile_picture( $user_id );
        $profile_pic = empty( $profile_pic ) ? [] : $profile_pic;
        
        $default_profile_pic[] = [
            'url'   => get_avatar_url( $user_id ),
            'name'  => $user->display_name,
        ];
    
        return [
            'country_list'    => $lists,
            'hrm_user_image_id' => $profile_pic,
            'department'      => $this->get_employee_department( $user_id ),
            'designation'      => $this->get_employee_designation( $user_id ),
            'hrm_gender'         => get_user_meta( $user_id, 'hrm_gender', true ),
            '_marital_status' => get_user_meta( $user_id, '_marital_status', true ),
            '_national_code'  => get_user_meta( $user_id, '_national_code', true ),
            '_birthday'       => hrm_get_date2mysql( get_user_meta( $user_id, '_birthday', true ) ),
            '_street1'        => get_user_meta( $user_id, '_street1', true ),
            '_street2'        => get_user_meta( $user_id, '_street2', true ),
            '_city_code'      => get_user_meta( $user_id, '_city_code', true ),
            '_state'          => get_user_meta( $user_id, '_state', true ),
            '_zip'            => get_user_meta( $user_id, '_zip', true ),
            '_work_mobile'    => get_user_meta( $user_id, '_work_mobile', true ),
            'email'           => $user->user_email,
            '_country_code'   => get_user_meta( $user_id, '_country_code', true ),
            'default_profile_pic' => $default_profile_pic
        ];
    }

    function get_profile_picture( $user_id ) {
        $image_ids = get_user_meta( $user_id, 'hrm_user_image_id', true );
        $image_ids = $image_ids ? array($image_ids) : [];
        $imaegs = [];

        foreach ( $image_ids as $key => $image_id ) {
            $imaegs[] = File_System::get_file( $image_id );
        }

        return $imaegs;
    }

    function get_employee_designation( $employee_id ) {
        $designation_id = get_user_meta( $employee_id, 'hrm_designation', true );
        $designation = Designation::find( $designation_id );

        return $designation ? $designation->title : '&#8211 &#8211';
    }

    function get_employee_department( $employee_id ) {
        $department_id = get_user_meta( $employee_id, 'hrm_job_category', true );
        $department = Department::find( $department_id );

        return $department ? $department->name : '&#8211 &#8211';
    }

    public static function ajax_save_personal_info() {
        check_ajax_referer('hrm_nonce');
      
        $FILES = $_FILES;
        
        $postdata = [
            'is_multiple_file' => isset( $_POST['is_multiple_file'] ) ?  hrm_clean( $_POST['is_multiple_file'] ) : false,
            'deleted_files' => isset( $_POST['deleted_files'] ) ?  hrm_clean( $_POST['deleted_files'] ) : [],
        ];

        $user_id = json_decode( stripslashes( $_POST['user_id'] ) );
        $user_id = empty( $user_id ) ? get_current_user_id() : intval( $user_id );
        
        $result = self::getInstance()->save_personal_info( $postdata, $FILES, $user_id );
        wp_send_json_success( $result );
    }

    function save_personal_info( $postData, $files, $user_id ) {
        
        foreach ( $files as $meta_name => $filesObj) {
            
            $file_ids = File_System::multiple_upload( $filesObj );

            if ( empty( $postData['is_multiple_file'] ) || $postData['is_multiple_file'] == 'false' ) {
                
                update_user_meta( $user_id, $meta_name, reset( $file_ids ) );
            } else {
                $dbids = get_user_meta( $user_id, $meta_name, true );
                update_user_meta( $user_id, $meta_name, array_merge( $dbids, $file_ids ) );
            }
            
        }
        
        if ( $postData['deleted_files'] ) {
            foreach ( $postData['deleted_files'] as $delted_files) {
                
                $files = json_decode( stripslashes( $delted_files ) );
                if ( empty( $files->files ) ) {
                    continue;
                }
                $dbids = get_user_meta( $user_id, $files->name, true );
                $id_diff = array_diff( $dbids, $files->files );
                
                foreach (  $files->files as $key => $id ) {
                    File_System::delete( $file_id );
                }

                update_user_meta( $user_id, $files->name, reset($id_diff) );
            }
        }
        
        foreach ( $postData as $key => $value) {
            update_user_meta( $user_id, $key, json_decode( stripslashes( $value ) ) ); 
        }

        return $this->get_personal_info($user_id);
    }
    function add_new_employee( $postdata ) {

        if ( 
            isset( $postdata['id'] ) 
            && 
            ! empty( $postdata['id'] ) 
            ) {
            
                $user_id = absint( $postdata['id'] );
           
                $this->update_empoyee( $user_id, $postdata );
                return $user_id;
        }

        $validate = $this->new_admin_form_validate( $postdata );

        if ( is_wp_error( $validate ) ) {
            return $validate;
        }

        $random_password = wp_generate_password( 8, false );
        $first_name      = hrm_clean( $postdata['firstName'] );
        $last_name       = hrm_clean( $postdata['lastName'] );
        $display_name    = $first_name .' '. $last_name;
        
        $userdata = array(
            'user_login'   => sanitize_user( $postdata['userName'] ),
            'user_pass'    => $random_password,
            'user_email'   => sanitize_email( $postdata['email'] ),
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => $display_name,
            'role'         => hrm_clean( $postdata['role'] )
        );

        $user_id = wp_insert_user( $userdata );

        if( $user_id ) {
            $this->update_empoyee( $user_id, $postdata );
            wp_new_user_notification( $user_id, null, 'both' );
            
            return $user_id;

        } else {
            return false;
        }
    }

    function update_empoyee( $user_id, $postdata ) {
        
        $display_name = hrm_clean( $postdata['firstName'] ) . ' ' . hrm_clean( $postdata['lastName'] );
        $join_date    = empty( $postdata['joiningDate'] ) ? current_time( 'mysql' ) : hrm_clean( $postdata['joiningDate'] );
        
        update_user_meta( $user_id, 'first_name', hrm_clean( $postdata['firstName'] ) );
        update_user_meta( $user_id, 'last_name', hrm_clean( $postdata['lastName'] ) );

        wp_update_user( array(
            'ID'           =>  $user_id,
            'display_name' => $display_name,
        ) );

        $user = new \WP_User( $user_id );
        $user->set_role( $postdata['role'] );

        update_user_meta( $user_id, 'hrm_job_category', hrm_clean( $postdata['department'] ) );
        update_user_meta( $user_id, 'hrm_location', hrm_clean( $postdata['location'] ) );
        update_user_meta( $user_id, 'hrm_job_desc', hrm_clean( $postdata['description'] ) );
        update_user_meta( $user_id, 'hrm_status', hrm_clean( $postdata['status'] ) );
        update_user_meta( $user_id, 'hrm_mob_number', hrm_clean( $postdata['mobileNumber'] ) );
        update_user_meta( $user_id, 'hrm_joined_date', hrm_date2mysql( $join_date ) );
        update_user_meta( $user_id, 'hrm_gender',  hrm_clean( $postdata['gender'] ) );
        update_user_meta( $user_id, 'hrm_role',  hrm_clean( $postdata['role'] ) );
        update_user_meta( $user_id, 'hrm_designation',  hrm_clean( $postdata['designation'] ) );

        if ( ! empty( $postdata['employee_image'] ) ) {
            $image_id = File_System::upload_base64_file( hrm_clean( $postdata['employee_image'][0] ) );
            update_user_meta( $user_id, 'hrm_user_image_id', $image_id );
        }
    }

    function new_admin_form_validate( $postdata ) {

        if ( empty( $postdata['userName'] ) ) {
            return new WP_Error( 'error', __('Username required ', 'hrm' ) );
        }

        if ( username_exists( $postdata['userName'] ) ) {
           
            return new WP_Error( 'error', __('Username already exist', 'hrm' ) );
        }

        if ( empty( $postdata['email'] ) ) {
            return new WP_Error( 'error', __('Eamil required', 'hrm' ) );
        }

        if ( ! is_email($postdata['email'] ) ) {
            return new WP_Error( 'error', __('Invalid email', 'hrm' ) );
        }

        if ( email_exists( $postdata['email']) ) {
            return new WP_Error( 'error', __('Email already exist', 'hrm' ) );
        }

        return true;
    }


    function employeer_search_query( $post, $limit, $pagenum ) {
        if ( !empty( $post['first_name'] ) ) {
            $meta[] =   array(
                'key'     => 'first_name',
                'value'   =>  trim( hrm_clean( $post['first_name'] ) ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $post['last_name'] ) ) {
            $meta[] = array(
                'key'     => 'last_name',
                'value'   =>  trim( hrm_clean( $post['last_name'] ) ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $post['status'] ) ) {
            $meta[] = array(
                'key'     => '_status',
                'value'   =>  trim( hrm_clean( $post['status'] ) ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $post['mobile'] ) ) {
            $meta[] = array(
                'key'     => '_mob_number',
                'value'   =>  trim( hrm_clean( $post['mobile'] ) ),
                'compare' => 'LIKE'
            );
        }

        if ( isset( $meta ) ) {
            $meta['relation'] = 'AND';
        } else {
            $meta = '';
        }

        $offset = ( $pagenum - 1 ) * $limit;

        $args = array(
            'search'         => !empty( $post['user'] ) ? trim( hrm_clean( $post['user'] ) ) : '',
            'search_columns' => array( 'user_login', 'user_email' ),
            'meta_query'     => $meta,
            'number'         => $limit,
            'offset'         => $offset
        );


        $user_query = new WP_User_Query( $args );

        return $user_query;
    }

    function get_employee_drop_down() {
        $employees = $this->get_employee();
        $emp_lists = array();

        foreach ( $employees as $key => $employee ) {
            $emp_lists[$employee->ID] = $employee->display_name;
        }

        return $emp_lists;
    }

    function get_employee( $employee_id ) {
        $employee = get_user_by( 'id', $employee_id );
        $resource = new Item( $employee, new Employee_Transformer );

        return $this->get_response( $resource );
    }

    function get_employees( $args = array() ) {

        $default = array(
            'role__in' => array_keys( hrm_get_roles() ),
            'page'     => 1,
            'number'   => hrm_per_page()   
        );

        $args = wp_parse_args( $args, $default );
        $args['offset'] = ( $args['page'] - 1 ) * $args['number'];
        
        $query     = new WP_User_Query( $args );
        $employees = $query->get_results();
        
        $resource = new Collection( $employees, new Employee_Transformer );
        $resource->setMeta( 
            [
                'pagination' => [
                    'total'    => $query->total_users,
                    'per_page' => $args['number']
                ]
            ] 
        );

        return $this->get_response( $resource );
    }

    function get_current_user_hr_role() {
        global $current_user;
        $roles = hrm_get_roles();

        foreach ( $current_user->roles as $key => $role ) {
            if ( array_key_exists( $role, $roles ) ) {
                return $role;
            }
        }
    }
}






