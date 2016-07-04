<?php
$offers = ORM::factory('Offer')->get_promoted(20);

if(count($offers)):
?>
<div id="offers_main_top_box" class="box primary">
	<div class="box-header"><?php echo ___('offers.boxes.promoted.title') ?></div>
	<div class="content">

		<div class="slider" id="promoted-offers">
			<div class="slider-track">
			<?php echo View::factory('frontend/offers/partials/list/box')->set('offers', $offers) ?>
			</div>
			<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
			<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
		</div>

	</div>
</div>
<?php endif; ?>