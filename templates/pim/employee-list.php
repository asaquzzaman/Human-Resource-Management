<div class="hrm-update-notification"></div>
<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'pim' );

if ( file_exists( $header_path ) ) {
    //require_once $header_path;
}

$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
?>
<div id="hrm-eployee-list"></div>
<?php

    global $wp_roles;

    if ( !$wp_roles ) {
        $wp_roles = new WP_Roles();
    }

    $role_names   = $wp_roles->get_names();

    $employers = get_users(); //hrm_Employeelist::getInstance()->get_employee();

    if ( !$employers ) {
        return;
    }

    //$total             = $employers->total_users;
    //$employers         = $employers->results;
    $add_permission    = hrm_user_can_access( $page, $tab, null, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $page, $tab, null, 'delete' ) ? true : false;
    $hrm_menu = hrm_page();

    $menu_pim_page = isset( $menu[hrm_pim_page()] ) ? $menu[hrm_pim_page()] : array();
    foreach ( $menu_pim_page as $pim_tab => $pim_tab_item ) {
        if ( array_key_exists( 'nested_tab', $pim_tab_item) && $pim_tab_item['nested_tab'] ) {
            $pim_single_tab = $pim_tab;
            break;
        }
    };
    foreach ( $employers as $key => $employer ) {
        $admin_url = hrm_employee_profile_url( hrm_pim_page(), $pim_single_tab, $employer->ID );

        if ( $delete_permission ) {
            $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$employer->ID.']" value="" type="checkbox">';
            $delete_text  = '<a href="#" class="hrm-delete" data-id='.$employer->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
            $td_attr[][0] = 'class="hrm-table-checkbox"';
        } else {
            $del_checkbox = '';
            $delete_text  = '';
        }

        if ( $add_permission ) {
            $name_id = '<div class="hrm-title-wrap">
            <a href="'.$admin_url.'" class="hrm-title"  data-table_option="" data-id='.$employer->ID.'>'
                .$employer->display_name.
            '</a>
            <div class="hrm-title-action">
                <a href="'.$admin_url.'" class="hrm-edit">'
                    .__( 'Profile', 'hrm' ).
                '</a>
                <a href="#" class="hrm-editable hrm-edit" data-action="employer_edit" data-table_option="hrm_notice" data-id='.$employer->ID.'>'
                    .__( 'Edit', 'hrm' ).
                '</a>'

                .$delete_text.
            '</div>';
        } else {
            $name_id = $employer->display_name;
        }

        /*if ( $delete_permission ) {
            $del_checkbox = '<input name="hrm_check['.$employer->ID.']" value="'.$employer->ID.'" type="checkbox">';
        } else {
            $del_checkbox = '';
        }

        if ( $add_permission ) {
            $name_id = '<a href="#" class="hrm-editable" data-action="employer_edit" data-table_option="" data-id='.$employer->ID.'>'.get_user_meta( $employer->ID, 'first_name', true ).'<a>';
        } else {
            $name_id = get_user_meta( $employer->ID, 'first_name', true );
        }*/

        $status = ( get_user_meta( $employer->ID, '_status', true ) == 'yes' ) ? 'Enable' : 'Disable';


        $role_display_name = reset( $employer->roles );
        $role_display_name = isset( $role_names[$role_display_name] ) ? $role_names[$role_display_name] : '';

        if ( $delete_permission ) {
            $body[] = apply_filters( 'hrm_employess_list_row', array(
                $del_checkbox,
                $name_id,
                get_user_meta( $employer->ID, 'first_name', true ),
                get_user_meta( $employer->ID, 'last_name', true ),
                $role_display_name,
                $status,
                get_user_meta( $employer->ID, '_mob_number', true ),
                hrm_get_date2mysql( get_user_meta( $employer->ID, '_joined_date', true ) ),
            ), $employer );
        } else {
            $body[] = apply_filters( 'hrm_employess_list_row', array(
                $name_id,
                get_user_meta( $employer->ID, 'last_name', true ),
                get_user_meta( $employer->ID, 'first_name', true ),
                $role_display_name,
                $status,
                get_user_meta( $employer->ID, '_mob_number', true ),
                hrm_get_date2mysql( get_user_meta( $employer->ID, '_joined_date', true ) ),
            ), $employer );
        }
    }

    $table = array();

    if ( $delete_permission ) {
        $table['head'] = array(
            '<input class="hrm-all-checked" type="checkbox">',
            __( 'Profile', 'hrm' ),
            __( 'First Name', 'hrm' ),
            __( 'Last Name', 'hrm' ),
            __( 'Role', 'hrm' ),
            __( 'Status', 'hrm' ),
            __( 'Mobile', 'hrm' ),
            __( 'Joined Date', 'hrm' ),
        );
    } else {
        $table['head'] = array(
            __( 'Profile', 'hrm' ),
            __( 'First Name', 'hrm' ),
            __( 'Last Name', 'hrm' ),
            __( 'Role', 'hrm' ),
            __( 'Status', 'hrm' ),
            __( 'Mobile', 'hrm' ),
            __( 'Joined Date', 'hrm' ),
        );
    }

    $table['body']       = isset( $body ) ? $body : '';
    $table['td_attr']    = isset( $td_attr ) ?$td_attr : '';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['table']      = 'hrm_employee';
    $table['tab']        = $tab;
    $table['page']       = $page;
    $table['action']     = 'employee_delete';
    $table['table_attr'] = array( 'class' => 'widefat' );

    echo hrm_Settings::getInstance()->table( $table );
    //table
    $job_titles = hrm_Settings::getInstance()->hrm_query( 'hrm_job_title' );

    unset($job_titles['total_row']);

    foreach ($job_titles as $key => $value) {
        $job_title[$value->id] = $value->job_title;
    }
    $job_title     = isset( $job_title ) ? $job_title : array();
    $job_categorys = hrm_Settings::getInstance()->hrm_query( 'hrm_job_category' );

    unset($job_categorys['total_row']);

    foreach ($job_categorys as $key => $value) {
        $job_category[$value->id] = $value->name;
    }

    $job_category = isset( $job_category ) ? $job_category : array();
    $locations    = hrm_Settings::getInstance()->hrm_query( 'hrm_location' );

    unset($locations['total_row']);

    foreach ($locations as $key => $value) {
        $location[$value->id] = $value->name;
    }

    $location  = isset( $location ) ? $location : array();
    $file_path = urlencode(__FILE__);
    ?>

    <!-- default $this for class hrm_Admin, $tab; -->
    <div class="hrm-pim">
        <?php Hrm_Settings::getInstance()->show_sub_tab_page( $page, $tab, $subtab ); ?>
    </div>
    <?php global $hrm_is_admin; ?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
        add_form_generator_action : 'add_form',
        add_form_apppend_wrap : 'hrm-eployee-list',
        redirect : '<?php echo $url; ?>',
        class_name : 'hrm_Employeelist',
        function_name : 'new_employee_form',
        job_title : '<?php echo json_encode( $job_title ); ?>',
        job_category : '<?php echo json_encode( $job_category ); ?>',
        location : '<?php echo json_encode( $location ); ?>',
        page: '<?php echo $page; ?>',
        tab: '<?php echo $tab; ?>',
        subtab: '<?php echo $subtab; ?>',
        req_frm: '<?php echo $file_path; ?>',
        is_admin: '<?php echo $hrm_is_admin; ?>',
    };
});
</script>

<script type="text/javascript">

    jQuery(function($) {

        function hrm_profile_pic_uploder() {
            var uploader = new plupload.Uploader({
                runtimes : 'html5,html4',
                browse_button : 'hrm-pickfiles',
                container : 'hrm-upload-file-container',
                file_data_name: 'hrm_attachment',
                multi_selection: false,
                max_file_size : '1mb',
                url : hrm_ajax_data.ajax_url,
                multipart_params: {
                    action: 'hrm_ajax_upload',
                    employee_id: '0',
                    _wpnonce: hrm_ajax_data._wpnonce
                },
                filters : [
                    {title : "Image files", extensions : 'jpg,JPEG,png'},
                ],
               // resize : {width : 1000, height : 1000 }
            });

            uploader.bind('Init', function(up, params) {
                //console.log('alskjfhskfj');
               //$('#art-filelist').html("<div>Current runtime: " + params.runtime + "</div>");
            });


            uploader.init();

            uploader.bind('FilesAdded', function(up, files) {
                $('#hrm-pickfiles').addClass('hrm-spinner');
                up.start();
                up.refresh(); // Reposition Flash/Silverlight
            });



            uploader.bind('UploadComplete', function( up, files, object ) {

                $('#hrm-pickfiles').removeClass('hrm-spinner');
            });

            uploader.bind('Error', function(up, err) {

                $('#art-filelist').append(
                    '<div class="art-error">'+
                    'Sorry, there was an error uploading some of your files.<br>Check to make sure they\'re JPG, JPEG, PNG, GIF files under '+art_image.max_file_size+'.<br>'+
                    'Try again or manage your artwork'+
                    '</div>'
                );

                up.refresh(); // Reposition Flash/Silverlight
            });

            uploader.bind('FileUploaded', function( up, file, response ) {

                var res = $.parseJSON(response.response);

                $('#' + file.id + " b").html("100%");

                if(res.success) {

                    $('#hrm-user-image-wrap').html(res.content);
                    $('.hrm-delete-file').removeClass('button');
                    $('.hrm-uploaded-item').find('img').attr({ width: 180, height: 180 });

                } else {
                    alert(res.error);
                }
            });
        }
     var hrm_file_ajax = {
        init: function() {
            $('#hrm').on( 'click', '.hrm-delete-file', this.deleteFile );

            $('body').on( 'after_getInsertDataForm', function( e, self, res ) {
                hrm_profile_pic_uploder();
            });

            $('body').on( 'after_success_edit', function( e, self, res ) {
                hrm_profile_pic_uploder();
            });
        },



         deleteFile: function(e) {
            e.preventDefault();

            if(confirm( hrm_ajax_data.confirm_msg )) {
                $('.hrm-delete-file').addClass('hrm-spinner');
                var that = $(this),
                    data = {
                        file_id: that.data('id'),
                        action: 'hrm_profile_pic_del',
                        employee_id: '0',
                        _wpnonce: hrm_ajax_data._wpnonce
                    };

                $.post(hrm_ajax_data.ajax_url, data, function(res) {
                    $('.hrm-delete-file').removeClass('hrm-spinner');
                    if( res.success ) {
                        that.closest('#hrm-user-image-wrap').html(res.data.content);
                    }
                });

            }
        }
    }

    hrm_file_ajax.init();
});


</script>