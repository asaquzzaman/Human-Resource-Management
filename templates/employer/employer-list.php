<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'employer' );

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}

?>

<div class="hrm-update-notification"></div>

<div id="hrm-admin-list"></div>
<?php

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

$search_query = Hrm_Admin::getInstance()->get_employer();

$results           = $search_query->get_results();
$total             = $search_query->get_total();
$add_permission    = hrm_user_can_access( $page,  $tab, $subtab, 'add' ) ? true : false;
$delete_permission = hrm_user_can_access( $page,  $tab, $subtab, 'delete' ) ? true : false;
$user              = wp_get_current_user();
$body              = array();
$td_attr           = array();

foreach ( $results as $id => $user_obj) {
    if ( $user->user_login ==  $user_obj->user_login ) {
        continue;
    }
	$flag = get_user_meta( $user_obj->ID, '_status', true );

	$status = ( $flag == 'yes' ) ? 'Enable' : 'Disable';
    $role = isset( $user_obj->roles ) ? reset( $user_obj->roles ) : '';

    if ( $delete_permission ) {
        $del_checkbox = '<input class="hrm-single-checked" name="hrm_check['.$user_obj->ID.']" value="" type="checkbox">';
        $delete_text  = '<a href="#" class="hrm-delete" data-id='.$user_obj->ID.'>'.__( 'Delete', 'hrm' ).'</a>';
        $td_attr[][0] = 'class="hrm-table-checkbox"';
    } else {
        $del_checkbox = '';
        $delete_text  = '';
    }
    $admin_url = hrm_employee_profile_url( 'hrm_pim', 'personal', 'personal_info', $user_obj->ID );
    if ( $add_permission ) {
        $name_id = '<div class="hrm-title-wrap">
        <a href="'.$admin_url.'" class="" >'.$user_obj->user_login.'<a>
         <div class="hrm-title-action">
			<a href="'.$admin_url.'" class="hrm-edit">'
                    .__( 'Profile', 'hrm' ).
            '</a>
         <a href="#" data-action="user-role-edit-form-appear" class="hrm-editable hrm-edit" data-id='.$user_obj->ID.'>'.__( 'Edit', 'hrm' ).'</a>'
        .$delete_text. '</div></div>';
    } else {
        $name_id = $user_obj->user_login;
    }

    $employer_status = hrm_user_can_access( $page,  $tab, $subtab, 'admin_list_employer_status', true );

    if ( $employer_status ) {
        $admin_status_dropdown = array(
            'class'    => 'hrm-admin-status',
            'extra'    => array(
                'data-user_id' => $user_obj->ID,
            ),
            'option'   => array( 'yes' => __( 'Enable', 'hrm' ), 'no' => __('Disable', 'hrm') ),
            'selected' => $flag
        );
        $admin_status_dropdown = Hrm_settings::getInstance()->select_field( 'admin_staus', $admin_status_dropdown );
    } else {
        $admin_status_dropdown = __('Permission denied', 'hrm' );
    }

    if ( $delete_permission ) {
        $body[] = array(
            $del_checkbox,
            $name_id,
            $role,
            $user_obj->display_name,
            $admin_status_dropdown,
        );

    } else {
        $body[] = array(
            $name_id,
            $role,
            $user_obj->display_name,
            $admin_status_dropdown,
        );
    }
}

$table = array();
if ( $delete_permission ) {
    $table['head']   = array( '<input class="hrm-all-checked" type="checkbox">', __( 'Admin Name', 'hrm') , __( 'Role', 'hrm' ), __( 'Display Name', 'hrm' ), __( 'Status', 'hrm' ) );
} else {
    $table['head']   = array( __( 'Admin Name', 'hrm') , __( 'Role', 'hrm' ), __( 'Display Name', 'hrm' ), __( 'Status', 'hrm' ) );
}

$table['body']       = isset( $body ) ? $body : '';
$table['td_attr']    = isset( $td_attr ) ? $td_attr : '';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_job_title_option';
$table['action']     = 'hrm_user_delete';
$table['table_attr'] = array( 'class' => 'widefat' );
$table['tab']        = $tab;
$table['subtab']     = $subtab;
$table['page']       = $page;
$table['results']    = $results;


echo Hrm_settings::getInstance()->table( $table );
$file_path = urlencode(__FILE__);



?>

<div id="hrm-create-user-wrap" title="<?php _e( 'Create a new user', 'hrm' ); ?>" style="display: none;">
    <div class="hrm-create-user-form-wrap">

        <div class="hrm-error"></div>

        <form action="" class="hrm-user-create-form">
            <?php wp_nonce_field( 'hrm_nonce', '_wpnonce' ); ?>
            <div class="hrm-field-wrap">
                <label><?php _e('Username', 'hrm'); ?></label>
                <input type="text" required name="admin_name">

            </div>
            <div class="hrm-field-wrap">
                <label><?php _e('First Name', 'hrm'); ?></label>
                <input type="text" name="first_name">

            </div>
            <div class="hrm-field-wrap">
                <label><?php _e('Last Name', 'hrm'); ?></label>
                <input type="text" name="last_name">

            </div>
            <div class="hrm-field-wrap">
                <label><?php _e('Email', 'hrm'); ?></label>
                <input type="email" required name="admin_email">

            </div>
            <div>
                <input class="button-primary" type="submit" value="Create User" name="create_user">
                <span></span>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    jQuery(function($) {
        $( "#hrm-create-user-wrap" ).dialog({
            autoOpen: false,
            modal: true,
            dialogClass: 'hrm-ui-dialog',
            width: 400,
            height: 'auto',
            position:['middle', 100],

        });
    });
</script>
<?php $url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
        add_form_generator_action : 'add_form',
        add_form_apppend_wrap : 'hrm-admin-list',
        redirect : '<?php echo $url; ?>',
        class_name : 'Hrm_Admin',
        function_name : 'admin_list',
        job_title : '<?php echo json_encode( $job_title ); ?>',
        job_category : '<?php echo json_encode( $job_category ); ?>',
        location : '<?php echo json_encode( $location ); ?>',
        page: '<?php echo $page; ?>',
        tab: '<?php echo $tab; ?>',
        subtab: '<?php echo $subtab; ?>',
        req_frm: '<?php echo $file_path; ?>',
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