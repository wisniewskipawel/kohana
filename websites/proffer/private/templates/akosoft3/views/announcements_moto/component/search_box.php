<form action="<?php echo $current_module->route_url('frontend/announcements/search'); ?>" method="GET" id="search_form">
	<div class="controls">
		<?php echo Form::input(
			'phrase', 
			isset($search_params['phrase']) ? $search_params['phrase'] : NULL, 
			array(
				'id' => 'search_phrase',
				'placeholder' => $current_module->trans('search.phrase.placeholder'),
			)
		) ?>
		<input type="submit" value="<?php echo ___('form.search') ?>" />
	</div>
</form>
