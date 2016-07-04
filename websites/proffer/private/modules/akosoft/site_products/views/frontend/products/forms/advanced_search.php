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
	
	<?php echo $form->form_id->render() ?>
	
	<div class="row">
		<?php if($form->has('phrase')) echo $form->phrase->render(TRUE) ?>
		<?php if($form->has('where')) echo $form->where->render(TRUE) ?>
	</div>
	
	<div  class="row">
		<?php if($form->has('product_manufacturer')) echo $form->product_manufacturer->render(TRUE) ?>
		<?php if($form->has('product_type')) echo $form->product_type->render(TRUE) ?>
	</div>
	
	<?php if($form->has('product_province')): ?>
	<div class="row">
		<?php echo $form->product_province->render(TRUE) ?>
		<?php if($form->has('product_county')) echo $form->product_county->render(TRUE) ?>
	</div>
	<?php endif; ?>
	
	<div class="row">
		<?php if($form->has('city')) echo $form->city->render(TRUE) ?>
	</div>
	
	<div id ="product-categories" class="row">
		<?php if($form->has('category_id')) echo $form->category_id->render(TRUE) ?>
	</div>
	
	<div class="row">
		<?php if($form->has('price_from')) echo $form->price_from->render(TRUE) ?>
		<?php if($form->has('price_to')) echo $form->price_to->render(TRUE) ?>
	</div>

	<?php echo $form->param('buttons_manager')->render() ?>
</form>