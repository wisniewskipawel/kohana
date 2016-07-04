<?php if ($ad): ?>
	<div class="banner">
		<?php if ($ad->ad_banner_link): ?>
			<a href="<?php echo Route::url('site_ads/frontend/ads/go_to', array('id' => $ad->ad_id)); ?>" target="_blank"><img src="<?php echo $ad->ad_banner_link ?>" alt="" /></a>
		<?php else: ?>
			<?php echo $ad->ad_code ?>
		<?php endif; ?>
	</div>
<?php endif; ?>