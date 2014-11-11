<?php
if ( hrm_current_user_role() == 'hrm_employee' ) {
    $employer_id = get_current_user_id();
} else {
    $employer_id = isset( $_GET['employee_id'] ) ? $_GET['employee_id'] : '';
}

$results = hrm_Employee::getInstance()->current_user_task( $employer_id, $subtab );

foreach( $results as $id => $projects ) {
	?>
		<h1><?php echo $projects['p_title']; ?></h1>
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

			<div>
				<input type="checkbox" class="hrm-complete-task" value="<?php echo $project['tID']; ?>">
				<?php echo $project['t_t']; ?>
				<?php echo $project['t_t']; ?>&nbsp; &#8594;
				<?php _e( 'Budget: '  ); ?><?php echo $currency . $task_budget; ?>
			</div>

		<?php
	}
}