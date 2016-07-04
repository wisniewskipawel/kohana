<?php if (Modules::enabled('site_ads')): ?>
	<?php echo ads::show(ads::PLACE_A) ?>

	<?php echo ads::show(ads::PLACE_D) ?>
	<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<div class="clearfix"></div>

<?php 
if(!(isset($frontend_main_index_top) AND !$frontend_main_index_top)) 
	echo Events::fire('frontend/main/index/top');
?>

<div class="clearfix"></div>

<div id="sidebar">

	<?php echo Events::fire('frontend/sidebar_left') ?>

</div>

<div id="content">

	<div id="flashinfo">
		<?php echo FlashInfo::render() ?>
	</div>

	<?php echo Events::fire('layout/pre_content') ?>
	
	<?php echo @$content ?>

	<div class="main_bottom">
		<?php echo Events::fire('frontend/main/bottom') ?>

		<div class="clearfix"></div>
	</div>

</div>

<div class="clearfix"></div>
