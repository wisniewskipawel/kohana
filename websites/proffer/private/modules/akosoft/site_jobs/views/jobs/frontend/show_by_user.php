<div class="box primary jobs">
	<h2><?php echo ___('jobs.show_by_user.title', array(
		':user_name' => HTML::chars($user->user_name),
	)) ?></h2>
	<div class="content">
		
		<?php echo $pager ?>
		
		<?php 
		echo View::factory('jobs/lists/rows')
			->set('jobs', $jobs)
			->set('place', 'show_by_user');
		?>
		
		<?php echo $pager ?>

	</div>
</div>