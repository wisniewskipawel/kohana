<div class="banners <?php echo ads::place_name($place) ?>">
	<iframe src="<?php echo Route::url('site_ads/frontend/ads/show', array('place' => $place), TRUE).URL::query($options, FALSE) ?>" seamless class="ads_frame" scrolling="no"></iframe>
</div>