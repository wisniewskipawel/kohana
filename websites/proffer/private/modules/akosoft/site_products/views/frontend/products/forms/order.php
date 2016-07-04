<?php
$form->template('site');
?>
<form enctype="multipart/form-data" action="<?php echo $form->action() ?>" method="<?php echo $form->method() ?>" class="<?php echo $form->param('class') ?>" id="<?php echo $form->param('id') ?>" name="<?php echo $form->param('name') ?>">
	
	<?php echo $form->form_id->render() ?>
	
	<ul class="errors">
		<?php if ($form->param('errors')): ?>
			<?php foreach ($form->param('errors') as $e): ?>
				<li><strong><?php echo $e['label'] ?><?php echo (strpos($e['driver_name'], ':') !== FALSE ? '' : ':') ?></strong> <?php echo $e['message'] ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	
	<?php if($form->has('quantity')) echo $form->quantity->render(TRUE) ?>
	
	<?php if($form->has('person_type')): ?>
	<div id="person_type_field" class="control-group">
		<label></label>
		<div class="controls">
			<?php echo $form->person_type->render(FALSE) ?>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="person_type_private">
		<?php if($form->has('name')) echo $form->name->render(TRUE) ?>
	</div>
	
	<div class="person_type_company">
		<?php if($form->has('company_name')) echo $form->company_name->render(TRUE) ?>
		
		<?php if($form->has('company_nip')) echo $form->company_nip->render(TRUE) ?>
	</div>
	
	<?php if($form->has('email')) echo $form->email->render(TRUE) ?>
	
	<?php if($form->has('phone')) echo $form->phone->render(TRUE) ?>
	
	<?php if($form->has('street')) echo $form->street->render(TRUE) ?>
	
	<?php if($form->has('postal_code')) echo $form->postal_code->render(TRUE) ?>
	
	<?php if($form->has('city')) echo $form->city->render(TRUE) ?>
	
	<?php if($form->has('remarks')) echo $form->remarks->render(TRUE) ?>
	
	<?php if($form->has('captcha')) echo $form->captcha->render(TRUE) ?>
	
	<?php echo $form->param('buttons_manager')->render() ?>
	
</form>

<script type="text/javascript">
$(function() {
	$('#person_type_field [type=radio]').change(person_type_change);
	person_type_change();
		
	$('.person_type_private label, .person_type_company label').each(function() {
		var $label = $(this);
		if(!$label.find('span.required').length)
			$label.append('<span class="required">*</span>');
	});
	
	function person_type_change() {
		var person_type = $('#person_type_field [type=radio]:checked').val();
		
		if(person_type == 'private')
			$('.person_type_private').show();
		else
			$('.person_type_private').hide();
		
		if(person_type == 'company')
			$('.person_type_company').show();
		else
			$('.person_type_company').hide();
	}
});
</script>