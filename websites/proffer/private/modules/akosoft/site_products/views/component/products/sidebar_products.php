<div id="sidebar_products_box" class="box">
	<div class="box-header"><?php echo ___('products.boxes.promoted_sidebar.title') ?></div>
	<div class="content">
		<div class="slider" data-is_vertical="1" data-visible_elements="2">
		<?php echo View::factory('frontend/products/partials/list_box_small')
			->set('products', $products); 
		?>
		</div>
	</div>
</div>
