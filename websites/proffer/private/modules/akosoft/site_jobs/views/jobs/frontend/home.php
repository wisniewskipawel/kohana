<?php
$model = new Model_Job;

$jobs_promoted = $model->find_promoted_home(Jobs::config('home_promoted_box_limit'));
$jobs_recent = $model->find_recent_home(Jobs::config('home_recent_box_limit'));

if(count($jobs_promoted)): ?>
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

<div class="box">
	<div class="box-header"><?php echo ___('jobs.boxes.home.recent.title') ?></div>
	<div class="content">
		
		<?php echo View::factory('jobs/lists/rows')
			->set('jobs', $jobs_recent)
			->set('context', 'home')
			->set('no_ads', TRUE);
		?>
		
	</div>
</div>

<?php if(Modules::enabled('site_jobs')) echo ads::show(ads::PLACE_AB) ?>
