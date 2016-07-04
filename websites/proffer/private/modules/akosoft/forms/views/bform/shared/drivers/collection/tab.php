<fieldset id="<?php echo $collection->option('name') ?>" class="tab">
	<?php
	echo View::factory('bform/'.$form->template().'/forms/render_collection')
		->set('collection', $collection)
		->set('form', $form);
	?>
</fieldset>