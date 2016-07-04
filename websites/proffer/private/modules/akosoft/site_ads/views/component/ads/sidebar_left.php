<div class="box text-links">
	<div class="box-header"><?php echo ___('ads.boxes.text_link.title') ?></div>
	<div class="content">
		<?php echo View::factory('frontend/ads/show_text')->set('ad', $ads); ?>
		<div class="clearfix"></div>
		
		<div class="box-content-link">
			<a href="<?php echo Route::url('site_ads/frontend/ads/add_text_ad_pre') ?>"><?php echo ___('ads.boxes.text_link.add_btn') ?></a>
		</div>
	</div>
</div>