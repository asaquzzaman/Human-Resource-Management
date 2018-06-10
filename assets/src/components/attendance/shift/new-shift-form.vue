<template>
	<div class="metabox-holder">
		<div id="hrm-hidden-form-warp" class="postbox">
	        
	        <h2 class="hndle">Time Shift</h2>
	        <div class="inside">
		        <form id="hrm-hidden-form" action="" @submit.prevent="selfNewRecord()">
		            <div id="hrm-form-field">
				    	
				    	<div class="hrm-field-sets">
				    		<div class="hrm-field-set-title">Shift Details</div>
				    		<div class="hrm-field-set-content">

				    			<div class="hrm-form-field-wrap">
					                <div>
					                    <label for="title">
					                        Shift Name<em>*</em>
					                    </label>
					                    <input type="text" v-model="shift.name"  required="required"> 
					                    <span class="hrm-clear"></span> 
					                    <span class="description"></span>
					                </div>
					            </div>

					    		<div class="hrm-form-field-wrap">
					                <div>
					                    <label for="title">
					                        Punch Start Time <em>*</em>
					                    </label>
					                    <input type="text" @blur="checkTimeValidation()" placeholder="08:00" v-model="shift.start" required="required">
					                    <span class="hrm-clear"></span> 
					                    <span class="description">24 Hour Format</span>
					                </div>
					            </div>

					            <div class="hrm-form-field-wrap">
					                <div>
					                    <label for="title">
					                        Active
					                    </label>
					                    <input type="checkbox" v-model="shift.status"> 
					                    <span class="hrm-clear"></span> 
					                    <span class="description"></span>
					                </div>
					            </div>

					            <div class="hrm-form-field-wrap hrm-shirft-mtsl">
		                            <label>Department<em>*</em></label>
		                            
		                            
		                            <div class="hrm-multiselect">
										<hrm-multiselect 
										    v-model="shift.departments.data" 
										    :options="deptDropDown" 
										    :multiple="true" 
										    :close-on-select="true"
										    :clear-on-select="true"
										    :hide-selected="false"
										    :show-labels="true"
										    placeholder="Select Department"
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
		                            <span class="description">Choose Parent Department</span>
		                        </div>
					            
					            <span class="hrm-clear"></span>
				            </div> 
				    	</div>






				    	<div class="hrm-field-sets">
				    		<div class="hrm-field-set-title">Timing Details</div>

				    		<div v-for="(time, index) in shift.times" :key="'time_'+index" class="hrm-field-set-content hrm-add-more-content">
				    			<div class="hrm-time-left">
					    			<div class="hrm-time-form-field-wrap">
						                <div>
						                    <label for="title">
						                        Shift Begin <em>*</em>
						                    </label>
						                    <input type="text" @blur="checkTimeValidation(time)" placeholder="10:00" v-model="time.begin" required="required">
						                    
						                    <span class="hrm-clear"></span> 
						                    <span class="description">24 Hour Format</span>
						                </div>
						            </div>

						            <div class="hrm-time-form-field-wrap">
						                <div>
						                    <label for="title">
						                        Shift Duration
						                    </label>
						                    <input disabled="disabled" class="hrm-shift-time-hour" :value="shiftDurationHours(time.begin, time.end)"  type="text">Hour
						                    <input disabled="disabled" class="hrm-shift-time-minute" :value="shiftDurationMinutes(time.begin, time.end)" type="text">Minute
						                    
						                    <span class="hrm-clear"></span> 
						                    <span class="description"></span>
						                </div>
						              
						            </div>
					        	</div>

					        	<div class="hrm-time-left">
						    		<div class="hrm-time-form-field-wrap">
						                <div>
						                    <label for="title">
						                        Shift End <em>*</em>
						                    </label>
						                    <input type="text" @blur="checkTimeValidation(time)" placeholder="18:00" v-model="time.end" required="required">
						                    <span class="hrm-clear"></span> 
						                    <span class="description">24 Hour Format</span>
						                </div>
						            </div>

						            <div class="hrm-time-form-field-wrap">
						                <div>
						                    <label for="title">
						                        Work Duration
						                    </label>
						                    <input @blur="checkTimeValidation()" class="hrm-shift-time-hour" required="required" step="1" v-model="time.workHours" min="0" type="number">Hour
						                    <input @blur="checkTimeValidation()" class="hrm-shift-time-minute" required="required" step="1"  min="0" v-model="time.workMinutes" type="number">Minute
						                    
						                    <span class="hrm-clear"></span> 
						                    <span class="description"></span>
						                </div>
						              
						            </div>
					        	</div>
					        	<span class="hrm-clear"></span>





						        <div class="hrm-time-form-field-wrap hrm-break-applicable">
					    			<input class="hrm-break-applicable-field" type="checkbox" v-model="time.breakStatus">
					    			<label for="hrm-break-applicable">Break Applicable</label>
					    			<a v-if="time.breakStatus" class="hrm-more-break-btn"  href="#" @click.prevent="moreBreak(time)" v-html="'&#43; Add More Break'"></a>
					    			<span class="hrm-clear"></span>
					    		</div>

					    		<div v-if="time.breakStatus">
					    			<div class="hrm-break-wrap" v-for="(rest, restIndex) in time.breaks" :key="'break_'+restIndex">
							    		<div class="hrm-time-left">
							    			<div class="hrm-time-form-field-wrap">
								                <div>
								                    <label for="title">
								                        Break Begin <em>*</em>
								                    </label> 
								                    <input required="required" @blur="checkTimeValidation()"  placeholder="13:00" v-model="rest.breakBeing" type="text">
								                    <span class="hrm-clear"></span> 
								                    <span class="description">24 Hour Format</span>
								                </div>
								            </div>

								            <div class="hrm-time-form-field-wrap">
								                <div>
								                    <label for="title">
								                        Break Duration
								                    </label>
								                    <input disabled="disabled" class="hrm-shift-time-hour" :value="breakDurationHours(rest)"   type="text">Hour
								                    <input disabled="disabled" class="hrm-shift-time-minute" :value="breakDurationMinutes(rest)"  type="text">Minute
								                    
								                    <span class="hrm-clear"></span> 
								                    <span class="description"></span>
								                </div>
								              
								            </div>

							        	</div>

							        	<div class="hrm-time-left">
								    		<div class="hrm-time-form-field-wrap">
								                <div>
								                    <label for="title">
								                        Break End <em>*</em>
								                    </label>
								                    <input required="required" @blur="checkTimeValidation()" placeholder="14:00" v-model="rest.breakEnd" type="text">
								                    <span class="hrm-clear"></span> 
								                    <span class="description">24 Hour Format</span> 
								                </div>
								            </div>
							        	</div>
							        	<span class="hrm-clear"></span>
							        	<a class="hrm-remove-break" v-if="time.breaks.length>1" @click.prevent="removeBreak(time.breaks, restIndex)" href="#">Remove Break</a>
						        	</div>
						        	
					        	</div>

					            <span class="hrm-clear"></span>
					        	<a v-if="shift.times.length > 1" @click.prevent="deleteTime(index)" href="#" class="button hrm-button-secondary button-secondary hrm-time-del-btn">Delete</a>
					        	<span class="hrm-clear"></span>

				            </div> 
					        <a @click.prevent="addMoreTime()" href="#" class="hrm-shift-add-more" v-html="'Add More Shift &#43;'"></a>

				    	</div>


				    </div>

		            <div class="hrm-action-wrap">
		                <input :disabled="!canSubmit" type="submit" class="button hrm-button-primary button-primary" name="requst" value="Submit">
		                
		                <a v-if="shift.id" @click.prevent="recordEditForm(shift, false)"  target="_blank" href="#" class="button hrm-button-secondary">Cancel</a>
		                <a v-if="!shift.id" @click.prevent="showHideNewRecordForm(false)"  target="_blank" href="#" class="button hrm-button-secondary">Cancel</a>
		                <div class="hrm-spinner" v-if="loading">Saving....</div>
		            </div>
		        </form>
	    	</div>
	    </div>
	</div>
</template>

<style>
	.hrm-shirft-mtsl .hrm-multiselect {
		float: left;
	}
	.hrm-time-left {
		float: left;
		width: 50%;
	}
	.hrm-shift-time-hour,
	.hrm-shift-time-minute {
		float: none !important;
		width: 45px !important;
	}
	.hrm-break-applicable-field {
		float: none !important;
	}
	.hrm-field-sets .hrm-time-form-field-wrap {
		margin-bottom: 5px;
	}
	.hrm-break-applicable {
		margin-top: 30px;
		margin-bottom: 10px !important;
	}

	.hrm-field-sets label {
		width: 25% !important;
	}
	.hrm-field-sets .description {
		margin-left: 25% !important;
	}
	.hrm-break-applicable label {
		width: 12.5% !important;
	}
	.hrm-shift-add-more {
		margin: 10px !important;
		text-decoration: none;
		display: inline-block;
	}

	.hrm-add-more-content:nth-child(2n+1) {
		background: #f9f9f9;
		border-bottom: 1px solid #eee;
	}
	.hrm-more-break-btn {
		text-decoration: none;
		margin-left: 5px;
	}
	.hrm-break-wrap {
		margin-bottom: 10px;
	}
	.hrm-time-del-btn {
		float: right;
	}

</style>

<script>
	import Mixin from './mixin'

	export default {
		mixins: [Mixin],
		props: {
			shift: {
				type: [Object],
				default () {
					return {
						start: '',
						name: '',
						status: true,
						departments: {
							data: []
						},
						times: [
							{
								begin: '',
								end: '',
								workHours: '',
								workMinutes: '',
								breakStatus: false,
								breaks: [
									{
										breakBeing: '',
										breakEnd: '',
										breakHours: '',
										breakMinutes: '',
									}
								]
								
							}
						]
					}
				}
			}
		},

		data () {
			return {
				loading: false,
				canSubmit: true,
			}
		},

		created () {
			this.getDepartments({
				data: {}
			});

			if(this.shift.id) {
				this.filterUpdated(this.shift);
			}
			
		},

		computed: {
			deptDropDown: function() {
                return this.$store.state.departments.departments;  
            }
		},

		components: {
			'hrm-multiselect': hrm.Multiselect
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
			filterUpdated (shift) {

				var shiftEnd = new Date(shift.puch_start);
				shift.start = hrm.Moment(shiftEnd).format("kk:mm");
				
			},
			checkValidTime (time, key) {
				if(!time) {
					return;
				}
				var isValidTime = hrm.Moment(time, "k:m", true).isValid();

				if(!isValidTime) {
					this.shift[key] = '';
					hrm.Toastr.error('Please insert valid time!');
				}
			},

			validateBreakDuration (shift_begin,  shift_end, break_begin, break_end, shift_work_hours, shift_work_minutes) {
				var shift_vaid = this.getDurationHourMinute(shift_begin, shift_end);
				shift_work_minutes = parseInt(shift_work_minutes) ? shift_work_minutes : 0;

				if(!shift_vaid) {
					return {
						status: false,
						error: 'Shift duration is not valid'
					};
				}

				var break_vaid = this.getDurationHourMinute(break_begin, break_end);

				if(!break_vaid) {
					return {
						status: false,
						error: 'Break duration is not valid'
					};
				}

				var shiftEnd = new Date(this.currentDate()+','+shift_end);
	            var breakEnd   = new Date(this.currentDate()+','+break_end);

	            var breakRange = hrm.Moment(breakEnd).isAfter(hrm.Moment(shiftEnd));
	            var sameBreakRange = hrm.Moment(breakEnd).isSame(hrm.Moment(shiftEnd));
	            
	            if(breakRange || sameBreakRange) {
	            	return {
						status: false,
						error: 'Break duration is not valid'
					}
	            }


				var totalShiftMinutes = (parseInt(shift_work_hours) * 60) + parseInt(shift_work_minutes);
				var totalBreakMinutes = (parseInt(break_vaid.hours) * 60) + parseInt(break_vaid.minutes);

				if( totalShiftMinutes <= totalBreakMinutes ) {
					return {
						status: false,
						error: 'Break duration is not valid'
					};
				}

	            return {
	            	status: true
	            }

			},

			selfNewRecord () {
				var self = this;

				if (!this.canSubmit) {
					//return false;
				}
				
				var postData = this.generateFieldData();

				postData['class']        = self.modelName;
				postData['method']       = 'create';
				postData['transformers'] = self.modelTransformer;

				// if (!this.selfFormValidation()) {
				// 	return false;
				// }	

				var args = {
					data: postData,

					callback (success, res) {
						self.loading = false;
						self.canSubmit = true;
						
						if(success) {
							self.showHideNewRecordForm(false);
							//self.makeEmptyField(self.fields);
						}
					}
				}
				
				//self.loading = true;
				//self.canSubmit = false;
				if(this.shift.id) {
					args.data.method = 'update';
					args.data.id = this.shift.id;
					this.updateRecord(args);
				} else {
					this.addNewRecord(args);
				}
				
			},

			generateFieldData () {
				var formated = {
					name: this.shift.name,
					puch_start: this.shift.start,
					status: this.shift.status ? 1 : 0,
					departments: this.filterDepartmentId(this.shift.departments.data),
					times: this.shift.times
				};

				return formated;

			},

			filterDepartmentId (departments) {
				var filter = [];

				departments.forEach(function(department) {
					filter.push(department.id);
				});

				return filter; 
			},


			selfFormValidation () {

				if(!this.shift.name.trim()) {
					hrm.Toastr.error('Shift name required');
					return false;
				}

				if(!this.shift.departments.length) {
					hrm.Toastr.error('Department required');
					return false;
				}

				var validate = this.validation();

				if(typeof validate.status != 'undefined' && validate.status === false) {
					hrm.Toastr.error(validate.error);
					return false;
				}

				return true;
			},

			makeEmptyField (data) {
				data.forEach(function(val) {
					val.model = '';
				});
			},

			shiftDurationHours (begin, end) {
				if(begin.trim() && begin.trim()) {
					let duration = this.getDurationHourMinute(begin, end);
					return duration.hours;
				} 

				return '';
			},

			shiftDurationMinutes (begin, end) {
				if(begin.trim() && end.trim()) {
					let duration = this.getDurationHourMinute(begin, end);
					return duration.minutes;
				} 

				return '';
			},

			addMoreTime () {
				this.shift.times.push({
					begin: '',
					end: '',
					workHours: '',
					workMinutes: '',
					breakStatus: false,
					breaks: [
						{
							breakBeing: '',
							breakEnd: '',
							breakHours: '',
							breakMinutes: '',
						}
					]
					
				});
			},

			deleteTime (index) {
				this.shift.times.splice(index, 1);
			},

			breakDurationHours (time) {
				if(!time.breakBeing || !time.breakEnd) {
					return '';
				}

				if(time.breakBeing.trim() && time.breakEnd.trim()) {
					let duration = this.getDurationHourMinute(time.breakBeing, time.breakEnd);
					time.breakHours = duration.hours;
					return duration.hours;
				} 

				return '';
			},

			breakDurationMinutes (time) {
				if(!time.breakBeing || !time.breakEnd) {
					return '';
				}

				if(time.breakBeing.trim() && time.breakEnd.trim()) {
					let duration = this.getDurationHourMinute(time.breakBeing, time.breakEnd);
					time.breakMinutes = duration.minutes;
					return duration.minutes;
				} 

				return '';
			},

			checkTimeValidation () {
				var validate = this.validation();

				if(typeof validate.status != 'undefined' && validate.status === false) {
					hrm.Toastr.error(validate.error);
					return false;
				}
			},

			validation () {
				return;
				var self = this;

				if(!this.shift.start.trim()) {
					return {
						status: false,
						error: 'Please at first insert the punch start time'
					}
				}
				var isValidTime = hrm.Moment(this.shift.start, "k:m", true).isValid();

				if(!isValidTime) {
					return {
						status: false,
						error: 'Punch statr time is not valid'
					}
				}

				var error_log = [];
				var totalShiftHours = 0;
				var totalShiftMinutes = 0;
				
				//Total time duration should be less than or equal 24 hours 
				this.shift.times.forEach(function(time) {
					if(time.begin.trim() && time.end.trim()) {
						var validTime = self.getDurationHourMinute(time.begin, time.end);
						
						if(validTime) {

							totalShiftHours = parseInt(totalShiftHours) + parseInt(validTime.hours);
							totalShiftMinutes = parseInt(totalShiftMinutes) + parseInt(validTime.minutes);
						}
					}
				});

				if(totalShiftHours > 24 ) {
					error_log.push({
						status: false,
						error: 'Total shift hour less than or equal 24 hours'
					});
				}
					
				if (totalShiftHours >= 24 && totalShiftMinutes > 0) {
					error_log.push({
						status: false,
						error: 'Total shift hour less than or equal 24 hours'
					});
				}

				this.shift.times.forEach(function(time) {


					if(time.begin.trim() && time.end.trim()) {

						// Checking shift duration validity
						let isValidBeing = hrm.Moment(time.begin.trim(), "k:m", true).isValid();
						let isValidEnd = hrm.Moment(time.end.trim(), "k:m", true).isValid();
						
						if(!isValidBeing || !isValidEnd) {
							error_log.push({
								status: false,
								error: 'Shift duration is not valid'
							});

							return;
						}

						//Shift duration shoul be greater than or less than punch start time
						let begin = new Date(self.currentDate()+','+time.begin);
			            let end   = new Date(self.currentDate()+','+time.end);
			            let start = new Date(self.currentDate()+','+self.shift.start);

			            begin = hrm.Moment(begin);
			            end   = hrm.Moment(end);
			            start = hrm.Moment(start);

			            //Is end less than begin
            			var isafter = moment(end).isAfter(begin);

            			//If end less than begin
			            if(!isafter) {
			                var end24 = new Date(self.currentDate()+','+'24:00');
			                    end24 = hrm.Moment(end24);
			                
			                let isBetween1 = hrm.Moment(start).isBetween(begin, end24);

			                if(isBetween1) {
				            	error_log.push({
									status: false,
									error: 'Shift duration should be greater or less than punch start time'
								});
				            }

				            var beign24 = new Date(self.currentDate()+','+'1:00');
			                    beign24 = hrm.Moment(beign24);

				            let isBetween2 = hrm.Moment(start).isBetween(beign24, end);

				            if(isBetween2) {
				            	error_log.push({
									status: false,
									error: 'Shift duration should be greater or less than punch start time'
								});
				            }
			            }
			            
			            

			            let isBetween3 = hrm.Moment(start).isBetween(begin, end);

			            if(isBetween3) {
			            	error_log.push({
								status: false,
								error: 'Shift duration should be greater or less than punch start time'
							});
			            }


			            //Work hour validate
			            if(time.workHours.trim()) {
			            	let work = self.workDurationValidation(time.begin, time.end, time.workHours, time.workMinutes);

			            	if(work.status === false) {
			            		error_log.push(work);
			            	}
			            }

			            //is Break active
			            if(time.breakStatus) {
			            	if(time.breakBeing.trim() && time.breakEnd.trim()) {
			            		//Check break duration validity
			            		var breakDuration = self.getDurationHourMinute(time.breakBeing, time.breakEnd);
			            		if(!breakDuration) {
			            			error_log.push({
										status: false,
										error: 'Break duration is not valid'
									});
			            		}

			            		let valBreakDuration = self.validateBreakDuration(time.begin, time.end, time.breakBeing, time.breakEnd, time.workHours, time.workMinutes);

			            		if(!valBreakDuration.status) {
			            			error_log.push(valBreakDuration);
			            		}
			            	}
			            }
					}
				});

				if(error_log.length) {
					return error_log[0];
				}

				return {
					status: true
				}
			},

			moreBreak (time) {
				time.breaks.push({
					breakBeing: '',
					breakEnd: '',
					breakHours: '',
					breakMinutes: '',
				});
			},

			removeBreak (breaks, index) {
				breaks.splice(index, 1);
			}

		}
	}
</script>