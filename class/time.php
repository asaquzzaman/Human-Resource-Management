<?php
class Hrm_Time {
    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new Hrm_Time();
        }

        return self::$_instance;
    }

    function __construct() {
        add_filter( 'hrm_search_parm', array( $this, 'project_search_parm' ), 10, 1 );
        add_action( 'text_field_before_input', array($this, 'task_budget_crrency_symbol'), 10, 2 );
    }

    function punch_form_status( $post ) {
        update_option( 'hrm_punch_form_status', hrm_clean( $post['status'] ) );
    }

    function get_individual_punch( $limit, $pagenum, $post = null ) {

        if ( isset( $post['from_date'] ) && isset( $post['to_date'] ) ) {
            if ( !empty( $post['from_date'] ) && !empty( $post['to_date'] ) ) {
                if ( strtotime( $post['from_date'] ) > strtotime( $post['to_date'] ) ) {
                    return false;
                }
            }
        }

        $offset = ( $pagenum - 1 ) * $limit;

        $args = array(
            'post_type'      => 'hrm_punch',
            'post_status'    => 'publish',
            'author'         => get_current_user_id(),
            'posts_per_page' => $limit,
            'offset'         => $offset
        );
        $post_date = false;
        if ( isset( $post['from_date'] ) && isset( $post['to_date'] ) && !empty( $post['from_date'] ) && !empty( $post['to_date'] ) ) {

            $from_date = $post['from_date'];
            $to_date = $post['to_date'];

            $args['date_query'] = array(
                'after'     => date( 'Y-m-d', strtotime( $from_date ) ),
                'before'    => date( 'Y-m-d', strtotime( $to_date ) ),
                'inclusive' => true,
            );
        } else {
            if ( isset( $post['from_date'] ) && !empty( $post['from_date'] ) ) {
                $args['date_query'] = array(
                    'after'     => $post['from_date'],
                    'inclusive' => true,
                );
                $args['order'] = 'ASC';
            }

            if ( isset( $post['to_date'] ) && !empty( $post['to_date'] ) ) {
                $args['date_query'] = array(
                    'before'    => $post['to_date'],
                    'inclusive' => true,
                );
                $args['order'] = 'ASC';
            }
        }

        return new WP_Query($args);
    }

    function search_punch_in_out_recored( $post, $limit, $pagenum ) {
        $user_id = isset( $post['user_id'] ) ? $post['user_id'] : false;

        if ( !$user_id ) {
            $user_id = isset( $post['user_id_js'] ) ? $post['user_id_js'] : false;
        }

        if ( !$user_id ) {
            return false;
        }

        if ( isset( $post['from_date'] ) && isset( $post['to_date'] ) ) {
            if ( !empty( $post['from_date'] ) && !empty( $post['to_date'] ) ) {
                if ( strtotime( $post['from_date'] ) > strtotime( $post['to_date'] ) ) {
                    return false;
                }
            }
        }

        $offset = ( $pagenum - 1 ) * $limit;

        $args = array(
            'post_type'      => 'hrm_punch',
            'post_status'    => 'publish',
            'author'         => $user_id,
            'posts_per_page' => $limit,
            'offset'         => $offset
        );
        $post_date = false;
        if ( isset( $post['from_date'] ) && isset( $post['to_date'] ) && !empty( $post['from_date'] ) && !empty( $post['to_date'] ) ) {

            $from_date = $post['from_date'];
            $to_date = $post['to_date'];

            $args['date_query'] = array(
                'after'     => date( 'Y-m-d', strtotime( $from_date ) ),
                'before'    => date( 'Y-m-d', strtotime( $to_date ) ),
                'inclusive' => true,
            );
        } else {
            if ( isset( $post['from_date'] ) && !empty( $post['from_date'] ) ) {
                $args['date_query'] = array(
                    'after'     => $post['from_date'],
                    'inclusive' => true,
                );
                $args['order'] = 'ASC';
            }

            if ( isset( $post['to_date'] ) && !empty( $post['to_date'] ) ) {
                $args['date_query'] = array(
                    'before'    => $post['to_date'],
                    'inclusive' => true,
                );
                $args['order'] = 'ASC';
            }
        }

        return new WP_Query($args);

    }

    function edit_attendance_save($post) {

        $post_date = $post['punch_in_date'] .' '. $post['punch_in_time'];
        $punch_out = $post['punch_out_date'] .' '. $post['punch_out_time'];

        $datetime1 = strtotime( $post_date );
        $datetime2 = strtotime( $punch_out );
        $diff = $datetime2 - $datetime1;

        if ( $diff <= 0  ) {
            $arg = array(
                'ID'           => $post['post_id'],
                'post_date'    => date( 'Y-m-d H:i:s', strtotime( $post_date ) ),
                'post_content' => $post['punch_in_note']
            );

            wp_update_post($arg);
            return true;
        }

        $arg = array(
            'ID' => $post['post_id'],
            'post_date' => date( 'Y-m-d H:i:s', strtotime( $post_date ) ),
            'post_content' => $post['punch_in_note']
        );

        $post_id = wp_update_post($arg);
        $punch_out_date_time = strtotime( $punch_out );

        if ( !empty( $post['punch_out_date'] ) ) {
            update_post_meta( $post['post_id'], '_puch_out_time', $punch_out_date_time );
            update_post_meta( $post['post_id'], '_puch_out_note', $post['punch_out_note'] );

            update_post_meta( $post_id, '_puch_in_status', '0' );
            update_user_meta( $post['user_id_js'], '_puch_in_status', '0' );
        }


        return true;
    }

    function punch_in_out_form() {
        return $this->punch_out_form();
    }
}