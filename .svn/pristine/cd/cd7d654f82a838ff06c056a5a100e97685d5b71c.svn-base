
;(function($){
    var hrmGeneral = {
        init: function() {

            this.chosen();
            this.datePicker();


            $('.hrm-add-button').on( 'click', this.getInsertDataForm );
            $('body').on( 'click', '.hrm-form-cancel', this.formshowHide );
            $('body').on( 'submit', '#hrm-hidden-form', this.add );
            $('a.hrm-editable').on( 'click', this.edit );
            $('.hrm-delete-button').on( 'click', this.delete );
            $('#hrm-visible-form-warp').on( 'submit', '#hrm-visible-form', this.singleFormAdd );
            $('.hrm-user-create-form').on('submit', this.userCreate);
            $('body').on('click', '.hrm-delte-user-meta', this.removeUserMeta);
            $('body').on('change', '.hrm-leave-action', this.leaveStatusChange);
            $('.hrm-complete-task').on( 'click', this.taskComplete );
            $('.hrm-incomplete-task').on( 'click', this.taskInComplete );
            $('.hrm-personal').on( 'click', '.hrm-deposit-check', this.depositStatus );
            $('.hrm-task-desc').on( 'click', this.showTaskDesc );

            $('body').on( 'before_send_edit', function( e, self, data ) {
                if ( self.data('action') == 'get_role' ) {

                    data.role_name = self.data('role_name');
                    data.display_name = self.data('display_name');

                }

                if ( self.data('action') == 'sub_task_edit'  ) {
                    data.project_id = self.data('project_id');
                }
            });

            $('body').on( 'before_send_getInsertDataForm', function( e, self, data ) {

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

            $('body').on('after_add', function( e, self, res ) {
                if ( res.data.task_create_status === true ) {
                    hrm_dataAttr = {
                        add_form_generator_action : 'add_form',
                        add_form_apppend_wrap : 'hrm-projects',
                        class_name : 'hrm_Admin',
                        function_name : 'task_form',
                        project_id : res.data.project_id,
                        redirect: hrm_dataAttr.redirect,
                    };

                    hrmGeneral.getInsertDataForm(e);

                    return false;
                }

                if ( res.data.sub_task_create_status === true ) {
                    hrm_dataAttr = {
                        add_form_generator_action : 'add_form',
                        add_form_apppend_wrap : 'hrm-projects',
                        class_name : 'hrm_Admin',
                        function_name : 'sub_task_form',
                        task_id : res.data.task_id,
                    };

                    hrmGeneral.getInsertDataForm(e);

                    return false;
                }

                return true;

            });

            $('body').on( 'after_getInsertDataForm', function( e, self, res ) {

                hrmGeneral.datePicker();

                if ( res.data['append_data']['project_autocomplete'] === true ) {
                    hrmGeneral.project();
                }

                if ( res.data['append_data']['admin_list_autocomplete'] === true ) {
                    hrmGeneral.autocomplete();
                }

                if ( hrm_dataAttr.class_name == 'hrm_Leave' && hrm_dataAttr.function_name == 'assign' ) {
                    hrmGeneral.chosen();
                }

                if ( res.data.append_data.personal_salary ) {
                    hrmGeneral.directDepositHandelar();
                    $('#hrm_personal_salary').on( 'change', '.hrm-direct-deposit-handelar', hrmGeneral.directDepositHandelar );
                }


            });

            $('body').on( 'after_success_edit', function( e, self, res ) {

                hrmGeneral.datePicker();

                if ( res.data['append_data']['project_autocomplete'] === true ) {
                    hrmGeneral.project();
                }

                if ( hrm_dataAttr.class_name == 'hrm_Leave' && hrm_dataAttr.function_name == 'assign' ) {
                    hrmGeneral.chosen();
                }
            } )
        },

        showTaskDesc: function(e) {
            e.preventDefault();
            var self = $(this),
                task_id = self.data('task_id');
                open_dialog_wrap = 'hrm-task-desc-wrap-'+task_id;

            $( '.'+open_dialog_wrap ).dialog( "open" );
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

            $('body').trigger( 'before_send_getInsertDataForm', [self, data] );

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                var form_wrap = $('#'+hrm_dataAttr.add_form_apppend_wrap);
                if( res.success ) {
                    form_wrap.html( res.data['append_data']['append_data'] );
                    var hidden_form = form_wrap.find( '#hrm-hidden-form-warp');

                    hidden_form.slideDown('slow');

                    $('body').trigger( 'after_getInsertDataForm', [self, res] );

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
                    $('.hrm-error-notification')
                        .removeClass('error')
                        .addClass('updated')
                        .html( '<p><strong>'+ res.data.success_msg+'</strong></p>' );
                } else {
                    $('.hrm-error-notification')
                        .addClass('updated error')
                        .html( '<p><strong>'+res.data+'<strong></p>' );
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

        scrollTop: function() {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        },

        delete: function(e) {
            e.preventDefault();
            var form = $('#hrm-list-form');
            data = form.serialize() + '&redirect=' + hrm_dataAttr.redirect;

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                hrmGeneral.scrollTop();
                if( res.success ) {
                    $('.hrm-error-notification')
                        .removeClass('error')
                        .addClass('updated')
                        .html( '<p><strong>'+ res.data.msg+'</strong></p>' );
                    setTimeout(function() {
                        location.href = res.data.redirect;
                    }, 3000 );
                } else {
                    $('.hrm-error-notification')
                        .addClass('updated error')
                        .html( '<p><strong>'+res.data.msg+'<strong></p>' );
                }
            });
        },
        search: function(e) {
            e.preventDefault();
            var self = $(this),
                data = self.serialize();
            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                location.reload();
            });
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
            data = form.serialize(),
            redirect = form.find('input[name=url]').val();

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
                    $('.hrm-error-notification')
                        .removeClass('error')
                        .addClass('updated')
                        .html( '<p><strong>'+ res.data.success_msg+'</strong></p>' );

                    $('body').trigger('after_add', [form, res] );

                    setTimeout(function() {
                        if ( redirect.length > 0 ) {
                            location.href = redirect;
                        }

                    }, 3000 );


                } else {
                    $('.hrm-error-notification')
                        .addClass('updated error')
                        .html( '<p><strong>'+res.data.error_msg+'<strong></p>' );
                    $('#hrm-hidden-form-warp').remove();
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

            $('body').trigger( 'before_send_edit', [self, data] );

            $.post( hrm_ajax_data.ajax_url, data, function( res ) {
                var form_wrap = $('#'+hrm_dataAttr.add_form_apppend_wrap);
                if( res.success ) {
                    form_wrap.html( res.data['append_data']['append_data'] );
                    var hidden_form = form_wrap.find( '#hrm-hidden-form-warp');
                    hidden_form.slideDown('slow');
                    $('body').trigger( 'after_success_edit', [self, res] );
                }
            });
        },

        chosen: function() {

            $('.hrm-chosen').chosen();
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

        datePicker: function() {
            $(".hrm-datepicker").datepicker({ dateFormat: "yy-mm-dd" });
        }
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
        }
    });



})(jQuery);