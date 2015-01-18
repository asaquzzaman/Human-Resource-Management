<?php
class Hrm_Settings {
	private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new hrm_Settings();
        }

        return self::$_instance;
    }

    function get_emp_meta( $id, $key, $status = true ) {
        return get_user_meta( $id, $key, $status );
    }

    function get_current_page_url( $page, $tab, $subtab ) {
        $url = add_query_arg( array( 'page' => $page, 'tab' => $tab, 'sub_tab' => $subtab ), admin_url('admin.php') );

        return apply_filters( 'hrm_redirect_url', $url, $page, $tab, $subtab );
    }

    function show_tab_page( $page, $tab, $subtab, $nested_tab = '' ) {
        if ( !$tab ) {
            _e( 'Missing Tab Page!', 'hrm' );
            return;
        }

        $menu = hrm_page();
        $tab = empty( $nested_tab ) ? $tab : $nested_tab;

        if ( ! hrm_user_can_access( $tab, null, 'view' ) ) {
            printf( '<h1>%s</h1>', __( 'You do not have permission to access this page', 'cpm' ) );
            return false;
        }

        $path = isset( $menu[$page][$tab]['file_path'] ) ? $menu[$page][$tab]['file_path'] : '';

        if( file_exists( $path ) ) {
            require_once $path;
        } else {
            _e('Page not found', 'hrm' );
        }

    }


    function show_sub_tab_page( $page, $tab, $subtab ) {

        $menu = hrm_page();
        if( !isset( $menu[$page][$tab]['submenu'] ) ) {
            return;
        }

        if( empty( $menu[$page][$tab]['submenu'] ) && count( $menu[$page][$tab]['submenu'] ) ) {

            $subtab = key( $menu[$page][$tab]['submenu'] );

            if ( ! hrm_user_can_access( $tab, $subtab, 'view' ) ) {
                printf( '<h1>%s</h1>', __( 'You do not have permission to access this page', 'cpm' ) );
                return false;
            }

            $path = isset( $menu[$page][$tab]['submenu'][$subtab]['file_path'] ) ? $menu[$page][$tab]['submenu'][$subtab]['file_path'] : '';
            $path = apply_filters( 'hrm_subtab_path', $path, $page, $tab, $subtab );

            if( file_exists( $path ) ) {
                require_once $path;
            } else {
                echo 'Page not found';
            }
        } else {

            if ( ! hrm_user_can_access( $tab, $subtab, 'view' ) ) {
                printf( '<h1>%s</h1>', __( 'You do not have permission to access this page', 'cpm' ) );
                return;
            }

            $path = isset( $menu[$page][$tab]['submenu'][$subtab]['file_path'] ) ? $menu[$page][$tab]['submenu'][$subtab]['file_path'] : '';

            $path = apply_filters( 'hrm_subtab_path', $path, $page, $tab, $subtab );

            if( file_exists( $path ) ) {
                require_once $path;
            } else {
                echo 'Page not found';
            }
        }
    }

	function select_field( $name, $element ) {

        $extra_field = '';
        $id          = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $class       = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $disabled    = isset( $element['disabled'] ) ? esc_attr( $element['disabled'] ) : '';
        $extra       = isset( $element['extra'] ) ? $element['extra'] : array();
        $label       = isset( $element['label'] ) ? $element['label'] : '';
        $option      = isset( $element['option'] ) ? $element['option'] : array();
        $selected    = isset( $element['selected'] ) ? $element['selected'] : '';
        $desc        = isset( $element['desc'] ) ? $element['desc'] : '';
        $required    = ( isset( $extra['data-hrm_required'] ) &&  ( $extra['data-hrm_required'] === true ) ) ? '*' : '';
        $wrap_class  = isset( $element['wrap_class'] ) ? $element['wrap_class'] : '';
        $wrap_tag    = isset( $element['wrap_tag'] ) ? $element['wrap_tag'] : 'div';

        if( is_array( $extra ) && count( $extra ) ) {
            foreach( $extra as $key => $action ) {
                $extra_field .= esc_attr( $key ) .'="'. esc_attr( $action ).'" ';
            }
        }

        $html = sprintf( '<label for="%1s">%2s<em>%3s</em></label>', $id, $label, $required );
        $html .= sprintf( '<select class="%1$s" name="%2$s" id="%3$s" %4$s %5$s>', $class, $name, $id, $disabled, $extra_field );

        foreach ( $option as $key => $label ) {
            $html .= sprintf( '<option value="%1$s" %2$s >%3$s</option>', esc_attr( $key ), selected( $selected, $key, false ), esc_attr( $label ) );
        }

        $html .= sprintf( '</select>' );
        $html .= sprintf( '<span class="hrm-clear"></span><span class="description"> %s</span>', $desc );

        $wrap       = sprintf( '<%1$s class="hrm-form-field %2$s">', $wrap_tag, $wrap_class );
        $wrap_close = sprintf('</%1$s>', $wrap_tag);

        ob_start();
           	echo $this->multiple_field_inside_this_wrap( $element );
                echo $wrap;
                echo $html;
                echo $wrap_close;
            echo $this->multiple_field_inside_this_wrap_close( $element );

        return ob_get_clean();
    }

    function multiple_select_field( $name, $element ) {

        $extra_field = '';
        $id          = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $class       = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $disabled    = isset( $element['disabled'] ) ? esc_attr( $element['disabled'] ) : '';
        $extra       = isset( $element['extra'] ) ? $element['extra'] : array();
        $label       = isset( $element['label'] ) ? $element['label'] : '';
        $option      = isset( $element['option'] ) ? $element['option'] : array();
        $selected    = isset( $element['selected'] ) ? $element['selected'] : '';
        $desc        = isset( $element['desc'] ) ? $element['desc'] : '';
        $required    = ( isset( $extra['data-hrm_required'] ) &&  ( $extra['data-hrm_required'] === true ) ) ? '*' : '';
        $wrap_class  = isset( $element['wrap_class'] ) ? $element['wrap_class'] : '';
        $wrap_tag    = isset( $element['wrap_tag'] ) ? $element['wrap_tag'] : 'div';

        if( is_array( $extra ) && count( $extra ) ) {
            foreach( $extra as $key => $action ) {
                $extra_field .= esc_attr( $key ) .'="'. esc_attr( $action ).'" ';
            }
        }

        $html = sprintf( '<label for="%1s">%2s<em>%3s</em></label>', $id, $label, $required );
        $html .= sprintf( '<select multiple class="%1$s" name="%2$s" id="%3$s" %4$s %5$s>', $class, $name, $id, $disabled, $extra_field );

        foreach ( $option as $key => $label ) {
            $html .= sprintf( '<option value="%1$s" %2$s >%3$s</option>', esc_attr( $key ), selected( $selected, $key, false ), esc_attr( $label ) );
        }

        $html .= sprintf( '</select>' );
        $html .= sprintf( '<span class="hrm-clear"></span><span class="description"> %s</span>', $desc );

        $wrap       = sprintf( '<%1$s class="hrm-form-field %2$s">', $wrap_tag, $wrap_class );
        $wrap_close = sprintf('</%1$s>', $wrap_tag);

        ob_start();
            echo $this->multiple_field_inside_this_wrap( $element );
                echo $wrap;
                echo $html;
                echo $wrap_close;
            echo $this->multiple_field_inside_this_wrap_close( $element );

        return ob_get_clean();
    }

    function text_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $extra_field = '';
        $id          = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $class       = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $disabled    = isset( $element['disabled'] ) ? esc_attr( $element['disabled'] ) : '';
        $extra       = isset( $element['extra'] ) ? $element['extra'] : array();
        $label       = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $desc        = isset( $element['desc'] ) ? esc_attr( $element['desc'] ) : '';
        $value       = isset( $element['value'] ) ? esc_attr( $element['value'] ) : '';
        $placeholder = isset( $element['placeholder'] ) ? esc_attr( $element['placeholder'] ) : '';
        $required    = ( isset( $extra['data-hrm_required'] ) &&  ( $extra['data-hrm_required'] === true ) ) ? '*' : '';
        $wrap_class  = isset( $element['wrap_class'] ) ? $element['wrap_class'] : '';
        $wrap_tag    = isset( $element['wrap_tag'] ) ? $element['wrap_tag'] : 'div';

        if( is_array( $extra ) && count( $extra ) ) {
            foreach( $extra as $key => $action ) {
                $extra_field .= esc_attr( $key ) .'="'. esc_attr( $action ) . '" ';
            }
        }

        ob_start();
            //do_action( 'text_field_before_input', $name, $element );
        $input_before = ob_get_clean();

        $html = sprintf( '<label for="%1s">%2s<em>%3s</em></label>', $id, $label, $required );
        $html .= $input_before;
        $html .= sprintf( '<input type="text" name="%1$s" value="%2$s" placeholder="%3$s" class="%4$s" id="%5$s" %6$s %7$s />', $name,
            $value, $placeholder, $class, $id, $disabled, $extra_field );
        $html .= sprintf( '<span class="hrm-clear"></span><span class="description">%s</span>', $desc );

        $wrap       = sprintf( '<%1$s class="hrm-form-field %2$s">', $wrap_tag, $wrap_class );
        $wrap_close = sprintf('</%1$s>', $wrap_tag);

        ob_start();
            echo $this->multiple_field_inside_this_wrap( $element );
                echo $wrap;
                echo $html;
                echo $wrap_close;
            echo $this->multiple_field_inside_this_wrap_close( $element );
        return ob_get_clean();
    }

    function hidden_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $extra_field = '';
        $id    = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $class = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $extra = isset( $element['extra'] ) ? $element['extra'] : array();
        $value = isset( $element['value'] ) ? esc_attr( $element['value'] ) : '';

        if( is_array( $extra ) && count( $extra ) ) {
            foreach( $extra as $key => $action ) {
                $extra_field .= esc_attr( $key ) .'='. esc_attr( $action ) . ' ';
            }
        }


        $html = sprintf( '<input type="hidden" name="%1$s" value="%2$s" class="%3$s" id="%4$s" %5$s />', $name,
            $value, $class, $id, $extra_field );

        ob_start();
            echo '<div>';
            echo $html;
            echo '</div>';
        return ob_get_clean();
    }

    function radio_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $required   = ( isset( $element['required'] ) &&  ( $element['required'] == 'required' ) ) ? '*' : '';
        $label      = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $html       = sprintf( '<label for="">%1$s<em>%2$s</em></label>', $label, $required );
        $wrap_class = isset( $element['wrap_class'] ) ? $element['wrap_class'] : '';
        $wrap_tag   = isset( $element['wrap_tag'] ) ? $element['wrap_tag'] : 'div';

        $fields = isset( $element['fields'] ) ? $element['fields'] : array();

        $html .= '<span class="hrm-radio-wrap">';
        foreach( $fields as $field ) {
            $extra_attr = '';
            $value      = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
            $id         = isset( $field['id'] ) ? esc_attr( $field['id'] ) : 'hrm_' .$name .'_'. $value;
            $class      = isset( $field['class'] ) ? esc_attr( $field['class'] ) : esc_attr( $name );
            $disabled   = isset( $field['disabled'] ) ? esc_attr( $field['disabled'] ) : '';
            $extra      = isset( $field['extra'] ) ? $field['extra'] : array();
            $label      = isset( $field['label'] ) ? esc_attr( $field['label'] ) : '';
            $checked    = isset( $field['checked'] ) ? esc_attr( $field['checked'] ) : '';

            if( is_array( $extra ) && count( $extra ) ) {
                foreach( $extra as $key => $action ) {
                    $extra_attr .= esc_attr( $key ) .'='. esc_attr( $action ) . ' ';
                }
            }

            $html .= sprintf( '<input type="radio" name="%1$s" value="%2$s" class="%3$s" id="%4$s" %5$s %6$s %7$s />', $name, $value, $class, $id, $disabled, $extra_attr, checked( $value, $checked, false ) );
            $html .= sprintf( '<label class="hrm-radio" for="%1s">%2s</label>', $id, $label );

        }

        $html .= '</span>';

        $desc = isset( $element['desc'] ) ? esc_attr( $element['desc'] ) : '';
        $html .= sprintf( '<span class="hrm-clear"></span><span class="description">%s</span>', $desc );
        $wrap       = sprintf( '<%1$s class="hrm-form-field %2$s">', $wrap_tag, $wrap_class );
        $wrap_close = sprintf('</%1$s>', $wrap_tag);

        ob_start();
            echo $this->multiple_field_inside_this_wrap( $element );
                echo $wrap;
                echo $html;
                echo $wrap_close;
            echo $this->multiple_field_inside_this_wrap_close( $element );

        return ob_get_clean();
    }

    function checkbox_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $required   = ( isset( $element['required'] ) &&  ( $element['required'] == 'required' ) ) ? '*' : '';
        $wrap_class = isset( $element['wrap_class'] ) ? $element['wrap_class'] : '';
        $wrap_tag   = isset( $element['wrap_tag'] ) ? $element['wrap_tag'] : 'div';
        $label      = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $html       = sprintf( '<label for="">%1$s<em>%2$s</em></label>', $label, $required );
        $fields     = isset( $element['fields'] ) ? $element['fields'] : array();

        $html .= '<span class="hrm-checkbox-wrap">';

        foreach( $fields as $field ) {
            $extra_attr = '';
            $value      = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '';
            $id         = isset( $field['id'] ) ? esc_attr( $field['id'] ) : 'hrm_' .$name .'_'. $value;
            $class      = isset( $field['class'] ) ? esc_attr( $field['class'] ) : esc_attr( $name );
            $disabled   = isset( $field['disabled'] ) ? esc_attr( $field['disabled'] ) : '';
            $extra      = isset( $field['extra'] ) ? $field['extra'] : array();
            $label      = isset( $field['label'] ) ? esc_attr( $field['label'] ) : '';
            $checked    = isset( $field['checked'] ) ? esc_attr( $field['checked'] ) : '';

            if( is_array( $extra ) && count( $extra ) ) {
                foreach( $extra as $key => $action ) {
                    $extra_attr .= esc_attr( $key ) .'='. esc_attr( $action ) . ' ';
                }
            }

            $html .= sprintf( '<input type="checkbox" name="%1$s" value="%2$s" class="%3$s" id="%4$s" %5$s %6$s %7$s />', $name, $value, $class, $id, $disabled, $extra_attr, checked( $checked, $value, false ) );
            $html .= sprintf( '<label class="hrm-checkbox" for="%1s">%2s</label>', $id, $label );

        }

        $html .= '</span>';

        $desc       = isset( $element['desc'] ) ? esc_attr( $element['desc'] ) : '';
        $html       .= sprintf( '<span class="hrm-clear"></span><span class="description">%s</span>', $desc );
        $wrap       = sprintf( '<%1$s class="hrm-form-field %2$s">', $wrap_tag, $wrap_class );
        $wrap_close = sprintf('</%1$s>', $wrap_tag);

        ob_start();
            echo $this->multiple_field_inside_this_wrap( $element );
                echo $wrap;
                echo $html;
                echo $wrap_close;
            echo $this->multiple_field_inside_this_wrap_close( $element );
        return ob_get_clean();
    }

    function textarea_field( $name = '', $element ) {
        if( empty( $name ) ) {
            return;
        }

        $extra_field      = '';
        $wrap_class = isset( $element['wrap_class'] ) ? $element['wrap_class'] : '';
        $wrap_tag   = isset( $element['wrap_tag'] ) ? $element['wrap_tag'] : 'div';
        $id         = isset( $element['id'] ) ? esc_attr( $element['id'] ) : esc_attr( $name );
        $class      = isset( $element['class'] ) ? esc_attr( $element['class'] ) : esc_attr( $name );
        $disabled   = isset( $element['disabled'] ) ? esc_attr( $element['disabled'] ) : '';
        $extra      = isset( $element['extra'] ) ? $element['extra'] : array();
        $label      = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $desc       = isset( $element['desc'] ) ? esc_attr( $element['desc'] ) : '';
        $value      = isset( $element['value'] ) ? esc_attr( $element['value'] ) : '';
        $required   = ( isset( $extra['data-hrm_required'] ) &&  ( $extra['data-hrm_required'] === true ) ) ? '*' : '';

        if( is_array( $extra ) && count( $extra ) ) {
            foreach( $extra as $key => $action ) {
                $extra_field .= esc_attr( $key ) .'='. esc_attr( $action ).' ';
            }
        }

        $html = sprintf( '<label for="%1s">%2s<em>%3s</em></label>', $id, $label, $required );
        $html .= sprintf( '<textarea name="%1$s" class="%2$s" id="%3$s" %4$s %5$s >%6$s</textarea>', $name,
                $class, $id, $disabled, $extra_field, $value );
        $html .= sprintf( '<span class="hrm-clear"></span><span class="description">%s</span>', $desc );

        $wrap       = sprintf( '<%1$s class="hrm-form-field %2$s">', $wrap_tag, $wrap_class );
        $wrap_close = sprintf('</%s>', $wrap_tag);

        ob_start();
            echo $this->multiple_field_inside_this_wrap( $element );
                echo $wrap;
                echo $html;
                echo $wrap_close;
            echo $this->multiple_field_inside_this_wrap_close( $element );

        return ob_get_clean();
    }

    function multiple_field_inside_this_wrap( $element ) {
        $parent_wrap_attr = ( isset( $element['parent_wrap_attr'] ) && is_array( $element['parent_wrap_attr'] ) ) ? $element['parent_wrap_attr'] : array();
        $parent_wrap_start_tag = isset( $element['parent_wrap_start_tag'] ) ? $element['parent_wrap_start_tag'] : 'div';
        $attr = '';
        ob_start();
            if( isset( $element['parent_wrap_start'] ) && $element['parent_wrap_start'] ) {
                foreach ( $parent_wrap_attr as $id => $value) {
                    $attr .= esc_attr( $id ) .'="'. esc_attr( $value ).'" ';
                }

                echo '<' . $parent_wrap_start_tag .' '. $attr .'>';
            }
        return ob_get_clean();
    }

    function multiple_field_inside_this_wrap_close( $element ) {
        $parent_wrap_start_tag = isset( $element['parent_wrap_start_tag'] ) ? $element['parent_wrap_start_tag'] : 'div';
        ob_start();
            if( isset( $element['parent_wrap_close'] ) && $element['parent_wrap_close'] ) {
                echo '</' . $parent_wrap_start_tag .'>';
            }
        return ob_get_clean();
    }

    function descriptive_field( $element ) {

        $extra_field = '';
        $id    = isset( $element['id'] ) ? esc_attr( $element['id'] ) : '';
        $label      = isset( $element['label'] ) ? esc_attr( $element['label'] ) : '';
        $wrap_tag   = isset( $element['wrap_tag'] ) ? $element['wrap_tag'] : 'div';
        $wrap_class = isset( $element['wrap_class'] ) ? $element['wrap_class'] : '';
        $value    = isset( $element['value'] ) ? $element['value'] : '';

        $html = sprintf( '<label for="%1s">%2s</label>', $id, $label );
        $html .= $value;

        $wrap       = sprintf( '<%1$s class="hrm-form-field %2$s">', $wrap_tag, $wrap_class );
        $wrap_close = sprintf('</%s>', $wrap_tag);

        ob_start();
            echo $this->multiple_field_inside_this_wrap( $element );
                echo $wrap;
                echo $html;
                echo $wrap_close;
            echo $this->multiple_field_inside_this_wrap_close( $element );

        return ob_get_clean();
    }

    function get_serarch_form( $form, $heading = null ) {
        $form['action'] = isset( $form['action'] ) ? $form['action'] : '';
        $form['table_option'] = isset( $form['table_option'] ) ? $form['table_option'] : '';

        ob_start();

        ?>
            <div class="hrm-error-notification"></div>
            <div class="hrm-search-content">
                <div class="hrm-search-head">
                    <h2 id="hrm-searchLocationHeading"><?php echo $heading; ?></h2>
                </div>
                <form id="hrm-search-form" method="post" action="">
                    <input type="hidden" name="action" value="<?php echo esc_attr( $form['action'] ); ?>">
                    <input type="hidden" name="table_option" value="<?php echo esc_attr( $form['table_option'] ); ?>">

                    <?php wp_nonce_field( 'hrm_nonce', '_wpnonce' ); ?>
                    <?php

                    foreach( $form as $name => $field_obj ) {

                        if( ! isset( $field_obj['type'] ) || empty( $field_obj['type'] ) ) {
                            continue;
                        }
                        echo '<div class="hrm-text-wrap">';
                        switch ( $field_obj['type'] ) {
                            case 'text':
                                echo $this->text_field( $name, $field_obj );
                                break;
                            case 'select':
                                echo $this->select_field( $name, $field_obj );
                                break;
                            case 'textarea':
                                echo $this->textarea_field( $name, $field_obj );
                                break;
                            case 'radio':
                                echo $this->radio_field( $name, $field_obj );
                                break;
                            case 'checkbox':
                                echo $this->checkbox_field( $name, $field_obj );
                                break;
                            case 'hidden':
                                echo $this->hidden_field( $name, $field_obj );
                                break;
                            case 'multiple':
                                echo $this->multiple_select_field( $name, $field_obj );
                                break;
                            case 'paretn_wrap':
                                echo $this->multiple_field_inside_this_wrap( $field_obj );
                                break;
                            case 'paretn_wrap_close':
                                echo $this->multiple_field_inside_this_wrap_close( $field_obj );
                                break;
                            case 'descriptive':
                                echo $this->descriptive_field( $field_obj );
                                break;
                        }
                        echo '</div>';

                    }

                    ?>
                    <span class="hrm-clear"></span>
                    <input type="submit" name="<?php echo $form['action']; ?>" class="button-primary hrm-search" value="Search">
                </form>
            </div>

        <?php
        return ob_get_clean();
    }

    function hidden_form_generator( $form ) {
        $form['action']       = isset( $form['action'] ) ? $form['action'] : '';
        $form['table_option'] = isset( $form['table_option'] ) ? $form['table_option'] : '';
        $form['header']       = isset( $form['header'] ) ? $form['header'] : '';
        $tab                  = isset( $form['tab'] ) ? $form['tab'] : null;
        $subtab               = isset( $form['subtab'] ) ? $form['subtab'] : null;
        $form['url']          = isset( $form['url'] ) ? $form['url'] : '';

        ob_start();
        ?>

        <div id="hrm-hidden-form-warp" style="display: none;">
            <div class="hrm-search-head">
                    <h2 id="hrm-searchLocationHeading"><?php echo $form['header']; ?></h2>
            </div>
            <form id="hrm-hidden-form" action="" >
                <input type="hidden" name="action" value="<?php echo esc_attr( $form['action'] ); ?>">
                <input type="hidden" name="url" value="<?php echo $form['url']; ?>">
                <input type="hidden" name="table_option" value="<?php echo esc_attr( $form['table_option'] ); ?>">

                <?php wp_nonce_field( 'hrm_nonce', '_wpnonce' ); ?>
                <div id="hrm-form-field">

                    <?php
                        foreach( $form as $name => $field_obj ) {

                            if( ! isset( $field_obj['type'] ) || empty( $field_obj['type'] ) ) {
                                continue;
                            }

                            switch ( $field_obj['type'] ) {
                                case 'text':
                                    echo $this->text_field( $name, $field_obj );
                                    break;
                                case 'select':
                                    echo $this->select_field( $name, $field_obj );
                                    break;
                                case 'textarea':
                                    echo $this->textarea_field( $name, $field_obj );
                                    break;
                                case 'radio':
                                    echo $this->radio_field( $name, $field_obj );
                                    break;
                                case 'checkbox':
                                    echo $this->checkbox_field( $name, $field_obj );
                                    break;
                                case 'hidden':
                                    echo $this->hidden_field( $name, $field_obj );
                                    break;
                                case 'multiple':
                                    echo $this->multiple_select_field( $name, $field_obj );
                                    break;
                                case 'paretn_wrap':
                                    echo $this->multiple_field_inside_this_wrap( $field_obj );
                                    break;
                                case 'paretn_wrap_close':
                                    echo $this->multiple_field_inside_this_wrap_close( $field_obj );
                                    break;
                                case 'descriptive':
                                    echo $this->descriptive_field( $field_obj );
                                    break;
                            }

                        }
                    ?>
                </div>
                <div class="hrm-action-wrap">
                    <input type="submit" class="button hrm-submit-button button-primary" name="requst" value="Submit">
                    <a href="#" class="button hrm-form-cancel"><?php _e( 'Cancel', 'hrm' ); ?></a>
                    <div class="hrm-spinner" style="display: none;"><?php _e( 'Saving....', 'hrm' ); ?></div>
                </div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    function visible_form_generator( $form ) {
        $form['action']       = isset( $form['action'] ) ? $form['action'] : '';
        $form['table_option'] = isset( $form['table_option'] ) ? $form['table_option'] : '';
        $form['header']       = isset( $form['header'] ) ? $form['header'] : '';
        $form['id']           = isset( $form['id'] ) ? $form['id'] : '';
        $form['subtab']       = isset( $form['subtab'] ) ? $form['subtab'] : null;
        $form['tab']          = isset( $form['tab'] ) ? $form['tab'] : null;
        $submit_btn           = isset( $form['submit_btn'] ) ? $form['submit_btn'] : true;
        ob_start();
        ?>
        <div class="hrm-error-notification"></div>
        <div id="hrm-visible-form-warp">
            <div class="hrm-search-head">
                <h2 id="hrm-searchLocationHeading"><?php echo $form['header']; ?></h2>
            </div>
            <form id="hrm-visible-form" action="" method="post">
                <input type="hidden" name="action" value="<?php echo esc_attr( $form['action'] ); ?>">
                <input type="hidden" name="id" value="<?php echo esc_attr( $form['id'] ); ?>">
                <input type="hidden" name="url" value="<?php echo get_permalink(); ?>">
                <input type="hidden" name="table_option" value="<?php echo esc_attr( $form['table_option'] ); ?>">
                <?php wp_nonce_field( 'hrm_nonce', '_wpnonce' ); ?>

                <?php
                    foreach( $form as $name => $field_obj ) {

                        if( ! isset( $field_obj['type'] ) || empty( $field_obj['type'] ) ) {
                            continue;
                        }

                        switch ( $field_obj['type'] ) {
                            case 'text':
                                echo $this->text_field( $name, $field_obj );
                                break;
                            case 'select':
                                echo $this->select_field( $name, $field_obj );
                                break;
                            case 'textarea':
                                echo $this->textarea_field( $name, $field_obj );
                                break;
                            case 'radio':
                                echo $this->radio_field( $name, $field_obj );
                                break;
                            case 'checkbox':
                                echo $this->checkbox_field( $name, $field_obj );
                                break;
                            case 'hidden':
                                echo $this->hidden_field( $name, $field_obj );
                                break;
                            case 'multiple':
                                echo $this->multiple_select_field( $name, $field_obj );
                                break;
                            case 'paretn_wrap':
                                echo $this->multiple_field_inside_this_wrap( $field_obj );
                                break;
                            case 'paretn_wrap_close':
                                echo $this->multiple_field_inside_this_wrap_close( $field_obj );
                                break;
                            case 'descriptive':
                                echo $this->descriptive_field( $field_obj );
                                break;
                        }

                    }

                if ( hrm_user_can_access( $form['tab'], $form['subtab'], 'add' ) && $submit_btn ) {
                    ?>
                    <input type="submit" class="button hrm-submit-button button-primary" name="" value="Submit">
                    <div class="hrm-spinner" style="display: none;"><?php _e( 'Saving....', 'hrm' ); ?></div>
                    <?php
                }

                ?>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    function table( $table ) {
        if( ! isset( $table['head'] ) || ! is_array( $table['head'] ) || ! count( $table['head'] ) ) {
            return;
        }
        $table           = $this->data_formating( $table );
        $count_head      = count( $table['head'] );
        $table['action'] = isset( $table['action'] ) ? $table['action'] : '';
        $table['table']  = isset( $table['table'] ) ? $table['table'] : '';
        $tab             = isset( $table['tab'] ) ? $table['tab'] : null;
        $subtab          = isset( $table['subtab'] ) ? $table['subtab'] : null;
        $count           = 1;
        $add_button      = isset( $table['add_button'] ) ?  $table['add_button'] : true;
        $delet_button    = isset( $table['delete_button'] ) ?  $table['delete_button'] : true;
        $pagination      = isset( $table['view_btn'] ) ? $table['view_btn'] : true;
        $add_btn_name    = isset( $table['add_btn_name'] ) ? $table['add_btn_name'] : __( 'Add', 'hrm' );

        ob_start();
        ?>

        <form id="hrm-list-form" action="" method="post">
            <input type="hidden" name="action" value="<?php echo esc_attr( $table['action'] ); ?>">
            <input type="hidden" name="table_option" value="<?php echo esc_attr( $table['table'] ); ?>">
            <div class="hrm-table-action-wrap">
                <?php if ( hrm_user_can_access( $tab, $subtab, 'add' ) &&  $add_btn_name ) { ?>
                    <a href="#" class="button button-primary hrm-add-button"><?php echo $add_btn_name; ?></a>
                <?php } ?>

                <?php if ( hrm_user_can_access( $tab, $subtab, 'delete' ) && $delet_button ) { ?>
                    <a href="#" class="button hrm-delete-button"><?php _e( 'Delete', 'hrm' ); ?></a>
                <?php } ?>

            </div>
            <?php if ( $pagination ) {  ?>
                <div class="hrm-pagination-wrap">
                    <?php $this->pagination_select(); ?>
                    <input type="submit" class="button-primary hrm-view-action" value="<?php _e( 'View', 'hrm' ); ?>" name="hrm_pagination">
                </div>
            <?php } ?>

            <span class="hrm-clear"></span>
            <?php wp_nonce_field( 'hrm_nonce', '_wpnonce' ); ?>

            <table <?php echo $table['table_attr']; ?>>
                <thead>
                    <tr>
                        <?php foreach( $table['head']  as $key => $val ) { ?>

                            <?php $th_attr = isset( $table['th_attr'][$key] ) ? $table['th_attr'][$key] : ''; ?>

                            <th <?php echo $th_attr;?>><?php echo $val; ?></th>

                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $table['body']  as $key => $val ) { ?>
                    <?php $odd_even = ( $count % 2 == 0 ) ? 'hrm-even' : 'hrm-odd'; ?>
                    <tr class="<?php echo $odd_even; ?>">
                        <?php
                        for( $i=0; $i<$count_head; $i++ ) {
                                $td_attr = isset( $table['td_attr'][$key][$i] ) ? $table['td_attr'][$key][$i] : ''; ?>
                                <td <?php echo $td_attr; ?>><?php echo isset( $val[$i] ) ? $val[$i] : ''; ?></td>

                        <?php } ?>
                    </tr>
                    <?php $count++; ?>
                    <?php } ?>
                </tbody>
            </table>
        </form><?php

        return ob_get_clean();
    }

    function data_formating( $table ) {
        if( ! isset( $table['body'] ) || ! is_array( $table['body'] ) ) {
            $table['body'] = array();
        }
        $table_attr = array();
        if( isset( $table['table_attr'] ) && is_array( $table['table_attr'] ) ) {
            foreach ( $table['table_attr'] as $key => $value) {
                $table_attr[] = $key .'="'. esc_attr( $value ) .'"';
            }
        }
        $table['table_attr'] = implode( $table_attr, ' ');
        return $table;
    }


    function hrm_query( $table, $limit = 0 ) {
        global $wpdb;
        $tabledb = $wpdb->prefix . $table;

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;

        if ( $limit != 0 ) {
            $limit = "LIMIT $offset,$limit";
        } else {
            $limit = '';
        }

        $results = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb ORDER BY id desc $limit" );
        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );

        return $results;
    }

    function edit_query( $table, $id ) {
        global $wpdb;
        $table = $wpdb->prefix . $table;
        return $wpdb->get_row("SELECT * FROM $table WHERE id = $id", ARRAY_A );
    }


    function search( $limit = null ) {
        check_ajax_referer( 'hrm_nonce' );
        $data = false;

        if( ! isset( $_POST['table_option'] ) || empty( $_POST['table_option'] ) ) {

            foreach ($_GET as $key => $value) {
                $data[$key] = urldecode( trim( $value ) );
            }

            $data['pagenum'] = 1;
            $data['hrm_error'] = 'table_option';
            $data['type'] = '_search';
            $data = apply_filters( 'hrm_search_parm', $data );

            $query_arg = add_query_arg( $data, admin_url( 'admin.php' ));
            wp_redirect( $query_arg  );
            exit;
        }

        $table_option = get_option( $_POST['table_option'] );
        $table_option['table_option'] = ( isset( $table_option['table_option'] ) && is_array( $table_option['table_option'] ) ) ? $table_option['table_option'] : array();

        foreach ( $table_option['table_option'] as $name => $value ) {
            if( isset( $_POST[$value] ) && ! empty( $_POST[$value] ) ) {
                $data[$value] = urlencode( trim( $_POST[$value] ) );
            }

            if( isset( $_GET[$value] ) ) {
                unset( $_GET[$value] );
            }
        }



        if( $data ) {
            $data['table_option'] = $_POST['table_option'];
            $data['_wpnonce'] = $_POST['_wpnonce'];
            $data['type'] = '_search';
        } else {
            unset( $_GET['table_option'], $_GET['_wpnonce'], $_GET['type'] );
        }

        foreach ( $_GET as $key => $value ) {
            $data[$key] = trim( $value );
        }

        $data['pagenum'] = 1;
        $data = apply_filters( 'hrm_search_parm', $data );
        $query_arg = add_query_arg( $data, admin_url( 'admin.php' ));
        $query_arg = apply_filters( 'hrm_search_redirect', $query_arg, $data );
        wp_redirect(  $query_arg );
        exit();
    }

    function update_table_option( $table_option_name, $table_option ) {
       return update_option( $table_option_name, $table_option );
    }


    function search_query( $limit ) {
        check_ajax_referer( 'hrm_nonce' );
        if( ! isset( $_GET['table_option'] ) || empty( $_GET['table_option'] ) ) {
            return array();
        }

        $table_option = get_option( $_GET['table_option'] );

        $data = array();
        foreach ( $table_option['table_option'] as $name => $value ) {
            if( isset( $_GET[$value] ) && ! empty( $_GET[$value] ) ) {
                $data[] = $name .' LIKE ' ."'%".trim( $_GET[$value] ) ."%'";
            }
        }

        $data = apply_filters( 'hrm_search_query', $data, $table_option, $limit );

        $where = implode( $data, ' AND ');

        global $wpdb;
        $tabledb = $wpdb->prefix . $table_option['table_name'];

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $offset = ( $pagenum - 1 ) * $limit;

        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb WHERE $where ORDER BY id desc LIMIT $offset,$limit";

        $results = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS * FROM $tabledb WHERE $where ORDER BY id desc LIMIT $offset,$limit" );

        $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );

        return $results;
    }

    function pagination_query_arg() {

        foreach( $_GET as $key => $val ) {
            $data[$key] = $val;
        }
        $data['pagination'] = $_POST['paginaton'];
        $data['pagenum'] = 1;
        $query_arg = add_query_arg( $data, admin_url( 'admin.php' ));
        $query_arg = apply_filters( 'hrm_pagination_redirect', $query_arg, $data );
        wp_redirect( $query_arg  );
        exit;
    }


    function pagination( $total, $limit ) {

        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $num_of_pages = ceil( $total / $limit );

        $page_links = paginate_links( array(
            'base'      => add_query_arg( 'pagenum', '%#%' ),
            'format'    => '',
            'prev_text' => __( '&laquo;', 'aag' ),
            'next_text' => __( '&raquo;', 'aag' ),
            'add_args'  => false,
            'total'     => $num_of_pages,
            'current'   => $pagenum
        ) );

        if ( $page_links ) {
            return '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
        }
    }


    function pagination_select() {
        $selectd = isset( $_GET['pagination'] ) ? $_GET['pagination'] : 2;
        $arg = array(
            '2'  => __( '10', 'hrm'),
            '4'  => __( '20','hrm' ),
            '50'  => __( '50', 'hrm' ),
            '100' => __( '100', 'hrm' ),
        );

        $select = apply_filters( 'hrm_pagination_select', $arg );
        $select = ( is_array( $arg ) && count( $select ) ) ? $select : $arg;

        ?>
        <select id="hrm-pagination" name="paginaton">
        <?php
        foreach( $select as $value => $text ) {
            ?>
                <option value="<?php echo $value; ?>" <?php selected( $selectd, $value ); ?>><?php echo $text; ?></option>

            <?php
        }
        echo '</select>';
    }

    function conditional_query_val( $table_option = null, $fields = '*', $compare = array(), $row = false ) {
        $table = get_option( $table_option );
        $table = isset( $table['table_name'] ) ? $table['table_name'] : '';

        if ( is_array( $fields ) && count( $fields ) ) {
            $fields = implode( ', ', $field );
        }

        $where = array();
        foreach ($compare as $tb_field => $value ) {
            if ( is_array( $value ) ) {
                $in = implode( ',' , $value );
                $where[] = "$tb_field IN ( $in )";
            } else {
                $where[] =  "$tb_field = '$value'";
            }

        }

        $where = implode( ' AND ', $where );
        $where = apply_filters( 'hrm_where_query', $where );
        global $wpdb;
        $table = $wpdb->prefix.$table;
        if ( $row ) {
            return $wpdb->get_row( "SELECT $fields FROM $table WHERE $where" );
        } else {
            $results = $wpdb->get_results( "SELECT SQL_CALC_FOUND_ROWS $fields FROM $table WHERE $where" );
            $results['total_row'] = $wpdb->get_var("SELECT FOUND_ROWS()" );
            return $results;
        }

    }

    function country_list() {
        $list = include dirname( __FILE__ ) . '/../include/iso_country_codes.php';

        return array_merge( array('' => '- Select -'), $list );
    }

    function get_country_by_code( $code ) {
        $country_list = $this->country_list();

        if ( isset($country_list[$code])) {
            return $country_list[$code];
        }

        return false;
    }

    function get_currency_list() {

        $currency = apply_filters( 'hrm_currency', array(
            'AUD' => __( 'Australian Dollars', 'cpm' ),
            'BRL' => __( 'Brazilian Real', 'cpm' ),
            'CAD' => __( 'Canadian Dollars', 'cpm' ),
            'RMB' => __( 'Chinese Yuan', 'cpm' ),
            'CZK' => __( 'Czech Koruna', 'cpm' ),
            'DKK' => __( 'Danish Krone', 'cpm' ),
            'EUR' => __( 'Euros', 'cpm' ),
            'HKD' => __( 'Hong Kong Dollar', 'cpm' ),
            'HUF' => __( 'Hungarian Forint', 'cpm' ),
            'IDR' => __( 'Indonesia Rupiah', 'cpm' ),
            'INR' => __( 'Indian Rupee', 'cpm' ),
            'ILS' => __( 'Israeli Shekel', 'cpm' ),
            'JPY' => __( 'Japanese Yen', 'cpm' ),
            'KRW' => __( 'South Korean Won', 'cpm' ),
            'MYR' => __( 'Malaysian Ringgits', 'cpm' ),
            'MXN' => __( 'Mexican Peso', 'cpm' ),
            'NOK' => __( 'Norwegian Krone', 'cpm' ),
            'NZD' => __( 'New Zealand Dollar', 'cpm' ),
            'PHP' => __( 'Philippine Pesos', 'cpm' ),
            'PLN' => __( 'Polish Zloty', 'cpm' ),
            'GBP' => __( 'Pounds Sterling', 'cpm' ),
            'RON' => __( 'Romanian Leu', 'cpm' ),
            'SGD' => __( 'Singapore Dollar', 'cpm' ),
            'ZAR' => __( 'South African rand', 'cpm' ),
            'SEK' => __( 'Swedish Krona', 'cpm' ),
            'CHF' => __( 'Swiss Franc', 'cpm' ),
            'TWD' => __( 'Taiwan New Dollars', 'cpm' ),
            'THB' => __( 'Thai Baht', 'cpm' ),
            'TRY' => __( 'Turkish Lira', 'cpm' ),
            'USD' => __( 'US Dollars', 'cpm' ),
        ) );

        return array_unique( $currency );
    }


}