

jQuery(function($) {

     var hrm_file_ajax = {
        init: function() {
            $('#hrm').on( 'click', '#hrm-file .hrm-delete-file', this.deleteFile );
            $('#hrm').on( 'submit', '#hrm-file #hrm-file-upload-form', this.fileSubmit );


            $('body').on( 'after_getInsertDataForm', function( e, self, res ) {
                var uploader = new plupload.Uploader({
                    runtimes : 'html5,html4',
                    browse_button : 'hrm-pickfiles',
                    drop_element : 'hrm-drop-files-zone',
                    container : 'hrm-upload-file-container',
                    file_data_name: 'hrm_attachment',
                    max_file_size : '1mb',
                    url : hrm_ajax_data.ajax_url,
                    multipart_params: {
                        action: 'hrm_ajax_upload',
                        _wpnonce: hrm_ajax_data._wpnonce
                    },
                    filters : [
                        {title : "Image files", extensions : 'jpg, JPEG,png'},
                        {title : "Zip files", extensions : "zip"}
                    ],
                   // resize : {width : 1000, height : 1000 }
                });

                uploader.bind('Init', function(up, params) {
                    //console.log('alskjfhskfj');
                   //$('#art-filelist').html("<div>Current runtime: " + params.runtime + "</div>");
                });


                uploader.init();

                uploader.bind('FilesAdded', function(up, files) {

                    $.each(files, function(i, file) {
                        $('#hrm-filelist').append(
                            '<div class="hrm-single-progress">'+
                                '<span class="hrm-filename">'
                                     +file.name+
                                '<strong>0%</strong></span>'+
                                '<div class="hrm-upload-bar" id="' + file.id + '"></div>' +
                            '</div>'
                        );
                    });
                   // (' + plupload.formatSize(file.size) + ')
                    up.start();
                    up.refresh(); // Reposition Flash/Silverlight
                });

                uploader.bind('UploadProgress', function(up, file) {
                    $('#' + file.id ).css( {
                        'width' : file.percent+'%',
                    } );

                    $('#' + file.id).siblings('span').children('strong').html(file.percent + "%");

                    //'#' + file.id + " b"
                });

                uploader.bind('UploadComplete', function( up, files, object ) {

                    //location.href = art_image.dashboard;
                });

                uploader.bind('Error', function(up, err) {

                    $('#art-filelist').append(
                        '<div class="art-error">'+
                        'Sorry, there was an error uploading some of your files.<br>Check to make sure they\'re JPG, JPEG, PNG, GIF files under '+art_image.max_file_size+'.<br>'+
                        'Try again or manage your artwork'+
                        '</div>'
                    );

                   /* $('#art-filelist').append("<div class=\"art-error\">Error: " + err.code +
                        ", Message: " + err.message +
                        (err.file ? ", File: " + err.file.name : "") +
                        "</div>"
                    );*/

                    up.refresh(); // Reposition Flash/Silverlight
                });

                uploader.bind('FileUploaded', function( up, file, response ) {

                    var res = $.parseJSON(response.response);

                    $('#' + file.id + " b").html("100%");
                    var append = $('#' + file.id).closest('.hrm-single-progress');

                    if(res.success) {
                        append.html(res.content);
                    } else {
                        alert(res.error);
                    }
                });
            });
        },

        fileSubmit: function(e) {
            e.preventDefault();
            var slef = $(this),
                data = slef.serialize();

            $.post(hrm_ajax_data.ajax_url, data, function(res) {
               if ( res.success ) {

                }
            });
        },

        deleteFile: function(e) {
            e.preventDefault();

            if(confirm( hrm_ajax_data.confirm_msg )) {
                var that = $(this),
                    data = {
                        file_id: that.data('id'),
                        action: 'hrm_delete_file',
                        _wpnonce: hrm_ajax_data._wpnonce
                    };

                $.post(hrm_ajax_data.ajax_url, data, function( res ) {
                    if( res.success ) {
                        that.closest('.hrm-single-progress').fadeOut(function(){
                            $(this).remove();
                        });
                    }
                });

            }
        }
    }

    hrm_file_ajax.init();
});

