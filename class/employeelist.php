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

    function get_employee( $only_employee = false ) {
        
        if ( $only_employee ) {
            $employees = new WP_User_Query( array(
                'role__in'   => array( hrm_employee_role_key() ),
            ) );
        } else {
            $employees = new WP_User_Query( array(
                'role__in'   => array( hrm_employee_role_key(), hrm_manager_role_key() ),
            ) );
        }
        
        return $employees->get_results();
    }
}