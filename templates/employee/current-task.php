<?php

if ( isset( $_REQUEST['employee_id'] ) && $_REQUEST['employee_id'] ) {
    $employer_id = intval( $_REQUEST['employee_id'] );
} else {
    $employer_id = get_current_user_id();
}

$results = hrm_Employee::getInstance()->current_user_task( $employer_id, $subtab );

foreach( $results as $id => $projects ) {
	?>
	<div class="postbox">
		<div class="hrm-search-head">
			<h3><?php echo $projects['p_title']; ?></h3>
		</div>
		<?php
		unset( $projects['p_title'] );

		foreach ( $projects as $key => $project ) {
			if ( !isset( $project['t_t'] ) ) {
				continue;
			}

			$task_budget = get_post_meta( $project['tID'], '_task_budget', true );
			$task_budget = empty( $task_budget ) ? '0' : $task_budget;
			$currency = get_post_meta( $project['pID'], '_currency_symbol', true );
			?>

				<div class="hrm-my-task-body">
					<input type="checkbox" class="hrm-complete-task" value="<?php echo $project['tID']; ?>">
					<?php echo $project['t_t']; ?>
					<?php echo $project['t_t']; ?>&nbsp; &#8594;
					<?php _e( 'Budget: '  ); ?><?php echo $currency . $task_budget; ?>
				</div>

			<?php
		}
		?>
	</div>
	<?php
}