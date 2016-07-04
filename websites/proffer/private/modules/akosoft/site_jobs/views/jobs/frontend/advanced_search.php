<?php if(!count($jobs)): ?>

<div class="box primary jobs">
	<h2><?php echo ___('jobs.advanced_search.title') ?></h2>
	<div class="content">
		<?php echo $form->render('jobs/forms/advanced_search') ?>
	</div>
</div>

<?php else: ?>

<div class="box primary jobs">
	<h2><?php echo ___('jobs.advanced_search.results') ?></h2>
	<div class="content">
		<?php echo $pager ?>

		<div class="clearfix"></div>

		<?php echo View::factory('jobs/lists/rows')
			->set('jobs', $jobs)
			->set('context', 'advanced_search');
		?>

		<?php echo $pager ?>

		<div class="clearfix"></div>
	</div>
</div>

<?php endif; ?>