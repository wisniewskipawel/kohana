<div class="box primary products list_box">
	<h2><?php echo isset($category) ? ___('products.category.title', array(':category' => $category->category_name)) : ___('products.title') ?></h2>
	<div class="content">
		
		<?php 
		echo View::factory('frontend/products/partials/filters_and_sorters')
				->set('name', 'category_filters')
				->set('filters_sorters', $filters_sorters)
		?>

		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php 
		echo View::factory('frontend/products/partials/list_rows')
			->set('products', $products)
			->bind('ad', $ad)
			->set('place', 'category') 
		?>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>

	</div>
</div>