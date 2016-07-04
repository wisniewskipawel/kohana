<div id="products_box" class="box">
	<h2><?php echo ___('products.title') ?></h2>
	
	<div class="content">
		
		<?php echo View::factory('frontend/products/partials/list_rows')
			->set('products', $products)
			->set('no_ads', TRUE)
			->set('context', 'company')
		?>
		
		<?php if(count($products)): ?>
		<?php echo HTML::anchor(
			Route::get('site_products/frontend/products/show_by_company')
				->uri(array(
					'company_id' => $current_company->pk(),
				)), 
			___('products.company.see_all_btn'), 
			array('class' => 'see_all_btn')
		); ?>
		<?php endif; ?>
		
	</div>
</div>
