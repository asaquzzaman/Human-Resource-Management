<template>
	<div>
		<table class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                	<td v-if="deleteCheckbox" id="cb" class="manage-column column-cb check-column">
                		<input id="cb-select-all-1" type="checkbox">
                	</td>
                    <th v-for="(header, header_index) in headers" :key="header_index">
                    	{{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="" v-for="(record, record_index) in records" :key="record_index" v-if="record.editMode">
                	<th v-if="deleteCheckbox" scope="row" class="check-column">			
						<input id="cb-select-7" type="checkbox" name="post[]" value="7">
					</th>
					
                    <td v-for="(header, header_index) in headers" :key="header_index">
                    	{{ record[header.key] }}
                    </td>
                </tr>
                
                <tr v-else id="edit-8" class="inline-edit-row inline-edit-row-page quick-edit-row quick-edit-row-page inline-edit-page inline-editor" style="">
                	<td colspan="5" class="colspanchange">

						<fieldset class="inline-edit-col-left">
							<legend class="inline-edit-legend">Quick Edit</legend>
							<div class="inline-edit-col">
					
								<label>
									<span class="title">Title</span>
									<span class="input-text-wrap">
										<input type="text" v-model="record.title" class="ptitle">
									</span>
								</label>

								<label>
									<span class="title">From</span>
									<span class="input-text-wrap">
										<hrm-date-picker placeholder="From" v-model="record.start"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
									</span>
								</label>

								<label>
									<span class="title">To</span>
									<span class="input-text-wrap">
										<hrm-date-picker placeholder="To" v-model="record.end"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
									</span>
								</label>

								<label>
									<span class="title">Comments</span>
									<span class="input-text-wrap">
										<textarea v-model="record.description"></textarea>
									</span>
								</label>
							</div>
						</fieldset>

		
						<fieldset class="inline-edit-col-right">
							<div class="inline-edit-col"></div>
						</fieldset>

						<div class="submit inline-edit-save">
							<button type="button" class="button cancel alignleft">Cancel</button>
							<button type="button" class="button button-primary save alignright">Update</button>
							<br class="clear">
						</div>
					</td>
				</tr>
            </tbody>
        </table>
	</div>
</template>


<script>
	export default {
		props: {
			deleteCheckbox: {
				type: [Boolean],
				default () {
					return true;
				}
			}
		},

		data () {
			return {
				records: [],
				headers: [
					{
						label: 'Title',
						key: 'title'
					},
					{
						label: 'From',
						key: 'start'
					},
					{
						label: 'To',
						key: 'end'
					}, 
					{
						label: 'Comments',
						key: 'description'
					}
				],
			}
		},

		created () {
			
			var self = this;
			var postData = {
				'class': 'Work_Experience',
				'method': 'gets',
				'transformers': 'Work_Experiance_Transformer'
			};
            var request_data = {
                data: postData,
                success: function(res) {
                	res.data.forEach(function(work) {
                		self.workExperianceMeta(work);
                	});
                    self.records = res.data;
                }
            };

            self.httpRequest('hrm_get_records',request_data);
		},
		methods: {
			workExperianceMeta (work) {
				work.editMode = false;
			}
		}
		
	}
</script>