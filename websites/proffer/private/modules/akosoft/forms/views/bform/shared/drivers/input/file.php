<?php
echo Form::file($driver->html('name'), array(
	'id' => $driver->html('id'), 
	'class' => $driver->html('class'),
));
