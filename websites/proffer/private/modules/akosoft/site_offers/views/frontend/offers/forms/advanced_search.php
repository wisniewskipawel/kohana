<?php
$form->template('site');
?>
<form enctype="multipart/form-data" action="<?php echo $form->action() ?>" method="<?php echo $form->method() ?>" id="<?php echo $form->param('id') ?>" class="<?php echo $form->param('class') ?> form-vertical" name="<?php echo $form->param('name') ?>">

	<?php if ($form->param('errors')): ?>
		<ul class="<?php echo Kohana::$config->load('bform.css.errors.ul_class') ?>">
			<?php foreach ($form->param('errors') as $ar): ?>
				<li><b><?php echo $ar['label'] ?>:</b> <?php echo $ar['message'] ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	
	<div class="row">
		<?php if($form->has('phrase')) echo $form->phrase->render(TRUE) ?>
		<?php if($form->has('where')) echo $form->where->render(TRUE) ?>
	</div>
	
	<?php if($form->has('province_select')): ?>
	<div class="row">
		<?php echo $form->province_select->render(TRUE) ?>
		<?php if($form->has('offer_county')) echo $form->offer_county->render(TRUE) ?>
	</div>
	<?php endif; ?>
	
	<div class="row">
		<?php if($form->has('city')) echo $form->city->render(TRUE) ?>
	</div>
	
	<div class="row">
		<?php if($form->has('category')) echo $form->category->render(TRUE) ?>
	</div>
	
	<div class="row">
		<?php if($form->has('price_from')) echo $form->price_from->render(TRUE) ?>
		<?php if($form->has('price_to')) echo $form->price_to->render(TRUE) ?>
	</div>

	<?php echo $form->form_id->render() ?>
	
	<?php echo $form->param('buttons_manager')->render() ?>
</form>