<div class="box primary products profile_products list_box">
	<h2><?php echo ___('products.profile.my.title') ?></h2>
	<div class="content">

		<?php 
		echo View::factory('frontend/products/partials/filters_and_sorters')
			->set('filters_sorters', $filters_sorters)
			->set('name', 'my_filters')
		?>
		
		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>

		<?php
		echo View::factory('frontend/products/partials/list_rows')
			->set('products', $products)
			->set('context', 'my');
		?>
		
		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
	</div>
</div>
