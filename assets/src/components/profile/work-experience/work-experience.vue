<template>
	<div>
		<h1 class="wp-heading-inline">Work Experience</h1>
		<a v-if="hasProfileEditPermission()" @click.prevent="showHideNewRecordForm('toggle')" class="page-title-action">Add New</a>

		<profile-menu></profile-menu>

		<add-new-record-form class="hrm-toggle" v-if="isNewRecordFormActive" :fields="fields"></add-new-record-form>

	    <div class="hrm-tbl-action-wrap">
			<div v-if="hasProfileEditPermission()" class="hrm-table-action hrm-bulk-wrap">
				<label for="bulk-action-selector-top" class="screen-reader-text">
					Select bulk action
				</label>
				<select v-model="bulkAction" name="action" id="bulk-action-selector-top">
					<option value="-1">Bulk Actions</option>
					<option value="delete">Delete</option>
				</select>
				<a href="#" @click.prevent="selfBulkAction()" class="button hrm-button-secondary button-secondary">Apply</a>
			</div>

			<div class="hrm-table-action hrm-filter-wrap">
				<div class="alignleft actions">
					<form @submit.prevent="recordSearch()">
						<input v-model="search.title" placeholder="Title" type="text">
						<hrm-date-picker placeholder="From" v-model="search.from"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
						<hrm-date-picker placeholder="To" v-model="search.to" class="pm-datepickter-from" dependency="pm-datepickter-to"></hrm-date-picker>
						<input type="submit" class="button hrm-button-secondary button-secondary" value="Filter">
					</form>
				</div>

			</div>
			<div class="hrm-clear"></div>
		</div>
		
	    <hrm-table :fields="fields"></hrm-table>

	    <hrm-pagination 
            :total_pages="pagination.total_pages" 
            component_name='work_experiance_pagination'>
            
        </hrm-pagination> 

	</div>
</template>

<style>
	.hrm-bulk-wrap, .hrm-filter-wrap {
		float: left;
	}
	.hrm-tbl-action-wrap {
		margin-top: 20px;
	}
</style>

<script>
	import Table from './work-experience-table.vue';
	import Form from './new-work-experience-form.vue';
	import Mixin from './mixin'
	import MainMixin from '@components/profile/mixin'

	export default {
		data () {

			return {
				search: {
					filter: 'active',
					title: this.$route.query.title,
					from: this.$route.query.from,
					to: this.$route.query.to
				},
				bulkAction: -1,
				fields: [
					{
						type: 'text',
						model: '',
						label: 'Title',
						name: 'title',
						required: true
					},
					{
						type: 'datePickerFrom',
						model: '',
						label: 'From',
						name: 'start',
						required: true
					},
					{
						type: 'datePickerTo',
						model: '',
						label: 'To',
						name: 'end',
						required: true
					},
					{
						type: 'textarea',
						model: '',
						label: 'Description',
						name: 'description'
					}
				]
			}
		},
		mixins: [MainMixin, Mixin],
	

		computed: {
			isNewRecordFormActive () {
				return this.$store.state[this.nameSpace].isNewRecordFormActive;
			},

            total_experiance_page () {
                return 10;
            },

            pagination () {
            	return this.$store.state[this.nameSpace].pagination;
            }
		},
		components: {
			'hrm-table': Table,
			'add-new-record-form': Form
		},

		methods: {

			selfBulkAction () {
				var self = this;
				switch( this.bulkAction) {
					case 'delete':
						this.recordDelete(self.$store.state[self.nameSpace].deletedId, function() {
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
						});
						break;

					default:

						break;
				}
			},

			recordSearch () {
				this.$router.push({query: this.search});
				this.getRecords();
			}
		}
	}
</script>