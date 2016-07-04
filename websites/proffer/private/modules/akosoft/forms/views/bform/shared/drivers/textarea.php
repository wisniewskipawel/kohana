<?php 
$chars_counter = $driver->data('chars_counter');

if($chars_counter)
{
	$driver->html('class', 'chars_counter_input');
}

echo Form::textarea(
	$driver->html('name'), 
	$driver->data('value'), 
	array(
		'id' => $driver->html('id'), 
		'title' => $driver->html('title'), 
		'class' => $driver->html('class'), 
		'rows' => $driver->html('rows'), 
		'cols' => $driver->html('cols'), 
	)
);

if($chars_counter): ?>
<div class="chars_counter" data-max-chars="<?php echo $chars_counter ?>" data-target="<?php echo $driver->html('id') ?>" style="display: none;">
	<?php echo ___('bform.driver.textarea.chars_counter.info ') ?>: <span class="counter"></span>
</div>
<?php endif; ?>