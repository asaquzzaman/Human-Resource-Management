<?php
use HRM\Core\Common\Traits\Transformer_Manager;
use League\Fractal;
use League\Fractal\Resource\Item as Item;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Models\Work_Experience;
use HRM\Transformers\Work_Experiance_Transformer;
use HRM\Core\File_System\File_System;
use HRM\Transformers\Employee_Transformer;

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
    }

    public static function ajax_delete_employee() {
        check_ajax_referer('hrm_nonce');
        $employee_ids = $_POST['delete'];
        self::getInstance()->delete_employee( $employee_ids );

        wp_send_json_success();
    }

    public function delete_employee( $ids ) {
        foreach ( $ids as $key => $id ) {
            wp_delete_user( $id );
        }
    }

    public static function ajax_get_employees() {
        $postdata['page']  = $_POST['page'];
        $employees = self::getInstance()->get_employees( $postdata );
        
        wp_send_json_success( $employees );
    }

    public static function  ajax_insert_employee() {
        $postdata    = $_POST;
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
                    'key' => 'hrm_birthday',
                    'value' => $today,
                    'type' => 'DATE',
                    'compare' => '>=' 
                ),

                array(
                    'key' => 'hrm_birthday',
                    'type' => 'DATE',
                    'value' => $next_day,
                    'compare' => '<=' 
                )
            )
        ));

        foreach ( $users->results as $key => $result ) {
            $birthday                 = get_user_meta( $result->ID, 'hrm_birthday', true );
            $result->data->birthday   = hrm_get_date( $birthday );
            $result->data->avatar_url = get_avatar_url( $result->ID );
        }

        wp_send_json_success( $users->results );
    }

    function after_inset_information( $post, $last_inserted_id ) {
        if ( isset( $post['table_option'] ) && $post['table_option'] == 'hrm_salary' ) {
            $table_option = get_option( $post['table_option'] );
            $employee_id  = $post['emp_id'];
            $to_user      = get_user_by( 'id', $employee_id );
            $to           = $to_user->user_email;
            $sender       = get_current_user_id();
            $subject      = __( 'Salary', 'hrm' );

            $last_recored = Hrm_Settings::getInstance()->conditional_query_val( $table_option['table_name'], '*', array( 'id' => $last_inserted_id ), true );

            $message = $this->get_salary_message_body( $last_recored, $post, $to_user );

            Hrm_Settings::getInstance()->send( $to, $subject, $message, $sender );
        }
    }

    function get_salary_message_body( $last_recored, $post, $to_user ) {
        $employer = wp_get_current_user();
        $pay_grade = json_decode( stripcslashes( $post['pay_grade_js'] ), true );
        $direct_deposit = $last_recored->direct_deposit != 'yes' ? __( 'Nothing', 'hrm' ) : $last_recored->direct_deposit;
        ob_start();
        ?>
        <div style="width: 600px; background: #eee; padding: 5px;">
        <table width="600" style="background: #fff; padding: 10px;">
        <tr>
            <td style="padding: 10px;"><?php sprintf( 'Hello, %s', $to_user->display_name ); ?></td>
        </tr>
        <tr>
            <td style="padding: 10px;"><?php _e( 'Your salaray details', 'hrm' ); ?></td>
        </tr>
        </table>
        <table width="600" style="background: #fff; padding: 10px;">
            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Employer Name', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $employer->display_name; ?></td>
            </tr>
            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Date', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo hrm_get_date2mysql( $last_recored->billing_date ); ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Pay Grade', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $pay_grade[$last_recored->pay_grade]; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Salary Component', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->component; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Pay Frequency', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $this->pay_frequency( $last_recored->frequency ); ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Currency', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->currency; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Amount', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->amount; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Comments', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->comments; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Direct Deposit Details', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $direct_deposit; ?></td>
            </tr>
        <?php
        if ( $last_recored->direct_deposit == 'yes' ) {
            ?>
            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Account Number', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->account_number; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Account Type', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $this->account_type( $last_recored->account_type ); ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Routing Number', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->routing; ?></td>
            </tr>

            <tr>
                <th style="background: #f7f5f5; border: 1px solid #e1e1e1; text-align: left; padding-left: 8px;"><?php _e( 'Deposit Amount', 'hrm' ); ?></th>
                <td style="border: 1px solid #eee; font-size: 12px; padding: 10px;"><?php echo $last_recored->dipo_amount; ?></td>
            </tr>

            <?php
        }
            ?>
        </table>
        </div>
        <?php
        return ob_get_clean();
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

    function emp_upload_image($employee_id) {

        $image_id        = get_user_meta( $employee_id, '_hrm_user_image_id', true );
        $image_attchment = $this->get_image( $image_id );

        ?>
        <div id="hrm-user-image-wrap">
            <?php
            if ( $image_attchment ) {

                $delete = sprintf( '<a href="#" data-id="%d" class="hrm-delete-file">%s</a>', $image_attchment['id'], __( 'Delete', 'hrm' ) );
                $hidden = sprintf( '<input type="hidden" name="hrm_attachment[]" value="%d" />', $image_attchment['id'] );
                $file_url = sprintf( '<a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s" height="160" width="160"/></a>', $image_attchment['url'], $image_attchment['thumb'], esc_attr( $image_attchment['name'] ) );

                echo '<div class="hrm-uploaded-item">' . $file_url . ' ' . $delete . $hidden . '</div>';
            } else {
                echo get_avatar( $employee_id, 160 );
            }
            ?>

        </div>
        <?php
    }

    function after_ajax_upload( $response, $file, $post ) {
        if ( !isset( $post['employee_id'] ) ) {
            return;
        }
        $file_id = $response['file_id'];
        $employee_id = $post['employee_id'];
        update_user_meta( $employee_id, '_hrm_user_image_id', $file_id );
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
        $id = $postdata['user_id'];
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
        $result = self::getInstance()->experiance_filter( $_POST );
        wp_send_json_success( $result );
    }

    function experiance_filter( $postdata ) {
        $title = $postdata['title'];
        $from  = $postdata['from'];
        $to    = $postdata['to'];
        $page  = empty(  $postdata['page'] ) ? 1 : intval( $postdata['page'] );
        $per_page = hrm_per_page();

        $experiance = Work_Experience::where( function($q) use($title, $from, $to) {
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
        ->paginate( $per_page, ['*'], 'page', $page );
    
        $collection = $experiance->getCollection();

        $resource = new Collection( $collection, new Work_Experiance_Transformer );
        $resource->setPaginator( new IlluminatePaginatorAdapter( $experiance ) );

        return $this->get_response( $resource );
    }

    public static function ajax_get_personal_info() {
        check_ajax_referer('hrm_nonce');
        $user_id = empty( $_POST['user_id'] ) ? get_current_user_id() : intval( $_POST['user_id'] );
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
        $profile_pic = is_array($profile_pic) ? $profile_pic : [];

        return [
            'country_list'    => $lists,
            '_hrm_user_image_id' => $profile_pic,
            'department'      => $this->get_employee_department( $user_id ),
            '_gender'         => get_user_meta( $user_id, '_gender', true ),
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
        ];
    }

    function get_profile_picture( $user_id ) {
        $image_ids = get_user_meta( $user_id, '_hrm_user_image_id', true );
        $image_ids = $image_ids ? $image_ids : [];
        $imaegs = [];

        foreach ( $image_ids as $key => $image_id ) {
            $imaegs[] = File_System::get_file( $image_id );
        }

        return $imaegs;
    }

    function get_employee_department( $employee_id ) {
        $role = get_user_meta( $employee_id, 'role', true );
        $designation = hrm_current_user_display_role();

        return $designation ? $designation : '&#8211 &#8211';
    }

    public static function ajax_save_personal_info() {
        //check_ajax_referer('hrm_nonce');
        $user_id = empty( $_POST['user_id'] ) ? get_current_user_id() : intval( $_POST['user_id'] );
        $result = self::getInstance()->save_personal_info( $_POST, $_FILES, $user_id );
        wp_send_json_success( $result );
    }

    function save_personal_info( $postData, $files, $user_id ) {
        
        foreach ( $files as $meta_name => $filesObj) {
            
            $file_ids = File_System::multiple_upload( $filesObj );

            if ( empty( $postData['is_multiple_file'] ) || $postData['is_multiple_file'] == 'false' ) {
                
                update_user_meta( $user_id, $meta_name, $file_ids );
            } else {
                $dbids = get_user_meta( $user_id, $meta_name, true );
                update_user_meta( $user_id, $meta_name, array_merge( $dbids, $file_ids ) );
            }
            
        }
        
        if ( $postData['deleted_files'] ) {
            foreach ( $postData['deleted_files'] as $delted_files) {
                
                $files = json_decode( stripslashes( $delted_files ) );
                $dbids = get_user_meta( $user_id, $files->name, true );
                $id_diff = array_diff( $dbids, $files->files );
                
                foreach (  $files->files as $key => $id ) {
                    File_System::delete( $file_id );
                }

                update_user_meta( $user_id, $files->name, $id_diff );
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
            ! empty( absint($postdata['id'] ) ) 
        ) {
            $user_id = $postdata['id'];
            $this->update_empoyee( $user_id, $postdata );
            return $user_id;
        }

        $validate = $this->new_admin_form_validate( $postdata );

        if ( is_wp_error( $validate ) ) {
            return $validate;
        }

        $random_password = wp_generate_password( 8, false );
        $first_name      = sanitize_text_field( $postdata['firstName'] );
        $last_name       = sanitize_text_field( $postdata['lastName'] );
        $display_name    = $first_name .' '. $last_name;

        $userdata = array(
            'user_login'   => $postdata['userName'],
            'user_pass'    => $random_password,
            'user_email'   => $postdata['email'],
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => $display_name,
            'role'         => $postdata['role']
        );

        $user_id = wp_insert_user( $userdata );

        if( $user_id ) {
            $this->update_empoyee( $user_id, $postdata );
            wp_new_user_notification( $user_id, $random_password );
            
            return $user_id;

        } else {
            return false;
        }
    }

    function update_empoyee( $user_id, $postdata ) {
        
        $display_name = $postdata['firstName'] . ' ' . $postdata['lastName'];
        $join_date    = empty( $postdata['joiningDate'] ) ? current_time( 'mysql' ) : $postdata['joiningDate'];
        
        update_user_meta( $user_id, 'first_name', $postdata['firstName'] );
        update_user_meta( $user_id, 'last_name', $postdata['lastName'] );

        wp_update_user( array(
            'ID'           =>  $user_id,
            'display_name' => $display_name,
            'role'         => $postdata['role']
        ) );

        update_user_meta( $user_id, 'hrm_job_category', $postdata['department'] );
        update_user_meta( $user_id, 'hrm_location', $postdata['location'] );
        update_user_meta( $user_id, 'hrm_job_desc', $postdata['description'] );
        update_user_meta( $user_id, 'hrm_status', $postdata['status'] );
        update_user_meta( $user_id, 'hrm_mob_number', $postdata['mobileNumber'] );
        update_user_meta( $user_id, 'hrm_joined_date', hrm_date2mysql( $join_date ) );
        update_user_meta( $user_id, 'hrm_gender',  $postdata['gender'] );
        update_user_meta( $user_id, 'hrm_role',  $postdata['role'] );
        update_user_meta( $user_id, 'hrm_designation',  $postdata['designation'] );

        if ( $postdata['employee_image'] ) {
            $image_id = File_System::upload_base64_file( $postdata['employee_image'][0] );
            update_user_meta( $user_id, 'hrm_user_image_id', $image_id );
        }
    }

    function new_admin_form_validate( $postdata ) {

        if ( empty( $postdata['userName'] ) ) {
            return new WP_Error( 'error', __('Username required ', 'hrm' ) );
        }

        if ( username_exists( $postdata['userName'] ) ) {
            echo 'adkjfasd'; die();
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
                'value'   =>  trim( $post['first_name'] ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $post['last_name'] ) ) {
            $meta[] = array(
                'key'     => 'last_name',
                'value'   =>  trim( $post['last_name'] ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $post['status'] ) ) {
            $meta[] = array(
                'key'     => '_status',
                'value'   =>  trim( $post['status'] ),
                'compare' => 'LIKE'
            );
        }

        if ( !empty( $post['mobile'] ) ) {
            $meta[] = array(
                'key'     => '_mob_number',
                'value'   =>  trim( $post['mobile'] ),
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
            'search'         => !empty( $post['user'] ) ? trim( $post['user'] ) : '',
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
}







