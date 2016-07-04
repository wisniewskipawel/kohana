<form action="<?php echo Route::url('site_catalog/frontend/catalog/search')?>" method="GET" id="search_form">
	<input type="hidden" name="form_id" value="Form_Frontend_Catalog_Company_Search" />
	<?php echo Form::input('phrase', isset($search_params['phrase']) ? $search_params['phrase'] : NULL, array('class' => 'clear-on-focus', 'title' => ___('catalog.companies.search.phrase.placeholder'))) ?>
	<input type="submit" value="<?php echo ___('form.search') ?>" />
</form>
<a href="<?php echo Route::url('site_catalog/frontend/catalog/advanced_search') ?>"><?php echo ___('catalog.companies.advanced_search.title') ?></a>