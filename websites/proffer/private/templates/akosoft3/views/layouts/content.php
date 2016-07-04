<?php if (Modules::enabled('site_ads')): ?>
<?php echo ads::show(ads::PLACE_D) ?>
<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<div id="content">

	<div id="flashinfo">
		<?php echo FlashInfo::render() ?>
	</div>

	<?php echo Events::fire('layout/pre_content') ?>
	
	<?php echo @$content ?>

</div>

<div class="main_bottom row">
	<?php echo Events::fire('frontend/main/bottom') ?>
</div>