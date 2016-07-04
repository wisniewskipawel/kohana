<div class="box primary announcements list_box">
	<div class="box-header">
		<h2><?php echo isset($category) ? ___('announcements.category.title', array(':category' => $category->category_name)) : ___('announcements.module.name') ?></h2>
		
		<?php if(Modules::enabled('site_notifier')): ?>
		<a href="<?php echo Route::url('site_notifier/notifier/announcements') ?>" class="notifier_btn"><?php echo ___('notifiers.notifier_btn') ?></a>
		<?php endif; ?>
	</div>
	<div class="box-category">
		
		<?php 
		echo View::factory('frontend/announcements/_filters_and_sorters')
				->set('name', 'category_filters')
				->set('filters_sorters', $filters_sorters)
				->set('category', $category)
		?>

		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php 
		echo View::factory('frontend/announcements/_announcements_list')
			->set('announcements', $announcements)
			->bind('ad', $ad)
			->set('place', 'category') 
		?>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>

	</div>
</div>