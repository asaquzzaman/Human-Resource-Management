<table id="hrm-data-table" class="widefat dataTable no-footer" role="grid">
            
    <thead>
        <tr role="row">
        	<th class="sorting_asc" tabindex="0" aria-controls="hrm-data-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label=": activate to sort column descending">
        		<input @change.prevent="delAllDept()" class="hrm-all-checked" v-model="del_all_dept" type="checkbox">
        	</th>
            <th class="sorting" tabindex="0" aria-controls="hrm-data-table" rowspan="1" colspan="1" aria-label="Job Title: activate to sort column ascending" style="width: 304px;">
            	<?php _e( 'Department Title', 'hrm' ); ?>
            </th>
            <th class="sorting" tabindex="0" aria-controls="hrm-data-table" rowspan="1" colspan="1" aria-label="Job Description: activate to sort column ascending" style="width: 304px;">
            	<?php _e( 'Department Description', 'hrm' ); ?>
            </th>
            <th class="sorting" tabindex="0" aria-controls="hrm-data-table" rowspan="1" colspan="1" aria-label="Note: activate to sort column ascending" style="width: 305px;">
            	<?php _e( 'Status', 'hrm' ); ?>
            </th>
            <th class="sorting" tabindex="0" aria-controls="hrm-data-table" rowspan="1" colspan="1" aria-label="Note: activate to sort column ascending" style="width: 305px;">
                <?php _e( 'No. of Employee', 'hrm' ); ?>
            </th>
        </tr>
    </thead>

    <tbody>
                                
                                                
                                                
        <tr class="hrm-even odd" role="row" v-for="department in departments">
    
            <td class="hrm-table-checkbox sorting_1">
            	<input @change.prevent="delDept(department)" v-model="del_dept" class="hrm-single-checked" name="" :value="department.id" type="checkbox">
            </td>

    
            <td>
            	<div class="hrm-title-wrap">
            		<a href="#" class="hrm-editable hrm-title"><span v-html="department.hierarchical_pad"></span><span>{{ department.name }}</span></a>
					<div class="hrm-title-action">
						<department-edit-btn :department_id="department.id"></department-edit-btn>
                        <department-del-btn :department_id="department.id" :type="'single'"></department-del-btn>
						<span class="hrm-clear"></span>
					</div>
				</div>
			</td>

    
            <td>{{ department.description }}</td>

    
            <td>{{ departmentActivity(department) }}</td>
            <td>{{ department.number_of_employee }}</td>

        </tr>
        

    </tbody>
</table>