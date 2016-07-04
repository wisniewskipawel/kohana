<?php
$attributes = array('id' => $driver->html('id'), 'class' => $driver->html('class'));
if ($driver->html('disabled')) {
	$attributes['disabled'] = 'disabled';
}
if ($driver->html('read_only')) {
	$attributes['readonly'] = 'readonly';
}
?>

<?php echo Form::checkbox($driver->html('name'), $driver->html('value'), $driver->html('checked'), $attributes); ?>
<label class="<?php echo $driver->html('class') ?>" for="<?php echo $driver->html('id') ?>"><?php echo $driver->html('label') ?></label>
<?php if ($driver->html('html_after')): ?>
<br/><span class="html-after"><?php echo $driver->html('html_after') ?></span>
<?php endif ?>