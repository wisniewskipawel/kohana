<?php
echo Form::checkbox($driver->html('name'), 1, $driver->html('checked'), array(
	'id' => $driver->html('id'), 
	'class' => $driver->html('class')
));
