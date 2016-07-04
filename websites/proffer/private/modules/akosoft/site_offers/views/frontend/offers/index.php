<div class="box primary offers list_box">
	<div class="box-header">
		<h2><?php echo ___('offers.index.title') ?></h2>
		
		<?php if(Modules::enabled('site_notifier')): ?>
		<a href="<?php echo Route::url('site_notifier/notifier/offers') ?>" class="notifier_btn"><?php echo ___('notifiers.notifier_btn') ?></a>
		<?php endif; ?>
	</div>
	<div class="content">
		
		<?php echo View::factory('frontend/offers/partials/list_tabs')->set('filters_sorters', $filters_sorters) ?>

		<div class="clearfix"></div>

		<?php echo View::factory('frontend/offers/_filters_and_sorters')
				->set('filters_sorters', $filters_sorters)
				->set('name', 'category_filters')
		?>

		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php echo View::factory('frontend/offers/_offers_list')->set('offers', $offers)->bind('ad', $ad)->set('place', 'category') ?>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>

	</div>
</div>