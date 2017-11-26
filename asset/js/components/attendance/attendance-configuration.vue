<template>
	<div class="metabox-holder hrm-punch-in-out-wrap">
		<div class="postbox">

			<h2 class="hndle ui-sortable-handle">
				<span><?php _e( 'Attendance Configuration', 'hrm' ); ?></span>
			</h2>

			<div class="inside">
				<div class="hrm-attendance-configuration" id="hrm-hidden-form">
					<?php
						$field = array(
				            'label' => __( 'Enabale multiple attendance', 'hrm' ),
				            'desc' => __( 'Enable multiple attendance for per day', 'hrm' ),
				            'fields' => array(
				                array(
				                    'label'   => __( 'Enable', 'hrm' ),
				                    'checked' => '',
				                    'elements' => array(
				                    	'value'   => 'yes',
				                    	'id'      => 'hrm-multi-attendance-checkbox',
				                    	'v-model' => 'hrm_is_multi_attendance'
				                    )
				                )
				            ),
				        );

				        echo Hrm_Settings::getInstance()->new_checkbox_field( $field );

				        $field_obj = array(
							'label' =>  __( 'Office start time', 'hrm' ),
							'field_elements' => array(
								'v-hrm-datepicker',
								':value' => 'office_start_with_date_time',
								'class'  => 'hrm-date-time-picker-from',
								'id'     => 'hrm-office-start-date-field',
							)
						);

						echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

						$field_obj = array(
							'label' =>  __( 'Office closing time', 'hrm' ),
							'field_elements' => array(
								'v-hrm-datepicker',
								':value' => 'office_closed_with_date_time',
								'class'  => 'hrm-date-time-picker-to',
								'id'     => 'hrm-office-closed-date-field',
							)
						);

						echo Hrm_Settings::getInstance()->new_text_field( $field_obj );

						$allow_ip = array(
							'label' => __( 'Allow IP', 'hrm' ),
							'desc'  => __( 'Employee can puch in/out only from this IP', 'hrm' ),
							'field_elements' => array(
							    'type'  => 'textarea',
							    'value' => '',
							    'placeholder' => 'IP seperated by pipe "|"',
							    'v-model' => 'allow_ip'
							)
						);

						echo Hrm_Settings::getInstance()->new_textarea_field( $allow_ip );
					?>
					<input @click.prevent="saveConfiguration()" type="submit" class="button hrm-submit-button button-primary" name="requst" value="<?php _e( 'Save changes', 'hrm' ); ?>">
				</div>

			</div>
		</div>
	</div>
</template>

<script>
	export default {
		mixins: [HRM_Common_Mixin],
	
		data: function() {
			return {
				
			}
		},

		computed: {
			office_start_with_date_time: function() {
				return this.$store.state.office_start_with_date_time;
			},

			office_closed_with_date_time: function() {
				return this.$store.state.office_closed_with_date_time;
			},
			hrm_is_multi_attendance: {
				get: function() {
					return this.$store.state.hrm_is_multi_attendance;
				},

				set: function(val) {
					this.$store.commit('setMultiAttendance', val);
				}
			},

			allow_ip: {
				get: function() {
					return this.$store.state.allow_ip;
				},
				
				set: function(val) {
					this.$store.commit('setAllowIP', val);
				}
			}
		},

		created: function() {
			
			this.attendanceInit();
			this.$on('hrm_date_picker', this.setDateTime);
		},
		methods: {
			attendanceInit: function() {
				var request_data = {
					_wpnonce: HRM_Vars.nonce,
				},
				self  = this;

				wp.ajax.send( 'attendance_init', {
	                data: request_data,
	                success: function(res) {
	      				self.$store.commit( 'setInitVal', res );
	                },

	                error: function(res) {
	                	
	                }
	            });
			},
			setDateTime: function(date_time) {

				if( date_time.field == 'datetimepicker_from' ) {
					//this.office_start = date_time.date_time;
					this.$store.commit( 'office_start', date_time );
				}

				if( date_time.field == 'datetimepicker_to' ) {
					//this.office_closed = date_time.date_time;
					this.$store.commit( 'office_closed', date_time );
				}
			},
			saveConfiguration: function() {
				var request_data = {
						_wpnonce: HRM_Vars.nonce,
						hrm_is_multi_attendance: this.hrm_is_multi_attendance,
						office_start: this.$store.state.office_start_with_date_time,
						office_closed: this.$store.state.office_closed_with_date_time,
						allow_ip: this.$store.state.allow_ip

					},
					self = this;
				
				this.punch_in = 'disable';
				
				wp.ajax.send('attendance_configuration', {
	                data: request_data,
	                success: function(res) {
	                	// Display a success toast, with a title
	                    toastr.success(res.success);
	                    
	                    self.$store.commit( 'setAttendance', {records: res.attendance} );
	                },

	                error: function(res) {
	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        toastr.error(value);
	                    });
	                }
	            });
			}
		}
	}
</script>

<!-- 
var hrm_attendace_configuration = {
	template: '#tmpl-hrm-attendance-configuration',
	
	mixins: [HRM_Common_Mixin],
	
	data: function() {
		return {
			
		}
	},

	computed: {
		office_start_with_date_time: function() {
			return this.$store.state.office_start_with_date_time;
		},

		office_closed_with_date_time: function() {
			return this.$store.state.office_closed_with_date_time;
		},
		hrm_is_multi_attendance: {
			get: function() {
				return this.$store.state.hrm_is_multi_attendance;
			},

			set: function(val) {
				this.$store.commit('setMultiAttendance', val);
			}
		},

		allow_ip: {
			get: function() {
				return this.$store.state.allow_ip;
			},
			
			set: function(val) {
				this.$store.commit('setAllowIP', val);
			}
		}
	},

	created: function() {
		
		this.attendanceInit();
		this.$on('hrm_date_picker', this.setDateTime);
	},
	methods: {
		attendanceInit: function() {
			var request_data = {
				_wpnonce: HRM_Vars.nonce,
			},
			self  = this;

			wp.ajax.send( 'attendance_init', {
                data: request_data,
                success: function(res) {
      				self.$store.commit( 'setInitVal', res );
                },

                error: function(res) {
                	
                }
            });
		},
		setDateTime: function(date_time) {

			if( date_time.field == 'datetimepicker_from' ) {
				//this.office_start = date_time.date_time;
				this.$store.commit( 'office_start', date_time );
			}

			if( date_time.field == 'datetimepicker_to' ) {
				//this.office_closed = date_time.date_time;
				this.$store.commit( 'office_closed', date_time );
			}
		},
		saveConfiguration: function() {
			var request_data = {
					_wpnonce: HRM_Vars.nonce,
					hrm_is_multi_attendance: this.hrm_is_multi_attendance,
					office_start: this.$store.state.office_start_with_date_time,
					office_closed: this.$store.state.office_closed_with_date_time,
					allow_ip: this.$store.state.allow_ip

				},
				self = this;
			
			this.punch_in = 'disable';
			
			wp.ajax.send('attendance_configuration', {
                data: request_data,
                success: function(res) {
                	// Display a success toast, with a title
                    toastr.success(res.success);
                    
                    self.$store.commit( 'setAttendance', {records: res.attendance} );
                },

                error: function(res) {
                	// Showing error
                    res.error.map( function( value, index ) {
                        toastr.error(value);
                    });
                }
            });
		}
	}
}; -->