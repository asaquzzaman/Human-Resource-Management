;(function($){
    var hrmGeneral = {
        init: function() {
            this.chosen();
            this.datePicker();
            this.timePicker();
            this.datePickerRestricted();
            //this.slider();
            $('#hrm').on( 'click', '.hrm-add-button', this.getInsertDataForm );
            $('#hrm').on( 'click', '.hrm-form-cancel', this.formshowHide );
            $('#hrm').on( 'submit', '#hrm-hidden-form', this.add );
            $('#hrm').on( 'click', 'a.hrm-editable', this.edit );
            $('#hrm').on( 'click', '.hrm-delete-button', this.delete );
            $('#hrm').on( 'submit', '#hrm-visible-form-warp #hrm-visible-form', this.singleFormAdd );
            $('body').on('submit', '.hrm-user-create-form', this.userCreate);
            $('#hrm').on('click', '.hrm-delte-user-meta', this.removeUserMeta);
            $('#hrm').on('change', '.hrm-leave-action', this.leaveStatusChange);
            $('#hrm').on( 'click', '.hrm-complete-task', this.taskComplete );
            $('#hrm').on( 'click', '.hrm-incomplete-task', this.taskInComplete );
            $('#hrm').on( 'click', '.hrm-personal .hrm-deposit-check', this.depositStatus );
            $('#hrm').on( 'click', '.hrm-task-desc', this.showTaskDesc );
            $('#hrm').on( 'change', '.hrm-admin-status', this.changeAdminStatus );
            $('#hrm').on( 'click', '.hrm-time-editable', this.editAttendance );
            $('#hrm').on( 'change', '#hrm-search-form #hrm-rank-task-user', this.userTaskRating );
            $('#hrm').on( 'submit', '.hrm-evaluation-task-wrap #hrm-task-rating-form', this.taskRatingSubmission );
            $('#hrm').on( 'click', '.hrm-task-wrap .hrm-delete-task', this.deleteTask );
            $('#hrm').on( 'click', '#hrm-file .hrm-file-edit', this.editFile );
            $('#hrm').on( 'click', '.hrm-pagination a', this.pagination );
            $('#hrm').on( 'change', '#hrm-pagination', this.viewPagination );
            $('#hrm').on( 'submit', '#hrm-search-form', this.search );

            $('#hrm').on( 'before_send_edit', function( e, self, data ) {
                if ( self.data('action') == 'get_role' ) {

                    data.role_name = self.data('role_name');
                    data.display_name = self.data('display_name');

                }

                if ( self.data('action') == 'sub_task_edit'  ) {
                    data.project_id = self.data('project_id');
                }
            });

            $('#hrm').on( 'before_send_getInsertDataForm', function( e, self, data ) {

                if ( self.data('task') == 'task'  ) {
                    data.function_name = 'task_form';
                    data.project_id = self.data('project_id');
                }

                if ( self.data('sub_task') == 'sub_task'  ) {
                    data.function_name = 'sub_task_form';
                    data.task_id = self.data('task_id');
                    data.project_id = self.data('project_id');
                }

                if ( typeof hrm_dataAttr.project_id !== 'undefined' ) {
                    data.project_id = hrm_dataAttr.project_id;
                }

                if ( typeof hrm_dataAttr.task_id !== 'undefined' ) {
                    data.task_id = hrm_dataAttr.task_id;
                }

            });

            $('#hrm').on('after_add', function( e, self, res ) {
                if ( res.data.task_create_status === true ) {
                    hrm_dataAttr.add_form_generator_action = 'add_form';
                    hrm_dataAttr.add_form_apppend_wrap = 'hrm-projects';
                    hrm_dataAttr.class_name = 'Hrm_Admin';
                    hrm_dataAttr.function_name = 'task_form';
                    hrm_dataAttr.project_id = res.data.project_id;
                    hrm_dataAttr.redirect = hrm_dataAttr.redirect;

                    hrmGeneral.getInsertDataForm(e);

                    return false;
                }

                if ( res.data.sub_task_create_status === true ) {
                    hrm_dataAttr = {
                        add_form_generator_action : 'add_form',
                        add_form_apppend_wrap : 'hrm-projects',
                        class_name : 'Hrm_Admin',
                        function_name : 'sub_task_form',
                        task_id : res.data.task_id,
                    };

                    hrmGeneral.getInsertDataForm(e);

                    return false;
                }

                return true;

            });

            $('#hrm').on( 'before_send_insert_data', function( e, form, data ) {
                if ( hrm_dataAttr.class_name == 'HRM_File' && hrm_dataAttr.function_name == 'file_upload_form' ) {
                    data = form.serialize()+'&'+$.param(hrm_dataAttr);
                }
            });

            $('#hrm').on( 'after_getInsertDataForm', function( e, self, res ) {

                hrmGeneral.datePicker();
                hrmGeneral.datePickerRestricted();

                if ( res.data['append_data']['project_autocomplete'] === true ) {
                    hrmGeneral.project();
                }

                if ( res.data['append_data']['admin_list_autocomplete'] === true ) {
                    hrmGeneral.autocomplete();
                }

                if ( hrm_dataAttr.class_name == 'hrm_Leave' && hrm_dataAttr.function_name == 'assign' ) {
                    hrmGeneral.chosen();
                    hrmGeneral.datePickerLeaveRestricted();
                }

                if ( hrm_dataAttr.class_name == 'HRM_File' && hrm_dataAttr.function_name == 'file_upload_form' ) {
                    hrmGeneral.chosen();
                    //hrmGeneral.tinymceInit(res.data.tinymce_id);
                }

                if ( res.data.append_data.personal_salary ) {
                    hrmGeneral.directDepositHandelar();
                    $('#hrm_personal_salary').on( 'change', '.hrm-direct-deposit-handelar', hrmGeneral.directDepositHandelar );
                }
            });

            $('#hrm').on( 'after_success_edit', function( e, self, res ) {

                hrmGeneral.datePicker();
                hrmGeneral.datePickerRestricted();

                if ( res.data['append_data']['project_autocomplete'] === true ) {
                    hrmGeneral.project();
                }

                if ( hrm_dataAttr.class_name == 'hrm_Leave' && hrm_dataAttr.function_name == 'assign' ) {
                    hrmGeneral.chosen();
                    hrmGeneral.datePickerLeaveRestricted();
                }

            });
        },

        search: function(e) {
            e.preventDefault();
            var form = $(this),
                btn = form.find('.hrm-spinner'),
                limit = $('#hrm-pagination').val(),
                limit = ( typeof limit !== 'undefined' ) ? limit : 0,
                data = form.serialize()+'&'+$.param(hrm_dataAttr)+'&limit='+limit;

            var validate = hrmGeneral.formValidation( form );
            if( ! validate ) {
                return false;
            }
            btn.show();
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                btn.hide();
                if( res.success ) {
                    if ( typeof hrm_dataAttr.subtab !== 'undefined' && hrm_dataAttr.subtab ) {
                        $('#hrm-subtab-wrap').html( res.data.content );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    } else {
                        $('#hrm').html( res.data.content );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    }
                }
            });
        },

        viewPagination: function() {
            var self = $(this),
                limit = $('#hrm-pagination').val();
            if ( hrm_dataAttr.search_satus ) {
                var data = $('#hrm-search-form').serialize()+'&'+$.param(hrm_dataAttr)+'&limit='+limit;
            } else {
                var data = {
                    action: 'view_pagination',
                    _wpnonce: hrm_ajax_data._wpnonce,
                    hrm_attr: hrm_dataAttr,
                    limit: self.val(),
                };
            }
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if( res.success ) {
                    if ( typeof hrm_dataAttr.subtab !== 'undefined' && hrm_dataAttr.subtab ) {
                        $('#hrm-subtab-wrap').html( res.data.content );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    } else {
                        $('#hrm').html( res.data.content );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    }
                }
            });
        },

        pagination: function(e) {
            e.preventDefault();
            var self = $(this),
                url = self.attr('href'),
                limit = $('#hrm-pagination').val(),
                pagenum = hrmGetUrlParameter( url )['pagenum'];
            if ( hrm_dataAttr.search_satus ) {
                var data = $('#hrm-search-form').serialize()+'&'+$.param(hrm_dataAttr)+'&pagenum='+pagenum+'&limit='+limit;
            } else {
                var data = {
                    action: 'pagination',
                    pagenum: pagenum,
                    _wpnonce: hrm_ajax_data._wpnonce,
                    hrm_attr: hrm_dataAttr
                };
            }

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    if ( typeof hrm_dataAttr.subtab !== 'undefined' && hrm_dataAttr.subtab ) {
                        $('#hrm-subtab-wrap').html( res.data.content );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    } else {
                        $('#hrm').html( res.data.content );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    }
                }
            });

        },

        editFile: function(e) {
            e.preventDefault();
            var self = $(this),
                data = {
                    action: 'edit_file',
                    _wpnonce: hrm_ajax_data._wpnonce,
                    post_id: self.data('id'),
                };
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    $('#hrm-file-form-wrap').html( res.data.append_data )
                        .find('#hrm-hidden-form-warp').slideDown('slow').show();
                    hrmGeneral.chosen();
                    //hrmGeneral.tinymceInit(res.data.tinymce_id);


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
                }
            });
        },

        tinymceInit: function( id ) {

            tinymce.execCommand( 'mceRemoveEditor', true, id );
            tinymce.execCommand( 'mceAddEditor', true, id );
        },

        taskRatingSubmission: function(e) {
            e.preventDefault();
            if ( $('.hrm-datepicker').val() == '' ) {
                alert('Date field required');
                return;
            }
            var self = $(this),
                wrap = self.closest('.hrm-task-wrap'),
                data = self.serialize();
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if( res.success ) {
                    self.attr( 'value', res.data.btn_text );
                    wrap.find('.hrm-post_id').val(res.data.post_id);
                    alert( hrm_ajax_data.success_msg );
                }
            });
        },

        deleteTask: function() {
            if( !confirm( hrm_ajax_data.confirm_msg) ) {
                return;
            }
            var self = $(this),
                data = {
                    action: 'delete_task',
                    _wpnonce: hrm_ajax_data._wpnonce,
                    project_id: self.data('project_id'),
                    task_id : self.data('task_id'),
                    assing_to: self.data('task_assign')
                };
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    self.closest('.hrm-task-wrap').fadeOut(1000);
                }
            });
        },

        userTaskRating: function() {
            var self = $(this),
                data = {
                    action: 'user_task_rating_content',
                    _wpnonce: hrm_ajax_data._wpnonce,
                    project_id: self.data('project_id'),
                    user_id : self.val(),
                }
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    $('.hrm-evaluation-task-wrap').html(res.data.append_data);
                    $.each( res.data.slider_value, function( key, slider_obj ) {
                        hrmGeneral.sliderWithInitialValue( slider_obj.id, slider_obj.value, res.data.max );
                    });
                    //hrmGeneral.slider(res.data.max);
                    $.each( res.data.tasks_id, function( key, id ) {
                        hrmGeneral.datePickerMultiple( 'hrm-datepicker-' + id );
                    });

                    hrmGeneral.datePicker();
                }
            });
        },

        sliderWithInitialValue: function( id, val, max  ) {
            val = typeof val !== 'undefined' ? val : 0;
            max = typeof max !== 'undefined' ? max : '100';
            $('#hrm-rating-slider-'+id).slider({
                value: parseFloat(val),
                min: 0,
                max: parseFloat(max),
                step: parseFloat('1'),
                slide: function( event, ui ) {
                    var self = $(this);
                    self.closest('li').find(".hrm-slider-field").val( ui.value );
                    self.closest('li').find(".hrm-task-rating-value").text( ui.value )
                }
            });
        },

        slider: function( max ) {
            max = typeof max !== 'undefined' ? max : 100;
            $( ".hrm-slider-range-max" ).slider({
                min: 0,
                max: parseFloat(max),
                step: parseFloat('1'),
                slide: function( event, ui ) {
                    var self = $(this);
                    self.closest('li').find(".hrm-slider-field").val( ui.value );
                }
            });
        },

        editAttendance: function(e) {
            e.preventDefault();
            var self = $(this),
            data = {
                action: 'edit_attendance',
                _wpnonce: hrm_ajax_data._wpnonce,
                post_id: self.data('post_id'),
                hrm_dataAttr : hrm_dataAttr,
            }

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    $('#hrm-attendance').html( res.data.content )
                        .find('#hrm-hidden-form-warp').slideDown('slow').show();
                    hrmGeneral.datePicker();
                    hrmGeneral.timePicker();
                }
            });

        },

        changeAdminStatus: function(e) {
            e.preventDefault();
            if ( !confirm( hrm_ajax_data.confirm_msg ) ) {
                return;
            }

            var self = $(this),
                data = {
                    action: 'change_admin_status',
                    _wpnonce: hrm_ajax_data._wpnonce,
                    status: self.val(),
                    user_id: self.data('user_id')
                }
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    alert( hrm_ajax_data.success_msg );
                }
            });
        },

        showTaskDesc: function(e) {
            e.preventDefault();
            var self = $(this),
                task_id = self.data('task_id');
                open_dialog_wrap = 'hrm-task-desc-wrap-'+task_id;

            $( '#'+open_dialog_wrap ).dialog( "open" );

        },

        depositStatus: function(e) {
            e.preventDefault();
            var self = $(this),
                self_id = self.data('id'),
                open_dialog_wrap = 'hrm-deposit-wrap-'+self_id;

            $( '.'+open_dialog_wrap ).dialog( "open" );
        },

        directDepositHandelar: function() {

            var self = $('.hrm-direct-deposit-handelar');

            if ( self.is(':checked') ) {
                self.closest('form')
                    .find('.hrm-direct-deposit-part')
                    .closest('.hrm-form-field')
                    .show();
            } else {
                self.closest('form')
                    .find('.hrm-direct-deposit-part')
                    .closest('.hrm-form-field')
                    .hide();
            }

        },

        taskComplete: function() {
            var self = $(this),
                data = {
                    action: 'tast_complete',
                    _wpnonce: hrm_ajax_data._wpnonce,
                    task_id: self.val(),
                }
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    self.closest('div').remove();
                }
            });
        },

        taskInComplete: function() {
            var self = $(this),
                data = {
                    action: 'tast_incomplete',
                    _wpnonce: hrm_ajax_data._wpnonce,
                    task_id: self.val(),
                }
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    self.closest('div').remove();
                }
            });
        },

        leaveStatusChange: function() {

            var self = $(this),
                data = {
                    action: 'change_leave_status',
                    _wpnonce: hrm_ajax_data._wpnonce,
                    status: self.val(),
                    leave_id: self.data('leave_id')
                }
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    $('.hrm-error-notification')
                        .removeClass('error')
                        .addClass('updated')
                        .html( '<p><strong>'+ res.data.msg+'</strong></p>' );
                } else {
                    $('.hrm-error-notification')
                        .addClass('updated error')
                        .html( '<p><strong>'+res.data.msg+'<strong></p>' );
                }
            });
        },

        removeUserMeta: function(e) {
            e.preventDefault();
            var self = $(this);
            if( confirm(hrm_ajax_data.confirm_msg) ) {
                self.closest('.select-field').remove();
            }
        },

        getInsertDataForm: function(e) {
            e.preventDefault();
            var self = $(this);
            var data = {
                action : hrm_dataAttr.add_form_generator_action,
                _wpnonce : hrm_ajax_data._wpnonce,
                class_name : hrm_dataAttr.class_name,
                function_name : hrm_dataAttr.function_name,
                hrm_dataAttr : hrm_dataAttr
            }

            $('#hrm').trigger( 'before_send_getInsertDataForm', [self, data] );

            self.addClass('hrm-spinner');

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                self.removeClass('hrm-spinner');
                var form_wrap = $('#'+hrm_dataAttr.add_form_apppend_wrap);
                if( res.success ) {
                    form_wrap.html( res.data['append_data']['append_data'] );
                    var hidden_form = form_wrap.find( '#hrm-hidden-form-warp');

                    hidden_form.slideDown('slow');

                    $('#hrm').trigger( 'after_getInsertDataForm', [self, res] );

                }
            });

        },

        project: function() {
            $('.hrm-project-autocomplete').autocomplete({

                minLength: 3,
                source: function( request, response, extra) {
                    var self = $(this.element);
                    var data = {
                        action: self.data('action'),
                        search_admin: request.term,
                        _wpnonce : hrm_ajax_data._wpnonce,
                    };

                    $.post( hrm_ajax_data.ajax_url, data, function( resp ) {
                        self.removeClass( 'ui-autocomplete-loading' );
                        if( resp.success ) {
                            response( eval( resp.data ) );
                        } else {
                            response( '' );
                        }

                    });
                },

                select: function( el, val ) {
                    var user_meta = val.item._user_meta['append_data'],
                        self = $(this);
                    self.closest('div').append(user_meta);
                    self.val('');
                    return false;
                },

            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {

                    return $( "<li>" )
                            .append( "<a>" + item.label + "</a>" )
                            .appendTo( ul );
            };
        },

        userCreate: function(e) {
            e.preventDefault();
            var self = $(this),
                spinner = self.find('input[type=submit]').siblings('span');

            spinner.addClass('hrm-spinner');
            if( self.attr('disabled') == 'disabled' ) {
                return false;
            }
            self.attr('disabled', true );

            var data = {
                    action: 'user_create',
                    data: self.serialize(),
                };

            $.post( hrm_ajax_data.ajax_url, data, function( resp ) {

                self.attr('disabled', false );
                spinner.removeClass('hrm-spinner');

                if( resp.success ) {
                    var dialog = $( "#hrm-create-user-wrap" );
                    hrmGeneral.closeDialog(dialog);

                    $('#hrm-hidden-form').find('#hrm-form-field').append( resp.data._user_meta );

                    $( "form.hrm-user-create-form input[type=text], input[type=email]" ).val('');
                } else {
                    $('.hrm-error').html(resp.data);
                }
            });

            return false;

        },

        openDialog: function(selector ) {
            selector.dialog( "open" );
        },

        closeDialog: function(selector) {
            selector.dialog( "close" );
        },

        singleFormAdd: function(e) {

            e.preventDefault();
            var form = $(this),
                data = form.serialize(),
                submit_button = form.find('input[type=submit]');

            var validate = hrmGeneral.formValidation( form );
            if( ! validate ) {
                return false;
            }

            form.find('.hrm-spinner').show();
            submit_button.attr('disabled', true );

            $.post( hrm_ajax_data.ajax_url, data, function(res) {

                hrmGeneral.scrollTop();
                form.find('.hrm-spinner').hide();
                submit_button.attr('disabled', false );

                if( res.success ) {
                    hrmGeneral.scrollTop( '.hrm-update-notification' );
                    hrmGeneral.updateNotification( res.data.success_msg );
                } else {
                    hrmGeneral.scrollTop( '.hrm-update-notification' );
                    hrmGeneral.errorNotification( res.data.error_msg );
                }
            });
        },

        formValidation: function( form ) {
            var required = form.find('[data-hrm_validation="1"]'),
                validate = true,
                scroll_selector = [];

            form.find('.hrm-notification').remove();

            $.each( required, function( key, field ) {
                var self = $(field),
                    field_wrap = self.closest('.hrm-form-field'),
                    has_dependency = self.data('hrm_dependency');

                if ( has_dependency ) {
                    var dependency_handelar = form.find('[data-'+has_dependency+']'),
                        dependency_handelar_val = dependency_handelar.data(has_dependency);

                    if( dependency_handelar_val == 'checked' ) {
                        if ( !$(dependency_handelar).is(':checked') ) {
                            return;
                        }
                    }
                }

                if( self.data('hrm_required') && ( self.val() === '' || self.val() === null ) ) {

                    validate = false;
                    field_wrap.find('.hrm-notification').remove();
                    field_wrap.append('<div class="hrm-notification">'+self.data('hrm_required_error_msg')+'</div>');
                    scroll_selector.push(self);
                }

                if ( validate && self.data('hrm_email') ) {
                    validate = hrmGeneral.validateEmail( self.val() );
                    if ( validate === false ) {
                        field_wrap.find('.hrm-notification').remove();
                        field_wrap.append('<div class="hrm-notification">'+self.data('hrm_email_error_msg')+'</div>');
                        scroll_selector.push(self);
                    }
                }
            });

            if( ! validate ) {
                $('body,html').animate({scrollTop: scroll_selector[0].offset().top - 100});
            }

            return validate;
        },

        validateEmail: function($email) {

            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if( !emailReg.test( $email ) ) {
                return false;
            } else {
                return true;
            }
        },

        scrollTop: function( wrap ) {
            if ( typeof wrap !== 'undefined' ) {
                var top = $(wrap).position().top;
            } else {
                var top = 0;
            }
            $('body,html').animate({
                scrollTop: top
            }, 800);
        },

        errorNotification: function( message ) {
            var message = ( typeof message !== 'undefined' ) ? message : '';
            $('.hrm-update-notification')
                .addClass('error')
                .html( '<p class="hrm-error"><strong>'+message+'<strong></p>' );
            setTimeout(function() {
                $('.hrm-update-notification').removeClass('error').html('');
            }, 5000);
        },

        updateNotification: function( message ) {
            var message = ( typeof message !== 'undefined' ) ? message : '',
                notification_wrap = $('.hrm-update-notification');
            notification_wrap
                .addClass('updated')
                .removeClass('error')
                .html( '<p class="hrm-update"><strong>'+message+'<strong></p>' );
            setTimeout(function() {
                notification_wrap.removeClass('updated').html('');
            }, 5000);
        },

        formshowHide: function(e) {
            e.preventDefault();
            $(this).closest('#hrm-hidden-form-warp').slideUp('slow').remove('slow');

        },

        add: function(e) {
            e.preventDefault();
            var form = $(this),
            spinner = form.find('.hrm-spinner'),
            submit = form.find('.hrm-submit-button'),
            data = form.serialize()+'&'+$.param(hrm_dataAttr);

            $('#hrm').trigger( 'before_send_insert_data', [form, data] );

            var validate = hrmGeneral.formValidation( form );
            if( ! validate ) {
                return false;
            }

            spinner.show();
            submit.attr( 'disabled', true );

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                hrmGeneral.scrollTop();
                spinner.hide();
                submit.attr( 'disabled', false );

                form.find('#hrm-form-field').find('input[type=text], select, textarea').val('');

                if( res.success ) {

                    $('#hrm').trigger('after_add', [form, res] );

                    if ( typeof res.data.dataBreak !== 'undefined' && res.data.dataBreak ) {
                        return;
                    }

                    if ( typeof hrm_dataAttr.subtab !== 'undefined' && hrm_dataAttr.subtab ) {
                        $('#hrm-subtab-wrap').html( res.data.content );
                        hrmGeneral.scrollTop( '.hrm-update-notification' );
                        hrmGeneral.updateNotification( res.data.success_msg );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    } else {
                        $('#hrm').html( res.data.content );
                        hrmGeneral.scrollTop( '.hrm-update-notification' );
                        hrmGeneral.updateNotification( res.data.success_msg );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    }
                } else {
                    hrmGeneral.scrollTop( '.hrm-update-notification' );
                    hrmGeneral.errorNotification( res.data.error_msg );
                }
            });
        },

        delete: function(e) {
            e.preventDefault();
            var form = $('#hrm-list-form'),
                btn  = form.find('.hrm-delete-button'),
                data = form.serialize()+'&'+$.param(hrm_dataAttr);

            btn.addClass('hrm-spinner');

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                btn.removeClass('hrm-spinner');
                if ( res.success ) {
                    if ( typeof hrm_dataAttr.subtab !== 'undefined' && hrm_dataAttr.subtab ) {
                        $('#hrm-subtab-wrap').html( res.data.content );
                        hrmGeneral.scrollTop( '.hrm-update-notification' );
                        hrmGeneral.updateNotification( res.data.success_msg );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    } else {
                        $('#hrm').html( res.data.content );
                        hrmGeneral.scrollTop( '.hrm-update-notification' );
                        hrmGeneral.updateNotification( res.data.success_msg );
                        hrmGeneral.chosen();
                        hrmGeneral.datePicker();
                        hrmGeneral.datePickerRestricted();
                    }
                } else {
                    hrmGeneral.scrollTop( '.hrm-update-notification' );
                    hrmGeneral.errorNotification( res.data.error_msg );
                }
            });
        },

        edit: function(e) {
            e.preventDefault();
            var self = $(this),
                data = {
                    action : ( typeof self.data('action') !== 'undefined' ) ? self.data('action') : 'hrm_form_edit',
                    _wpnonce : hrm_ajax_data._wpnonce,
                    id : self.data('id'),
                    table_option : self.data('table_option'),
                    class_name : hrm_dataAttr.class_name,
                    function_name : hrm_dataAttr.function_name,
                    hrm_dataAttr : hrm_dataAttr,
                    selfData : self.data(),
                }

            $('#hrm').trigger( 'before_send_edit', [self, data] );

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                var form_wrap = $('#'+hrm_dataAttr.add_form_apppend_wrap);
                if( res.success ) {
                    form_wrap.html( res.data['append_data']['append_data'] );
                    var hidden_form = form_wrap.find( '#hrm-hidden-form-warp');
                    hidden_form.slideDown('slow');
                    $('#hrm').trigger( 'after_success_edit', [self, res] );
                }
            });
        },

        chosen: function() {

            $('#hrm .hrm-chosen').chosen().change(function(e, value) {
                hrmGeneral.getRatingTaskUser(value);
            });

        },

        getRatingTaskUser: function(value) {
            if ( ! $('.hrm-evaluation-task-wrap').length ) {
                return;
            }
            var data = {
                action: 'rating_task',
                _wpnonce : hrm_ajax_data._wpnonce,
                project_id : value.selected,
            };

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                if ( res.success ) {
                    var form = $('#hrm-search-form'),
                        user_exist = form.find('.hrm-task-rating-user');
                    if ( user_exist.length ) {
                        user_exist.remove();
                    }
                    form.find('.hrm-text-wrap').last().after(res.data.append_data);
                }
            });
        },

        autocomplete : function() {

            $('.admin-autocomplete').autocomplete({

                minLength: 3,
                source: function( request, response, extra) {
                    var self = $(this.element);
                    var data = {
                        action: self.data('action'),
                        search_admin: request.term,
                    };

                    $.post( hrm_ajax_data.ajax_url, data, function( resp ) {
                        self.removeClass( 'ui-autocomplete-loading' );
                        if( resp.success ) {
                            response( eval( resp.data ) );
                        } else {
                            response( '' );
                        }

                    });
                },

                select: function( el, val ) {
                    var id = val.item.id,
                        self = $(this);
                    if( val.item.value == 'hrm_create_user') {
                        val.item.value = '';
                        var dialog = $( "#hrm-create-user-wrap" );
                        hrmGeneral.openDialog( dialog );
                    } else {
                        $('#hrm-hidden-form').find('#hrm-form-field').append(val.item._user_meta);
                    }

                },

            }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {

                    return $( "<li>" )
                            .append( "<a>" + item.label + "</a>" )
                            .appendTo( ul );
            };



        },

        timePicker: function() {
            $(".hrm-timepicker").timepicker({
                timeFormat: "hh:mm:ss tt"
            });

        },

        datePicker: function() {
            $(".hrm-datepicker").datepicker({ dateFormat: "yy-mm-dd" });
        },

        datePickerMultiple: function(selector) {
            $("#"+selector).datepicker({ dateFormat: "yy-mm-dd" });
        },

        datePickerRestricted: function() {
             $( ".hrm-datepicker-from" ).datepicker({
                defaultDate: "+1w",
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                    $( ".hrm-datepicker-to" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( ".hrm-datepicker-to" ).datepicker({
                defaultDate: "+1w",
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                    $( ".hrm-datepicker-from" ).datepicker( "option", "maxDate", selectedDate );
                }
            });
        },

        datePickerLeaveRestricted: function() {
             $( ".hrm-datepicker-leave-from" ).datepicker({
                defaultDate: "+1w",
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                numberOfMonths: 1,
                minDate: new Date,
                onClose: function( selectedDate ) {
                    $( ".hrm-datepicker-leave-to" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( ".hrm-datepicker-leave-to" ).datepicker({
                defaultDate: "+1w",
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                    $( ".hrm-datepicker-leave-from" ).datepicker( "option", "maxDate", selectedDate );
                }
            });
        },
    }

    hrmGeneral.init();

    $( ".hrm-autocomplete" ).autocomplete({

        minLength: 3,
        source: function( request, response, extra) {
            var self = $(this.element);
            var data = {
                action: self.data('action'),
                search_value: request.term,
                table_option: self.data( 'table_option' ),
                search_field: self.data( 'search_field' ),
            };

            $.post( hrm_ajax_data.ajax_url, data, function( resp ) {
                self.removeClass( 'ui-autocomplete-loading' );
                if( resp.success ) {
                    response( eval( resp.data ) );
                } else {
                    response( '' );
                }

            });
        },

        select: function( el, val ) {
            var id = val.item.id,
                self = $(this);
            self.closest('form').find( 'input#hrm-hidden-field-id').val(id);
        },
    });


    function hrmGetUrlParameter( url ){
        var vars = [],
            hash = [];
        var hashes = url.slice( url.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }



})(jQuery);