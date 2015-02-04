<?php
class Hrm_Evaluation {
    private static $instance;

    public static function getInstance() {
        if( ! self::$instance ) {
            self::$instance = new Hrm_Evaluation();
        }

        return self::$instance;
    }

    function get_project_by_manager() {
        global $wpdb;

        $table   = $wpdb->prefix . 'hrm_user_role';
        $user_id = get_current_user_id();

        $args = array(
            'post_type'      => 'hrm_project',
            'posts_per_page' => '-1',
            'post_status'    => 'publish',
            'author__not_in' => array( $user_id ),
        );

        add_filter( 'posts_join', array( $this, 'jonin_user_role_table') );
        add_filter( 'posts_where', array( $this, 'get_project_where_user_role'), 10, 2 );

        $query = new WP_Query( $args );

        remove_filter( 'posts_join', array( $this, 'jonin_user_role_table') );
        remove_filter( 'posts_where', array( $this, 'get_project_where_user_role'), 10, 2 );

        return $query;
    }

    function search_rating_record( $post, $limit, $pagenum ) {
        if ( isset( $post['from_date'] ) && isset( $post['to_date'] ) ) {
            if ( !empty( $post['from_date'] ) && !empty( $post['to_date'] ) ) {
                if ( strtotime( $post['from_date'] ) > strtotime( $post['to_date'] ) ) {
                    return;
                }
            }
        }

        $offset = ( $pagenum - 1 ) * $limit;

        $args = array(
            'post_type'      => 'hrm_task',
            'post_status'    => array( 'publish', 'future' ),
            'posts_per_page' => $limit,
            'offset'         => $offset,
            'meta_query'     => array(
                'relation' => 'AND',
                 array(
                    'key' => '_rating_date',
                    'value' => date( 'Y-m-d', strtotime( $post['from_date'] ) ),
                    'compare' => '>='
                ),

                array(
                    'key' => '_rating_date',
                    'value' => date( 'Y-m-d', strtotime( $post['to_date'] ) ),
                    'compare' => '<='
                ),
            )
        );

        return new WP_Query($args);
    }

    function rating_recored( $limit, $pagenum ) {
        $offset  = ( $pagenum - 1 ) * $limit;
        $args = array(
            'post_type'      => 'hrm_task',
            'post_status'    => array( 'publish', 'future' ),
            'posts_per_page' => $limit,
            'offset'         => $offset,
            'meta_query'     => array(
                'relation' => 'AND',
                 array(
                    'key' => '_rating_date',
                    'value' => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
                    'compare' => '>='
                ),

                array(
                    'key' => '_rating_date',
                    'value' => date( 'Y-m-d', strtotime( current_time( 'mysql' ) ) ),
                    'compare' => '<='
                ),
            )
        );

        return new WP_Query($args);
    }

    function jonin_user_role_table( $join ) {
        global $wpdb;

        $table = $wpdb->prefix . 'hrm_user_role';
        $join .= "LEFT JOIN $table ON $wpdb->posts.ID = $table.project_id";

        return $join;
    }

    function get_project_where_user_role( $where, &$wp_query ) {
        global $wpdb;

        $table   = $wpdb->prefix . 'hrm_user_role';
        $user_id = get_current_user_id();
        $where   .= " AND $table.user_id = $user_id AND $table.role = 'manager'";

        return $where;
    }

    function get_project_by_author() {
        $user_id = get_current_user_id();

        $args = array(
            'post_type'      => 'hrm_project',
            'author'         => $user_id,
            'posts_per_page' => '-1',
            'post_status'    => 'publish'
        );
        $query = new WP_Query( $args );

        return $query;
    }

    function get_user_by_project_id( $project_id ) {
        $users = Hrm_Admin::getInstance()->get_project_assigned_user( $project_id );
        $option_value = array();
        $option_value['-1'] = __( '-Select-', 'hrm' );
        foreach ( $users as $user_id => $user ) {
            $option_value[$user_id] = $user['name'];
        }
        $co_worker = array(
            'label'    => __( 'Co Worker', 'hrm' ),
            'class'    => 'hrm-chosen',
            'id'       => 'hrm-rank-task-user',
            'type'     => 'select',
            'option'   => $option_value,
            'selected' => '',
            'desc'     => __( 'Type project name', 'hrm' ),
            'extra' => array(
                'data-placeholder' => __( "Choose project", 'hrm' ),
                'data-project_id'  => $project_id
            ),
        );
        echo '<div class="hrm-text-wrap hrm-task-rating-user">';
        echo Hrm_Settings::getInstance()->select_field( 'co_worker', $co_worker );
        echo '</div>';
    }

    function user_task_content( $project_id, $user_id ) {

        $outstanding_tasks = $this->get_outstnding_task( $project_id, $user_id, 'outstanding_task' );
        $completed_tasks   = $this->get_outstnding_task( $project_id, $user_id, 'completed_task' );
        $running_tasks     = $this->get_outstnding_task( $project_id, $user_id );
        $all_task_id       = array();
        $slider_value      = array();
        $running_task_total = 0;
        $outstanding_task_total = 0;
        $completed_task_total = 0;

        ob_start();

        ?>
        <form id="hrm-task-rating-form" action="" method="post">
        <input type="hidden" id="hrm-user-id" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" id="hrm-project-id" name="project_id" value="<?php echo $project_id; ?>">
        <input type="hidden" name="action" value="task_rating">
        <?php wp_nonce_field( 'hrm_nonce', '_wpnonce' ); ?>
        <div class="hrm-visible-form-warp">
            <div class="hrm-search-head">
                <h2 id="hrm-searchLocationHeading"><?php _e( 'Current Task', 'hrm' ); ?></h2>
            </div>
            <div class="hrm-inside-padding-wrap">

                <?php
                if ( !count( $running_tasks ) ) {
                     _e( 'No task found!', 'hrm' );
                }

                foreach ( $running_tasks as $project_id => $running_task ) {

                    echo '<h3>'. __('Project Title', 'hrm') . ' &#8594; ' . $running_task['p_title'] . '</h3>';
                    unset( $running_task['p_title'] );
                    $running_task_total = count( $running_task );

                    foreach ( $running_task as $key => $task ) {
                        $task_id = $task['tID'];
                        $all_task_id[] = $task_id;

                        $rating_value = get_post_meta( $task_id, '_rating_value', true );

                        $slider_value[] = array(
                            'id'    => $task['tID'],
                            'value' => !empty( $rating_value ) ? $rating_value : 0,
                        );

                        $slider = array(
                            'class'    => 'hrm-slider-field hrm-task-rating',
                            'value'    => !empty( $rating_value ) ? $rating_value : '',
                        );

                        ?>
                            <ul>
                                <li>

                                    <div class="hrm-task-wrap">
                                        <strong><?php echo $task['t_t']; ?></strong>
                                        <div class="hrm-slider-field hrm-task-rating">
                                            <strong><?php _e( 'Rating ', 'hrm' ); ?></strong><span class="hrm-task-rating-value"><?php echo intval( $rating_value ); ?></span>
                                        </div>
                                        <?php echo Hrm_Settings::getInstance()->hidden_field( 'task_rating['.$task_id.']', $slider ) ;?>
                                        <div class="hrm-slider-width" id="hrm-rating-slider-<?php echo $task_id; ?>"></div>
                                    </div>

                                </li>
                            </ul>
                        <?php
                    }

                }

                ?>
            </div>
        </div>

        <div class="hrm-visible-form-warp">
            <div class="hrm-search-head">
                <h2 id="hrm-searchLocationHeading"><?php _e( 'Outstanding Task', 'hrm' ); ?></h2>
            </div>
            <div class="hrm-inside-padding-wrap">
                <?php
                if ( !count( $outstanding_tasks ) ) {
                        _e( 'No task found!', 'hrm' );
                }

                foreach ( $outstanding_tasks as $project_id => $running_task ) {

                    echo '<h3>'. __('Project Title', 'hrm') . ' &#8594; ' . $running_task['p_title'] . '</h3>';
                    unset( $running_task['p_title'] );
                    $outstanding_task_total = count( $running_task );

                    foreach ( $running_task as $key => $task ) {
                        $task_id = $task['tID'];
                        $all_task_id[] = $task_id;

                        $rating_value = get_post_meta( $task_id, '_rating_value', true );

                        $slider_value[] = array(
                            'id'    => $task['tID'],
                            'value' => $rating_value ? intval( $rating_value ) : 0,
                        );

                        $slider = array(
                            'class'    => 'hrm-slider-field hrm-task-rating',
                            'value'    => $rating_value ? intval( $rating_value ) : '',
                        );

                    ?>
                        <ul>
                            <li>
                                <div class="hrm-task-wrap">
                                    <strong><?php echo $task['t_t']; ?></strong>
                                    <div class="hrm-slider-field hrm-task-rating">
                                        <strong><?php _e( 'Rating ', 'hrm' ); ?></strong><span class="hrm-task-rating-value"><?php echo intval( $rating_value ); ?></span>
                                    </div>
                                    <?php echo Hrm_Settings::getInstance()->hidden_field( 'task_rating['.$task_id.']', $slider ) ;?>
                                    <div class="hrm-slider-width" id="hrm-rating-slider-<?php echo $task['tID']; ?>"></div>
                                </div>
                            </li>
                        </ul>
                    <?php
                    }

                }

                ?>
            </div>
        </div>

        <div class="hrm-visible-form-warp">
            <div class="hrm-search-head">
                <h2 id="hrm-searchLocationHeading"><?php _e( 'Complete Task', 'hrm' ); ?></h2>
            </div>
            <div class="hrm-inside-padding-wrap">
                <?php
                if ( !count( $completed_tasks ) ) {
                    _e( 'No task found!', 'hrm' );
                }

                foreach ( $completed_tasks as $project_id => $running_task ) {

                    echo '<h3>'. __('Project Title', 'hrm') . ' &#8594; ' . $running_task['p_title'] . '</h3>';
                    unset( $running_task['p_title'] );
                    $completed_task_total = count( $running_task );

                    foreach ( $running_task as $key => $task ) {
                        $task_id = $task['tID'];
                        $all_task_id[] = $task_id;
                        $rating_value = get_post_meta( $task_id, '_rating_value', true );

                        $rating_post_id = isset( $rating->ID ) ? $rating->ID : 0;

                        $slider_value[] = array(
                            'id'    => $task['tID'],
                            'value' => $rating_value ? intval( $rating_value ) : 0,
                        );

                        $slider = array(
                            'class'    => 'hrm-slider-field hrm-task-rating',
                            'value'    => $rating_value ? intval( $rating_value ) : '',
                        );

                    ?>
                        <ul>
                            <li>
                                <div class="hrm-task-wrap">
                                    <strong><?php echo $task['t_t']; ?></strong>
                                    <div class="hrm-slider-field hrm-task-rating">
                                        <strong><?php _e( 'Rating ', 'hrm' ); ?></strong><span class="hrm-task-rating-value"><?php echo intval( $rating_value ); ?></span>
                                    </div>
                                    <?php echo Hrm_Settings::getInstance()->hidden_field( 'task_rating['.$task_id.']', $slider ) ;?>
                                    <div class="hrm-slider-width" id="hrm-rating-slider-<?php echo $task['tID']; ?>"></div>
                                </div>
                            </li>
                        </ul>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
        <?php
        $rating_date = isset( $task_id ) ? get_post_meta( $task_id, '_rating_date', true ) : '';
        $rating_date = !empty( $rating_date ) ? hrm_get_date2mysql( $rating_date ) : '';
        ?>
        <br>
        <input type="text" placeholder="<?php _e( 'Date', 'hrm' ); ?>" class="hrm-datepicker" name="task_rate_date" value="<?php echo $rating_date; ?>">
        <input type="submit" class="btn button-primary" value="<?php _e( 'Rating', 'hrm' ); ?>">

        </form>
        <?php
        $total = $running_task_total + $outstanding_task_total + $completed_task_total;
        $max = $total ? ( 100/$total ) : 0;

        return array( 'slider_value' => $slider_value, 'max' => $max, 'content' => ob_get_clean(), 'tasks_id' => $all_task_id );
    }

    function get_outstnding_task( $project_id, $user_id, $subtab = null ) {
        global $wpdb;

        if ( isset( $subtab ) && $subtab == 'outstanding_task' ) {

            $query1 = "AND tcomp.meta_key = '_completed' AND tcomp.meta_value = '0'";
            $query2 = "AND tend.meta_value != '' AND STR_TO_DATE( tend.meta_value, '%Y-%m-%d') < STR_TO_DATE( NOW(), '%Y-%m-%d')";
        } else if ( isset( $subtab ) && $subtab == 'completed_task' ) {

            $query1 = "AND tcomp.meta_key = '_completed' AND tcomp.meta_value = '1'";
            $query2 = '';
        } else {
            $query1 = "AND tcomp.meta_key = '_completed' AND tcomp.meta_value = '0'";
            $query2 = "AND ( tend.meta_value = '' OR STR_TO_DATE( tend.meta_value, '%Y-%m-%d') >= STR_TO_DATE( NOW(), '%Y-%m-%d') ) ";
        }
        $sql = "SELECT t.post_title as t_t, t.ID as tID, tpm.meta_value as tassign, tend.meta_value as tend,
                p.post_title as p_t, p.ID as pID
                FROM $wpdb->posts as t
                LEFT JOIN $wpdb->posts as p ON p.ID = t.post_parent
                LEFT JOIN $wpdb->postmeta as tpm ON tpm.post_id = t.ID
                LEFT JOIN $wpdb->postmeta as tend ON tend.post_id = t.ID
                LEFT JOIN $wpdb->postmeta as tcomp ON tcomp.post_id = t.ID
                WHERE
                t.post_type = 'hrm_task' AND t.post_status = 'publish' AND t.post_parent = $project_id
                AND p.post_type = 'hrm_project' AND p.post_status = 'publish'
                AND tpm.meta_key = '_assigned' AND tpm.meta_value = $user_id
                $query1
                AND tend.meta_key = '_end_date' $query2";

        $results = $wpdb->get_results($sql, ARRAY_A );

        $retrun = array();
        foreach ( $results as $key => $result ) {
            if ( array_key_exists( $result['pID'], $retrun ) ) {
                $retrun[$result['pID']][] = $result;
            } else {
                $retrun[$result['pID']][] = $result;
                $retrun[$result['pID']]['p_title'] = $result['p_t'];
            }
        }

        return $retrun;
    }

    function new_task_rating( $post ) {
        if( !isset( $post['task_rating'] ) ) {
            return false;
        }

        if( !is_array( $post['task_rating'] ) ) {
            return false;
        }

        $rating_date = empty( $_POST['task_rate_date'] ) ? current_time( 'mysql' ) : $_POST['task_rate_date'];

        foreach ( $post['task_rating'] as $task_id => $rating_value ) {
            update_post_meta( $task_id, '_rating_value', $rating_value );
            update_post_meta( $task_id, '_rating_date', $rating_date );
        }
    }


    function new_inserted_task_rating( $project_id, $assing_to ) {
        if ( !$assing_to ) {
            return false;
        }

        $tasks = $this->count_total_task( $project_id, $assing_to );
        $total_task = $tasks->found_posts;

        foreach ( $tasks->posts as $key => $post ) {
            $task_rating = get_post_meta( $post->ID, '_rating_value', true );
            $pre_base    = 100/$total_task;
            $new_base    = 100/($total_task + 1);
            $new_rating  = ( $task_rating * $new_base) / $pre_base;
            update_post_meta( $post->ID, '_rating_value', $new_rating );
        }
    }

    function reduce_task_rating( $project_id, $assing_to ) {
        $tasks = $this->count_total_task( $project_id, $assing_to );
        $total_task = $tasks->found_posts;

        if( $total_task <= 1 ) {
            return;
        }

        foreach ( $tasks->posts as $key => $post ) {
            $task_rating = get_post_meta( $post->ID, '_rating_value', true );
            $pre_base    = 100/$total_task;
            $new_base    = 100/($total_task - 1);
            $new_rating  = ( $task_rating * $new_base) / $pre_base;
            update_post_meta( $post->ID, '_rating_value', $new_rating );
        }
    }

    function count_total_task( $project_id, $assing_to = false ) {

        $args = array(
            'post_type'      => 'hrm_task',
            'post_status'    => array( 'publish', 'future' ),
            'post_parent'    => $project_id,
            'posts_per_page' => '-1',
        );

        if ( $assing_to ) {
            $args['meta_query'] =  array(
                array(
                    'key'     =>'_assigned',
                    'value'   => $assing_to,
                    'compare' => '='
                )
            );
        }

        $query = new WP_Query( $args );

        return $query;//->found_posts;
    }

    function update_task_rating( $post ) {

        $assing_to = get_post_meta( $post['id'], '_assigned', true );

        if( $assing_to != $post['assigned'] ) {
            update_post_meta( $post['id'], '_rating_value', 0 );

            $task = get_post( $post['id'] );
            $project_id = $task->post_parent;

            $this->new_inserted_task_rating( $project_id, $post['assigned'] );
            $this->reduce_task_rating( $project_id, $assing_to );
        }

    }

    function parent_rating_delete( $project_id ) {
        $args = array(
            'post_parent' => $project_id,
            'post_type'   => 'hrm_rating_parent'
        );

        $posts = get_posts( $args );

        if (is_array($posts) && count($posts) > 0) {

            // Delete all the Children of the Parent Page
            foreach($posts as $post){

                $child_args = array(
                    'post_parent' => $project_id,
                    'post_type'   => 'hrm_rating'
                );

                $child_posts = get_posts( $child_args );

                foreach($child_posts as $child_post){
                    wp_delete_post($child_post->ID, true);
                }

                wp_delete_post($post->ID, true);
            }
        }
    }

}



