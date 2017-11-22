
<div class="hrm-content-wrap">
    
    <router-view name="HRM_Dept_Pagination"></router-view>
    <div class="hrm-department">
        
        <div class="hrm-update-notification"></div>

    	<div id="hrm-admin-department">

            <div class="hrm-slide-up" v-hrm-slide-down style="display: none;" v-if="is_new_department_form_visible"><new-department-form></new-department-form></div>

            <form id="hrm-list-form" class="" action="" method="post">

                <div class="hrm-table-action-wrap">
                    <div class="hrm-left-action">
                        <department-add-btn></department-add-btn>
                        <department-del-btn :type="'group'"></department-del-btn>
                        <span class="hrm-clear"></span>
                    </div>

                   <!--  <div class="hrm-right-action">
                        <department-paginate-drop-down></department-paginate-drop-down>
                        <department-search></department-search>
                        <span class="hrm-clear"></span>
                    </div> -->

                    <span class="hrm-clear"></span>
                    
                </div>

    			<div id="hrm-data-table_wrapper" class="dataTables_wrapper no-footer">
    				
                    
    				
                   <department-table></department-table>
                   <department-pagination></department-pagination>

            	</div>
            </form>

        </div>
        
    </div>
</div>

