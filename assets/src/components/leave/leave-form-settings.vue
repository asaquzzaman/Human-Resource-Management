<template>
	<div>
		<leave-header></leave-header>
		<div class="metabox-holder hrm-punch-in-out-wrap">
			<div class="postbox">

				<h2 class="hndle ui-sortable-handle">
					<span>Leave Form Settings</span>
				</h2>

				<div class="inside">
					<div class="hrm-attendance-configuration" id="hrm-hidden-form">
						<form id="hrm-leave-form-setting" action="" @submit.prevent="saveLeaveFormSettings()">
							<div v-if="false" class="hrm-form-field">
								<label>
									Others employee 
									<em></em>
								</label>
								<div class="hrm-multiselect">

							        <hrm-multiselect 
							            v-model="others_employee" 
							            :options="roles" 
							            :multiple="true" 
							            :close-on-select="true"
							            :clear-on-select="true"
							            :hide-selected="false"
							            :show-labels="true"
							            placeholder="Select roles"
							            select-label=""
							            selected-label="selected"
							            deselect-label=""
							            :taggable="false"
							            label="name"
							            track-by="id"
							            :allow-empty="true">

							        </hrm-multiselect>               
							    </div>
							    <span class="hrm-clear"></span>
							    <span class="description">This roles can aplly behalf of others employee leave</span>
							</div>

							<div class="hrm-form-field">
								<label>
									Leave type  
									<em></em>
								</label>
								<div class="hrm-multiselect">

							        <hrm-multiselect 
							            v-model="leave_types" 
							            :options="roles" 
							            :multiple="true" 
							            :close-on-select="true"
							            :clear-on-select="true"
							            :hide-selected="false"
							            :show-labels="true"
							            placeholder="Select roles"
							            select-label=""
							            selected-label="selected"
							            deselect-label=""
							            :taggable="false"
							            label="name"
							            track-by="id"
							            :allow-empty="true">

							        </hrm-multiselect>               
							    </div>
							    <span class="hrm-clear"></span>
							    <span class="description">This roles can aplly leave type enable/disable option</span>
							</div>

							<div v-if="false" class="hrm-form-field">
								<label>
									Leave request approve by 
									<em></em>
								</label>
								<div class="hrm-multiselect">

							        <hrm-multiselect 
							            v-model="apply_to" 
							            :options="roles" 
							            :multiple="true" 
							            :close-on-select="true"
							            :clear-on-select="true"
							            :hide-selected="false"
							            :show-labels="true"
							            placeholder="Select roles"
							            select-label=""
							            selected-label="selected"
							            deselect-label=""
							            :taggable="false"
							            label="name"
							            track-by="id"
							            :allow-empty="true">

							        </hrm-multiselect>               
							    </div>
							    <span class="hrm-clear"></span>
							    <span class="description">This roles can change leave status</span>
							</div>
							<input  type="submit" class="button button-primary  hrm-button-primary" name="requst" value="Save changes">
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<style>
	#hrm-hidden-form span {
		display: block !important;
	}
	.multiselect__tags {
		display: inline-block !important;
		width: 100%;
	}
	.multiselect__input {
		border: none !important;
		box-shadow: none !important;
	}

</style>


<script>
	import leave_header from './leave-header.vue';
    import Mixin from './mixin'
	
	export default {
		beforeRouteEnter (to, form, next) {
			next (vm => {
				vm.getLeaveFromSettings();
			});
		},
		data () {
			return {
				others_employee: [],
				leave_types: [],
				apply_to: [],
				roles: []
			}
		},
		mixins: [Mixin],
		components: {
			'hrm-multiselect': hrm.Multiselect,
			'leave-header': leave_header
		},

		methods: {
			getLeaveFromSettings () {
				var self = this;
				var request = {
					data: {},
					success (res) {
						self.roles = self.processRoles(res.roles);
						//self.others_employee = self.processOthersEmployee(res.settings, res.roles);
						self.leave_types = self.processLeaveTypes(res.settings, res.roles);
						//self.apply_to = self.processApplyTo(res.settings, res.roles);
					}
				}
				this.httpRequest('get_leave_form_settings', request);
			},

			processApplyTo (settings, roles) {
				if (typeof settings.apply_to === 'undefined') {
					return [];
				}

				var apply_to = [];

				jQuery.each(roles, function(id, name) {
					if ( settings.apply_to.indexOf(id) !== -1 ) {
						apply_to.push({
							id: id,
							name: name
						});
					}
				});

				return apply_to;
			},

			processOthersEmployee (settings, roles) {
				if (typeof settings.others_employee_leave === 'undefined') {
					return [];
				}

				var others_employee_leave = [];

				jQuery.each(roles, function(id, name) {
					if ( settings.others_employee_leave.indexOf(id) !== -1 ) {
						others_employee_leave.push({
							id: id,
							name: name
						});
					}
				});

				return others_employee_leave;
			},

			saveLeaveFormSettings () {
				var self = this;
				var request = {
					data: {
						others_employee_leave: self.others_employee,
						leave_types: self.leave_types,
						apply_to: self.apply_to
					},
					beforeSend () {
						self.loadingStart(
							'hrm-leave-form-setting',
							{animationClass: 'preloader-update-animation'}
						);
					},
					success (res) {
						self.loadingStop('hrm-leave-form-setting');
						hrm.Toastr.success('Update successfully!');
					}
				}
				this.httpRequest('save_leave_form_settings', request);
			}
		}
	}	
</script>
