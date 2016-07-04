<?php if (Modules::enabled('site_ads')): ?>
<?php echo ads::show(ads::PLACE_D) ?>
<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<div class="layout_posts_main">

	<?php 
	if(!(isset($frontend_main_index_top) AND !$frontend_main_index_top)) 
		echo Events::fire('frontend/main/index/top');
	?>

	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-8">

			<div id="flashinfo">
				<?php echo FlashInfo::render() ?>
			</div>

			<?php echo @$content ?>

			<div class="clearfix"></div>

		</div>

		<div id="sidebar" class="col-md-4">
			<?php echo View::factory('layouts/posts/sidebar')->render() ?>
		</div>

		<div class="clearfix"></div>
	</div>
	
</div>