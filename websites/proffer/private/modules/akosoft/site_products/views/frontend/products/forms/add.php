<form enctype="multipart/form-data" action="<?php echo $form->action() ?>" method="post" class="bform" id="add-product" name="<?php echo $form->param('name') ?>">

	<ul class="errors">
		<?php if ($form->param('errors')): ?>
			<?php foreach ($form->param('errors') as $e): ?>
				<li><strong><?php echo $e['label'] ?><?php echo (strpos($e['driver_name'], ':') !== FALSE ? '' : ':') ?></strong> <?php echo $e['message'] ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>

	<?php echo $form->form_id->render(); ?>

	<fieldset class="border">
		<div id="product-categories">
			<?php echo $form->category_id->render(TRUE); ?>
		</div>

		<?php echo $form->product_type->render(TRUE) ?>
		
		<?php echo $form->product_title->html('row_class', 'full')->render(TRUE) ?>

	</fieldset>

	<?php if($form->has('images')): ?>
		<fieldset class="border files">

			<?php echo $form->images->html('row_class', 'full')->render(TRUE) ?>

		</fieldset>
	<?php endif ?>

	<fieldset class="border">
		<?php echo $form->product_content->html('row_class', 'full')->render(TRUE) ?>
		
		<?php echo $form->product_manufacturer->render(TRUE) ?>
		
		<?php echo $form->product_tags->render(TRUE) ?>
	</fieldset>

	<fieldset class="border">
		<?php echo $form->product_buy->render(TRUE) ?>
		
		<div class="row">
			<?php echo $form->product_allegro_url->render(TRUE) ?>
			<?php echo $form->product_shop_url->render(TRUE) ?>
		</div>
	</fieldset>
	
	<fieldset class="price_fieldset border">
			  
		<div class="row">
			<?php echo $form->product_price->render(TRUE) ?>
			<?php echo $form->product_price_to_negotiate->render(TRUE) ?>
		</div>
		
		<div class="row">
			<?php echo $form->product_state->render(TRUE) ?>

			<?php echo $form->product_availability->render(TRUE) ?>
		</div>
		
	</fieldset>

	<?php if($promoted_companies): ?>
	
	<fieldset class="border">
		<?php echo $form->company_id->render(TRUE) ?>
	</fieldset>
	
	<?php else: ?>
	
	<fieldset class="border">
		
		<div class="row">
			<?php echo $form->product_person_type->render(TRUE) ?>
			<?php echo $form->product_person->render(TRUE) ?>
		</div>
		
		<div class="row">
			<?php echo $form->product_email->render(TRUE) ?>
			<?php echo $form->product_www->render(TRUE) ?>
		</div>
		
		<div class="row">
			<?php echo $form->product_telephone->render(TRUE) ?>
		</div>
		
	</fieldset>
	
	<fieldset class="fieldset_localization border">

		<div class="fields">
			<div class="row">
				<?php if ($form->has('product_province')): ?>
					<?php echo $form->product_province->render(TRUE); ?>

					<?php $field = 'product_county'; if ($form->has($field)): $field = $form->{$field}; ?>
							<?php echo $field->render(TRUE); ?>
					<?php endif ?>
				<?php endif ?>
			</div>

			<div class="row">
				<?php echo $form->product_city->render(TRUE) ?>
				<?php echo $form->product_postal_code->render(TRUE) ?>
			</div>

			<div class="row">
				<?php echo $form->product_street->render(TRUE) ?>
			</div>
		</div>
		
		<?php echo $form->product_map->render(TRUE) ?>
	</fieldset>
	
	<script type="text/javascript">
	$(function() {
		$('#bform-product-person-type').bind('change', person_type_select);
		person_type_select();
	});

	function person_type_select() {
		var $person_type = $('#bform-product-person-type');

		if($person_type.val() === 'company') {
			$('#bform-product-person-row label')
					.html('<?php echo ___('products.forms.product_person_labels.company') ?> <span class="required">*</span>');
		} else if($person_type.val() === 'person') {
			$('#bform-product-person-row label')
					.html('<?php echo ___('products.forms.product_person_labels.person') ?> <span class="required">*</span>');
		}
	}
	</script>
	
	<?php endif; ?>

	<?php if (!$auth->is_logged()): ?>
	<fieldset class="border not_logged">

		<?php echo $form->captcha->render(TRUE) ?>

		<?php if($field = $form->get('agreements')): ?>
		<div class="rules">
			<?php echo $field->render(TRUE) ?>
		</div>
		<?php endif; ?>

	</fieldset>
	<?php endif; ?>

	<fieldset class="buttons">
		<input type="reset" value="<?php echo ___('form.clear') ?>" class="btn btn-secondary" />
		<input type="submit" value="<?php echo ___('form.add') ?>" />
	</fieldset>
</form>