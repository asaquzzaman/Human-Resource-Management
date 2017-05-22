<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'admin' );

if ( file_exists( $header_path ) ) {
	require_once $header_path;
}

?>

<div class="hrm-department">
    <div class="hrm-update-notification"></div>

	<div id="hrm-admin-department">

        <form id="hrm-list-form" class="" action="" method="post">

            <div class="hrm-table-action-wrap">
                <department-add-btn></department-add-btn>
                <department-del-btn></department-del-btn>
                
            </div>
                
            <span class="hrm-clear"></span>

			<div id="hrm-data-table_wrapper" class="dataTables_wrapper no-footer">
				
                <department-paginate-drop-down></department-paginate-drop-down>
                <department-search></department-search>
				
               <department-table></department-table>
               <department-pagination></department-pagination>

        		
        	</div>
        </form>
    </div>
</div>


