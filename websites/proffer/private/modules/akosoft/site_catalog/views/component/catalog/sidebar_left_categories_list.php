<div class="box categories">
	<div class="box-header"><?php echo ___('catalog.boxes.categories.title') ?>:</div>
	<div class="content">
		<nav class="categories_nav">
			<?php echo View::factory('component/catalog/_categories_list')->set('categories', $categories); ?>
		</nav>
		
		<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_B) ?>
		
	</div>
</div>