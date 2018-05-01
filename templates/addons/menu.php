<div class="wrap hrm-license">

	<h2 class="nav-tab-wrapper">
		<?php
			foreach ( $addons as $key => $addon ) {
				$url = add_query_arg(
					array(
						'page' => 'hrm_addons_update',
						'tab'  => $addon['key']
					), 
					admin_url('admin.php')
				);
				$active = !empty($_GET['tab']) && ($_GET['tab'] == $addon['key']) ? 'nav-tab-active' : '';
				?>

				<a href="<?php echo $url; ?>" class="<?php echo $active; ?>  nav-tab">
					<?php echo $addon['label']; ?>
				</a>
				<?php
			}

		?>
	    
	</h2>

	<?php do_action( 'hrm_addons_content', $addons ); ?>

</div>