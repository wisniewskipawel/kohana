<form enctype="multipart/form-data" action="<?php echo $form->action() ?>" method="<?php echo $form->method() ?>" id="<?php echo $form->param('id') ?>" class="<?php echo $form->param('class') ?>" name="<?php echo $form->param('name') ?>">

	<?php if ($form->param('errors')): ?>
		<ul class="<?php echo Kohana::$config->load('bform.css.errors.ul_class') ?>">
			<?php foreach ($form->param('errors') as $ar): ?>
				<li><b><?php echo $ar['label'] ?>:</b> <?php echo $ar['message'] ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php
	echo View::factory('bform/site/forms/render_collection')
		->set('collection', $form)
		->set('form', $form);
	?>

	<?php echo $form->param('buttons_manager')->layout('bform/site/drivers_layouts/buttons')->render() ?>

</form>