<div id="jobs_layout_show">
	<?php if (Modules::enabled('site_ads')): ?>
		<?php echo ads::show(ads::PLACE_A) ?>

		<?php echo ads::show(ads::PLACE_D) ?>
		<?php echo ads::show(ads::PLACE_D2) ?>
	<?php endif ?>
	
	<?php echo FlashInfo::render() ?>
	
	<div id="jobs_content">
		<?php echo @$content ?>
	</div>
	
	<div class="clearfix"></div>
	
	<?php if($template->config('modules_box_enabled')) 
		echo Widget_Box::factory('modules')->render() ?>
	
	<div class="clearfix"></div>
</div>