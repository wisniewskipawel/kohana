<?php
$values = Arr::range(1, $driver->data('max_rating'));

echo Form::select(
	$driver->data('name'), 
	Arr::unshift($values, NULL, ''), 
	$driver->get_value(), 
	array(
		'id' => $driver->html('id'),
	));
?>
<div class="rateit" data-rateit-backingfld="#<?php echo $driver->html('id') ?>"></div>