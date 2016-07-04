<?php if($collection->option('decorate')): ?>
	<?php if(isset($options['fieldset']) AND $options['fieldset']): ?>
	<fieldset class="<?php echo Arr::get($options, 'fieldset_class') ?>">
	<legend><?php echo Arr::get($options, 'label') ?></legend>
	<?php else: ?>
	<div class="collection collection_<?php echo $collection->option('name') ?>">
	<?php endif; ?>
<?php endif; ?>

<?php foreach ($collection->get_all() as $e): ?>

	<?php echo $e; ?>

<?php endforeach; ?>
	
<?php if($collection->option('decorate')): ?>
	<?php if(isset($options['fieldset']) AND $options['fieldset']): ?>
	</fieldset>
	<?php else: ?>
	</div>
	<?php endif; ?>
<?php endif; ?>