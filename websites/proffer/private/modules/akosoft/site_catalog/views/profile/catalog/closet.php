<div class="box primary list_box">
	<h2><?php echo ___('catalog.profile.closet.title') ?></h2>
	<div class="content">
		
		<?php echo View::factory('partials/closet_tabs') ?>

		<div class="clearfix"></div>

		<?php echo View::factory('frontend/catalog/partials/filters_sorters')
				->set('filters_sorters', $filters_sorters)
				->set('context', 'closet');
		?>
		
		<?php echo $pager ?>
		
		<?php echo View::factory('frontend/catalog/_list')
			->set('companies', $companies)
			->set('view_action', 'closet')
		?>
		
		<?php echo $pager ?>
		
	</div>
</div>