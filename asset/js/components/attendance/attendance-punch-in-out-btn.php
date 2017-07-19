<div class="metabox-holder hrm-punch-in-out-wrap">
	<div class="postbox">

		<h2 class="hndle ui-sortable-handle">
			<span><?php _e( 'Punch in/out', 'hrm' ); ?></span>
		</h2>

		<div class="inside">
			<div class="main hrm-punch-in-out-main">
				<div class="hrm-clock-wrap">
					<strong><time><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date( 'F j, Y', strtotime( current_time( 'mysql' ) ) ); ?></time></strong>
					<strong><time><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date( 'g:i a', strtotime( current_time( 'mysql' ) ) ); ?></time></strong>
				</div>
				
				<button :disabled="isDisabled()" class="button button-primary" @click.prevent="punchIn()"><?php _e( 'Punch In', 'hrm' ); ?></button>
				<button :disabled="punch_out_disable" class="button button-secondary" @click.prevent="punchOut()"><?php _e( 'Punch Out', 'hrm' ); ?></button>
			</div>
		</div>
	</div>
</div>