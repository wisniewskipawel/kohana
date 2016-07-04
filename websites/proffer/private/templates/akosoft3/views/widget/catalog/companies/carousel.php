<div id="widget_catalog_companies_carousel_box" class="box primary">
	<div class="box-header">
		<h2><?php echo ___('catalog.boxes.carousel.promoted') ?></h2>
		<a href="<?php echo Route::url('site_catalog/frontend/catalog/promoted') ?>" class="more_btn_carousel"><?php echo ___('more') ?></a>
	</div>

	<div class="content">

		<div class="slider" id="promoted-companies">
			<div class="slider-track">
			<?php echo View::factory('frontend/catalog/_companies_box_list')->set('companies', $companies_promoted) ?>
			</div>
			<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
			<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
		</div>

	</div>
	<div class="clearfix"></div>
</div>