<div  id="hrm-hidden-form-warp" class="postbox">
    <div class="hrm-search-head">
        <h3><?php _e( 'Department', 'hrm' ); ?></h3>
    </div>
    <form id="hrm-hidden-form" action="" >
        <div id="hrm-form-field">

            <div class="hrm-form-field ">
            	<label for="title">
            		Title<em>*</em>
            	</label>
            	<input type="text" name="title" value="" placeholder="" class="title" id="title"  data-hrm_validation="1" data-hrm_required="1" data-hrm_required_error_msg="This field is required"  />
            	<span class="hrm-clear"></span>
            	<span class="description"></span>
            </div>

            <div class="hrm-form-field ">
            	<label for="description">
            		Description<em></em>
            	</label>
            	<textarea name="description" class="hrm-admin-notice-field" id="description"></textarea>
            	<span class="hrm-clear"></span>
            	<span class="description"></span>
            </div>

            <div class="hrm-form-field ">
            	<label for="date">
            		date<em></em>
            	</label>
            	<input type="text" name="date" value="" placeholder="" class="hrm-datepicker" id="date"/>
            	<span class="hrm-clear"></span>
            	<span class="description"></span>
            </div>
        </div>

        <div class="hrm-action-wrap">
            <input type="submit" class="button hrm-submit-button button-primary" name="requst" value="Submit">

            <a @click.prevent="showHideNewDepartmentForm($event)" target="_blank" href="#" class="button hrm-form-cancel">Cancel</a>
            <div class="hrm-spinner" style="display: none;">Saving....</div>
        </div>
    </form>
</div>




