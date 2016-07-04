<?php if (Modules::enabled('site_ads')): ?>
	<?php echo ads::show(ads::PLACE_D) ?>
	<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<div id="galleries_layout" class="row">
	
	<div id="galleries_content" class="col-md-8">
		
		<div id="content" class="row">
			<div class="col-md-12">
				<div id="flashinfo">
					<?php echo FlashInfo::render() ?>
				</div>

				<?php echo @$content ?>
			</div>
		</div>
		
	</div>
	
	<div id="galleries_sidebar" class="col-md-4">
		<?php echo View::factory('galleries/sidebar')->render() ?>
	</div>
	
</div>