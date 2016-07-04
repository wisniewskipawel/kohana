<div class="box primary jobs profile_jobs list_box">
	<h2><?php echo ___('jobs.profile.my.title') ?></h2>
	<div class="content">
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php echo View::factory('jobs/lists/rows')
			->set('jobs', $jobs)
			->set('context', 'my');
		?>
		
		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
	</div>
</div>
