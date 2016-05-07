

// jQuery(function($) {

//      var hrm_file_ajax = {
//         init: function() {
//             $('#hrm').on( 'click', '#hrm-file .hrm-delete-file', this.deleteFile );
//             $('#hrm').on( 'submit', '#hrm-file #hrm-file-upload-form', this.fileSubmit );


//             $('body').on( 'after_getInsertDataForm', function( e, self, res ) {
//                 var uploader = new plupload.Uploader({
//                     runtimes : 'html5,html4',
//                     browse_button : 'hrm-pickfiles',
//                     drop_element : 'hrm-drop-files-zone',
//                     container : 'hrm-upload-file-container',
//                     file_data_name: 'hrm_attachment',
//                     max_file_size : '1mb',
//                     url : hrm_ajax_data.ajax_url,
//                     multipart_params: {
//                         action: 'hrm_ajax_upload',
//                         _wpnonce: hrm_ajax_data._wpnonce
//                     },
//                     filters : [
//                         {title : "Image files", extensions : 'jpg, JPEG,png'},
//                         {title : "Zip files", extensions : "zip"}
//                     ],
//                    // resize : {width : 1000, height : 1000 }
//                 });

//                 uploader.bind('Init', function(up, params) {
//                     //console.log('alskjfhskfj');
//                    //$('#art-filelist').html("<div>Current runtime: " + params.runtime + "</div>");
//                 });


//                 uploader.init();

//                 uploader.bind('FilesAdded', function(up, files) {

//                     $.each(files, function(i, file) {
//                         $('#hrm-filelist').append(
//                             '<div class="hrm-single-progress">'+
//                                 '<span class="hrm-filename">'
//                                      +file.name+
//                                 '<strong>0%</strong></span>'+
//                                 '<div class="hrm-upload-bar" id="' + file.id + '"></div>' +
//                             '</div>'
//                         );
//                     });
//                    // (' + plupload.formatSize(file.size) + ')
//                     up.start();
//                     up.refresh(); // Reposition Flash/Silverlight
//                 });

//                 uploader.bind('UploadProgress', function(up, file) {
//                     $('#' + file.id ).css( {
//                         'width' : file.percent+'%',
//                     } );

//                     $('#' + file.id).siblings('span').children('strong').html(file.percent + "%");

//                     //'#' + file.id + " b"
//                 });

//                 uploader.bind('UploadComplete', function( up, files, object ) {

//                     //location.href = art_image.dashboard;
//                 });

//                 uploader.bind('Error', function(up, err) {

//                     $('#art-filelist').append(
//                         '<div class="art-error">'+
//                         'Sorry, there was an error uploading some of your files.<br>Check to make sure they\'re JPG, JPEG, PNG, GIF files under '+art_image.max_file_size+'.<br>'+
//                         'Try again or manage your artwork'+
//                         '</div>'
//                     );

//                    /* $('#art-filelist').append("<div class=\"art-error\">Error: " + err.code +
//                         ", Message: " + err.message +
//                         (err.file ? ", File: " + err.file.name : "") +
//                         "</div>"
//                     );*/

//                     up.refresh(); // Reposition Flash/Silverlight
//                 });

//                 uploader.bind('FileUploaded', function( up, file, response ) {

//                     var res = $.parseJSON(response.response);

//                     $('#' + file.id + " b").html("100%");
//                     var append = $('#' + file.id).closest('.hrm-single-progress');

//                     if(res.success) {
//                         append.html(res.content);
//                     } else {
//                         alert(res.error);
//                     }
//                 });
//             });
//         },

//         fileSubmit: function(e) {
//             e.preventDefault();
//             var slef = $(this),
//                 data = slef.serialize();

//             $.post(hrm_ajax_data.ajax_url, data, function(res) {
//                if ( res.success ) {

//                 }
//             });
//         },

//         deleteFile: function(e) {
//             e.preventDefault();

//             if(confirm( hrm_ajax_data.confirm_msg )) {
//                 var that = $(this),
//                     data = {
//                         file_id: that.data('id'),
//                         action: 'hrm_delete_file',
//                         _wpnonce: hrm_ajax_data._wpnonce
//                     };

//                 $.post(hrm_ajax_data.ajax_url, data, function( res ) {
//                     if( res.success ) {
//                         that.closest('.hrm-single-progress').fadeOut(function(){
//                             $(this).remove();
//                         });
//                     }
//                 });

//             }
//         }
//     }

//     hrm_file_ajax.init();
// });
// 




;(function($) {
   /**
     * Upload handler helper
     *
     * @param string {browse_button} browse_button ID of the pickfile
     * @param string {container} container ID of the wrapper
     * @param int {max} maximum number of file uplaods
     * @param string {type}
     */
    window.hrm_Uploader = function( action, browse_button, container, drop, type, allowed_type, max_file_size, callback ) {
         
        this.container = container;
        this.browse_button = browse_button;

        //if no element found on the page, bail out
        if( !$('#'+browse_button).length ) {
            return;
        }

        //instantiate the uploader
        this.uploader = new plupload.Uploader({
            dragdrop: true,
            drop_element: drop,
            runtimes : 'html5,html4',
            browse_button: browse_button,
            container: container,
           // multipart: true,
            multipart_params: {
                action: action, 
                file_id: $( '#' + browse_button ).data('file_id'),
                _wpnonce: hrm_ajax_data._wpnonce
            },
            //multiple_queues: false,
            //multi_selection: false,
            //urlstream_upload: true,
           // file_data_name: 'wpuf_file',
            max_file_size: max_file_size + 'kb',
            url: hrm_ajax_data.plupload.url + '&type=' + type,
            flash_swf_url: hrm_ajax_data.plupload.flash_swf_url,
            filters: [{
                title: 'Allowed Files',
                extensions: allowed_type
            }],

            views: {
                list: true,
                thumbs: true, // Show thumbs
                active: 'thumbs'
            },
     
            // Flash settings
            flash_swf_url : '/plupload/js/Moxie.swf',
         
            // Silverlight settings
            silverlight_xap_url : '/plupload/js/Moxie.xap'

        });

        //attach event handlers
        this.uploader.bind('Init', $.proxy(this, 'init'));
        this.uploader.bind('FilesAdded', $.proxy(this, 'added'));
        this.uploader.bind('QueueChanged', $.proxy(this, 'upload'));
        this.uploader.bind('UploadProgress', $.proxy(this, 'progress'));
        this.uploader.bind('Error', $.proxy(this, 'error'));
        this.uploader.bind('FileUploaded', $.proxy(this, 'uploaded'));
        
        this.uploader.init();
        this.callback = callback;

        $('#' + container).on('click', 'a.attachment-delete', $.proxy(this.removeAttachment, this));
    };

               
    hrm_Uploader.prototype = {

        init: function (up, params) {
            //this.showHide();
        },

        executeFunctionByName: function (functionName, context, args ) {
            if ( typeof functionName == 'undefined' ) {
                return false;
            }
            var args       = [].slice.call(arguments).splice(2);
            var namespaces = functionName.split(".");
            var func       = namespaces.pop();

            for(var i = 0; i < namespaces.length; i++) {
                context = context[namespaces[i]];
            }
            if ( typeof context[func] === "function" ) {
                return context[func].apply(context, args);
            } else {
                return false;
            }
        },

        added: function (up, files) {
             
            var $container = $('#' + this.container).find('.hrm-attachment-upload-filelist');
            var $container_wrap = $('#' + this.container).find('.hrm-attachment-list');
                
            $.each(files, function(i, file) {
                
                $container_wrap.append('<li class="hrm-image-wrap thumbnail '+file.id+'">'+
                    '<div class="attachment-name hrm-img-progress">'+
                        '<div class="upload-item" id="' + file.id + '">'+
                            '<div class="progress progress-striped active">'+
                                '<div class="bar"></div>'+
                            '</div>'+
                            // '<div class="filename original">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>'+
                        '</div>'+
                    '</div>'+
                '</li>');
            });

            up.refresh(); // Reposition Flash/Silverlight
            up.start();
        },

        upload: function (uploader) {
            this.uploader.start();
        },

        progress: function (up, file) {
            var item = $('#' + file.id);    
            $('.bar', item).css({ width: file.percent + '%' });
            $('.percent', item).html( file.percent + '%' );  
        },

        error: function (up, error) {
            $('#' + this.container).find('#' + error.file.id).remove();

            var msg = '';
            switch(error.code) {
                case -600:
                    msg = 'The file you have uploaded exceeds the file size limit. Please try again.';
                    break;

                case -601:
                    msg = 'You have uploaded an incorrect file type. Please try again.';
                    break;

                default:
                    msg = 'Error #' + error.code + ': ' + error.message;
                    break;
            }

            alert(msg);

            this.uploader.refresh();
        },

        uploaded: function ( up, file, response ) {
            
            var res = $.parseJSON(response.response),
                data  = {
                    up : up,
                    file: file,
                    response: response
                };
                
            var callback = this.executeFunctionByName( this.callback.after_uploaded, window, data );
            if ( callback !== false ) {
                return;
            } 
                
            $('#' + file.id + " b").html("100%");
            $('#' + file.id).remove();

            if( res.success ) {
                $('.'+file.id).replaceWith(res.data);
                //$('.hrm-pre-load-image-wrap').remove();
               // var $container = $('#' + this.container).find('.hrm-attachment-list');
                //$container.append(res.data);
            } else {
                alert(res.error);
            }
        },

        removeAttachment: function(e) {
            e.preventDefault();

            var self = this,
            el = $(e.currentTarget);

            if ( confirm(hrm_ajax_data.message.confirmMsg) ) {
                var data = {
                    attach_id : el.data('attach_id'),
                    custom_attr: el.closest('.hrm-image-wrap').find('.hrm-file-mime').data(),
                    _wpnonce: hrm_ajax_data.nonce,
                    action : 'hrm_file_delete'
                };

                jQuery.post(hrm_ajax_data.ajaxurl, data, function() {
                    el.parent().parent().remove();

                    self.uploader.refresh();
                });
            }
        }
    };
})(jQuery);






