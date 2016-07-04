<form action="<?php echo Route::url('site_products/frontend/products/search')?>" method="GET" id="search_form">
	<?php echo Form::input('phrase', isset($search_params['phrase']) ? $search_params['phrase'] : NULL, array('class' => 'clear-on-focus', 'title' => ___('products.search.phrase.placeholder'))) ?>
	<input type="submit" value="<?php echo ___('form.search') ?>" />
</form>
<a href="<?php echo Route::url('site_products/frontend/products/advanced_search') ?>"><?php echo ___('products.advanced_search.title') ?></a>
