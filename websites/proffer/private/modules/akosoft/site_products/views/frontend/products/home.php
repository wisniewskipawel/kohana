<div id="promoted_home_box" class="box primary">
	<div class="box-header"><?php echo ___('products.boxes.home.title') ?></div>
	<div class="content">
		<?php echo View::factory('frontend/products/partials/list_box')
			->set('products', $promoted_products)
			->set('no_ads', TRUE); ?>
	</div>
</div>

<div class="clearfix"></div>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_AB) ?>

<div class="clearfix"></div>