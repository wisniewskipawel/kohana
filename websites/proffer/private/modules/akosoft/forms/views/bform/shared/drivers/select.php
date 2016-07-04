<?php 
echo Form::select(
	$driver->html('name'),
	$driver->html('options'),
	$driver->get_value(),
	array(
		'class' => $driver->html('class'),
		'id' => $driver->html('id'),
		'size' => $driver->html('size'),
	)
);