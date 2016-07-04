<?php $template->section_pre_main = (string)Widget_Box::factory('products/promoted')->render() ?>

<div id="promoted_home_box" class="box primary">
	<div class="box-header">
		<span class="box-header-title"><?php echo ___('template.products.boxes.home.title') ?></span>
		<a class="box-header-right" href="<?php echo Route::url('site_products/frontend/products/index') ?>"><?php echo ___('template.products.boxes.home.more') ?></a>
		<span class="box-tabs">
			<a <?php if ($from == 'recent'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'recent')) ?>"><?php echo ___('template.products.boxes.home.recent') ?></a>
			<a <?php if ($from == 'popular'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'popular')) ?>"><?php echo ___('template.products.boxes.home.popular') ?></a>
			<a <?php if ($from == 'promoted'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'promoted')) ?>"><?php echo ___('template.products.boxes.home.promoted') ?></a>
		</span>
	</div>
	<div class="content">
		<?php echo View::factory('frontend/products/partials/list_rows')
			->set('products', $products); ?>
	</div>
</div>

<div class="clearfix"></div>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_AB) ?>

<div class="clearfix"></div>