<div class="hrm-update-notification"></div>
<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'pim' );

if ( file_exists( $header_path ) ) {
    //require_once $header_path;
}


$can_manage = hrm_user_can( 'manage_employee' );
$can_edit = hrm_user_can( 'edit_employee' );



$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
?>
<div id="hrm-eployee-list"></div>
<?php

    global $wp_roles;

    if ( !$wp_roles ) {
        $wp_roles = new WP_Roles();
    }

    $role_names   = $wp_roles->get_names();

    $employers = hrm_Employeelist::getInstance()->get_employee();

    if ( !$employers ) {
        //return;
    }

    $hrm_menu = hrm_page();
    $pim_single_tab = false;

    $menu_pim_page = isset( $menu[hrm_pim_page()] ) ? $menu[hrm_pim_page()] : array();
    foreach ( $menu_pim_page as $pim_tab => $pim_tab_item ) {
        if ( array_key_exists( 'nested_tab', $pim_tab_item) && $pim_tab_item['nested_tab'] ) {
            $pim_single_tab = $pim_tab;
            break;
        }
    };
    foreach ( $employers as $key => $employer ) {
        $admin_url = hrm_employee_profile_url( hrm_employee_page(), $pim_single_tab, $employer->ID );
        $image_id        = get_user_meta( $employer->ID, '_hrm_user_image_id', true );
        $image_attchment = Hrm_Employeelist::getInstance()->get_image( $image_id );

        if ( $image_attchment ) {
            $file_url = sprintf( '<a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s" width="30" height="30" /></a>', $image_attchment['url'], $image_attchment['thumb'], esc_attr( $image_attchment['name']) );

            $emp_image =  '<div class="hrm-uploaded-item">' . $file_url .'</div>';
        } else {
            $emp_image = get_avatar( $employer->ID, 30 );
        }

        if ( $can_manage ) {
            $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$employer->ID.']" value="" type="checkbox">';
            $delete_text  = '<a href="#" class="hrm-delete" data-id='.$employer->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
            $td_attr[][0] = 'class="hrm-table-checkbox"';
        } else {
            $del_checkbox = '<input class="hrm-single-checked" disabled="disabled" value="" type="checkbox">';
            $delete_text  = '';
        }

        

        if ( $can_manage ) {
            $name_id = '<div class="hrm-title-wrap">
            <a href="'.$admin_url.'" class="hrm-title"  data-table_option="" data-id='.$employer->ID.'>'
                .$employer->display_name.
            '</a>
            <div class="hrm-title-action">
                <a href="#" class="hrm-editable hrm-edit" data-action="employer_edit" data-table_option="hrm_notice" data-id='.$employer->ID.'>'
                    .__( 'Edit', 'hrm' ).
                '</a>'

                .$delete_text.
            '</div></div>';
        } else if ( hrm_user_can( 'edit_employee', $employer->ID ) ) {
            $name_id = '<div class="hrm-title-wrap">
                <a href="'.$admin_url.'" class="hrm-title"  data-table_option="" data-id='.$employer->ID.'>'
                    .$employer->display_name.
                '</a>
                <div class="hrm-title-action">
                    <a href="#" class="hrm-editable hrm-edit" data-action="employer_edit" data-table_option="hrm_notice" data-id='.$employer->ID.'>'
                        .__( 'Edit', 'hrm' ).
                    '</a>
                </div></div>';
        } else {
            $name_id = '<div class="hrm-title-wrap">
                <a href="'.$admin_url.'" class="hrm-title"  data-table_option="" data-id='.$employer->ID.'>'
                    .$employer->display_name.
                '</a></div>';
        }



        $status = ( get_user_meta( $employer->ID, '_status', true ) == 'yes' ) ? 'Enable' : 'Disable';
        
        $department = get_user_meta( $employer->ID, '_job_category', true );
        $department = Hrm_Admin::getInstance()->get_departments( $department );
        $department_name = $department ? $department->name : '';
        
        $role_display_name = reset( $employer->roles );
        $role_display_name = isset( $role_names[$role_display_name] ) ? $role_names[$role_display_name] : '';

       
        $body[] = apply_filters( 'hrm_employess_list_row', array(
            $del_checkbox,
            $emp_image . $name_id,
            get_user_meta( $employer->ID, 'first_name', true ),
            get_user_meta( $employer->ID, 'last_name', true ),
            $role_display_name,
            $department_name,
            $status,
            get_user_meta( $employer->ID, '_mob_number', true ),
            hrm_get_date2mysql( get_user_meta( $employer->ID, '_joined_date', true ) ),
        ), $employer );

    }

    $table = array();

    if ( $can_manage ) {
        $checkbox = '<input class="hrm-all-checked" type="checkbox">';
    } else {
        $checkbox = '<input disabled="disabled" class="hrm-all-checked" type="checkbox">';
    }

    
    $table['head'] = array(
        $checkbox,
        __( 'Profile', 'hrm' ),
        __( 'First Name', 'hrm' ),
        __( 'Last Name', 'hrm' ),
        __( 'Role', 'hrm' ),
        __( 'Department', 'hrm' ),
        __( 'Status', 'hrm' ),
        __( 'Mobile', 'hrm' ),
        __( 'Joined Date', 'hrm' ),
    );
    

    $table['body']       = isset( $body ) ? $body : '';
    $table['td_attr']    = isset( $td_attr ) ?$td_attr : '';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['table']      = 'hrm_employee';
    $table['tab']        = $tab;
    $table['page']       = $page;
    $table['action']     = 'employee_delete';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['add_btn']     = $can_manage;
    $table['delete_btn']  = $can_manage;

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
                max_file_size : '10mb',
                url : HRM_Vars.ajax_url,
                multipart_params: {
                    action: 'hrm_ajax_upload',
                    employee_id: '0',
                    _wpnonce: HRM_Vars.nonce
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
                    'Sorry, there was an error uploading some of your files.<br>Check to make sure they\'re JPG, JPEG, PNG, GIF files under 1mb<br>'+
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

            if(confirm( HRM_Vars.confirm_msg )) {
                $('.hrm-delete-file').addClass('hrm-spinner');
                var that = $(this),
                    data = {
                        file_id: that.data('id'),
                        action: 'hrm_profile_pic_del',
                        employee_id: '0',
                        _wpnonce: HRM_Vars.nonce
                    };

                $.post(HRM_Vars.ajax_url, data, function(res) {
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