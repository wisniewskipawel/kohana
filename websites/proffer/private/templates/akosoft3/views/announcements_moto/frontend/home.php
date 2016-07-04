<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

$template->set_layout($current_module->view('layouts/home')) ?>

<div class="moto_home_container">
	
	<div class="row">
		<div id="sidebar" class="col-md-4 col-lg-3">
			<?php echo $current_module->widget('categories', array('disable_ad' => TRUE))->render() ?>

			<?php if($current_module->config('map')) echo Widget_Box::factory('regions/map', array(
				'route' => $current_module->route('frontend/announcements/index'),
			))->render() ?>
		</div>

		<div id="content" class="col-md-8 col-lg-9">
			<?php echo $current_module->widget('HomeBox')->render() ?>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
<?php if (Modules::enabled('site_ads')) echo ads::show(ads::PLACE_AB) ?>

<div class="clearfix"></div>

	<?php echo $current_module->widget('promoted')->render() ?>
	
</div>

