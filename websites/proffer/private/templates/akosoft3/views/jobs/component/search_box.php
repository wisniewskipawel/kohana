<form action="<?php echo Route::url('site_jobs/frontend/jobs/search')?>" method="GET" id="search_form">
	<div class="controls">
		<?php echo Form::input(
			'phrase', 
			isset($search_params['phrase']) ? $search_params['phrase'] : NULL, 
			array(
				'id' => 'search_phrase',
				'placeholder' => ___('jobs.search.phrase.placeholder'),
			)
		) ?>
		<input type="submit" value="<?php echo ___('form.search') ?>" />
	</div>
</form>
<a href="<?php echo Route::url('site_jobs/frontend/jobs/advanced_search') ?>" class="advanced_search_btn"><?php echo ___('jobs.advanced_search.title') ?></a>
