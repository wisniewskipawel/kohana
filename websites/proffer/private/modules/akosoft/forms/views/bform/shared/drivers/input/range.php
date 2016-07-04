<?php
echo Form::input(
	$driver->data('from_name'), 
	Arr::get($driver->get_value(), 'from'),
	array(
		'class' => $driver->html('class').' input_range_from', 
		'title' => ___('form.range.from'), 
		'placeholder' => ___('form.range.from'), 
	)
);
?>

<?php
echo Form::input(
	$driver->data('to_name'), 
	Arr::get($driver->get_value(), 'to'),
	array(
		'class' => $driver->html('class').' input_range_to', 
		'title' => ___('form.range.to'), 
		'placeholder' => ___('form.range.to'), 
	)
);
