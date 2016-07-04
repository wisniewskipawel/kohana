<div class="box primary jobs">
	<div class="box-header">
		<h2><?php 
			echo isset($category) ? 
			___('jobs.category.title', array(':category' => $category->category_name)) : ___('jobs.module.name') 
		?></h2>
		
		<?php if(Modules::enabled('site_notifier')): ?>
		<a href="<?php echo Route::url('site_notifier/notifier/jobs') ?>" class="notifier_btn"><?php echo ___('notifiers.notifier_btn') ?></a>
		<?php endif; ?>
	</div>
	<div class="content">
		
		<?php echo $pager ?>
		
		<?php 
		echo View::factory('jobs/lists/rows')
			->set('jobs', $jobs)
			->set('place', 'category');
		?>
		
		<?php echo $pager ?>

	</div>
</div>