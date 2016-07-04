<?php if (Modules::enabled('site_ads')): ?>
	<?php echo ads::show(ads::PLACE_D) ?>
	<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<div id="jobs_layout_show">
	
	<?php echo FlashInfo::render() ?>
	
	<div id="jobs_content">
		<?php echo @$content ?>
	</div>
	
	<div class="clearfix"></div>
</div>