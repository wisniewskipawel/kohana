<?php if($collection->option('decorate')): ?>
	<?php if(isset($options['fieldset']) AND $options['fieldset']): ?>
	<fieldset class="<?php echo Arr::get($options, 'fieldset_class') ?>">
		<?php if($fieldset_label = Arr::get($options, 'label')): ?>
		<legend><?php echo $fieldset_label ?></legend>
		<?php endif; ?>
	<?php else: ?>
	<div class="collection collection_<?php echo $collection->option('name') ?>">
	<?php endif; ?>
<?php endif; ?>
		
<?php 
foreach($collection->get_all() as $e)
{
	echo $e;
}
?>
	
<?php if($collection->option('decorate')): ?>
	<?php if(isset($options['fieldset']) AND $options['fieldset']): ?>
	</fieldset>
	<?php else: ?>
	</div>
	<?php endif; ?>
<?php endif; ?>