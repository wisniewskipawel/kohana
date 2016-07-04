<?php
echo Form::checkbox(
	$driver->html('name'), 
	$driver->data('value'), 
	(bool)$driver->get_value(), 
	array(
		'id' => $driver->html('id'), 
		'class' => $driver->html('class'),
	)
);
