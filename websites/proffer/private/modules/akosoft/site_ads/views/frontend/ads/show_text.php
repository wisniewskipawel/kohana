<div class="text-links">
<?php foreach ($ad as $a): ?>
	<div class="ad_entry">
		<a class="ad_title" href="<?php echo Route::url('site_ads/frontend/ads/go_to', array('id' => $a->ad_id)) ?>" target="_blank"><?php echo $a->ad_title ?></a>
		<p class="ad_desc"><?php echo $a->ad_description ?></p>
	</div>
<?php endforeach ?>
</div>