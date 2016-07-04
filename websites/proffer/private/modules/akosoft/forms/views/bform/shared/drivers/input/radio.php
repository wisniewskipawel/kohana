<?php
echo Form::radio(
	$driver->html('name'), 
	$value, 
	$value == $driver->get_value()
);
