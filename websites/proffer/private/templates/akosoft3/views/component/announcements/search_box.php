<form action="<?php echo Route::url('site_announcements/frontend/announcements/search')?>" method="GET" id="search_form">
	<div class="controls">
		<?php echo Form::input(
			'phrase', 
			isset($search_params['phrase']) ? $search_params['phrase'] : NULL, 
			array(
				'id' => 'search_phrase',
				'placeholder' => ___('announcements.search.phrase.placeholder'),
			)
		) ?>
		<input type="submit" value="<?php echo ___('form.search') ?>" />
	</div>
</form>
<a href="<?php echo Route::url('site_announcements/frontend/announcements/advanced_search') ?>" class="advanced_search_btn"><?php echo ___('announcements.advanced_search.title') ?></a>
