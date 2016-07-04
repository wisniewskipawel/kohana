<div class="box primary products list_box">
	<h2><?php echo ___('products.show_by_company.title', array(':company_name' => $company->company_name)) ?></h2>
	<div class="content">

		<div class="clearfix"></div>

		<?php echo View::factory('frontend/products/partials/filters_and_sorters')
							->set('filters_sorters', $filters_sorters)
							->set('name', 'show_by_user_filters')
					?>

		<div class="clearfix"></div>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>
		
		<?php 
		echo View::factory('frontend/products/partials/list_box')
			->set('products', $products)
			->bind('ad', $ad) 
		?>
		
		<?php echo $pager ?>
		
		<div class="clearfix"></div>

	</div>
</div>