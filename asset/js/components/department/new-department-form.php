<div  id="hrm-hidden-form-warp" class="postbox">
    <div class="hrm-search-head">
        <h3><?php _e( 'Department', 'hrm' ); ?></h3>
    </div>
    <form id="hrm-hidden-form" action="" @submit.prevent="createNewDepartment()">
        <div id="hrm-form-field">

            <div class="hrm-form-field ">
            	<label for="title">
            		<?php _e( 'Title', 'hrm' ); ?><em>*</em>
            	</label>
            	<input type="text" required="required" v-model="title" name="title" value="" placeholder="" class="title" id="title"  data-hrm_validation="1" data-hrm_required="1" data-hrm_required_error_msg="This field is required"  />
            	<span class="hrm-clear"></span>
            	<span class="description"></span>
            </div>

            <div class="hrm-form-field ">
            	<label for="description">
            		<?php _e( 'Description', 'hrm' ); ?><em></em>
            	</label>
            	<textarea name="description" v-model="description" class="hrm-admin-notice-field" id="description"></textarea>
            	<span class="hrm-clear"></span>
            	<span class="description"></span>
            </div>

            <div class="hrm-form-field ">
                <label for="status"><?php _e( 'Parent', 'hrm' ); ?><em>   </em></label>
                <select v-model="parent" class="status" name="status" id="status" data-placeholder="-- Chose --">
                    <option value="1"><?php _e( 'Enable', 'hrm' ); ?></option>
                    <option value="0"><?php _e( 'Desable', 'hrm' ); ?></option>
                </select>
                <span class="hrm-clear"></span>
                <span class="description"><?php _e( 'Choose Parent Department', 'hrm' ); ?></span>
            </div>

            
        	<div  class="hrm-form-field ">
                <label for="status"><?php _e( 'Status', 'hrm' ); ?><em>   </em></label>
                <select v-model="status" class="status" name="status" id="status" data-placeholder="-- Chose --">
                    <option value="1"><?php _e( 'Enable', 'hrm' ); ?></option>
                    <option value="0"><?php _e( 'Desable', 'hrm' ); ?></option>
                </select>
                <span class="hrm-clear"></span>
                <span class="description"><?php _e( 'Choose department status', 'hrm' ); ?></span>
            </div>
            
        </div>

        <div class="hrm-action-wrap">
            <input  type="submit" class="button hrm-submit-button button-primary" name="requst" value="Submit">

            <a @click.prevent="showHideNewDepartmentForm($event)" target="_blank" href="#" class="button hrm-form-cancel"><?php _e( 'Cancel', 'hrm' ); ?></a>
            <div class="hrm-spinner" v-if="show_spinner"><?php _e( 'Saving....', 'hrm' ); ?></div>
        </div>
    </form>
</div>




