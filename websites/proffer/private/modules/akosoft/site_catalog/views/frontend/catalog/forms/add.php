 <form enctype="multipart/form-data" action="<?php echo $form->action() ?>" method="post" class="bform form-vertical" id="add_company_form" name="<?php echo $form->param('name') ?>">
	<ul class="errors">
		<?php if ($form->param('errors')): ?>
			<?php foreach ($form->param('errors') as $e): ?>
				<li><strong><?php echo $e['label'] ?><?php echo (strpos($e['driver_name'], ':') !== FALSE ? '' : ':') ?></strong> <?php echo $e['message'] ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>

	<?php echo $form->form_id->render(); ?>

	<fieldset class="border" id="get_ajax_subcategories">
		
		<?php echo $form->category->render(TRUE) ?>
		
	</fieldset>
	
	<fieldset class="border">
		
		<div class="row full">
			<?php if($field = $form->get('slug')): ?>
			<div class="control-group full">
				<label for="<?php echo $field->html('id') ?>">
					<?php echo $field->html('label') ?>
					<?php if($field->data('required')): ?>
					<span class="required">*</span>
					<?php endif ?>
				</label>
				<div class="controls">
					<div class="inline">
					<?php if(catalog::is_subdomain_enabled()): ?>
						<span>http://</span><?php echo $field->render() ?><span>.<?php echo parse_url(Kohana::$base_url, PHP_URL_HOST) ?></span>
					<?php else: ?>
						<span><?php echo Route::url('site_catalog/company/show', array('subdomain' => '&nbsp;'), 'http') ?></span>
						<?php echo $field->render() ?>
					<?php endif; ?>
					</div>
					<?php if ($field->data('has_error')): ?>
						<span class="error"><?php echo $field->html('error_messages') ?></span>
					<?php endif ?>
				</div>
			</div>
			<?php endif;?>
		</div>
		
		<div class="row">
			<?php if($form->has('company_name')) echo $form->company_name->render(TRUE); ?>
			<?php if($form->has('logo')) echo $form->logo->render(TRUE); ?>
		</div>
		
	</fieldset>

	 <?php if($form->has('photos')): ?>
		 <fieldset class="border">

			 <div class="row">
				 <?php echo $form->photos->render(TRUE) ?>
			 </div>

		 </fieldset>
	 <?php endif; ?>
		
	<fieldset class="fieldset_localization border">
		
		<div class="fields">
			<?php if($form->has('province_select')) echo $form->province_select->render(TRUE); ?>
			<?php if($form->has('company_county')) echo $form->company_county->render(TRUE); ?>
			<?php if($form->has('company_city')) echo $form->company_city->render(TRUE); ?>
			<?php if($form->has('company_postal_code')) echo $form->company_postal_code->render(TRUE); ?>
			<?php if($form->has('company_address')) echo $form->company_address->render(TRUE); ?>
		</div>
		
		<?php echo $form->company_map->render(TRUE) ?>
		
	</fieldset>
	
	<fieldset class="border">
		<div class="row">
			<?php if($form->has('company_telephone')) echo $form->company_telephone->render(TRUE); ?>
			<?php if($form->has('company_email')) echo $form->company_email->render(TRUE); ?>
		</div>
			
		<div class="row">
			<?php if($form->has('link')) echo $form->link->render(TRUE); ?>
			<?php if($form->has('company_nip')) echo $form->company_nip->render(TRUE); ?>
		</div>
		
	</fieldset>
	
	<?php if($form->has('company_description')): ?>
	<fieldset class="border">
		<div class="row">
			<?php echo $form->company_description->html('row_class', 'full')->render(TRUE); ?>
		</div>
	</fieldset>
	<?php endif; ?>
	
	<?php if($form->has('company_products')): ?>
	<fieldset class="border">
		<div class="row">
			<?php echo $form->company_products->html('row_class', 'full')->render(TRUE); ?>
		</div>
	</fieldset>
	<?php endif; ?>
	
	<?php if($form->has('company_hours')): ?>
	<fieldset class="border">
		<div class="row">
			<?php echo $form->company_hours->render(TRUE); ?>
		</div>
	</fieldset>
	<?php endif; ?>
	
	<?php if($field = $form->get('company_keywords')): ?>
	<fieldset class="border">
		
		<div class="row">
			<?php echo $field->render(TRUE) ?>
		</div>
		
	</fieldset>
	<?php endif; ?>
	
	<?php if($field = $form->get('payments')): ?>
	<fieldset class="border">
		<?php echo $field ?>
	</fieldset>
	<?php endif;?>
	
	<?php if(!BAuth::instance()->is_logged()): ?>
	<fieldset class="border not_logged">
			
			<div class="row">
				<?php if($field = $form->captcha) echo $field->render(TRUE) ?>

				<?php if($field = $form->get('agreements')): ?>
				<div class="rules">
					<?php echo $field->render(TRUE) ?>
				</div>
				<?php endif; ?>
			</div>
		</fieldset>
	<?php endif; ?>

	<fieldset class="border buttons">
		<input type="submit" value="<?php echo ___('form.add') ?>" />
	</fieldset>
</form>

<script type="text/javascript">
$(document).ready(function() {
	<?php if(Request::$current->post('category')): foreach(Request::$current->post('category') as $i => $category): ?>
		<?php if ( ! empty($category)): ?>
		main.catalog.forms.load_catalog_categories(<?php echo (int)$category ?>, <?php echo $i ?>);
		<?php endif ?>
	<?php endforeach; endif;?>
});
</script>
