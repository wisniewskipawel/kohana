<?php $max_level = max(array_keys($level_categories)); 
foreach($level_categories as $level => $categories): ?>	

<?php echo Form::select(
	$max_level == $level ? $driver->data('name') : NULL,
	Arr::unshift(
		$categories, 
		Arr::get($selected_categories, $level-1), 
		___('select.choose')
	),
	Arr::get($selected_categories, $level),
	array(
		 'id' => $driver->html('id'),
		'class' => $driver->html('class'),
	)) ?>

<?php endforeach; ?>
