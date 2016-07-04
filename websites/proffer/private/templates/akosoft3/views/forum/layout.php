<?php if (Modules::enabled('site_ads')): ?>
	<?php echo ads::show(ads::PLACE_D) ?>
	<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<div id="forum_layout">
	
	<?php echo FlashInfo::render() ?>
	
	<div id="forum_content">
		<?php echo @$content ?>
	</div>
	
</div>