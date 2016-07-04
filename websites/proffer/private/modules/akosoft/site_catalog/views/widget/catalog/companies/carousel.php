<div id="widget_catalog_companies_carousel_box" class="box">
	<div class="box-header">
		<h2><?php echo ___('catalog.boxes.carousel.promoted') ?></h2>
		<ul class="box-actions">
			<li><a href="#promoted-companies" class="sort active"><?php echo ___('catalog.boxes.carousel.promoted') ?></a></li>
			<li><a href="#popular-companies" class="sort"><?php echo ___('catalog.boxes.carousel.popular') ?></a></li>
			<li><a href="#last-companies" class="sort"><?php echo ___('catalog.boxes.carousel.last') ?></a></li>
		</ul>
		<a href="<?php echo Route::url('site_catalog/frontend/catalog/promoted') ?>" class="more_btn"><?php echo ___('more') ?></a>
	</div>

	<div class="content">

		<div class="tabs-wrapper slider" id="last-companies">
			<div class="slider-track">
			<?php echo View::factory('frontend/catalog/_companies_box_list')->set('companies', $companies_last) ?>
			</div>
			<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
			<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
		</div>

		<div class="tabs-wrapper slider hidden" id="popular-companies">
			<div class="slider-track">
			<?php echo View::factory('frontend/catalog/_companies_box_list')->set('companies', $companies_popular) ?>
			</div>
			<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
			<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
		</div>

		<div class="tabs-wrapper slider hidden" id="promoted-companies">
			<div class="slider-track">
			<?php echo View::factory('frontend/catalog/_companies_box_list')->set('companies', $companies_promoted) ?>
			</div>
			<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
			<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
		</div>


	</div>
	<div class="clearfix"></div>
</div>