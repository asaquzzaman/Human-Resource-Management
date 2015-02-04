<div class="hrm-update-notification"></div>
<?php
//table defination
//table defination

$search = array();
//search form
$search['job_title'] = array(
    'label' => __( 'Job Title', 'hrm' ),
    'type'  => 'text',
    'value' => isset( $_POST['job_title'] ) ? $_POST['job_title'] : '',
    'desc'  => 'please insert job title',
);

$search['type'] = array(
    'type' => 'hidden',
    'value' => '_search'
);

$search['action'] = 'hrm_search';
$search['table_option'] = 'hrm_job_title_option';
echo hrm_Settings::getInstance()->get_serarch_form( $search, 'Job Title');
//search form
?>
<div id="hrm-admin-job-title"></div>
<?php

	//table


    $pagenum     = hrm_pagenum();
    $limit       = hrm_result_limit();
    if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
        $post = $_POST;
        $results = Hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
        $search_satus = true;

    } else {
        $results = Hrm_Settings::getInstance()->hrm_query( 'hrm_job_title', $limit, $pagenum );
        $search_satus = false;
    }


    if( isset( $results['total_row'] ) ) {
        $total = $results['total_row'];
        unset( $results['total_row'] );
    } else {
        $total = 0;
    };

    $add_permission = hrm_user_can_access( $tab, $subtab, 'add' ) ? true : false;
    $delete_permission = hrm_user_can_access( $tab, $subtab, 'delete' ) ? true : false;
    foreach ( $results as $key => $value) {
        if ( $add_permission ) {
            $name_id = '<a href="#" class="hrm-editable" data-table_option="hrm_job_title_option" data-id='.$value->id.'>'.$value->job_title.'<a>';
        } else {
            $name_id = $value->job_title;
        }

        if ( $delete_permission ) {
            $del_checkbox = '<input name="hrm_check['.$value->id.']" value="" type="checkbox">';
        } else {
            $del_checkbox = '';
        }

        $body[] = array(
            $del_checkbox,
            $name_id,
            $value->job_description,
            esc_attr( $value->note ),
        );

        $td_attr[] = array(
            'class="check-column"'
        );
    }

    $del_checkbox        = ( $delete_permission ) ? '<input type="checkbox">' : '';
    $table               = array();
    $table['head']       = array( $del_checkbox, 'Job Title', 'Job Description', 'Note' );
    $table['body']       = isset( $body ) ? $body : array();
    $table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
    $table['th_attr']    = array( 'class="check-column"' );
    $table['table']      = 'hrm_job_title_option';
    $table['action']     = 'hrm_delete';
    $table['table_attr'] = array( 'class' => 'widefat' );
    $table['tab']        = $tab;
    $table['subtab']     = $subtab;

    echo Hrm_Settings::getInstance()->table( $table );
    //table

    //pagination
    echo Hrm_Settings::getInstance()->pagination( $total, $limit, $pagenum );
    $file_path = urlencode(__FILE__);
?>
<?php $url = hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ); ?>
<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
            add_form_generator_action : 'add_form',
            add_form_apppend_wrap : 'hrm-admin-job-title',
            class_name : 'Hrm_Admin',
            redirect : '<?php echo $url; ?>',
            function_name : 'job_title_insert_form',
            page: '<?php echo $page; ?>',
            tab: '<?php echo $tab; ?>',
            subtab: '<?php echo $subtab; ?>',
            req_frm: '<?php echo $file_path; ?>',
            limit: '<?php echo $limit; ?>',
            search_satus: '<?php echo $search_satus; ?>',
            subtab: true
        };
    });
</script>