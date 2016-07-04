<div class="banners banners_inline <?php echo ads::place_name($place) ?>">
	<?php foreach($ad as $a): ?>
	<?php echo View::factory('frontend/ads/show_ad')->set('ad', $a) ?>
	<?php endforeach; ?>
</div>
