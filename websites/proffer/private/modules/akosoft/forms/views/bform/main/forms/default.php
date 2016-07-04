<form enctype="multipart/form-data" action="<?php echo $form->action() ?>" method="<?php echo $form->method() ?>" id="<?php echo $form->param('id') ?>" class="<?php echo $form->param('class') ?>" name="<?php echo $form->param('name') ?>">

	<?php if ($form->param('errors')): ?>
		<div>
			<ul class="<?php echo Kohana::$config->load('bform.css.errors.ul_class') ?>">
				<?php foreach ($form->param('errors') as $e): ?>
					<li><strong><?php echo $e['label'] ?><?php echo (strpos($e['label'], ':') !== FALSE ? '' : ':') ?></strong> <?php echo $e['message'] ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	
	<?php if(!empty($form->tabs)): ?>
		<div class="<?php echo Kohana::$config->load('bform.css.tabs.class') ?>">
			<ul>
				<?php foreach ($form->tabs as $t): ?>
					<li><a href="#<?php echo $t->option('name') ?>"><?php echo $t->option('label') ?></a></li>
				<?php endforeach; ?>
			</ul>
	<?php endif; ?>

	<?php
	echo View::factory('bform/main/forms/render_collection')
		->set('collection', $form)
		->set('form', $form);
	?>

	<?php if(!empty($form->tabs)): ?>
		</div>
	<?php endif; ?>
	
	<?php echo $form->param('buttons_manager')->render() ?>

</form>