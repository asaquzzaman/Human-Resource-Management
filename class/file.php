<?php

class HRM_File {
	private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new HRM_File();
        }

        return self::$_instance;
    }

    function file_delete($post) {
        $posts_id = isset( $_POST['hrm_check'] ) ? $_POST['hrm_check'] : array();
        $author = get_current_user_id();
        foreach ( $posts_id as $post_id => $value ) {
            $query = $this->get_share_files( $author, $post_id );

            foreach ($query->posts as $key => $attachment ) {
                 wp_delete_attachment( $attachment->ID, true );
            }

            wp_delete_post( $post_id, true );
        }
    }

    function get_assing_user( $post_id ) {
        $role = hrm_current_user_role();
        $users = get_post_meta( $post_id, '_attachment_user' );
        $assing = '';
        foreach ( $users as $key => $user_id ) {
            $user = get_user_by( 'id', $user_id );
            if ( $role == 'hrm_employee' ) {
                $assing .= sprintf( '<span title="%s">%s</span>', $user->display_name, get_avatar( $user_id, 36 ) );
            } else {
                $url = hrm_employee_menu_url( hrm_pim_page(), 'personal', $user_id );
                $assing .= sprintf( '<a class="hrm-avatar" href="%1s" title="%2s">%3s</a>', $url, $user->display_name, get_avatar( $user_id, 36 ) );
            }
        }

        return $assing;
    }

    function get_share_files( $post_author = false, $post_parent = false ) {

        $args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => '-1'
        );

        if ( $post_author ) {
            $args['author'] = $post_author;
        }

        if ( $post_parent ) {
            $args['post_parent'] = $post_parent;
        }

        return new WP_Query( $args );
    }

    function searching_file_posts( $post, $limit, $pagenum ) {

        $post_author = get_current_user_id();
        $offset  = ( $pagenum - 1 ) * $limit;

        $args = array(
            'post_type'      => array( 'hrm_file', 'attachment' ),
            'author'         => $post_author,
            'post_status'    => array( 'publish', 'inherit' ),
            'offset'         => $offset,
            's'              => trim( $_POST['doc_search'] ),
            'posts_per_page' => $limit,
        );

        return new WP_Query( $args );
    }

    function get_share_file_posts( $limit = 0, $pagenum = 1, $post_author = false ) {
        $post_author = $post_author ? $post_author : get_current_user_id();
        //$offset  = ( $pagenum - 1 ) * $limit;

        $args = array(
            'post_type'      => 'hrm_file',
            'author'         => $post_author,
            'post_status'    => 'publish',
            //'offset'         => $offset,
            'posts_per_page' => -1,
        );

        return new WP_Query( $args );

    }

    function search_file_posts_inbox( $post, $limit, $pagenum, $inbox_user_id ) {

        $offset  = ( $pagenum - 1 ) * $limit;

        $args = array(
            'post_type'      => array( 'hrm_file', 'attachment' ),
            'post_status'    => array( 'publish', 'inherit' ),
            'offset'         => $offset,
            's'              => trim( $_POST['doc_search'] ),
            'posts_per_page' => $limit,
            'meta_query'     => array(
                array(
                    'key'    => '_attachment_user',
                    'value'  => $inbox_user_id,
                    'compare'=> '='
                )
            )
        );

        return new WP_Query( $args );
    }

    function get_file_posts_inbox( $inbox_user_id ) {

        //$offset  = ( $pagenum - 1 ) * $limit;
        $args = array(
            'post_type'      => 'hrm_file',
            'post_status'    => 'publish',
            //'offset'         => $offset,
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'    => '_attachment_user',
                    'value'  => $inbox_user_id,
                    'compare'=> '='
                )
            )
        );

        return new WP_Query( $args );

    }

    function file_upload_form( $post = false ) {
        if ( $post ) {
            $author = get_current_user_id();
            $post_id = $post['post_id'];
            $share_files = $this->get_share_files( $author, $post_id );
            $share_files = $share_files->posts;
            $post = get_post($post_id);
            $assign_user = get_post_meta( $post_id, '_attachment_user' );
            $file['post_id'] = array(
                'type'     => 'hidden',
                'value'    => $post_id,
            );
        } else {
            $share_files = false;
        }
        ob_start();
        ?>

            <div id="hrm-upload-file-container" >
                <div class="hrm-drop-area" id="hrm-drop-files-zone">

                    <p class="hrm-first-child"><?php _e( 'Drop files here', 'hrm' ); ?></p>

                    <p><?php _e( 'or', 'hrm' ); ?></p>

                    <a id="hrm-pickfiles" href="#"><?php _e( 'Select files', 'hrm' ); ?></a>
                </div>
                <div id="hrm-filelist">
                    <?php
                    if ( $share_files ) {
                        foreach ( $share_files as $key => $share_file ) {

                            $file_info = $this->get_file( $share_file->ID );

                            $delete = sprintf( '<a href="#" data-id="%d" class="hrm-delete-file button">%s</a>', $file_info['id'], __( 'Delete File', 'hrm' ) );
                            $hidden = sprintf( '<input type="hidden" name="hrm_attachment[]" value="%d" />', $file_info['id'] );
                            $file_url = sprintf( '<a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s" /></a>', $file_info['url'], $file_info['thumb'], esc_attr( $file_info['name'] ) );

                            echo '<div class="hrm-uploaded-item">' . $file_url . ' ' . $delete . $hidden . '</div>';
                        }
                    }

                    ?>
                </div>
            </div>

        <?php
        $html_content = ob_get_clean();
        $users = get_users();
        $option_value = array();
        foreach ($users as $key => $user ) {
            $option_value[$user->ID] = $user->display_name;
        }

        $file[] = array(
            'type' => 'html',
            'content' => $html_content
        );

        $file['title'] = array(
            'label'    => __( 'Title', 'hrm' ),
            'type'     => 'text',
            'value'    => isset( $post->post_title ) ? $post->post_title : '',
            'extra' => array(
                'data-hrm_validation' => true,
                'data-hrm_required' => true,
                'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
            ),
        );

        $file['content'] = array(
            'label'     => __( 'Description', 'hrm' ),
            'type'      => 'textarea',
            'value'   => isset( $post->post_content ) ? $post->post_content : '',
        );

        $file['file_users[]'] = array(
            'label'    => __( 'User', 'hrm' ),
            'class'    => 'hrm-chosen',
            'id'       => 'hrm-rank-task',
            'type'     => 'multiple',
            'option'   => $option_value,
            'selected' => isset( $assign_user ) ? $assign_user : '',
            'desc'     => __( 'Choose users', 'hrm' ),
            'extra' => array(
                'data-placeholder' => __( "Type user name", 'hrm' ),
            ),
        );

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        $file['action'] = 'file_upload';
        $file['header'] = 'File';
        $file['url'] = $redirect;
        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $file );
            $return_value = array(
                'append_data' => ob_get_clean(),
                'tinymce_id'  => 'hrm-file-editor'
            );
        return $return_value;
    }

    function file_user_set($post) {
        if ( !isset( $post['hrm_attachment'] ) ) {
            return false;
        }

        if ( !is_array( $post['hrm_attachment'] ) ) {
            return false;
        }

        if ( !count( $post['hrm_attachment'] ) ) {
            return;
        }

        $arg = array(
            'post_title'   => $post['title'],
            'post_content' => $post['content'],
            'post_type'    => 'hrm_file',
            'post_status'  => 'publish'
        );

        if ( isset( $post['post_id'] ) && !empty( $post['post_id'] ) ) {
            $arg['ID'] = $post['post_id'];
            $post_id = wp_update_post( $arg );
        } else {
            $post_id = wp_insert_post( $arg );
        }

        $users = isset( $post['file_users'] ) && is_array( $post['file_users'] ) ? $post['file_users'] : array();
        delete_post_meta( $post_id, '_attachment_user' );
        foreach ( $users as $key => $user_id ) {
            add_post_meta( $post_id, '_attachment_user', $user_id );
        }

        $files = $post['hrm_attachment'];

        foreach ( $files as $key => $file_id ) {
            wp_update_post( array( 'ID' => $file_id, 'post_parent' => $post_id ) );
        }
        ob_start();
            $page = $post['page'];
            $tab = $post['tab'];
            $subtab = $post['subtab'];
            require_once dirname (__FILE__) . '/../templates/file/share.php';
        return array( 'content' => ob_get_clean() );
    }

    function file_upload() {
    	if ( $_FILES['hrm_attachment']['error'] > 0 ) {
            return false;
        }

        $upload = array(
			'name'     => $_FILES['hrm_attachment']['name'],
			'type'     => $_FILES['hrm_attachment']['type'],
			'tmp_name' => $_FILES['hrm_attachment']['tmp_name'],
			'error'    => $_FILES['hrm_attachment']['error'],
			'size'     => $_FILES['hrm_attachment']['size']
        );

        $uploaded_file = wp_handle_upload( $upload, array('test_form' => false) );

        if ( isset( $uploaded_file['file'] ) ) {
            $file_loc = $uploaded_file['file'];
            $file_name = basename( $_FILES['hrm_attachment']['name'] );
            $file_type = wp_check_filetype( $file_name );
            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment( $attachment, $file_loc );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file_loc );
            wp_update_attachment_metadata( $attach_id, $attach_data );

            return array('success' => true, 'file_id' => $attach_id);
        }

        return array('success' => false, 'error' => $uploaded_file['error']);
    }

    function get_file( $attachment_id ) {
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
            } else {
                $response['thumb'] = wp_mime_type_icon( $file->post_mime_type );
                $response['type'] = 'file';
            }

            return $response;
        }

        return false;
    }

    function delete_file( $file_id, $force = true ) {
        wp_delete_attachment( $file_id, $force );
    }

    function delete_inbox_file( $file_ids, $user_id ) {
        if( is_array( $file_ids ) ) {
            foreach ( $file_ids as $file_id => $value ) {
                delete_post_meta( intval( $file_id ), '_attachment_user', $user_id );
            }
        } else {
            delete_post_meta( intval( $file_id ), '_attachment_user', $user_id );
        }
    }

    function role_permission ( $role_name = false, $display_name = null ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        $get_page = isset( $_POST['hrm_dataAttr']['page'] ) ? $_POST['hrm_dataAttr']['page'] : '';
        if ( $role_name !== false ) {
            $roles =  get_role( $role_name );
            $hidden_form['id'] = array(
                'type' => 'hidden',
                'value' => 'edit'
            );
        }

        $page = hrm_page();

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

        foreach( $page as $tab => $tab_item )  {

            if ( $get_page != $tab ) {
                continue;
            }
            foreach ($tab_item as $tab_name => $tab_name_itme) {

                $view = isset( $roles->capabilities[$tab_name.'_view'] ) ? 'view' : '';
                $add = isset( $roles->capabilities[$tab_name.'_add'] ) ? 'add' : '';
                $delete = isset( $roles->capabilities[$tab_name.'_delete'] ) ? 'delete' : '';

                $tab_role[] = array(
                    'label' => __( 'View', 'hrm' ),
                    'value' => 'view',
                    'class' => 'hrm-cap-'.$tab_name.'_view',
                    'checked' => ( $role_name === false ) ? 'view' : $view,
                );

                $tab_role[] = array(
                    'label' => __( 'Add', 'hrm' ),
                    'value' => 'add',
                    'class' => 'hrm-cap-'.$tab_name.'_add',
                    'checked' => ( $role_name === false ) ? 'add' : $add,
                );

                $tab_role[] = array(
                    'label' => __( 'Delete', 'hrm' ),
                    'value' => 'delete',
                    'class' => 'hrm-cap-'.$tab_name.'_delete',
                    'checked' => ( $role_name === false ) ? 'delete' : $delete,
                );

                if ( isset( $tab_name_itme['role'] ) && is_array( $tab_name_itme['role'] ) && count( $tab_name_itme['role'] ) ) {
                    foreach ( $tab_name_itme['role'] as $role_value => $label ) {
                        $checked = isset( $roles->capabilities[$tab_name.'_'.$role_value] ) ? $role_value : '';
                        $tab_role[] = array(
                            'label' => $label,
                            'value' => $role_value,
                            'class' => 'hrm-cap-'.$tab_name.'_'.$role_value,
                            'checked' => ( $role_name === false ) ? $role_value : $checked,
                        );
                    }
                }

                $hidden_form['cap['.$tab_name.'][]'] = array(
                    'label'      => $tab_name_itme['title'],
                    'type'       => 'checkbox',
                    'desc'       => 'Choose access permission',
                    'wrap_class' => 'hrm-parent-field',
                    'fields'     => $tab_role,
                );

                $tab_role = '';
            }
        }

        $hidden_form['header'] = 'User Role';
        $hidden_form['action'] = 'user_role';
        $hidden_form['url'] = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $hidden_form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

}