<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<?php if($auto_refresh = Kohana::$config->load('modules.site_ads.settings.auto_refresh')): ?>
		<meta http-equiv="refresh" content="<?php echo (int)$auto_refresh ?>">
		<?php endif; ?>
		
		<?php echo HTML::style('media/css/ads.css'); ?>
	</head>
	<body id="ads_layout">
		<?php foreach($ads as $ad): ?>
		<?php echo View::factory('frontend/ads/show_ad')->set('ad', $ad) ?>
		<?php endforeach; ?>
	</body>
</html>
