<div class="hrm-update-notification"></div>
<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'pim' );

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}

$url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
?>
<div v-show="{{job_title_form}}" id="hrm-job-title-form-wrap" style="display: none;">
    <?php require_once HRM_TEMP_PATH . '/admin/js-job-title-form.php'; ?>
</div>
<div v-show="{{job_location_form}}" id="hrm-job-location-form-wrap" style="display: none;">
    <?php require_once HRM_TEMP_PATH . '/admin/js-job-location-form-wrap.php'; ?>
</div>
<div v-show="{{job_category_form}}" id="hrm-job-category-form-wrap" style="display: none;">
    <?php require_once HRM_TEMP_PATH . '/admin/js-job-category-form.php'; ?>
</div>
<div v-show="{{employee_form}}" id="hrm-eployee-list" style="display: none;">
    <?php require_once HRM_TEMP_PATH . '/pim/new-employee-form-js.php'; ?>
</div>
<?php

    $role_names = hrm_get_roles()->get_names();
    $employees  = Hrm_Employeelist::getInstance()->get_employees(); 

    $add_permission    = hrm_user_can_access( $page, $tab, null, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $page, $tab, null, 'delete' ) ? true : false;

    $menu_pim_page = isset( $menu[hrm_pim_page()] ) ? $menu[hrm_pim_page()] : array();
    foreach ( $menu_pim_page as $pim_tab => $pim_tab_item ) {
        if ( array_key_exists( 'nested_tab', $pim_tab_item) && $pim_tab_item['nested_tab'] ) {
            $pim_single_tab = $pim_tab;
            break;
        }
    };
    wp_localize_script( 'hrm_admin', 'hrm_employee', $employees );
    foreach ( $employees as $key => $employer ) {
        $employee_info[$employer->ID] = array(
            'job_title' => get_user_meta( $employer->ID, '_job_title', true ),
            'job_category' => get_user_meta( $employer->ID, '_job_category', true ),
            'job_location' => get_user_meta( $employer->ID, '_location', true ),
            'first_name'   => get_user_meta( $employer->ID, 'first_name', true ),
            'last_name'    => get_user_meta( $employer->ID, 'last_name', true ),
            'joined_date'  => hrm_get_date2mysql( get_user_meta( $employer->ID, '_joined_date', true ) ),
            'job_desc'     => get_user_meta( $employer->ID, '_job_desc', true ),
            'mobile'       => get_user_meta( $employer->ID, '_mob_number', true ),
            'status'       => get_user_meta( $employer->ID, '_status', true ),
        );

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
                <a href="#" v-on:click="hrmEdit"  class="hrm-editable hrm-edit" data-action="employer_edit" data-table_option="hrm_notice" data-id='.$employer->ID.'>'
                    .__( 'Edit', 'hrm' ).
                '</a>'

                .$delete_text.
            '</div>';
        } else {
            $name_id = $employer->display_name;
        }

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
wp_localize_script( 'hrm_admin', 'hrm_employee_info', $employee_info );
    $table = array();

    if ( $delete_permission ) {
        $table['head'] = array(
            '<input class="hrm-all-checked" type="checkbox">',
            __( 'Profile', 'hrm' ),
            __( 'First Name', 'hrm' ),
            __( 'Last Name', 'hrm' ),
            __( 'Department', 'hrm' ),
            __( 'Status', 'hrm' ),
            __( 'Mobile', 'hrm' ),
            __( 'Joined Date', 'hrm' ),
        );
    } else {
        $table['head'] = array(
            __( 'Profile', 'hrm' ),
            __( 'First Name', 'hrm' ),
            __( 'Last Name', 'hrm' ),
            __( 'Department', 'hrm' ),
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


<?php
//$new_employee_form_path = HRM_TEMP_PATH . '/pim/new-employee-form-js.php';
//hrm_get_js_template( $new_employee_form_path, 'hrm-new-employee-form' );

