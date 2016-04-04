<?php

class HRM_Client {
    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new HRM_Client();
        }

        return self::$_instance;
    }

    function get_clients( $limit = -1 ) {
        $clients = array();
        $args = array(
            'meta_query' => array(
                array(
                    'key'     => '_hrm_client',
                    'value'   => '1',
                    'compare' => '='
                ),
            )
        );
        $clients = new WP_User_Query( $args );

        return $clients;
    }

    function new_client_form( $client_id = false ) {

        $country  = hrm_Settings::getInstance()->country_list();
        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';
        $post_id = isset( $post->ID ) ? intval( $post->ID ) : false;

        if ( $client_id ) {
            $current_client = get_user_by( 'id', $client_id );
            $form['client_id'] = array(
                'type' => 'hidden',
                'value' => $client_id
            );
        }

        if ( $client_id === false ) {
            $form['user_name'] = array(
                'label' =>  __( 'User Name', 'hrm' ),
                'type'  => 'text',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                ),
            );

            $form['email'] = array(
                'label' =>  __( 'E-mail', 'hrm' ),
                'type'  => 'text',
                'extra' => array(
                    'data-hrm_validation' => true,
                    'data-hrm_required' => true,
                    'data-hrm_email' => true,
                    'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
                    'data-hrm_email_error_msg'=> __( 'Please enter a valid email', 'hrm' ),
                ),
            );
        }

        $form['first_name'] = array(
            'label' =>  __( 'First Name', 'hrm' ),
            'type'  => 'text',
            'value' => isset( $current_client->first_name ) ? $current_client->first_name : ''
        );
        $form['last_name'] = array(
            'label' =>  __( 'Last Name', 'hrm' ),
            'type'  => 'text',
            'value' => isset( $current_client->last_name ) ? $current_client->last_name : ''
        );

        $form['client_role'] = array(
            'label'    => __( 'Role', 'hrm' ),
            'type'     => 'select',
            'option'   => hrm_get_role(),
            'selected' => isset( $current_client->roles ) ? reset( $current_client->roles ) : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $form['joining_date'] = array(
            'label' => __( 'Joining Date', 'hrm' ),
            'value' => $client_id ? hrm_get_date2mysql( get_user_meta( $client_id, '_joining_date', true ) ) : '',
            'type'  => 'text',
            'class' => 'hrm-datepicker-from'
        );

        $form['phone'] = array(
            'label' => __( 'Phone', 'hrm' ),
            'type'  => 'text',
            'value' => $client_id ? get_user_meta( $client_id, '_phone', true ) : ''
        );
        $form['fax'] = array(
            'label' => __( 'Fax', 'hrm' ),
            'type'  => 'text',
            'value' => $client_id ? get_user_meta( $client_id, '_fax', true ) : ''
        );
        $form['addres_street_1'] = array(
            'label' => __( 'Address Street 1', 'hrm' ),
            'type'  => 'text',
            'value' => $client_id ? get_user_meta( $client_id, '_addres_street_1', true ) : ''
        );

        $form['address_street_2'] = array(
            'label' => __( 'Address Street 2', 'hrm' ),
            'type'  => 'text',
            'value' => $client_id ? get_user_meta( $client_id, '_address_street_2', true ) : ''
        );

        $form['city'] = array(
            'label' => __( 'City', 'hrm' ),
            'type'  => 'text',
            'value' => $client_id ? get_user_meta( $client_id, '_phone', true ) : ''
        );

        $form['state_province'] = array(
            'label' => __( 'State/Province', 'hrm' ),
            'type'  => 'text',
            'value' => $client_id ? get_user_meta( $client_id, '_state_province', true ) : ''
        );

        $form['zip'] = array(
            'label' => __( 'Zip/Postal Code', 'hrm' ),
            'type'  => 'text',
            'value' => $client_id ? get_user_meta( $client_id, '_zip', true ) : ''
        );

        $form['country'] = array(
            'label'    => __( 'Country', 'hrm' ),
            'type'     => 'select',
            'option'   => $country,
            'selected' => $client_id ? get_user_meta( $client_id, '_country', true ) : '',
            'desc'     => 'Chose your country'
        );

        $form['description'] = array(
            'label' => __( 'Description', 'hrm' ),
            'class' => 'hrm-client-description-field',
            'type'  => 'textarea',
            'value' => $client_id ? get_user_meta( $client_id, 'description', true ) : '',
        );

        $form['action'] = 'new_client';
        $form['header'] = __('New Client', 'hrm');
        $form['url']    = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function new_client( $postdata ) {

        $client_id = isset( $postdata['client_id'] ) && ! empty( $postdata['client_id'] ) ? intval( $postdata['client_id'] ) : false;

        if ( $client_id ) {
            $first_name      = sanitize_text_field( $postdata['first_name'] );
            $last_name       = sanitize_text_field( $postdata['last_name'] );
            $display_name    = $first_name .' '. $last_name;

            $userdata = array(
                'ID'           => $client_id,
                'first_name'   => $first_name,
                'last_name'    => $last_name,
                'display_name' => $display_name,
                'role'         => $postdata['client_role'],
                'description'  => $postdata['description']
            );

            $new_client_id = wp_update_user( $userdata );
        } else {
            $is_valid = Hrm_Employeelist::getInstance()->new_admin_form_validate( $postdata );

            if ( is_wp_error( $is_valid ) ) {
                return $is_valid;
            }

            $random_password = wp_generate_password( 8, false );
            $first_name      = sanitize_text_field( $postdata['first_name'] );
            $last_name       = sanitize_text_field( $postdata['last_name'] );
            $display_name    = $first_name .' '. $last_name;

            $userdata = array(
                'user_login'   => $postdata['user_name'],
                'user_pass'    => $random_password,
                'user_email'   => $postdata['email'],
                'first_name'   => $first_name,
                'last_name'    => $last_name,
                'display_name' => $display_name,
                'role'         => $postdata['client_role'],
                'description'  => $postdata['description']
            );

            $new_client_id = wp_insert_user( $userdata );
        }

        if ( $new_client_id ) {
            $this->udpate_client_meta( $new_client_id, $postdata );
            if ( $client_id === false ) {
                wp_new_user_notification( $client_id, $random_password );
            }
            return $new_client_id;
        } else {
            return false;
        }
    }

    function udpate_client_meta( $client_id, $post ) {
        $joining_date = empty( $post['joining_date'] ) ? current_time( 'mysql' ) : hrm_date2mysql( $post['joining_date'] );
        update_user_meta( $client_id, '_joining_date', $joining_date );
        update_user_meta( $client_id, '_phone', $post['phone'] );
        update_user_meta( $client_id, '_fax', $post['fax'] );
        update_user_meta( $client_id, '_addres_street_1', $post['addres_street_1'] );
        update_user_meta( $client_id, '_address_street_2', $post['address_street_2'] );
        update_user_meta( $client_id, '_city', $post['city'] );
        update_user_meta( $client_id, '_state_province', $post['state_province'] );
        update_user_meta( $client_id, '_zip', $post['zip'] );
        update_user_meta( $client_id, '_country', $post['country'] );
        update_user_meta( $client_id, '_hrm_client', 1 );
    }

    function client_delete( $client_id ) {

        $client_delete = wp_delete_user( $client_id );
        if ( $client_delete ) {
            return true;
        } else {
            return false;
        }
    }

    function get_projects_by_client( $client_id ) {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'hrm_project',
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'     => '_client',
                    'value'   => $client_id,
                    'compare' => '='
                )
            )
        );

        return new WP_Query( $args );
    }

    function new_client_partial_payment_form( $data = false ) {

        $redirect = ( isset( $_POST['hrm_dataAttr']['redirect'] ) && !empty( $_POST['hrm_dataAttr']['redirect'] ) ) ? $_POST['hrm_dataAttr']['redirect'] : '';

        $clients_query = $this->get_clients();
        $clients = array();
        $clients[null] = __( '-Select-', 'hrm' );
        foreach ( $clients_query->results as $key => $client ) {
            $clients[$client->ID] = $client->display_name;
        }

        $data_id = isset( $data['id'] ) ? intval( $data['id'] ) : false;

        if ( $data_id === false ) {
            $form['client_id'] = array(
                'label'    => __( 'Client', 'hrm' ),
                'type'     => 'select',
                'class'    => 'hrm-project-by-client',
                'option'   => $clients,
                'selected' => $client_id ? get_user_meta( $client_id, '_country', true ) : '',
                'desc'     => __( 'Chose Client', 'hrm' ),
                'extra' => array(
                    'data-hrm_validation'         => true,
                    'data-hrm_required'           => true,
                    'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
                ),
            );
        } else {
            $form['id'] = array(
                'value' => intval( $data_id ),
                'type'  => 'hidden',
            );

            $form['client_id'] = array(
                'value' => intval( $data['client_id'] ),
                'type'  => 'hidden',
            );

            $form['project_id'] = array(
                'value' => intval( $data['project_id'] ),
                'type'  => 'hidden',
            );
        }

        $form['description'] = array(
            'label' => __( 'Description', 'hrm' ),
            'class' => 'hrm-client-description-field',
            'type'  => 'textarea',
            'value' => isset( $data['description'] ) ? esc_attr( $data['description'] ) : '',
        );

        $form['date'] = array(
            'label' => __( 'Payment Date', 'hrm' ),
            'value' => $data['date'] ? hrm_get_date2mysql( $data['date'] ) : '',
            'type'  => 'text',
            'class' => 'hrm-datepicker-from',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

   /*     $form['currency'] = array(
            'label' => __( 'Currency', 'hrm' ),
            'type'  => 'text',
            'value' => $client_id ? get_user_meta( $client_id, '_zip', true ) : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );*/

        $form['amount'] = array(
            'label' => __( 'Amount', 'hrm' ),
            'type'  => 'text',
            'value' => $data['amount'] ? $data['amount'] : '',
            'extra' => array(
                'data-hrm_validation'         => true,
                'data-hrm_required'           => true,
                'data-hrm_required_error_msg' => __( 'This field is required', 'hrm' ),
            ),
        );

        $form['action']       = 'ajax_referer_insert';
        $form['table_option'] = 'hrm_client_partial_payment';
        $form['header']       = __('Client Partial Payment', 'hrm');
        $form['url']          = $redirect;

        ob_start();
        echo hrm_Settings::getInstance()->hidden_form_generator( $form );

        $return_value = array(
            'append_data' => ob_get_clean(),
        );

        return $return_value;
    }

    function update_partial_payment( $befor_data, $post ) {
        global $wpdb;

        $table = $wpdb->prefix . $post['table'];
        $data = array(
            'description' => $post['description'],
            'date'        => hrm_date2mysql( $post['date'] ),
            'amount'      => $post['amount']
        );

        $wpdb->update( $table, $data, array( 'id' => $post['id'] ) );

        $condition = array(
            'client_id'  => $befor_data['client_id'],
            'project_id' => $befor_data['project_id']
        );
        $partial_payments = Hrm_Settings::getInstance()->conditional_query_val( $post['table'], '*', $condition );

        unset( $partial_payments['total_row'] );
        $table = $this->partial_payment_table( $partial_payments );

        $currency_symbol = get_post_meta( $befor_data['project_id'], '_currency_symbol', true );
        $project_budget = get_post_meta( $befor_data['project_id'], '_budget', true );
        $client_pay     = $this->client_total_pay( $partial_payments );
        $client_due     = $project_budget - $client_pay;
        $payment_summary = $this->partial_client_payemnt_summery( $currency_symbol, $client_pay, $client_due );
        return array( 'table' => $table, 'summary' => $payment_summary );
    }

    function partial_payment_tr_congent( $partial_payment ) {
        ob_start();
        ?>
        <td>
            <textarea class="hrm-disable-field-css hrm-disabled-field" name="description" disabled="disabled"><?php  echo $partial_payment->description; ?></textarea>
        </td>
        <td>
            <input type="text" name="date" class="hrm-disable-field-css hrm-partial-payment-date-field hrm-disabled-field hrm-datepicker-from" value="<?php echo esc_attr( hrm_get_date2mysql( $partial_payment->date ) ); ?>" disabled="disabled">
        </td>
        <td>
            <?php echo $currency_symbol; ?><input type="text" name="amount" class="hrm-disable-field-css hrm-partial-payment-amount-field hrm-disabled-field" value="<?php echo esc_attr( $partial_payment->amount ); ?>" disabled="disabled">
        </td>
        <td style="width: 16%;">
            <a href="#" class="hrm-update-prtial-btn"><?php _e( 'Edit', 'hrm' ); ?></a>
            <a href="#" style="display: none;" class="hrm-update-prtial-save-btn" data-table_option="hrm_client_partial_payment" data-id="<?php echo $partial_payment->id; ?>"><?php _e( 'Save', 'hrm' ); ?></a>
            <a href="#" style="display: none;" class="hrm-update-prtial-cancel-btn" data-table_option="hrm_client_partial_payment" data-id="<?php echo $partial_payment->id; ?>"><?php _e( 'Cancel', 'hrm' ); ?></a>
        </td>
        <td>
            <a href="#" class="hrm-delete hrm-update-prtial-delete-btn" data-table_option="hrm_client_partial_payment" data-id="<?php echo $partial_payment->id; ?>"><?php _e( 'Delete', 'hrm' ); ?></a>
        </td>
        <?php
        return ob_get_clean();
    }

    function partial_payment_total( $currency_symbol, $partial_total_amount ) {
        ob_start();
        ?>
        <td></td>
        <td><strong><?php  _e( 'Total', 'hrm' ); ?></strong></td>
        <td><strong><?php  echo $currency_symbol.$partial_total_amount ?></strong></td>
        <td></td>
        <td></td>
        <?php
        return ob_get_clean();
    }

    function partial_payment_table( $partial_payments ) {
        ob_start();
        ?>
            <table class="hrm-sub-table widefat">
                <tr>
                    <th><strong><?php _e( 'Description', 'hrm' ); ?></strong></th>
                    <th><strong><?php _e( 'Date', 'hrm' ); ?></strong></th>
                    <th><strong><?php _e( 'Amount', 'hrm' ); ?></strong></th>
                    <th><strong><?php _e( 'Edit', 'hrm' ); ?></strong></th>
                    <th><strong><?php _e( 'Delete', 'hrm' ); ?></strong></th>

                </tr>

                <?php
                    $partial_total_amount = 0;
                    foreach ( $partial_payments as $key => $partial_payment ) {

                        $partial_total_amount = $partial_total_amount + $partial_payment->amount;
                        ?>

                            <tr class="hrm-partial-wrap">

                                <?php
                                    echo $this->partial_payment_tr_congent( $partial_payment );
                                ?>
                            </tr>

                        <?php
                    }
                ?>

                <tr id="hrm-partial-total-<?php echo $project->ID; ?>">
                <?php

                    echo $this->partial_payment_total( $currency_symbol, $partial_total_amount );
                ?>

                </tr>
            </table>
        <?php
        return ob_get_clean();
    }

    function client_total_pay( $partial_payments ) {
        $partial_total_amount = 0;
        foreach ( $partial_payments as $key => $partial_payment ) {

            $partial_total_amount = $partial_total_amount + $partial_payment->amount;

        }

        return $partial_total_amount;
    }

    function partial_client_payemnt_summery( $currency_symbol, $client_pay, $client_due ) {
        ob_start();
        ?>
            <div><?php echo '<strong>Client Pay </strong>' . $currency_symbol . $client_pay; ?></div>
            <div><?php echo '<strong>Client Due Payment </strong>'. $currency_symbol . $client_due; ?></div>
        <?php
        return ob_get_clean();
    }

    function cancel_partial_payment_update( $befor_data, $post ) {
        $table = $post['table'];
        $condition = array(
            'client_id'  => $befor_data['client_id'],
            'project_id' => $befor_data['project_id']
        );
        $partial_payments = Hrm_Settings::getInstance()->conditional_query_val( $table, '*', $condition );
        unset( $partial_payments['total_row'] );
        $table = $this->partial_payment_table( $partial_payments );
        return $table;
    }

    function cancel_partial_payment_delete( $befor_data, $post ) {
        global $wpdb;
        $table = $wpdb->prefix . $post['table'];
        $wpdb->delete( $table, array( 'id' => $post['id'] ) );

        $condition = array(
            'client_id'  => $befor_data['client_id'],
            'project_id' => $befor_data['project_id']
        );
        $partial_payments = Hrm_Settings::getInstance()->conditional_query_val( $post['table'], '*', $condition );

        unset( $partial_payments['total_row'] );
        $table = $this->partial_payment_table( $partial_payments );

        $currency_symbol = get_post_meta( $befor_data['project_id'], '_currency_symbol', true );
        $project_budget = get_post_meta( $befor_data['project_id'], '_budget', true );
        $client_pay     = $this->client_total_pay( $partial_payments );
        $client_due     = $project_budget - $client_pay;
        $payment_summary = $this->partial_client_payemnt_summery( $currency_symbol, $client_pay, $client_due );
        return array( 'table' => $table, 'summary' => $payment_summary );
    }

}