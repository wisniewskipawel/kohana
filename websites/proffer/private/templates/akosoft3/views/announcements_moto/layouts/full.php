<?php if (Modules::enabled('site_ads')): ?>
<?php echo ads::show(ads::PLACE_D) ?>
<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<div class="clearfix"></div>

<div class="layout_moto_full wrapper">
	
	<div id="flashinfo">
		<?php echo FlashInfo::render() ?>
	</div>

	<?php echo Events::fire('frontend/main/index/top') ?>

	<?php echo @$content ?>
	
</div>