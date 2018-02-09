<template>
	<div>
		<table class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                	<td v-if="deleteCheckbox" id="cb" class="manage-column column-cb check-column">
                		<input @change.prevent="deleteAll()" v-model="deleteAllStatus" id="cb-select-all-1" type="checkbox">
                	</td>
                    <th v-for="(header, header_index) in filterHeader(fields)" :key="header_index">
                    	{{ header.tableHead }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="" v-for="(record, record_index) in records" :key="record_index" v-if="!record.editMode">
                	<th v-if="deleteCheckbox" scope="row" class="check-column">			
						<input id="cb-select-7" @change="actionCheckbox()" v-model="deletedId" :value="record.id" type="checkbox">
					</th>
					
                    <td v-for="(field, field_index) in filterHeader(fields)">
                    	<span v-html="printCellData(record, field)"></span>
                    	<div v-if="field.tbRowAction" class="row-actions">
                    		<span class="edit"><a @click.prevent="recordEditForm(record)" href="#">Edit</a> | </span>
	                    	<span class="trash"><a @click.prevent="selfDelete(record)" href="#">Delete</a> </span>
	                    </div>
                    </td>
                </tr>
                
                <tr v-else id="edit-8" class="inline-edit-row inline-edit-row-page quick-edit-row quick-edit-row-page inline-edit-page inline-editor" style="">
                	<td :colspan="fields.length + 1" class="colspanchange">
                		<form action="" @submit.prevent="selfUpdate(record)">
							<fieldset class="inline-edit-col-left">
								<legend class="inline-edit-legend">Quick Edit</legend>
								<div class="inline-edit-col">
						
									<label v-for="(field, field_index) in filterEditField(fields)">
										<span class="title">{{ field.label }}</span>
										<span class="input-text-wrap">
											<hrm-edit-field :record="record" :field="field"></hrm-edit-field>
											<!-- <input type="text" v-model="record[field.name]" class="ptitle"> -->
										</span>
									</label>
								</div>
							</fieldset>

			
							<fieldset class="inline-edit-col-right">
								<div class="inline-edit-col"></div>
							</fieldset>

							<div class="submit inline-edit-save">
								<button @click.prevent="recordEditForm(record, false)" type="button" class="button cancel alignleft">Cancel</button>
								<input :disabled="!canSubmit" type="submit" class="button button-primary save alignright" value="Update">
								<div v-if="loading" class="hrm-spinner alignright"></div>
								<br class="clear">
							</div>
						</form>
					</td>
				</tr>

				<tr v-if="!records.length">
					<td :colspan="fields.length + 1">
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
		mixins: [HRMMixin.organization],	
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

				data['class']        = self.modelName;
				data['method']       = 'update';
				data['transformers'] = self.modelTransformer;
				data['id']           = record.id;

				self.canSubmit = false;
				self.loading = true;

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
					if (!hasRecords && self.pagination.total_pages > 1) {
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