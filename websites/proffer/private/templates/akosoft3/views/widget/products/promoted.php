<?php
$products = ORM::factory('Product')->get_promoted(20);

if(count($products)):
?>
<div id="products_main_top_box" class="box primary">
	<div class="box-header"><?php echo ___('products.boxes.promoted.title') ?></div>
	<div class="content">

		<div class="slider" id="promoted-products">
			<div class="slider-track">
			<?php echo View::factory('frontend/products/partials/list_box_small')->set('products', $products) ?>
			</div>
			<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
			<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
		</div>

	</div>
</div>
<?php endif; ?>