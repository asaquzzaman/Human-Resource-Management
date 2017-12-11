<template>
	<div class="metabox-holder hrm-punch-in-out-wrap">
		<div class="postbox">

			<h2 class="hndle ui-sortable-handle">
				<span>Punch in/out</span>
			</h2>

			<div class="inside">
				<div class="main hrm-punch-in-out-main">
					<div class="hrm-clock-wrap">
						<strong>
							<time><i class="fa fa-calendar" aria-hidden="true"></i> {{ currentDate() }}</time>
						</strong>
						<strong>
							<time><i class="fa fa-clock-o" aria-hidden="true"></i> <clock></clock></time>
						</strong>
					</div>
					
					<button :disabled="isDisabled()" class="button button-primary" @click.prevent="punchIn()">Punch In</button>
					<button :disabled="punch_out_disable" class="button button-secondary" @click.prevent="punchOut()">Punch Out</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Clock from './../common/clock.vue';

	export default {
		mixins: [HRMMixin.attendance],
		data: function() {
			return {
				press_punch_in_btn: false,
				press_punch_our_btn: false,
				punch_out_disable: false,
				punch_id: 0,
			}
		},
		created () {

		},
		components: {
			'clock': Clock
		},
		methods: {
			punchIn: function() {

				//for preventing multipule submit
				if ( this.press_punch_in_btn ) {
					return false;
				}

				//for preventing multipule submit
				this.press_punch_in_btn = true;

				var request_data = {
						_wpnonce: HRM_Vars.nonce,
					},
					self = this;
				
				wp.ajax.send('punch_in', {
	                data: request_data,
	                success: function(res) {
	                	// Display a success toast, with a title
	                    toastr.success(res.success);
	                    //self.punch_id = res.punch_id;
	                    //self.punch_id = res.punch_in_status;

	                    self.$store.commit( 'attendance/setAttendance', {records: res.attendance} );
	                    self.$store.commit( 'attendance/punch_in', { status: 'disable' } );

	                    //for preventing multipule submit
	                    self.press_punch_in_btn = false;
	                },

	                error: function(res) {
	                	//for preventing multipule submit
	                    self.press_punch_in_btn = false;
	                	
	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        toastr.error(value);
	                    });
	                }
	            });
			},

			punchOut: function() {
				//for preventing multipule submit
				if ( this.press_punch_our_btn ) {
					return false;
				}

				//for preventing multipule submit
				this.press_punch_our_btn = true;

				var request_data = {
						_wpnonce: HRM_Vars.nonce,
					},
					self = this;

				self.punch_out_disable = true;
				
				wp.ajax.send('punch_out', {
	                data: request_data,
	                success: function(res) {
	                	// Display a success toast, with a title
	                    toastr.success(res.success);
						self.punch_out_disable = false;

						self.$store.commit( 'attendance/setAttendance', {records: res.attendance} );
	                    self.$store.commit( 'attendance/punch_in', { status: res.punch_in_status } );

	                    //for preventing multipule submit
						self.press_punch_our_btn = false;
	                },

	                error: function(res) {
	                	self.punch_out_disable = false;
	                	//for preventing multipule submit
						self.press_punch_our_btn = false;

	                	// Showing error
	                    res.error.map( function( value, index ) {
	                        toastr.error(value);
	                    });
	                }
	            });
			},

			isDisabled: function() {
				if ( this.$store.state.attendance.punch_in_status == 'enable' ) {
					return false;
				}

				return true;
			}
		}	
	}
</script>

