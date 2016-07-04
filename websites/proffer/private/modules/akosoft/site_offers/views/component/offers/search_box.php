<form action="<?php echo Route::url('site_offers/frontend/offers/search')?>" method="GET" id="search_form">
	<?php echo Form::input('phrase', isset($search_params['phrase']) ? $search_params['phrase'] : NULL, array('class' => 'clear-on-focus', 'title' => ___('offers.search.phrase.placeholder'))) ?>
	<input type="submit" value="<?php echo ___('form.search') ?>" />
</form>
<a href="<?php echo Route::url('site_offers/frontend/offers/advanced_search') ?>"><?php echo ___('offers.advanced_search.title') ?></a>