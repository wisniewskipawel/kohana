<?php if(Kohana::$config->load('modules.site_catalog.map') AND $template->config('map_enabled')): ?>
<?php echo View::factory('map/home')->set('route', Route::get('site_catalog/frontend/catalog/show_category')); ?>
<?php else: ?>
<div id="info_box_no_map">
	<?php echo HTML::image('media/catalog/img/no_map.png', array('alt' => 'Info')) ?>
</div>
<?php endif;  ?>

<div class="frontend_main_index_top <?php if(!Kohana::$config->load('modules.site_catalog.map')): ?>map_disabled<?php endif;  ?>">
	
	<div id="info_box">
		<?php echo HTML::image('media/catalog/img/info_box.png', array('alt' => 'Info')) ?>
	</div>

	<?php echo Widget_Box::factory('catalog/companies/carousel'); ?>
</div>