<form action="<?php echo Route::url('site_jobs/frontend/jobs/search')?>" method="GET" id="search_form">
	<?php echo Form::input('phrase', isset($search_params['phrase']) ? $search_params['phrase'] : NULL, array('class' => 'clear-on-focus', 'title' => ___('jobs.search.phrase.placeholder'))) ?>
	<input type="submit" value="<?php echo ___('form.search') ?>" />
</form>
<a href="<?php echo Route::url('site_jobs/frontend/jobs/advanced_search') ?>"><?php echo ___('jobs.advanced_search.title') ?></a>
