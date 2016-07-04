<div class="box primary companies">
	<h2><?php echo ___('catalog.companies.promoted.title') ?></h2>
	<div class="content">
	
		<?php echo View::factory('frontend/catalog/partials/filters_sorters')
				->set('filters_sorters', $filters_sorters);
		?>
		
		<?php echo $pager ?>
	
		<?php echo View::factory('frontend/catalog/_list')
				->set('companies', $companies)
		?>

		<?php echo $pager ?>

	</div>
</div>