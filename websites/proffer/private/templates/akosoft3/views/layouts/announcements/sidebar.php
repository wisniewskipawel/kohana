<div id="categories_side">
	
	<button type="button" class="btn btn-default btn-block collapse-btn" data-toggle="collapse" data-target="#categories_box">
		<?php echo ___('template.browse_categories') ?>
		<span class="caret"></span>
	</button>
	
	<div id="categories_box" class="box collapse">
		<div class="box-header"><?php echo ___('template.browse_categories') ?></div>
		<div class="box-content">
			<nav id="categories_nav">
				<?php echo View::factory('layouts/announcements/partials/categories')
					->set('categories', ORM::factory('Announcement_Category')->get_categories_list())
					->render() ?>
			</nav>
		</div>
	</div>
	
</div>

<?php if(announcements::config('map')) echo Widget_Box::factory('regions/map', array(
	'route' => Route::get('site_announcements/frontend/announcements/index'),
))->render() ?>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_B) ?>

<?php
if(Modules::enabled('site_ads') AND $template->config('site_ads.index_box_enabled'))
{
	$ads = ORM::factory('Ad')->get_by_type_many(Model_Ad::TEXT_C, 3);
	echo View::factory('component/ads/sidebar_left')->set('ads', $ads);
}

if(Modules::enabled('site_products'))
{
	$product = new Model_Product;
	$product->filter_by_promoted();
	$product->limit(3);
	$product->order_by(DB::expr('RAND()'));
	$products = $product->find_all();

	if(count($products))
	{
		echo View::factory('component/products/sidebar_products')
			->set('products', $products)
			->render();
	}
}
	
