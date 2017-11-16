<template>
	<div class="hrm-td-editble-wrap inline-edit-row">
		<form @submit.prevent="updateSelfHoliday()">
			<fieldset class="hrm-inline-edit-col-left">
				<legend class="inline-edit-legend">Quick Edit</legend>
				
				<div class="hrm-field-wrap">
					<label class="hrm-inline-edit-label">
						<span class="title">Name</span>
					</label>
					<div class="hrm-inline-edit-field">
						<span class="input-text-wrap">
							<input  type="text" v-model="holiday.name" name="post_title" class="ptitle hrm-input-width" value="">
						</span>
					</div>
				</div>

				<div class="hrm-field-wrap">
					<label class="hrm-inline-edit-label">
						<span class="title">Description</span>
					</label>
					<div class="hrm-inline-edit-field">
						<span class="input-text-wrap">
							<input  type="text" v-model="holiday.description" name="post_title" class="ptitle hrm-input-width" value="">
						</span>
					</div>
				</div>
			</fieldset>

			<p class="submit inline-edit-save">
				<button @click.prevent="showHideHolidayUpdateForm('toggle', holiday)" type="button" class="button cancel alignleft">Cancel</button>			
				<input type="submit" value="submit" class="button button-primary save alignright">
				<br class="clear">
			</p>
		</form>
	</div>
</template>

<script>

	export default {
		props: ['holiday'],

		methods: {
			updateSelfHoliday () {
				var args = {
            		data: {
            			id: this.holiday.id,
            			name: this.holiday.name,
            			description: this.holiday.description,
            		},
            		callback: function() {

            		}
            	}
            	this.updateHoliday(args);
			}
		}
	}
</script>

<style>
	.hrm-input-width {
		width: 50% !important;
	}
	.hrm-multiselect .multiselect {
		width: 50% !important;
	}
	.hrm-field-wrap {
		display: block;
		width: 100%;
	}
	.hrm-inline-edit-label, .hrm-inline-edit-field {
		float: left;
	}
	.hrm-inline-edit-label {
		width: 15%;
	}
	.hrm-inline-edit-field {
		width: 60%;
	}
	.hrm-field-wrap .title {
		width: 100% !important;
	}
	.hrm-field-wrap:after {
		visibility: hidden;
		display: block;
		font-size: 0;
		content: " ";
		clear: both;
		height: 0;
	}
</style>