<?php $max_level = max(array_keys($level_categories)); foreach($level_categories as $level => $categories): ?>	
<div id="<?php echo $driver->html('row_id') ?>" class="control-group input <?php echo $driver->html('row_class') ?>">
	<label <?php if ($driver->html('id')): ?>for="<?php echo $driver->html('id') ?>"<?php endif; ?>>
		<?php echo $level > 2 ? ___('bform.driver.orm_categories.subcategory.label') : $driver->html('label') ?> <?php echo $driver->data('required') ? '<span class="required">*</span>' : ''; ?>
	</label>
	<div class="controls">
	<?php echo Form::select(
		$max_level == $level ? $driver->data('name') : NULL,
		Arr::unshift(
			$categories, 
			Arr::get($selected_categories, $level-1), 
			___('select.choose')
		),
		Arr::get($selected_categories, $level),
		array(
			 'id' => $driver->html('id'),
			'class' => $driver->html('class'),
		)) ?>
	</div>
</div>
<?php endforeach; ?>

