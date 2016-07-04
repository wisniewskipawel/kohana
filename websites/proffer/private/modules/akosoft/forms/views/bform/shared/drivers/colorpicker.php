<?php
echo Form::input(
	$driver->html('name'),
	($driver->data('clear_value') === TRUE) ? '' : $driver->get_value(),
	array(
		'id' => $driver->html('id'),
		'class' => $driver->html('class'),
		'size' => $driver->html('size'),
		'title' => $driver->html('title'),
		'placeholder' => $driver->html('placeholder'),
		'type' => 'color',
	)
);
