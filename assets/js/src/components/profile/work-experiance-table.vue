<template>
	<div>
		<table class="wp-list-table widefat fixed striped pages">
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
	                    	<span class="trash"><a  href="#">Delete</a> </span>
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
                
                <tr v-else id="edit-8" class="inline-edit-row inline-edit-row-page quick-edit-row quick-edit-row-page inline-edit-page inline-editor" style="">
                	<td colspan="5" class="colspanchange">
                		<form action="" @submit.prevent="selfUpdate(record)">
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
											<hrm-date-picker placeholder="To" v-model="record.end"  class="pm-datepickter-to" dependency="pm-datepickter-to"></hrm-date-picker>
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
								<button @click.prevent="recordEditForm(record, false)" type="button" class="button cancel alignleft">Cancel</button>
								<input :disabled="!canSubmit" type="submit" class="button button-primary save alignright" value="Update">
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
		mixins: [HRMMixin.profile],
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
				this.$store.commit( 'profile/showHideEditForm', 
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

				self.canSubmit = false;
				self.loading = true;
				
				var args = {
					data: record,
					callback () {
						self.canSubmit = true;
						self.loading = false;
					}
				}
				
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
			}
		}
		
	}
</script>