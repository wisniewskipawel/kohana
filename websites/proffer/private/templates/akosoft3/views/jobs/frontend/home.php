<?php if(count($jobs_promoted)): ?>
<div class="box primary">
	<div class="box-header"><?php echo ___('jobs.boxes.home.promoted.title') ?></div>
	<div class="content">
		
		<?php echo View::factory('jobs/lists/rows')
			->set('jobs', $jobs_promoted)
			->set('context', 'home')
			->set('no_ads', TRUE);
		?>
		
	</div>
</div>
<?php endif; ?>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_AB) ?>

<div class="box">
	<div class="box-header">
		<span class="box-header-title"><?php echo ___('template.jobs.boxes.home.title') ?></span>
		<a class="box-header-right" href="<?php echo Route::url('site_jobs/frontend/jobs/index') ?>"><?php echo ___('template.jobs.boxes.home.more') ?></a>
		<span class="box-tabs">
			<a <?php if ($from == 'recent'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'recent')) ?>"><?php echo ___('template.jobs.boxes.home.recent') ?></a>
			<a <?php if ($from == 'popular'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'popular')) ?>"><?php echo ___('template.jobs.boxes.home.popular') ?></a>
			<a <?php if ($from == 'promoted'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'promoted')) ?>"><?php echo ___('template.jobs.boxes.home.promoted') ?></a>
		</span>
	</div>
	<div class="content">
		
		<?php echo View::factory('jobs/lists/rows')
			->set('jobs', $jobs)
			->set('context', 'home');
		?>
		
	</div>
</div>