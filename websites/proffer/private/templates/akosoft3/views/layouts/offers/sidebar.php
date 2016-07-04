<div id="categories_side">
	
	<button type="button" class="btn btn-default btn-block collapse-btn" data-toggle="collapse" data-target="#categories_box">
		<?php echo ___('template.browse_categories') ?>
		<span class="caret"></span>
	</button>
	
	<div id="categories_box" class="box collapse">
		<div class="box-header"><?php echo ___('template.browse_categories') ?></div>
		<div class="box-content">
			<nav id="categories_nav">
				<?php echo View::factory('layouts/offers/partials/categories')
					->set('categories', ORM::factory('Offer_Category')->get_categories_list())
					->render() ?>
			</nav>
		</div>
	</div>
	
</div>

<?php if(offers::config('provinces_enabled')) echo Widget_Box::factory('regions/map', array(
	'route' => Route::get('site_offers/frontend/offers/index'),
))->render() ?>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_B) ?>

<?php
if(Modules::enabled('site_ads') AND $template->config('site_ads.index_box_enabled'))
{
	$ads = ORM::factory('Ad')->get_by_type_many(Model_Ad::TEXT_C, 3);
	echo View::factory('component/ads/sidebar_left')->set('ads', $ads);
}
?>
