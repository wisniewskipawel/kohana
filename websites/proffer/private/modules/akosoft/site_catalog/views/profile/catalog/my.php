<div class="box primary">
	<h2><?php echo ___('catalog.profile.my.title') ?></h2>
	<div class="content">
		
		<?php echo View::factory('frontend/catalog/partials/filters_sorters')
				->set('filters_sorters', $filters_sorters)
				->set('context', 'my');
		?>
		
		<?php echo $pager ?>
		
		<?php echo View::factory('frontend/catalog/_list')
			->set('companies', $companies)
			->set('view_action', 'my')
		?>
		
		<?php echo $pager ?>
		
	</div>

</div>