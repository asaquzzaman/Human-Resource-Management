<?php
if ( isset( $_GET['employee_id'] ) && $_GET['employee_id'] ) {
    $employer_id = intval( $_GET['employee_id'] );
} else {
    $employer_id = get_current_user_id();
}

$job_title_id = get_user_meta( $employer_id, '_job_title', true );
$job_title = hrm_Settings::getInstance()->conditional_query_val( 'hrm_job_title', '*', array( 'id' => $job_title_id ) );

$job_cat_id = get_user_meta( $employer_id, '_job_category', true );
$job_category = hrm_Settings::getInstance()->conditional_query_val( 'hrm_job_category', '*', array( 'id' => $job_cat_id ) );

$job_location_id = get_user_meta( $employer_id, '_location', true );
$job_location = hrm_Settings::getInstance()->conditional_query_val( 'hrm_location', '*', array( 'id' => $job_location_id ) );

?>

<div id="hrm-job-info" class="postbox">
    <div class="hrm-search-head">
        <h3><?php _e( 'Job Information', 'hrm' )?></h3>
    </div>
    <div class="padding-wrap">
        <?php
            if ( isset( $job_title[0]->job_title ) && !empty( $job_title[0]->job_title ) ) {
                ?>
                <p class="job-content-warp">
                    <strong class="title"><?php _e( 'Title', 'hrm' ); ?></strong>
                    <span class="content"><?php echo $job_title[0]->job_title; ?></span>
                    <spna class="hrm-clear"></span>
                </p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_category[0]->name ) && !empty( $job_category[0]->name ) ) {
                ?>
                <p class="job-content-warp">
                    <strong class="title"><?php _e( 'Category', 'hrm' ); ?></strong>
                    <span class="content"><?php echo $job_category[0]->name; ?></span>
                    <spna class="hrm-clear"></span>
                </p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->name ) && !empty( $job_location[0]->name ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location Name', 'hrm' ); ?></strong><span class="content"><?php echo $job_location[0]->name; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->country_code ) && !empty( $job_location[0]->country_code ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location Country', 'hrm' ); ?></strong><span class="content"><?php echo $this->get_country_by_code( $job_location[0]->country_code ); ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->province ) && !empty( $job_location[0]->province ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location Province', 'hrm' ); ?></strong><span class="content"><?php echo $job_location[0]->province; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->city ) && !empty( $job_location[0]->city ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location City', 'hrm' ); ?></strong><span class="content"><?php echo $job_location[0]->city; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->address ) && !empty( $job_location[0]->address ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location Address', 'hrm' ); ?></strong><span class="content"><?php echo $job_location[0]->address; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->zip_code ) && !empty( $job_location[0]->zip_code ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location zip code', 'hrm' ); ?></strong><span class="content"><?php echo $job_location[0]->zip_code; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->phone ) && !empty( $job_location[0]->phone ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location Phone', 'hrm' ); ?></strong><span class="content"><?php echo $job_location[0]->phone; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->fax ) && !empty( $job_location[0]->fax ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location Fax', 'hrm' ); ?></strong><span class="content"><?php echo $job_location[0]->fax; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $job_location[0]->notes ) && !empty( $job_location[0]->notes ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Location Description', 'hrm' ); ?></strong><span class="content"><?php echo $job_location[0]->notes; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $value->city ) && !empty( $value->city ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'City', 'hrm' ); ?></strong><span class="content"><?php echo $value->city; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $value->address ) && !empty( $value->address ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Address', 'hrm' ); ?></strong><span class="content"><?php echo $value->address; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>

        <?php
            if ( isset( $value->zip_code ) && !empty( $value->zip_code ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Zip/Postal Code', 'hrm' ); ?></strong><span class="content"><?php echo $value->zip_code; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>

        <?php
            if ( isset( $value->phone ) && !empty( $value->phone ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Phone', 'hrm' ); ?></strong><span class="content"><?php echo $value->phone; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>

        <?php
            if ( isset( $value->fax ) && !empty( $value->fax ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Fax', 'hrm' ); ?></strong><span class="content"><?php echo $value->fax; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>
        <?php
            if ( isset( $value->notes ) && !empty( $value->notes ) ) {
                ?>
                <p class="job-content-warp"><strong class="title"><?php _e( 'Notes', 'hrm' ); ?></strong><span class="content"><?php echo $value->notes; ?></span><spna class="hrm-clear"></span></p>
                <?php
            }
        ?>

        <p class="job-content-warp"><strong class="title"><?php _e( 'Job description', 'hrm' ); ?></strong><span class="content"><?php echo get_user_meta( $employer_id, '_job_desc', true ); ?></span><spna class="hrm-clear"></span></p>
    </div>
</div>