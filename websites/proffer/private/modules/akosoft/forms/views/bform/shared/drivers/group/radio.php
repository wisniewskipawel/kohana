<?php foreach($driver->data('values') as $value): ?>
<label class="radio_option">
	<?php
	echo Form::radio(
		$driver->html('name'), 
		$value['name'], 
		$value['name'] == $driver->get_value(),
		$value['attributes']
	);
	?>
	<?php echo $value['label'] ?>
</label>
<?php endforeach; ?>