<template>
	<div id="hrm-list-table">
		<table v-if="isFetchRecord"  class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                	<td v-if="deleteCheckbox" id="cb" class="manage-column column-cb check-column">
                		<input @change.prevent="deleteAll()" v-model="deleteAllStatus" id="cb-select-all-1" type="checkbox">
                	</td>
                    <th v-for="(header, header_index) in headers" :key="header_index">
                    	{{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
            	
                <tr class="" v-for="(record, record_index) in records" :key="record_index" v-if="!record.editMode">
                	<th v-if="deleteCheckbox" scope="row" class="check-column">			
						<input id="cb-select-7" @change="actionCheckbox()" v-model="deletedId" :value="record.id" type="checkbox">
					</th>
					
                    <td>
                    	{{ record.title }}

                    	<div class="row-actions">
                    		<span class="edit"><a @click.prevent="recordEditForm(record)" href="#">Edit</a> | </span>
	                    	<span class="trash"><a @click.prevent="selfDelete(record)" href="#">Delete</a> </span>
	                    </div>
                    </td>
                    <td>
                    	{{ record.start }}
                    </td>
                    <td>
                    	{{ record.end }}
                    </td>
                    <td>
                    	{{ record.description }}
                    </td>
                </tr>
                
                <tr v-else :id="'hrm-edit-'+record.id" :data-recordId="record.id" class="inline-edit-row hrm-edit-toggle">
                	<td colspan="5" class="colspanchange">
                		<form :id="'hrm-edit-form-'+record.id" class="hrm-edit-form" action="" @submit.prevent="selfUpdate(record)">
							<fieldset class="inline-edit-col-left">
								<legend class="inline-edit-legend">Quick Edit</legend>
								<div class="inline-edit-col">
									
									<div class="hrm-edit-field-wrap">
										<label class="title">
											Title<em>*</em>
										</label>

										<span class="input-text-wrap">
											<input type="text" required="required" v-model="record.title" class="ptitle">
										</span>
										<div class="hrm-clear"></div>
									</div>
										
									<div class="hrm-edit-field-wrap">
										<label class="title">
											From<em>*</em>
										</label>
										<span class="input-text-wrap">
											<hrm-date-picker required="required" placeholder="From" v-model="record.start"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
										</span>
										<div class="hrm-clear"></div>
									</div>

									<div class="hrm-edit-field-wrap">
										<label class="title">
											To<em>*</em>
										</label>
										<span class="input-text-wrap">
											<hrm-date-picker required="required" placeholder="To" v-model="record.end"  class="pm-datepickter-to" dependency="pm-datepickter-to"></hrm-date-picker>
										</span>
										<div class="hrm-clear"></div>
									</div>

									<div class="hrm-edit-field-wrap">
										<label class="title">
											Comments
										</label>
										<span class="input-text-wrap">
											<textarea v-model="record.description"></textarea>
										</span>
										<div class="hrm-clear"></div>
									</div>
								</div>
							</fieldset>


							<div class="submit inline-edit-save">
								<button @click.prevent="recordEditForm(record, false)" type="button" class="button hrm-button-secondary cancel alignleft">Cancel</button>
								<input :disabled="!canSubmit" type="submit" class="button hrm-button-primary button-primary save alignright" value="Update">
								<div v-if="loading" class="hrm-spinner alignright"></div>
								<br class="clear">
							</div>
						</form>
					</td>
				</tr>

				<tr v-if="!records.length">
					<td colspan="5">
						No result found!
					</td>
				</tr>
            </tbody>
        </table>
	</div>
</template>

<style>
	.alignright {
		float: right;
	}
	.hrm-spinner {
		margin-right: 10px;
		margin-top: 6px;
	}
</style>

<script>
	export default {
		mixins: [HRMMixin.workExperience],	
		props: {
			deleteCheckbox: {
				type: [Boolean],
				default () {
					return true;
				}
			},
			fields: {
				type: [Array],
				default () {
					return []
				}
			}
		},

		data () {
			return {
				canSubmit: true,
				loading: false,
				deleteAllStatus: false,
				deletedId: [],
				headers: [
					{
						label: 'Title',
					},
					{
						label: 'From',
					},
					{
						label: 'To',
					}, 
					{
						label: 'Comments',
					}
				],
			}
		},
		
		created () {
			this.getRecords();
		},

		computed: {
			records () {
				return this.$store.state[this.nameSpace].records;
			}
		},

		watch: {
			deletedId () {
				this.$store.commit(this.nameSpace + '/setDeletedId', this.deletedId);
			},
			'$route' (to, from) {
				this.getRecords();
			}
		},
		methods: {
			recordEditForm (record, status) {
				status = status || 'toggle';
				this.$store.commit( this.nameSpace+'/showHideEditForm', 
					{
						id: record.id,
						status: status
					} 
				);
			},

			selfUpdate (record) {
				var self = this;
				record['class'] = 'Work_Experience';
				record['method'] = 'update';
				record['transformers'] = 'Work_Experiance_Transformer';

				var args = {
					data: record,
					callback () {
						self.canSubmit = true;
						self.loading = false;
					}
				}

				if (!this.editFormValidation(self.fields, record)) {
					return false;
				}
				
				self.canSubmit = false;
				self.loading = true;

				this.updateRecord(args);
			},

			deleteAll () {
				if (this.deleteAllStatus) {
                    var deleted_id = [];

                    this.$store.state[this.nameSpace].records.map(function(record) {
                        deleted_id.push(record.id);
                    });

                    this.deletedId = deleted_id;

                } else {
                    this.deletedId = [];
                }
			},

			actionCheckbox () {
				let records = this.$store.state[this.nameSpace].records;
				
				if ( records.length == this.deletedId.length ) {
					this.deleteAllStatus = true;
				} else {
					this.deleteAllStatus = false;
				}
			},

			selfDelete (record) {
				var self = this;
				this.recordDelete([record.id], function() {
					var hasRecords = self.$store.state[self.nameSpace].records.length;
					var page = self.$route.params.current_page_number;
					if (!hasRecords && page > 1) {
						self.$router.push({
							params: {
								current_page_number: page - 1
							},
							query: self.$route.query
						});
					}
					
					if (
						!hasRecords 
							&& 
						typeof self.pagination != 'undefined'
							&&
						self.pagination.total_pages > 1
					) {
						self.getRecords();
					}
				})
			},
		}
		
	}
</script>