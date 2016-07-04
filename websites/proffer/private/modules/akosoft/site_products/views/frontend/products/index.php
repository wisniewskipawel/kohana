<div class="box primary products list_box">
	<h2><?php echo ___('products.index.title') ?></h2>
	<div class="content">
		
		<?php
		echo View::factory('frontend/products/partials/list_tabs')
			->set('filters_sorters', $filters_sorters)
		?>

		<div class="clearfix"></div>

		<?php 
		echo View::factory('frontend/products/partials/filters_and_sorters')
				->set('name', 'index_filters')
				->set('filters_sorters', $filters_sorters)
		?>

		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php 
		echo View::factory('frontend/products/partials/list_box')
			->set('products', $products)
			->bind('ad', $ad) 
		?>
		
		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>

	</div>
</div>