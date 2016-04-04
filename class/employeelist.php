<?php

class Hrm_Employeelist {
    private static $_instance;

    public static function getInstance() {
        if( ! self::$_instance ) {
            self::$_instance = new hrm_Employeelist();
        }

        return self::$_instance;
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
        $employee_id     = isset( $data['employer_id'] ) && is_array( $data['employer_id'] ) && $data['employer_id'] ? reset( $data['employer_id'] ) : false;
        $this->emp_upload_image($employee_id);
    }

    function emp_upload_image($employee_id) {

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
        $first_name      = sanitize_text_field( $postdata['first_name'] );
        $last_name       = sanitize_text_field( $postdata['last_name'] );
        $display_name    = $first_name .' '. $last_name;

        $userdata = array(
            'user_login'   => $postdata['user_name'],
            'user_pass'    => $random_password,
            'user_email'   => $postdata['email'],
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => $display_name,
            'role'         => $postdata['emp_role']
        );

        $user_id = wp_insert_user( $userdata );

        if( $user_id ) {
            $image = isset( $postdata['hrm_attachment'] ) ? $postdata['hrm_attachment'] : array();
            $image_id = is_array( $image ) && $image ? reset( $image ) : 0;
            update_user_meta( $user_id, '_hrm_user_image_id', $image_id );
            $this->update_empoyer( $user_id, $postdata );

            wp_new_user_notification( $user_id, $random_password );

            return $user_id;

        } else {
            return false;
        }

    }

    function update_empoyer( $user_id, $postdata ) {
        $display_name = $postdata['first_name'] . ' ' . $postdata['last_name'];
        $join_date = empty( $postdata['joined_date'] ) ? current_time( 'mysql' ) : $postdata['joined_date'];
        update_user_meta( $user_id, 'first_name', $postdata['first_name'] );
        update_user_meta( $user_id, 'last_name', $postdata['last_name'] );

        wp_update_user( array(
            'ID'           =>  $user_id,
            'display_name' => $display_name,
            'role'         => $postdata['emp_role']
        ) );

        update_user_meta( $user_id, '_job_title', $postdata['emp_job_title'] );
        update_user_meta( $user_id, '_job_category', $postdata['emp_job_category'] );
        update_user_meta( $user_id, '_location', $postdata['emp_location'] );
        update_user_meta( $user_id, '_job_desc', $postdata['job_desc'] );
        update_user_meta( $user_id, '_status', $postdata['status'] );
        update_user_meta( $user_id, '_mob_number', $postdata['mobile'] );
        update_user_meta( $user_id, '_joined_date', hrm_date2mysql( $join_date ) );

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

    function new_employee_form( $employer = null ) {
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        global $wp_roles;

        if ( !$wp_roles ) {
            $wp_roles = new WP_Roles();
        }

        $role_names   = $wp_roles->get_names();

        $job_title    = json_decode( stripcslashes( $_POST['hrm_dataAttr']['job_title'] ) );
        $job_category = json_decode( stripcslashes( $_POST['hrm_dataAttr']['job_category'] ) );
        $location     = json_decode( stripcslashes( $_POST['hrm_dataAttr']['location'] ) );

        $employer_id = isset( $employer->ID ) ? $employer->ID : false;
        if ( $employer_id ) {
            $user = get_user_by( 'id', $employer_id );
        }

        if ( $employer === null ) {
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
                'value' => $employer_id,
                'type'  => 'hidden',
            );
        }

        $hidden_form['first_name'] = array(
            'label' =>  __( 'First Name', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $employer_id, 'first_name', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );
        $hidden_form['last_name'] = array(
            'label' =>  __( 'Last Name', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $employer_id, 'last_name', true ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );
        $new_role_url = hrm_new_role_url();
        $hidden_form['emp_role'] = array(
            'label'    => __( 'Role', 'hrm' ),
            'type'     => 'select',
            'option'   => $role_names,
            'selected' => isset( $user->roles ) ? reset( $user->roles ) : '',
            //'desc' => sprintf( '<a class="hrm-form-link" href="%s">%s</a>', $new_role_url,  __( 'Create New', 'hrm' ) ),
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $new_job_title_url = hrm_job_title();
        $hidden_form['emp_job_title'] = array(
            'label' => __( 'Job Title', 'hrm' ),
            'type' => 'select',
            'option' => $job_title,
            'selected' => get_user_meta( $employer_id, '_job_title', true ),
            'desc' => sprintf( '<a class="hrm-form-link" href="%s">%s</a>', $new_job_title_url,  __( 'Create New', 'hrm' ) ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $category_url = hrm_job_category();
        $hidden_form['emp_job_category'] = array(
            'label' => __( 'Job Category', 'hrm' ),
            'type' => 'select',
            'option' => $job_category,
            'selected' => get_user_meta( $employer_id, '_job_category', true ),
            'desc' => sprintf( '<a class="hrm-form-link" href="%s">%s</a>', $category_url,  __( 'Create New', 'hrm' ) ),
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $location_url = hrm_job_location();
        $hidden_form['emp_location'] = array(
            'label' => __( 'Location', 'hrm' ),
            'type' => 'select',
            'option' => $location,
            'selected' => get_user_meta( $employer_id, '_location', true ),
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
            'selected' => get_user_meta( $employer_id, '_status', true )
        );
        $hidden_form['mobile'] = array(
            'label' =>  __( 'Mobile Number', 'hrm' ),
            'type'  => 'text',
            'value' => get_user_meta( $employer_id, '_mob_number', true )
        );
        $hidden_form['joined_date'] = array(
            'label' =>  __( 'Joined Date', 'hrm' ),
            'type'  => 'text',
            'class' => 'hrm-datepicker',
            'value' => get_user_meta( $employer_id, '_joined_date', true )
        );

        $hidden_form['job_desc'] = array(
            'label' =>  __( 'Description', 'hrm' ),
            'type'  => 'textarea',
            'value' => get_user_meta( $employer_id, '_job_desc', true )
        );


        $hidden_form['action'] = 'new_employer';
        $hidden_form['header'] = 'Employee Information';
        $hidden_form['url'] = $redirect;

        ob_start();
        $this->do_action();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );
        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;

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

    function get_employee() {
        $employers = new WP_User_Query( array(
            //'role'   => 'hrm_employee',
        ) );
        return $employers;
    }
}