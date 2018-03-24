<template>
	<div>
		<table v-if="isFetchRecord" class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                	<td v-if="manageEmployee()" id="cb" class="manage-column column-cb check-column">
                		<input @change.prevent="deleteAll()" v-model="deleteAllStatus" id="cb-select-all-1" type="checkbox">
                	</td>
                	<th class="has-row-actions">Name</th>
                    <th v-for="(header, header_index) in filterHeader(fields)" :key="header_index">
                    	{{ header.tableHead }}
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr :data-recordId="record.id" class="" v-for="(record, record_index) in records" :key="record_index" v-if="!record.editMode">
                	<th v-if="manageEmployee()" scope="row" class="check-column">			
						<input id="cb-select-7" @change="actionCheckbox()" v-model="deletedId" :value="record.id" type="checkbox">
					</th>

					<td class="">
						<img class="hrm-avatar" :src="record.avatar" style="height:32px; width: 32px;">
						<router-link class="hrm-profile-link" :to="{
							name: 'employee_general_information',
							params: {
								employeeId: record.id
							}
						}">
							{{ record.display_name }}
						</router-link>
						<div class="hrm-clear"></div>
						<div class="row-actions">
                    		<span v-if="manageEmployee() || record.can_update" class="edit"><a @click.prevent="recordEditForm(record)" href="#">Edit</a></span>
	                    	<span v-if="manageEmployee()" class="trash"> | <a @click.prevent="selfDelete(record)" href="#">Delete</a> </span>
	                    </div>

					</td>
					
                    <td v-for="(field, field_index) in filterHeader(fields)">
                    	<span v-html="printCellData(record, field)"></span>
                    </td>
                </tr>
                
                <tr v-else :id="'hrm-edit-'+record.id" :data-recordId="record.id" class="inline-edit-row hrm-edit-toggle" style="">
                	<td colspan="9" class="colspanchange">
                		<form :id="'hrm-edit-form-'+record.id" class="hrm-edit-form" action="" @submit.prevent="selfUpdate(record)">
							<fieldset class="inline-edit-col-left">
								<legend class="inline-edit-legend">Quick Edit</legend>
								<div class="inline-edit-col">
						
									<div class="hrm-edit-field-wrap" v-for="(field, field_index) in filterEditField(fields)">
										<label class="title">
											{{ field.label }} <em v-if="field.required">*</em>
										</label>
										<span class="input-text-wrap">
											<hrm-edit-field :record="record" :field="field"></hrm-edit-field>
											<!-- <input type="text" v-model="record[field.name]" class="ptitle"> -->
										</span>
										<div class="hrm-clear"></div>
									</div>
								</div>
							</fieldset>

			
							<fieldset class="inline-edit-col-right">
								<div class="inline-edit-col"></div>
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
					<td colspan="9">
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
	.hrm-avatar,
	.hrm-profile-link {
		float: left;
	}
	.hrm-avatar {
		margin-right: 5px;
	}
	.has-row-actions {
		width: 16%;
	}

</style>

<script>
	export default {
		mixins: [HRMMixin.employee],	
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
			}
		},
		
		created () {
			this.getRecords();
		},

		computed: {
			records () {
				return this.$store.state[this.nameSpace].records;
			},
			pagination () {
            	var pagination = this.$store.state[this.nameSpace].pagination;
            	pagination['total_pages'] = Math.ceil(pagination.total/pagination.per_page);
            	return pagination;
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
			filterEditField (fields) {
				return fields.filter(function(field) {
					return field.editable ? true : false;
				});
			},
			filterHeader (fields) {
				return fields.filter(function(field) {
					return typeof field.tableHead === 'undefined' 
						? false
						: true;
				});
			},
			printCellData (record, field) {
				if (typeof field.filterPrintData == 'undefined') {
					return record[field.name];
				}

				return field.filterPrintData( record[field.name] );
			},

			recordEditForm (record, status) {
				status = status || 'toggle';
				this.$store.commit( this.nameSpace + '/showHideEditForm', 
					{
						id: record.id,
						status: status
					} 
				);
			},

			selfUpdate (record) {
				
				var self = this,
					data = {};

				data['id']  = record.id;

				self.fields.forEach(function(field) {
					if ( !field.editable ) {
						return;
					}

					if (typeof field.filterEditingData != 'undefined') {
						data[field.name] = field.filterEditingData(record[field.name]);
					} else {
						data[field.name] = record[field.name];
					}
				});
				
				var args = {
					data: data,
					callback () {
						self.canSubmit = true;
						self.loading = false;
					}
				}

				if (!this.editFormValidation(self.fields, data)) {
					return false;
				}

				self.canSubmit = false;
				self.loading = true;
				
				this.updateRecord(args);
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
			}
		}
		
	}
</script>