<div id="categories_side">
	
	<button type="button" class="btn btn-default btn-block collapse-btn" data-toggle="collapse" data-target="#categories_box">
		<?php echo ___('template.browse_categories') ?>
		<span class="caret"></span>
	</button>
	
	<div id="categories_box" class="box collapse">
		<div class="box-header"><?php echo ___('template.browse_categories') ?></div>
		<div class="box-content">
			<nav id="categories_nav">
				<?php echo View::factory('layouts/catalog/partials/categories')
					->set('categories', ORM::factory('Catalog_Category')->get_categories_list())
					->render() ?>
			</nav>
		</div>
	</div>
	
</div>

<?php if(catalog::config('map')) echo Widget_Box::factory('regions/map', array(
	'route' => Route::get('site_catalog/frontend/catalog/show_category'),
))->render() ?>

<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_B) ?>

<?php echo View::factory('layouts/catalog/sidebar_home')->render() ?>
