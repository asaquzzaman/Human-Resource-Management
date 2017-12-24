<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'employee' );

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}

?>
<div class="hrm-update-notification"></div>
<?php

if ( isset( $_REQUEST['employee_id'] ) && $_REQUEST['employee_id'] ) {
    $employee_id = intval( $_REQUEST['employee_id'] );
} else {
    $employee_id = get_current_user_id();
}


$employee        = get_user_by( 'id', $employee_id );
$country         = hrm_Settings::getInstance()->country_list();
$image_id        = get_user_meta( $employee_id, '_hrm_user_image_id', true );
$image_attchment = Hrm_Employeelist::getInstance()->get_image( $image_id );
$didplay_status  = !$image_attchment ? 'style="display:none;"' : '';
ob_start();

$can_edit = hrm_user_can( 'edit_employee', $employee_id );

?>
<div class="hrm-profile-image-wrap">
    
    <div class="hrm-employee-pic-text"><strong><?php  _e( 'Profile Picture', 'hrm' ); ?></strong></div>
    <div id="hrm-upload-file-container">
        
        <?php if ( $can_edit ) { ?>
            <div class="hrm-drop-area" id="hrm-drop-files-zone">
                <a id="hrm-pickfiles" href="#"><?php _e( 'Change', 'hrm' ); ?></a>
            </div>
        <?php } ?>

        <div id="hrm-user-image-wrap">
            <?php

            if ( $image_attchment ) {

                $delete = $can_edit ? sprintf( '<a href="#" data-id="%d" class="hrm-delete-file">%s</a>', $image_attchment['id'], __( 'Delete', 'hrm' ) ) : '';
                $hidden = sprintf( '<input type="hidden" name="hrm_attachment[]" value="%d" />', $image_attchment['id'] );
                $file_url = sprintf( '<a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s" width="100" height="100" /></a>', $image_attchment['url'], $image_attchment['thumb'], esc_attr( $image_attchment['name']) );

                echo '<div class="hrm-uploaded-item">' . $file_url . ' ' . $delete . $hidden . '</div>';
            } else {
                echo get_avatar( $employee_id, 100 );
            }
            ?>

        </div>
    </div>
</div>

<?php
$profile_pic = ob_get_clean();

ob_start();
$dept_id = get_user_meta( $employee_id, '_job_category', true );
$job_category = Hrm_Admin::getInstance()->get_departments( $dept_id );

?>
    <div class="hrm-descriptive-wrap">

        <div class="hrm-descriptive-label">Department</div>
        <div class="hrm-descriptive-content">
            <strong>
                <?php echo empty ( $job_category->name ) ? '&#8211 &#8211' : $job_category->name; ?>
                    
            </strong>
        </div>
    </div>
<?php
$department = ob_get_clean();

ob_start();
$role = get_user_meta( $employee_id, 'role', true );
$designation = hrm_current_user_display_role();

?>
    <div class="hrm-descriptive-wrap">

        <div class="hrm-descriptive-label">Designation</div>
        <div class="hrm-descriptive-content"><strong><?php echo $designation ? $designation : '&#8211 &#8211'; ?></strong></div>
    </div>
<?php
$designation = ob_get_clean();


$field[] = array(
    'label' => '',
    'type'  => 'descriptive',
    'value' => $profile_pic
);

$field[] = array(
    'label' => '',
    'type'  => 'descriptive',
    'value' => $department
);

// $field[] = array(
//     'label' => '',
//     'type'  => 'descriptive',
//     'value' => $designation
// );

$field['user_id'] = array(
    'type' => 'hidden',
    'value' => $employee_id
);


$field['gender'] = array(
    'label'  => __( 'Gender', 'hrm' ),
    'type'   => 'radio',
    'desc'   => 'select your gender',
    'fields' => array(
        array(
            'label'   => __( 'Male', 'hrm' ),
            'value'   => 'male',
            'checked' => $this->get_emp_meta( $employee_id, '_gender' ),
            'disabled' => $can_edit ? false : 'disabled',
        ),
        array(
            'label'   => __( 'Female', 'hrm' ),
            'value'   => 'female',
            'checked' => $this->get_emp_meta( $employee_id, '_gender' ),
            'disabled' => $can_edit ? false : 'disabled',
        ),
    ),
);

$field['marital_status'] = array(
    'label'    => __( 'Marital Status', 'hrm' ),
    'type'     => 'select',
    'selected' => $this->get_emp_meta( $employee_id, '_marital_status' ),
    'disabled' => $can_edit ? false : 'disabled',
    'option'   => array(
        ''     => __( '--Select--', 'hrm' ),
        'single'  => __( 'Single', 'hrm' ),
        'married' => __( 'Married', 'hrm' )
    )
);

$field['national_code'] = array(
    'label'    => __( 'Nationality', 'hrm' ),
    'type'     => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_national_code' ),
    'disabled' => $can_edit ? false : 'disabled',
);

$field['birthday'] = array(
    'label' => __( 'Birthday', 'hrm' ),
    'type'  => 'text',
    'class' => 'hrm-datepicker',
    'value' => hrm_get_date2mysql( $this->get_emp_meta( $employee_id, '_birthday' ) ),
    'disabled' => $can_edit ? false : 'disabled',
);

$field['street1'] = array(
    'label' => __( 'Address Street 1', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_street1' ),
    'disabled' => $can_edit ? false : 'disabled',
);

$field['street2'] = array(
    'label' => __( 'Address Street 2', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_street2' ),
    'disabled' => $can_edit ? false : 'disabled',
);

$field['city_code'] = array(
    'label' => __( 'City', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_city_code' ),
    'disabled' => $can_edit ? false : 'disabled',
);


$field['state'] = array(
    'label' => __( 'State/Province', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_state' ),
    'disabled' => $can_edit ? false : 'disabled',
);

$field['zip'] = array(
    'label' => __( 'Zip/Postal Code', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_zip' ),
    'disabled' => $can_edit ? false : 'disabled',
);


$field['country_code'] = array(
    'label' => __( 'Country', 'hrm' ),
    'type' => 'select',
    'option' => $country,
    'selected' => $this->get_emp_meta( $employee_id, '_country_code' ),
    'desc' => 'Chose your country',
    'disabled' => $can_edit ? false : 'disabled',
);

$field['work_mobile'] = array(
    'label' => __( 'Work Telephone', 'hrm' ),
    'type'  => 'text',
    'value' => $this->get_emp_meta( $employee_id, '_work_mobile' ),
    'disabled' => $can_edit ? false : 'disabled',
);

// $field['work_email'] = array(
//     'label' => __( 'Email', 'hrm' ),
//     'type'  => 'text',
//     'value' => $this->get_emp_meta( $employee_id, '_work_email' ),
//     'extra' => array(
//         'data-hrm_validation' => true,
//         'data-hrm_email' => true,
//         'data-hrm_email_error_msg'=> __( 'Please enter a valid email', 'hrm' ),
//     ),
//     'disabled' => $can_edit ? false : 'disabled',
// );

ob_start();
?>
    <div class="hrm-descriptive-wrap">

        <div class="hrm-descriptive-label">Email</div>
        <div class="hrm-descriptive-content">
            <strong>
                <?php echo $employee->user_email; ?>
                    
            </strong>
        </div>
    </div>

<?php
$email = ob_get_clean();

$field[] = array(
    'label' => '',
    'type'  => 'descriptive',
    'value' => $email
);



$field['header']       = 'Personal Information';
$field['action']       = 'update_my_info';
$field['table_option'] = 'hrm_personal_info';
$field['id']           = isset( $results->id ) ? $results->id : '';
$field['tab']          = $tab;
$field['sub_tab']      = $subtab;
$field['page']         = $page;
$field['submit_btn']   = $can_edit;



echo hrm_Settings::getInstance()->visible_form_generator( $field );


?>


<script type="text/javascript">

    jQuery(function($) {

     var hrm_file_ajax = {
        init: function() {
            $('#hrm').on( 'click', '.hrm-delete-file', this.deleteFile );


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
                        employee_id: <?php echo $employee_id; ?>,
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

                    // $('#art-filelist').append(
                    //     '<div class="art-error">'+
                    //     'Sorry, there was an error uploading some of your files.<br>Check to make sure they\'re JPG, JPEG, PNG, GIF files under '+art_image.max_file_size+'.<br>'+
                    //     'Try again or manage your artwork'+
                    //     '</div>'
                    // );

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

        },



        deleteFile: function(e) {
            e.preventDefault();

            if(confirm( HRM_Vars.confirm_msg )) {
                $('.hrm-delete-file').addClass('hrm-spinner');
                var that = $(this),
                    data = {
                        file_id: that.data('id'),
                        action: 'hrm_profile_pic_del',
                        employee_id: <?php echo $employee_id; ?>,
                        _wpnonce: HRM_Vars.nonce
                    };

                $.post(HRM_Vars.ajax_url, data, function(res) {
                    if( res.success ) {
                        $('.hrm-delete-file').removeClass('hrm-spinner');
                        that.closest('#hrm-user-image-wrap').html(res.data.content);
                    }
                });

            }
        }
    }

    hrm_file_ajax.init();
});


</script>

<style>
    .hrm-delete-file {
        display: block;
    }
    .hrm-profile-image-wrap:after, .hrm-descriptive-wrap:after {
        content: "";
        clear: both;
        display: block;
    }
    .hrm-descriptive-wrap:after {
        margin-bottom: 10px;
    }
    .hrm-employee-pic-text {
        width: 21%;
    }
    #hrm-upload-file-container {
        margin-bottom: 10px; 
    }
    .hrm-profile-image-wrap .hrm-employee-pic-text, 
    #hrm-upload-file-container {
        float: left;
    }
    .hrm-descriptive-content, .hrm-descriptive-label {
        float: left;
    }
    .hrm-descriptive-label {
        width: 21%;
        font-size: 14px;
    }

</style>

