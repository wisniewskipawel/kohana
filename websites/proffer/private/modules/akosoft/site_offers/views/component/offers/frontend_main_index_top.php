<?php if(Kohana::$config->load('modules.site_offers.settings.provinces_enabled') AND $template->config('map_enabled')): ?>
<?php echo View::factory('map/home')->set('route', Route::get('site_offers/frontend/offers/index')); ?>
<?php else: ?>
<div id="info_box_no_map">
	<?php echo HTML::image('media/offers/img/no_map.png', array('alt' => 'Info')) ?>
</div>
<?php endif;  ?>

<div class="frontend_main_index_top <?php if(!Kohana::$config->load('modules.site_offers.settings.provinces_enabled')): ?>map_disabled<?php endif;  ?>">

	<div id="info_box">
		<?php echo HTML::image('media/offers/img/info_box.png', array('alt' => 'Info')) ?>
	</div>

	<?php echo HTML::image('media/offers/img/info_box2.png'); ?>
</div>