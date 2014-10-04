<?php
if ( hrm_current_user_role() == 'hrm_employer' ) {
    $employer_id = get_current_user_id();
} else {
    $employer_id = isset( $_GET['employee_id'] ) ? $_GET['employee_id'] : '';
}
$job_title_id = get_user_meta( $employer_id, '_job_title', true );
$job_title = hrm_Settings::getInstance()->conditional_query_val( 'hrm_job_title_option', '*', array( 'id' => $job_title_id ) );

$job_cat_id = get_user_meta( $employer_id, '_job_category', true );
$job_category = hrm_Settings::getInstance()->conditional_query_val( 'hrm_job_category', $field = '*', $compare = array( 'id' => $job_cat_id ) );

$job_location_id = get_user_meta( $employer_id, '_location', true );
$job_location = hrm_Settings::getInstance()->conditional_query_val( 'hrm_location_option', $field = '*', $compare = array( 'id' => $job_location_id ) );

?>

<div id="hrm-visible-form-warp">
    <div class="hrm-search-head">
        <h2 id="hrm-searchLocationHeading"><?php _e( 'Job', 'hrm' )?></h2>
    </div>
    <?php
        if ( isset( $job_title[0]->job_title ) && !empty( $job_title[0]->job_title ) ) {
            ?>
            <p><strong><?php _e( 'Title', 'hrm' ); ?></strong><?php echo $job_title[0]->job_title; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_category[0]->name ) && !empty( $job_category[0]->name ) ) {
            ?>
            <p><strong><?php _e( 'Category', 'hrm' ); ?></strong><?php echo $job_category[0]->name; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->name ) && !empty( $job_location[0]->name ) ) {
            ?>
            <p><strong><?php _e( 'Location Name', 'hrm' ); ?></strong><?php echo $job_location[0]->name; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->country_code ) && !empty( $job_location[0]->country_code ) ) {
            ?>
            <p><strong><?php _e( 'Location Country', 'hrm' ); ?></strong><?php echo $this->get_country_by_code( $job_location[0]->country_code ); ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->province ) && !empty( $job_location[0]->province ) ) {
            ?>
            <p><strong><?php _e( 'Location Province', 'hrm' ); ?></strong><?php echo $job_location[0]->province; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->city ) && !empty( $job_location[0]->city ) ) {
            ?>
            <p><strong><?php _e( 'Location City', 'hrm' ); ?></strong><?php echo $job_location[0]->city; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->address ) && !empty( $job_location[0]->address ) ) {
            ?>
            <p><strong><?php _e( 'Location Address', 'hrm' ); ?></strong><?php echo $job_location[0]->address; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->zip_code ) && !empty( $job_location[0]->zip_code ) ) {
            ?>
            <p><strong><?php _e( 'Location zip code', 'hrm' ); ?></strong><?php echo $job_location[0]->zip_code; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->phone ) && !empty( $job_location[0]->phone ) ) {
            ?>
            <p><strong><?php _e( 'Location Phone', 'hrm' ); ?></strong><?php echo $job_location[0]->phone; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->fax ) && !empty( $job_location[0]->fax ) ) {
            ?>
            <p><strong><?php _e( 'Location Fax', 'hrm' ); ?></strong><?php echo $job_location[0]->fax; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $job_location[0]->notes ) && !empty( $job_location[0]->notes ) ) {
            ?>
            <p><strong><?php _e( 'Location Description', 'hrm' ); ?></strong><?php echo $job_location[0]->notes; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $value->city ) && !empty( $value->city ) ) {
            ?>
            <p><strong><?php _e( 'City', 'hrm' ); ?></strong><?php echo $value->city; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $value->address ) && !empty( $value->address ) ) {
            ?>
            <p><strong><?php _e( 'Address', 'hrm' ); ?></strong><?php echo $value->address; ?></p>
            <?php
        }
    ?>

    <?php
        if ( isset( $value->zip_code ) && !empty( $value->zip_code ) ) {
            ?>
            <p><strong><?php _e( 'Zip/Postal Code', 'hrm' ); ?></strong><?php echo $value->zip_code; ?></p>
            <?php
        }
    ?>

    <?php
        if ( isset( $value->phone ) && !empty( $value->phone ) ) {
            ?>
            <p><strong><?php _e( 'Phone', 'hrm' ); ?></strong><?php echo $value->phone; ?></p>
            <?php
        }
    ?>

    <?php
        if ( isset( $value->fax ) && !empty( $value->fax ) ) {
            ?>
            <p><strong><?php _e( 'Fax', 'hrm' ); ?></strong><?php echo $value->fax; ?></p>
            <?php
        }
    ?>
    <?php
        if ( isset( $value->notes ) && !empty( $value->notes ) ) {
            ?>
            <p><strong><?php _e( 'Notes', 'hrm' ); ?></strong><?php echo $value->notes; ?></p>
            <?php
        }
    ?>

    <p><strong><?php _e( 'Job description', 'hrm' ); ?></strong><?php echo get_user_meta( $employer_id, '_job_desc', true ); ?></p>

</div>