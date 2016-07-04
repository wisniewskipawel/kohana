<form enctype="multipart/form-data" action="<?php echo $form->action() ?>" method="post" class="bform" id="add-offer" name="<?php echo $form->param('name') ?>">

	<ul class="errors">
		<?php if ($form->param('errors')): ?>
			<?php foreach ($form->param('errors') as $e): ?>
				<li><strong><?php echo $e['label'] ?><?php echo (strpos($e['driver_name'], ':') !== FALSE ? '' : ':') ?></strong> <?php echo $e['message'] ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>

	<?php echo $form->form_id->render(); ?>

	<fieldset class="border">
		<div class="row">

			<?php if($field = $form->get('offer_title')) echo $field->html('row_class', 'full offer_title')->render(TRUE); ?>

		</div>

		<div class="row">

			<?php if($field = $form->get('offer_content')): ?>
				<?php echo $field->html('row_class', 'full')->render(TRUE) ?>
			<?php endif;?>

		</div>
	</fieldset>

	<fieldset class="border">
		<div class="row">
			
			<?php if($field = $form->get('offer_price_old')) echo $field->render(TRUE) ?>
			
			<?php if($field = $form->get('offer_price')) echo $field->render(TRUE) ?>
			
		</div>
		<div class="row">
			
			<?php if($field = $form->get('download_limit')) echo $field->render(TRUE) ?>
			
			<?php if($field = $form->get('offer_availability')) echo $field->render(TRUE); ?>
			
		</div>
		
		<div class="row">
			<?php if($field = $form->get('limit_per_user')) echo $field->render(TRUE); ?>
			<?php if($field = $form->get('coupon_expiration')) echo $field->render(TRUE); ?>
		</div>
	</fieldset>

	<fieldset class="border">
		<div class="row">

			<?php if($field = $form->get('category_id')) echo $field->render(TRUE) ?>

		</div>
	</fieldset>

	<fieldset class="border">

		<div class="row">
			
			<?php if($field = $form->get('offer_person_type')) echo $field->render(TRUE) ?>
			
			<?php if($field = $form->get('offer_person')) echo $field->render(TRUE) ?>
			
		</div>
		
		<?php if($field = $form->get('offer_company_nip')): ?>
		<div class="row person_type_company">
			<?php echo $field; ?>
		</div>
		<?php endif; ?>

		<div class="row">
			
			<?php if($field = $form->get('province_select')) echo $field->render(TRUE) ?>
			
			<?php if($field = $form->get('offer_county')) echo $field->render(TRUE) ?>
			
		</div>
		
		<div class="row">
			
			<?php if($field = $form->get('offer_city')) echo $field->render(TRUE) ?>
			
		</div>

		<div class="row">
			
			<?php if($field = $form->get('offer_postal_code')) echo $field->render(TRUE) ?>
			
			<?php if($field = $form->get('offer_street')) echo $field->render(TRUE) ?>
			
		</div>

		<div class="row">
			
			<?php if($field = $form->get('offer_telephone')) echo $field->render(TRUE) ?>
			
			<?php if($field = $form->get('offer_email')) echo $field->render(TRUE) ?>
			
		</div>

		<div class="row">
			
			<?php if($field = $form->get('offer_www')) echo $field->render(TRUE) ?>

			<?php if($field = $form->get('company_id')) echo $field->render(TRUE) ?>
			
		</div>
		
	</fieldset>

	<?php if($field = $form->get('image1')): ?>
	<fieldset class="border">
		<div class="row">
			<?php echo $field->render(TRUE) ?>
		</div>
	</fieldset>
	<?php endif;?>

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


<script type="text/javascript">
$('document').ready(function() {
	
	$('#bform-offer-person-type').on('change', on_change_person_type);
	on_change_person_type();
	
	function on_change_person_type() {
		var $person_type = $('#bform-offer-person-type');
		var $company_elements = $('.person_type_company');
		
		if($person_type.val() == 'company') {
			$company_elements.show();
		} else {
			$company_elements.hide();
		}
	}
	
	<?php if ($category_id = Request::current()->post('category_id')): ?>
	var category_id = <?php echo (int)$category_id ?>;

	$.ajax({
		url: base_url + 'ajax/offers/get_selects/' + category_id,
		success: function(data) {
			if (data.length) {
				$('#bform-category-id').after(data).remove();
			}
		}
	});
	<?php endif ?>
});
</script>
